<?php namespace ProcessWire;

// get all blog entries
$blogPosts = pages()->get("template=blog-posts")->children("limit=12");

// no found
if( !count($blogPosts) ) {
	files()->include('views/blog/parts/_no-found.php');
}

// pagination
$pagination = pagination($blogPosts);
?>

<div id="content-body">

	<?= $pagination ?>

	<!-- BLOG POSTS -->
	<div class='blog-posts'>
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
