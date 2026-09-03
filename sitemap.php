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

$siteRoot = site_root_url('');

// Each entry's 'loc' is the canonical URL path relative to the site root
// (matching the <link rel="canonical"> declared on that page, minus the
// leading slash) and 'file' is the source file used to read a real
// last-modified date from.
$pages = [
    ['loc' => '', 'file' => 'index.php'],
    ['loc' => 'experiences.php', 'file' => 'experiences.php'],
    ['loc' => 'contact.php', 'file' => 'contact.php'],
    ['loc' => 'attractions/index.php', 'file' => 'attractions/index.php'],
    ['loc' => 'packages/index.php', 'file' => 'packages/index.php'],
];
foreach ($destinations as $d) {
    $pages[] = ['loc' => 'attractions/' . $d['slug'] . '.php', 'file' => 'attractions/' . $d['slug'] . '.php'];
}
foreach ($packages as $p) {
    $pages[] = ['loc' => 'packages/' . $p['slug'] . '.php', 'file' => 'packages/' . $p['slug'] . '.php'];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($pages as $page):
    $loc = htmlspecialchars($siteRoot . $page['loc']);
    $filePath = __DIR__ . '/' . $page['file'];
    $lastmod = is_file($filePath) ? date('Y-m-d', filemtime($filePath)) : null;
    $sep = strpos($page['loc'], '?') === false ? '?' : '&';
    $enUrl = htmlspecialchars($siteRoot . $page['loc'] . $sep . 'lang=en');
    $arUrl = htmlspecialchars($siteRoot . $page['loc'] . $sep . 'lang=ar');
?>
  <url>
    <loc><?= $loc ?></loc>
<?php if ($lastmod): ?>
    <lastmod><?= $lastmod ?></lastmod>
<?php endif; ?>
    <xhtml:link rel="alternate" hreflang="en" href="<?= $enUrl ?>" />
    <xhtml:link rel="alternate" hreflang="ar" href="<?= $arUrl ?>" />
    <xhtml:link rel="alternate" hreflang="x-default" href="<?= $enUrl ?>" />
  </url>
<?php endforeach; ?>
</urlset>
