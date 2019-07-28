<?php namespace ProcessWire;

// authors url slug
$authorsUrlSlug = sanitizer()->pageName(setting('authors'));
// archives url slug
$archivesUrlSlug = sanitizer()->pageName(setting('archives'));

// bog links
$blogLinks = [
// categories
  0 => pages()->get("template=blog-categories"),
// tags
  1 => pages()->get("template=blog-tags"),
// list posts
  2 => pages()->get("template=blog"),
// authors
  3 => pages()->get("template=blog-posts"),
// archives
  4 => pages()->get("template=blog"),
// RSS
  5 => pages()->get("template=blog-rss")
];

// icons
$blogIcons = ['hash','maximize','user', 'crosshair','archive','rss']
?>

<!-- BLOG LINKS -->
<div id='blog-links' class='blog-links m-t m-b'>
	<?php foreach ($blogLinks as $key => $link):
	// title / aria-label / link url
		if($blogIcons[$key] == 'user') {
			$title = setting('authors');
			$link_url = $link->url . "$authorsUrlSlug/";
			} else if($blogIcons[$key] == 'archive') {
			$title = setting('archives');
			$link_url = $link->url . "$archivesUrlSlug/";
			} else {
			$title = $link->title;
			$link_url = $link->url;
			}
	?>
		<a href='<?= $link_url ?>' aria-label="<?= $title ?>">
		<i data-feather="<?= $blogIcons[$key] ?>"></i>
		<span><?= $title ?></span>
		</a>
	<?php endforeach; ?>
</div>
