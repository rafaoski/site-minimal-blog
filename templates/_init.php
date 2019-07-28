<?php namespace ProcessWire;
/**
 * This _init.php file is called automatically by ProcessWire before every page render
 *
 */

/** @var ProcessWire $wire */

urls()->set('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');


setting([
// GET Home Page
	'home' => pages()->get('/'),
// Custom body class
	'body-classes' => WireArray([
		'template-' . page()->template->name,
		'page-' . page()->id,
	]),
// Blog Options
	'comments' => true, // Blog Comments
	'to-any' => true, // Universal Sharing Buttons ( https://www.addtoany.com/ )
// Options Page
	'logo' => pages('options')->logo ? pages('options')->logo->url : '',
	'favicon' => pages('options')->favicon ? pages('options')->favicon->url : '',
	'background-image' => true, // Body Background Image
	'gw-code' => 'GOOGLE WEBMASTER CODE',
	'ga-code' => 'GOOGLE ANALYTICS CODE',
// Get Styles
	'css-files' => WireArray([
		urls('templates') . 'assets/css/main.css'
	]),
// Get Scripts
	'js-files' => WireArray([
		'https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js',
		'https://unpkg.com/feather-icons',
	// urls('templates') . 'assets/js/app.js',
	]),
// Basic Transate
	'current-page' => __('Current page: '),
	'lang-code' => __('en'),
	'edit' => __('Edit'),
	'next' => __('Next'),
	'previous' => __('Previous'),
	'more-pages' => __('More Pages'),
	'search-placeholder' => __('Search'),
	'search-label' => __('Search Word'),
	'found-pages' => __("Found %d page(s)."),
	'no-found' =>  __('Sorry, no results were found.'),
	'read-more' => __('Read more'),
	'e-mail' => __('E-Mail'),
	'phone' => __('Phone'),
	'adress' => __('Adress'),
	'all-right' => __('All Rights Reserved'),
// Blog Translate
	'in-blog' => __('In The Blog'),
	'posted-in' => __('Posted in'),
	'all-posts' => __('All posts'),
	'recent-posts' => __('Recent posts'),
	'more-posts' => ('More posts'),
	'written-on' => __('Written on'),
	'byline-text' => __('Posted by %1$s on %2$s'),
	'also-like' => __('You might also like:'),
	'select-archives' => __('Select Archives'),
	'archives-date' => __('Date: %s/%s'),
// The translation ("archives") is important for the pages of the archives of the blog. Adds a clean URL segment ...
	'archives' => __('Archives'), // Do not delete this translation !!!
// The translation ("authors") is important for the pages of the authors of the blog. Adds a clean URL segment ...
	'authors' => __('Authors'), // Do not delete this translation !!!
	'rss-title' => __('Recent Posts'),
	'rss-description' => __('The most recent pages updated on my site'),
	'max-note' => __('%d more (not shown)', __FILE__),
	'no-found' => __('No Items Found'),
// Comments Form Translate
	'post-comment' => __('Post a comment'),
	'comment-text' => __('Comments'),
	'success-message' => __('Thank you, your comment has been posted.'),
	'pending-message' => __('Your comment has been submitted and will appear once approved by the moderator.'),
	'error-message' => __('Your comment was not saved due to one or more errors.') . ' ' .
	__('Please check that you have completed all fields before submitting again.'),
	'comment-cite' => __('Your Name'),
	'comment-email' => __('Your E-Mail'),
	'comment-website' => __('Website'),
	'comment-stars' => __('Your Rating'),
	'comment-submit' => __('Submit'),
	'stars-required' => __('Please select a star rating'),
// Pagination Translate
	'next' => __('Next'),
	'previous' => __('Previous'),
]);

include_once('./_func.php');

// ADD USER => https://processwire.com/api/variables/user/
	// $u = $users->add('user-demo');
	// $u->pass = "demo99";
	// $u->addRole("guest");
	// $u->save();

// RESET PASSWORD => https://processwire.com/talk/topic/1736-forgot-backend-password-how-do-you-reset/
	// $u = $users->get('admin'); // or whatever your username is
	// $u->of(false);
	// $u->pass = 'your-new-password';
	// $u->save();

/*
( ProcessWire API variables ) https://processwire.com/docs/start/variables/
( Page ) https://processwire.com/docs/start/variables/page/
( Pages ) https://processwire.com/docs/start/variables/pages/
( Images ) https://processwire.com/docs/fields/images/
( New functions API ) https://processwire.com/blog/posts/processwire-3.0.39-core-updates/#new-functions-api
( More on the Functions API ) https://processwire.com/blog/posts/processwire-3.0.40-core-updates/
( Markup regions ) https://processwire.com/docs/front-end/output/markup-regions/
( Get or set a runtime site setting ) https://processwire.com/api/ref/functions/setting/
( New $page->if() method ) https://processwire.com/blog/posts/pw-3.0.126/
( Optimize field use ) https://processwire.com/blog/posts/making-efficient-use-of-fields-in-processwire/
( Modules ( plugins ) and hooks ) https://processwire.com/docs/modules/
( Yes, it’s that simple! ;) ) https://processwire.com/blog/posts/building-custom-admin-pages-with-process-modules/
*/
