<?php namespace ProcessWire;

// reset variables
$textDate = $date = '';

// archive text
$archiveText = ' / ' . sanitizer()->pascalCase($archivesUrlSlug) . ' / ';

// item year
$y = $sanitizer->pageName(input()->urlSegment2);
// item month
$m = $sanitizer->pageName(input()->urlSegment3);

// date to search archives
$date_s = "$y/$m/01";
$date_e = "$y/$m/31";

// if is archive url segments 2 or bigger
if( strlen(input()->urlSegment2) ) {

	// Show info about archive date
	$textDate = '<h2>' . sprintf(setting('archives-date'), $y, $m) . '</h2>';

	// title seo date
	$date =  " - $y/$m";

	// find items
	$items = pages()->find("template=blog-post, date>=$date_s, date<=$date_e, sort=-date, limit=12");

	// uikit icon
	$iconReply = "<i data-feather='arrow-left'></i>";

	// link to archives page
	$archiveText = "<a href='" . page()->url . $archivesUrlSlug . "/'>" . sanitizer()->pascalCase($archivesUrlSlug) . ' ' . $iconReply . "</a>";

		// if no items found
		if( count($items) == 0 ) {

			throw new Wire404Exception();

		}

} else { // find all items

	$items = pages()->find("template=blog-post, sort=-date, limit=12");

}

?>

<head id='html-head' data-pw-append>
	<meta name="robots" content="noindex,follow" />
</head>

<title id='title'><?= strtoupper( $archivesUrlSlug ) . $date ?></title>

<meta name="description" id='description' data-pw-remove/>

<p id='page-title'>
	<?= $archiveText ?>
</p>

	<ul id='breadcrumb' class='breadcrumb' data-pw-replace>
		<?php foreach (page()->parents->and(page()) as $key):?>
		<li><a href="<?= $key->url ?>"><?= $key->title ?></a></li>
		<?php endforeach; ?>
		<?php if( !strlen(input()->urlSegment3) ): ?>
		<li><span><?= $archivesUrlSlug ?></li></span>
		<?php else: ?>
		<li><a href='<?= page()->url . $archivesUrlSlug ?>/'><?= sanitizer()->pascalCase($archivesUrlSlug) ?></a>
		<li><span><?= "$y/$m" ?></span></li>
		<?php endif; ?>
	</ul>

<div id='content-body'>

	<?= $textDate ?>

	<form action="./">

		<select name='form' onchange='location = this.options[this.selectedIndex].value;'>

		<option value='#'><?= setting('select-archives') ?></option>

			<?= blogArchive() ?>

		</select>

	</form>

	<?= pagination($items, ['baseUrl' => "./"]) ?>

	<div class='archive-article'>
		<?php
			foreach ($items as $item) {
				files()->include('views/blog/parts/_blog-article.php', ['item' => $item]);
			}
		?>
	</div>

	<?= pagination($items, ['baseUrl' => "./"]) ?>

</div>
