<?php namespace ProcessWire;

$blogPage = pages()->get("template=blog");
?>
<head id='html-head' pw-append>
<script src='<?= urls('jquery') ?>' defer></script>
<script src='<?= urls()->FieldtypeComments ?>comments.min.js' defer></script>
<link rel="stylesheet" href="<?= urls()->FieldtypeComments ?>comments.css">
</head>

<div id="hero" data-pw-remove></div>

<p id='page-title'>
	<a href='<?= page()->parent->url ?>'>
		<?= page()->parent->title ?>
		<i data-feather="arrow-left"></i>
	</a>
</p>

<div id='content-body'>

	<!-- CONTENT BLOG -->
	<div class='content-post'>

		<!-- CONTENT ARTICLE -->
		<div class='content-article'>
			<?php
				// blog article
				echo files()->render('views/blog/parts/_blog-article.php',
				[
					'item' => page(),
					// 'options' => [],
				]);

				// page links
				echo files()->render('views/template-parts/_page-links.php');

				// if comments
				if( setting('comments') ) {
					include('parts/_blog-comments.php');
				}
			?>
		</div>

		<!-- SIDEBAR -->
		<div class='content-sidebar'>
			<?php include('parts/_blog-sidebar.php') ?>
		</div>

	</div>

	<!-- PREVIOUS NEXT POST MENU -->
	<div class="nav-page flex-center" style='justify-content: space-around; flex-wrap: wrap;'>
		<?= prNx(page()) ?>
	</div>

<?php
// Universal Sharing Buttons ( https://www.addtoany.com/ )
echo toAny(
	[
		'twitter' => true,
		'facebook' => true,
		'email' => true
	])
?>
</div>
