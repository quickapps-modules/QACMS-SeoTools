<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?xml-stylesheet type="text/xsl" href="<?php echo $this->Html->url('/seo_tools/xsl/xml-sitemap.xsl'); ?>"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/', true); ?></loc>
		<priority>1.0</priority>
	</url>

	<?php foreach ($urlset['url'] as $url): ?>
	<url>
		<loc><?php echo $url['loc']; ?></loc>
		<lastmod><?php echo $url['lastmod']; ?></lastmod>
	</url>
	<?php endforeach; ?>
</urlset>