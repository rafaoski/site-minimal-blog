<?php namespace ProcessWire;

$tags = page()->children("limit=40");

// no items found
if( !count($tags) ) {
	files()->include('views/blog/parts/_no-found.php');
}
?>

<div id="hero">
	<?php include('parts/_blog-links.php') ?>
</div>

<div id='content-body'>

<?= pagination($tags) ?>

<!-- BLOG POSTS -->
<div class='flex-center' style='flex-wrap: wrap'>
	<?php foreach($tags as $tag): ?>
		<?php if (count($tag->references())): ?>
		<a class='card-default' style='margin: 20px;' href='<?=$tag->url?>'>
			<div>
				<?=$tag->title?>
				<span>( <?= count($tag->references()) ?> )</span>
				</div>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<?= pagination($tags) ?>

</div>
