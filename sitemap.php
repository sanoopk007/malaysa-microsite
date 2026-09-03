<?php
/**
 * Generated dynamically from the same data arrays that drive the
 * navigation and listing pages, so it can never drift out of sync
 * with the actual site structure.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/destination-data.php';
require_once __DIR__ . '/includes/package-data.php';

header('Content-Type: application/xml; charset=UTF-8');

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $scheme . ($_SERVER['HTTP_HOST'] ?? 'localhost');

$urls = ['/index.php', '/experiences.php', '/contact.php', '/attractions/index.php', '/packages/index.php'];
foreach ($destinations as $d) $urls[] = '/attractions/' . $d['slug'] . '.php';
foreach ($packages as $p) $urls[] = '/packages/' . $p['slug'] . '.php';

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
  <url><loc><?= htmlspecialchars($host . $u) ?></loc></url>
<?php endforeach; ?>
</urlset>
