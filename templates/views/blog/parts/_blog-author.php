<?php namespace ProcessWire;

//	author nick_name ( user Nick Name )
$user_nick = sanitizer()->pageName(input()->urlSegment2, true);
//	get user ( author ) from users
$postUser = users()->get("nick_pagename=$user_nick");
//	find all author ( user ) blog posts
$blogPosts = pages()->find("template=blog-post, created_users_id=$postUser->id, limit=12");
//	no items found
if( !count($blogPosts) ) {
	files()->include('views/blog/parts/_no-found.php');
//	ession()->redirect(pages()->get("template=blog")->httpUrl;
//	throw new Wire404Exception();
}
//	pagination
$pagination = pagination($blogPosts, ['baseUrl' => "./"]);
?>

<head id='html-head' data-pw-append>
	<meta name="robots" content="noindex,follow" />
</head>

<title id='title'><?= $postUser->nick_name ?></title>

<meta name="description" id='description' data-pw-remove/>

<p id='page-title'>
	/ <?= $postUser->nick_name ?> /
</p>

<ul id='breadcrumb'>
	<?php foreach (page()->parents->and(page()) as $key):?>
	<li><a href="<?= $key->url ?>"><?= $key->title ?></a></li>
	<?php endforeach; ?>
	<li><a href='<?= page()->url . $authorsUrlSlug ?>/'><?= setting('authors') ?></a></li>
	<li><?= $postUser->nick_name ?></li>
</ul>

<div id="content-body">

	<?= $pagination ?>

	<!-- BLOG POSTS -->
	<div class='blog-article'>
		<?php
			foreach ($blogPosts as $item) {
				echo files()->render('views/blog/parts/_blog-article.php',
					[
						'item' => $item,
						// 'options' => [],
					]);
			}
		?>
	</div>

	<?= $pagination ?>

</div>
