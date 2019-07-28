<?php namespace ProcessWire;

// if isset Options from render or included files
isset($options) ? '' : $options = array();

// default options to merge
$defaults = [
	'disable_img' => false,
	'img_width' => count($item->images) ? $item->images->first->width : '',
	'img_height' => count($item->images) ? $item->images->first->height : '',
	// you should change the authors url slug in the _init.php file ( 'authors' => __('Authors') ) if the page has a different slug than the authors
	'authors_url_slug' => sanitizer()->pageName(setting('authors')),
	// user Nick Name
	'nick_name' => $item->createdUser->nick_name,
	// user slug to page
	'nick_pagename' => sanitizer()->pageName($item->createdUser->nick_pagename, true),
	// unformatted date from fields ( date )
	'date' => wireDate('Y/m/d', $item->getUnformatted("date")),
	'date_archives_url' => pages()->get("template=blog")->url .
			sanitizer()->pageName(setting('archives')) . '/' . wireDate('Y/m/', $item->getUnformatted("date")),
];

// Merge Options
$options = array_merge($defaults, $options);
?>

<article class='blog-article <?= 'article_' . $item->id ?>'>
	<header>
		<?php
		// if is blog post
		if ($item->id == page('id')): ?>
		<h1 class='blog-title'>
			/ <?= $item->title ?>
		</h1>
		<?php else: ?>
		<h3 class='blog-title'>
			<a title="<?= $item->title ?>" href="<?= $item->url ?>">
				/ <?= $item->title ?>
			</a>
		</h3>
		<?php endif; ?>

		<p>
			<a href="<?= $options['date_archives_url'] ?>">
			<i data-feather="calendar"></i>
				<?= $options['date'] ?>
			</a>

			<?php if($options['nick_pagename']): ?> |
			<a href="<?= pages()->get("template=blog")->url . "$options[authors_url_slug]/" . $options['nick_pagename']; ?>/">
			<i data-feather="user"></i> <?= $options['nick_name'] ?>
			</a>
			<?php endif; ?>

			<?php // num comments
				if ( count($item('comments')) && setting('comments') ):
					$comments_count = $item->get('comments')->count();
			?> |
			<a href='<?=$item->url ?>#comments'>
			<i data-feather="message-square"></i> <?= $comments_count ?>
			</a>
			<?php endif; ?>
		</p>
	</header>

	<?php if (count($item->images) && $options['disable_img'] == false): ?>
	<figure class='flex-center'>
		<div>
			<a href="<?= page()->template != 'blog-post' ? $item->url : $item->images->first->url ?>">
				<img src="<?= $item->images->first->url ?>" class='responsive' alt="<?= $item->images->first->description ?: $item->name?>"
				width='<?= $options['img_width'] ?>' height='<?= $options['img_height'] ?>'>
			</a>
			<?php if ($item->images->first->description): ?>
			<figcaption style='display: block; font-size: 16px'><?= $item->images->first->description ?></figcaption>
			<?php endif; ?>
		</div>
	</figure>
	<?php endif; ?>

	<?php // if is blog post
		if ($item->id == page('id')):
	?>

	<?= $item->body ?>

	<footer>
		<?php if (count($item->categories)): ?>
		<div>
		<i data-feather="hash" style='width: 20px; height: 20px;'></i>
			<?= $item->categories->each("<a href='{url}'>{title}</a> ") ?>
		</div>
		<?php endif; ?>

		<?php if (count($item->tags)): ?>
		<div>
			<i data-feather="maximize" style='width: 20px; height: 20px;'></i>
			<?= $item->tags->each("<a href='{url}'>{title}</a> ") ?>
		</div>
		<?php endif; ?>
	</footer>

	<?php else: ?>
		<p><?= $item->render('body', 'text-medium') ?></p>
		<a href="<?= $item->url ?>" title="<?= setting('read-more') ?>">
		<i data-feather="arrow-right"></i> <?= setting('read-more') ?>
		</a><hr>
	<?php endif; ?>

</article>
