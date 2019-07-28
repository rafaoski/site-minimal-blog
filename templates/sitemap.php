<?php namespace ProcessWire; ?>

<div id='hero' data-pw-remove></div>

<div id="content-body">

<?php
	$maxDepth = 4;
	renderNavTree($pages->get('/'), $maxDepth);
?>

</div>
