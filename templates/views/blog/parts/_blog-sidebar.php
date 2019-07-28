<?php namespace ProcessWire;

// translatable " authors " text
$authText = setting('authors');

// Categories
$categories = pages()->get("template=blog-categories");

// Tags
$tags = pages()->get("template=blog-tags");

// Recent Posts
$recentPosts = page()->parent->children('limit=6');

// AUTHORS / You should change the authors url slug in the _init.php file ( 'authors' => __('Authors') ) if the page has a different name than the authors
$authorsUrlSlug = sanitizer()->pageName($authText, true);
$authUrl = pages()->get("template=blog")->url . $authorsUrlSlug;
$blogAuthors = users()->find("nick_name!='', nick_pagename!='', limit=12");
// $blogAuthors = pages()->find("template=user, nick_name!='', nick_pagename!='', include=all, limit=2");
?>

<!-- RECENT POSTS -->
<h3><?= setting('recent-posts') ?></h3>
<ul class='sidebar-recent-posts'><?php
foreach ($tags->children("limit=10") as $item) {
   echo "<li><a title='$item->name' href='$item->url'>$item->title</a></li>";
}
?></ul>
<p>
	<a href='<?= page()->parent->url ?>'>
		<?= setting('more-posts') ?>
		<i data-feather="arrow-right"></i>
	</a>
</p>

<!-- CATEGORIES -->
<h3><?= $categories->title ?></h3>
<ul class='sidebar-categories'><?php
foreach ($categories->children("limit=10") as $item) {
   echo "<li><a title='$item->name' href='$item->url'>$item->title</a></li>";
}
?></ul>
<p>
	<a href='<?= $categories->parent->url ?>'>
		<?= $categories->title ?>
		<i data-feather="arrow-right"></i>
	</a>
</p>

<!-- TAGS -->
<h3><?= $tags->title ?></h3>
<ul class='sidebar-tags'><?php
foreach ($tags->children("limit=10") as $item) {
   echo "<li><a title='$item->name' href='$item->url'>$item->title</a></li>";
}
?></ul>
<p>
	<a href='<?= $tags->parent->url ?>'>
		<?= $tags->title ?>
		<i data-feather="arrow-right"></i>
	</a>
</p>

<!-- ARCHIVES -->
<h3> <?= setting('archives') ?>
<ul class='sidebar-archives'>
  <?= blogArchive() ?>
</ul>
<p>
	<a
		href='<?= pages()->get("template=blog")->url . sanitizer()->pageName(setting('archives')) . '/' ?>'>
		<?= setting('archives') ?>
		<i data-feather="arrow-right"></i>
	</a>
</p>

<!-- AUTHORS -->
<h3><?= $authText ?></h3>
<ul class='sidebar-autchors'>
		<?php
			foreach ($blogAuthors as $key => $author):
				$auth_url = pages()->get("template=blog")->url . $authorsUrlSlug . '/' .  $author->nick_pagename . '/';
		?>
	<li>
		<a href="<?= $auth_url ?>">
			/ <?= $author->nick_name ?>
		</a>
	</li>
	<?php endforeach; ?>

</ul>
<p>
	<a href='<?= $authUrl ?>/'>
		<?= $authText ?>
	</a>
	<i data-feather="arrow-right"></i>
</p>
