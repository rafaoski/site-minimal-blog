<?php namespace ProcessWire;

$categories = page()->children("limit=18");

//	no items found
if( !count($categories) ) {
	files()->include('views/blog/parts/_no-found.php');
}
?>

<div id="hero">
	<?php include('parts/_blog-links.php') ?>
</div>

<div id='content-body'>

<?= pagination($categories) ?>

<!-- BLOG POSTS -->
<div class='flex-center' style='flex-wrap: wrap'>
	<?php foreach($categories as $category): ?>
		<?php if (count($category->references())): ?>
			<a class='card-default' style='margin: 10px' href='<?=$category->url?>'>
				<div>
					<h4><?=$category->title?>
					<span>( <?= count($category->references()) ?> )</span></h4>
				</div>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<?= pagination($categories) ?>

</div>
