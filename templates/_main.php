<?php namespace ProcessWire;
/**
 * _main.php template file, called after a page’s template file
 *
 */

// reset variables
$img = $img_alt = '';

// Get First Image
if(page()->images && count(page()->images)) {
	$img = page()->images->first;
	$img_alt = $img->description ?: page()->title;
}
?>
<!DOCTYPE html>
<html lang="<?= setting('lang-code') ?>">
<head id='html-head'>
<?php // site head
	echo siteHead();
?>
</head>
<body id='html-body' class='<?= setting('body-classes')->implode(' ') ?>'<?= backgroundImage(['img' => $img]) ?>>
<?= linkCss() // Get the link css if the file ( assets/css/templates/{template-name.css }) exists ?>

	<!-- HEADER -->
	<header id="header" class="container-medium header">

		<p id='privacy-policy' class='privacy-policy'>
			<?= privacyPolicy() ?>
		</p>

		<?= langMenu(page()) ?>

		<p id='site-info' class='site-info flex-center flex-direction-column'>
			<?= siteInfo() ?>
		</p>

		<ul id='breadcrumb' class='breadcrumb'><?= breadCrumb() ?></ul>

		<nav id='main-nav' class='main-nav'><?= navLinks() ?></nav>

	</header>

	<!-- HERO -->
	<div id="hero" class='container-medium m-t flex-center flex-wrap-mobile hero' data-pw-optional>

		<div id='left-hero' class="flex-center flex-direction-column flex-wrap-mobile left-hero">

			<?= page()->if("meta_title", "<h1>{meta_title}</h1>") ?>

			<?php if ($img): ?>
				<img src='<?= $img->url ?>' class='responsive' alt='<?= $img_alt ?>'>
			<?php endif ?>

		</div>

		<?= page()->if("meta_description", "<h2 class='right-hero'>{meta_description}</h2>") ?>

	</div>

	<!-- CONTENT BODY -->
	<div id="content-body" class='container content-body'>
		<?= page()->body ?>
	</div>

	<?= editPage() ?>
	<?= debugInfo() ?>

	<!-- FOOTER -->
	<footer id='footer' class='container-full footer'>

		<?= searchForm() ?>

		<?= socialProfiles(['class' => 'social-profiles flex-center']) ?>

		<p id='copyright' class='copyright flex-center'>
			<small>&copy; <?= date('Y') ?> &bull;</small>
			<a href='https://processwire.com' target='_blank' rel='noopener noreferrer'>Powered by ProcessWire CMS</a>
		</p>

	</footer>

<?php
// Google Fonts
echo googleFonts( ['fonts' => ['Nunito:200,600']] );
// echo gwCode( setting('gw-code') );
// echo gaCode( setting('ga-code') );
?>
<script>
window.addEventListener('<?php if (!user()->isLoggedin()) echo 'turbolinks:';?>load', function() {
  feather.replace();
})
</script>

</body>
</html>
