<?php namespace ProcessWire; ?>

<?php if (page()->hasChildren()): ?>

<div id="content-body" pw-append>

	<h3><?= setting('more-pages') ?></h3>

	<div class='flex-center' style='flex-wrap: wrap'>

		<?php foreach (page()->children() as $item): ?>
		<a class="card-default" style='margin: 20px;' href='<?= $item->url ?>'>
			<div>
				<h4><?= $item->title ?></h4>
			</div>
		</a>
		<?php endforeach; ?>

	</div>

</div>

<?php endif;
