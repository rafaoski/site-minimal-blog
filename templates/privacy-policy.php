<?php namespace ProcessWire; ?>

<div id="hero" class='hero' data-pw-optional>

	<?= page()->if("meta_title", "<h1>{meta_title}</h1>") ?>
	<?= page()->if("meta_description", "<h2 class='right-hero'>{meta_description}</h2>") ?>

</div>