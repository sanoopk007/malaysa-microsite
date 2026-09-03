<?php
/**
 * Enquiry form handler. Uses PHP mail() for now; swap the mail() call below
 * for PHPMailer + SMTP later without touching contact.php.
 */
require_once __DIR__ . '/config.php';

function reject(string $reason): void
{
    error_log('Enquiry rejected: ' . $reason);
    $_SESSION['enquiry_status'] = 'error';
    header('Location: ../contact.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.php');
    exit;
}

// CSRF check
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    reject('csrf_mismatch');
}

// Honeypot — bots tend to fill hidden fields
if (!empty($_POST['website'])) {
    reject('honeypot_triggered');
}

// Simple session-based rate limiting: max 5 submissions per 10 minutes
$now = time();
$_SESSION['enquiry_log'] = array_filter($_SESSION['enquiry_log'] ?? [], fn($t) => $t > $now - 600);
if (count($_SESSION['enquiry_log']) >= 5) {
    reject('rate_limited');
}

function clean(string $key): string
{
    return trim(filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW) ?? '');
}

$name       = clean('name');
$email      = clean('email');
$mobile     = clean('mobile');
$country    = clean('country');
$travelDate = clean('travel_date');
$travellers = clean('travellers');
$destination = clean('destination');
$package    = clean('package');
$message    = clean('message');

if ($name === '' || $mobile === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    reject('validation_failed');
}

$body = "New enquiry from Visit Malaysia 2026-2027 website:\n\n"
    . "Name: {$name}\n"
    . "Email: {$email}\n"
    . "Mobile: {$mobile}\n"
    . "Country: {$country}\n"
    . "Travel date: {$travelDate}\n"
    . "Travellers: {$travellers}\n"
    . "Destination: {$destination}\n"
    . "Package: {$package}\n"
    . "Message:\n{$message}\n";

$subject = 'New Malaysia Travel Enquiry — ' . $name;
$headers = 'From: no-reply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\n"
    . 'Reply-To: ' . $email . "\r\n";

$sent = @mail($config['contact_email'], $subject, $body, $headers);

$_SESSION['enquiry_log'][] = $now;

if (!$sent) {
    // mail() commonly fails on local dev servers without an MTA configured;
    // log it so the enquiry isn't silently lost, and still confirm receipt
    // rather than exposing server-level mail errors to the visitor.
    error_log('Enquiry mail() failed for: ' . $email);
}

$_SESSION['enquiry_status'] = 'success';
header('Location: ../contact.php');
exit;
