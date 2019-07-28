<?php namespace ProcessWire;

// find all authors
$blogAuthors = pages()->find("template=user, nick_name!='', nick_pagename!='', include=all, limit=24");

// no items found
if( !count($blogAuthors) ) {
	files()->include('views/blog/parts/_no-found.php');
}
// pagination
$pagination = pagination($blogAuthors, ['baseUrl' => "./"]);
?>

<head id='html-head' data-pw-append>
	<meta name="robots" content="noindex,follow" />
</head>

<title id='title'><?= setting('authors') ?></title>
<meta name="description" id='description' data-pw-remove/>

<p id='page-title'>
	/ <?= setting('authors') ?> /
</p>

<ul id='breadcrumb' data-pw-replace>
	<?php foreach (page()->parents->and(page()) as $key):?>
	<li><a href="<?= $key->url ?>"><?= $key->title ?></a></li>
	<?php endforeach; ?>
	<li><span><?= setting('authors') ?></span></li>
</ul>

<div id="content-body">

	<?= $pagination ?>

	<!-- BLOG AUTHORS -->
	<?php if ( count($blogAuthors) ): ?>
	<div class="content-blog-authors flex-center" style="flex-wrap: wrap">
		<?php foreach ($blogAuthors as $author): ?>
			<a class='card-default' style='margin: 20px;'
				href="<?= pages()->get("template=blog")->url . $authorsUrlSlug . '/' . sanitizer()->pageName($author->nick_name , true) . '/' ?>">
				<div>
					<h4><?= $author->nick_name ?></h4>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?= $pagination ?>

</div>
