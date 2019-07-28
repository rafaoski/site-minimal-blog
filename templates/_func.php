<?php namespace ProcessWire;

/**
 * Return link css if the directory ( assets/css/templates/{template-name.css }) exists
 *
 * @param array|string $options Options to modify default behavior:
 *  - `link_href` (link): link href to css file.
 *  - `file_location` (link): Check is a file exists.
 *
 */
function linkCss($options = array())
{

// File location
$fileLocation = 'assets/css/templates/' . page()->template->name . '.css';

// Default Options
$defaults = array(
	// get url to css
		'link_href' => urls('templates') . $fileLocation,
		'file_location' => __DIR__ . '/' . $fileLocation,
	);
	// Merge Options
	$options = _mergeOptions($defaults, $options);

	if( !file_exists($options['file_location']) ) return;

	return "\n\t<link rel='stylesheet' href='$options[link_href]'>\n";
}

/**
 * Return Blog Archives
 *
 * @param array|string $options Options to modify default behavior:
 *  - `end_date` (date): or whenever you want it to end like 2019.
 *  - `start_date` (date): or whenever you want it to start like 2017.
 *  - `count_months` (number): How many show the monthly archives in the sidebar of the blog.
 *
 */
function blogArchive($options = array())
{

// $out is where we store the markup we are creating in this function
$out = '';
// Get blog page
$blogPage = pages()->get("template=blog-posts");

// Default Options
$defaults = array(
// Like First Blog Post ( 2016 )
	'start_date' => wireDate('Y', $blogPage->children()->last()->getUnformatted("date")),
// Like Last Blog Post ( 2019 )
	'end_date' => wireDate('Y', $blogPage->children()->first()->getUnformatted("date")),
// How many show the monthly archives in the sidebar of the blog.
	'count_months' => 12,
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// CODE FROM => https://processwire.com/talk/topic/263-creating-archives-for-newsblogs-sections/
		for ($year = $options['end_date']; $year >= $options['start_date']; $year--) {

				for ($month = 12; $month > 0; $month--) {
						$startTime = strtotime("$year-$month-01"); // 2011-12-01 example
						if ($startTime > time()) {
								continue; // don't bother with future dates
						}
						if ($month == 12) {
								$endTime = strtotime(($year+1) . "-01-01");
						} else {
								$endTime = strtotime("$year-" . ($month+1) . "-01");
						}
						// All archive entries
						$entries = $blogPage->children("date>=$startTime, date<$endTime");
						// Get item url slug date
						$date = date("Y/m", $startTime);
						// Archive url slug
						$url = pages()->get("template=blog")->url . sanitizer()->pageName(setting('archives')) . '/' . $date . '/';
						// If count entries bigger than 0
						if (count($entries) > 0) {
						// if is archive page show form option value
							if(input()->urlSegment1 == sanitizer()->pageName(setting('archives'))) {
								$out .= "<option value='$url'>$date - (" . count($entries) . ")</option>";
							} else {
						// How many show the monthly archives in the sidebar of the blog ( $options['count_months'] )
							if(count($entries) <= $options['count_months']) {
								$out .= "<li><a href='$url'>$date - (" . count($entries) . ")</a></li>";
							}

							}
						}
				}
		}

		return $out;
}

/**
 * Return Previous Next Button Page
 * Basic Example echo prNx($page)
 *
 * @param Page $item
 *
 */
function prNx(Page $item)
{
// If  item is empty return null
if(!$item) return;

// $out is where we store the markup we are creating in this function
$out = '';

// Prev Next Button
		$p_next = $item->next();
		$p_prev = $item->prev();

// link to the prev blog post, if there is one
		if ($p_prev->id) {
		$out .= "<a href='$p_prev->url'>";
		$out .= "<i data-feather='arrow-left'></i>" . $p_prev->title . "</a>";
		}

// link to the next blog post, if there is one
		if ($p_next->id) {
				$out .= "<a href='$p_next->url'>";
				$out .= $p_next->title . "<i data-feather='arrow-right'></i>" . "</a>";
		}

		return $out;
}

/**
 * Return AddToAny social share buttons script
 * https://www.addtoany.com/
 *
 * @param array $options Basic Usage toAny(['twitter' => true'])
 * 'twitter' => true,
 * 'facebook' => true,
 * 'google_plus' => false,
 * 'linkedin' => false,
 * 'rreddit' => false,
 * 'email' => false,
 * 'google_gmail' => false,
 * 'share_all' => true,
 *
 */
function toAny($options = array())
{
// If setting 'to-any' is not set true ( see _init.php setting() ) return null
	if( setting('to-any') == false ) return;
// $out is where we store the markup we are creating in this function
	$out = '';
// Reset variables
	$buttonLinks = '';
// Default share links
	$links = [
		'twitter' => "<a class='a2a_button_twitter'></a>",
		'facebook' => "<a class='a2a_button_facebook'></a>",
		'google_plus' => "<a class='a2a_button_google_plus'></a>",
		'linkedin' => "<a class='a2a_button_linkedin'></a>",
		'rreddit' => "<a class='a2a_button_reddit'></a>",
		'email' => "<a class='a2a_button_email'></a>",
		'google_gmail' => "<a class='a2a_button_google_gmail'></a>",
		'share_all' => "<a class='a2a_dd' href='https://www.addtoany.com/share'></a>"
	];
// Foreach Items
	foreach ($options as $key => $value) {
		if($options[$key] == true) {
			$buttonLinks .= $links[$key];
		}
	}
// Start Content
	$out .= "<!-- AddToAny BEGIN -->
	<div class='a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style'
			 style='left:0px; top:100px; background-color: #2e2d2d99;'>";
	$out .= $buttonLinks; // Show Links
	$out .= "</div>
	<script async src='https://static.addtoany.com/menu/page.js'></script>
	<!-- /AddToAny END -->";
	return $out;
}

/**
 * Return site head
 *
 * @param array|string $options Options to modify default behavior:
 *  - `css` (url): CSS files url.
 *  - `js` (url): JS files url.
 *  - `favicon` (url): Favicon url.
 *  - `title` (string): Meta title.
 *  - `description` (string): Meta description.
 *
 */
function siteHead($options = array())
{

	// $out is where we store the markup we are creating in this function
	$out = '';

	// Default Options
	$defaults = array(
		'css' => setting('css-files'),
		'js' => setting('js-files'),
		'favicon' => setting('favicon'),
		'title' => page('meta_title|title'),
		'description' => page('meta_description')
	);
	// Merge Options
	$options = _mergeOptions($defaults, $options);

	// disable turbolinks if the user is logged in
	if (user()->isLoggedin()) {
		unset($options['js'][0]); // unset turbolinks
	}

	$out.= "<meta http-equiv='content-type' content='text/html; charset=utf-8'>\n";
	$out.= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
	$out.= "<link rel='icon' href='$options[favicon]'/>\n";
	$out.= "<title id='title'>$options[title]</title>\n";
	$out.= "<meta id='description' name='description' content='$options[description]'/>\n";
	$out.= $options['css']->each("<link rel='stylesheet' href='{value}'>\n");
	$out.= $options['js']->each("<script src='{value}' defer></script>\n");
	$out.= hreflang(page()); // the hreflang parameter
	$out.= seoPagination(); // seo meta robots ( 'noindex, follow' ) or seo pagination

	return $out;
}

/**
 * Return the hreflang parameter
 *
 * @param Page $page
 *
 */
function hreflang(Page $page)
{
  if(!$page->getLanguages()) return;
  if (!modules()->isInstalled("LanguageSupportPageNames")) return;

  // $out is where we store the markup we are creating in this function
  $out = '';

  // handle output of 'hreflang' link tags for multi-language
  foreach(languages() as $language) {
	// if this page is not viewable in the language, skip it
	if(!$page->viewable($language)) continue;
	// get the http URL for this page in the given language
	$url = $page->localHttpUrl($language);
	// hreflang code for language uses language name from homepage
	$hreflang = setting('home')->getLanguageValue($language, 'name');
	if($hreflang == 'home') $hreflang = setting('lang-code');
	// output the <link> tag: note that this assumes your language names are the same as required by hreflang.
	$out .= "<link rel='alternate' hreflang='$hreflang' href='$url' />\n";
  }
  return $out;
}

/**
 * Return seo meta robots ( 'noindex, follow' ) or seo pagination
 *
 * @return mixed
 *
 */
function seoPagination()
{
// If not any pageNum or pageHeaderTags
if( input()->pageNum == null || config()->pagerHeadTags == null ) return;

// $out is where we store the markup we are creating in this function
	$out = '';

// https://processwire.com/blog/posts/processwire-2.6.18-updates-pagination-and-seo/
		if (input()->pageNum > 1) {
				$out .= "<meta name='robots' content='noindex,follow'>\n";
		}
// https://weekly.pw/issue/222/
		if (config()->pagerHeadTags) {
				$out .= config()->pagerHeadTags . "\n";
		}
		return $out;
}

/**
 * Return Navigation Links
 *
 * @param array|string $options Options to modify default behavior:
 *  - `root_url` (link): Home Page URL.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function navLinks($options = array())
{

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'root_url' => pages('/')->and(pages('/')->children)
);
// Merge Options
$options = _mergeOptions($defaults, $options);

		foreach($options['root_url'] as $item) {
			$class = $item->id == page()->id ? 'current-item' : 'no-current';
			$out .= "<a class='$class' href='$item->url'>$item->title</a>\n";
		}

  return $out;
}

/**
 * Return Language Menu
 *
 * @param Page $page
 * @param string $id
 *
 */
function langMenu(Page $page, $id = 'lang-menu')
{
if(!$page->getLanguages()) return;
if (!modules()->isInstalled("LanguageSupportPageNames")) return;
// $out is where we store the markup we are creating in this function
$out = "\n\t<div id='$id'>\n";

foreach(languages() as $language) {
  if(!$page->viewable($language)) continue; // is page viewable in this language?
	$class = $language->id == user()->language->id ? 'current-item' : 'no-current';
	$url = $page->localUrl($language);
	$hreflang = setting('home')->getLanguageValue($language, 'name');
	if($hreflang == 'home') $hreflang = setting('lang-code');
	$out .= "\t\t<a class='lang-item $class' hreflang='$hreflang' href='$url'>$language->title</a>\n";
}
$out .= "\t</div>\n\n";
return $out;
}

/**
 * Given a group of pages render a tree of navigation
 *
 * @param Page|PageArray $items Page to start the navigation tree from or pages to render
 * @param int $maxDepth How many levels of navigation below current should it go?
 *
 */
function renderNavTree($items, $maxDepth = 3) {

	$currentPage = setting('current-page');

	// if we've been given just one item, convert it to an array of items
	if($items instanceof Page) $items = array($items);

	// if there aren't any items to output, exit now
	if(!count($items)) return;

	// $out is where we store the markup we are creating in this function
	// start our <ul> markup
	echo "<ul class='nav nav-tree'>";

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class and
		// visually hidden text for screen readers to it
		if($item->id == wire('page')->id) {
			echo "<li class='current' aria-current='true'><span class='visually-hidden'>$currentPage</span>";
		} else {
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a>";

		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children
		if($item->hasChildren() && $maxDepth) {
			renderNavTree($item->children, $maxDepth-1);
		}

		// close the list item
		echo "</li>";
	}

	// end our <ul> markup
	echo "</ul>";
}

/**
 * Return Breadcrumbs
 *
 * @param array|string $options Options to modify default behavior:
 *  - `page` (Page|PageArray): Home Page URL.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function breadCrumb($options = array())
{
	if(page()->template == 'home' || page()->parent->template == 'home') return;

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'page' => page(),
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// breadcrumbs are the current page's parents
foreach ($options['page']->parents as $item) {
	$out .= "<li><a href='$item->url'>$item->title</a></li>";
}

// optionally output the current page as the last item
	$out .= $options['page']->parents->id != 1  ? "<li>{$options['page']->title}</li>" : '';

// return breadcrumb
	return $out;
}

/**
 * Return background image
 *
 * @param array|string $options Options to modify default behavior:
 *  - `img` (url): Image url.
 *
 */
function backgroundImage($options = array())
{

// Default Options
	$defaults = array(
		'img' => null,
	);
// Merge Options
	$options = _mergeOptions($defaults, $options);

	if ( setting('background-image') && $options['img'] ) {
		return  " style='background-image: linear-gradient( rgba(255, 255, 255, 0.92), rgba(216, 216, 216, 0.88) ), url({$options['img']->url});'";
	}
}

/**
 * Return Privacy Policy Page
 *
 * @param array|string $options Options to modify default behavior:
 *	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *  - `privacy_page` (link): URL to privacy page.
 *  - `read_more` (string): Read more text.
 *
 */
function privacyPolicy($options = array())
{
// Default Options
$defaults = array(
	'privacy_page' => pages()->get("template=privacy-policy"),
	'read_more' => setting('read-more'),
  );
// Merge Options
$options = _mergeOptions($defaults, $options);
  	return "
	<span class='privacy-text'>
		<i data-feather='info'></i>
		{$options['privacy_page']->meta_title}
	</span>

	<a href='{$options['privacy_page']->url}'>
		$options[read_more]
	</a>
  ";
}

/**
 * Return Social Profiles
 *
 * @param array|string $options Options to modify default behavior:
 *  - `social_profiles` (link): URL to social profiles separate with comma like.
 *  - `id` (string): Selector id.
 *  - `class` (string): Selector class.
 * `https://facebook.com/,`
 * `https://twitter.com/processwire,`
 * `https://youtube.com/,`
 * `https://instagram.com/,`
 * `https://github.com/processwire/processwire`
 *
 */
function socialProfiles($options = array())
{

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'social_profiles' => pages('options')->textarea,
	'id' => 'social-profiles',
	'class' => 'social-profiles'
  );
// Merge Options
$options = _mergeOptions($defaults, $options);

// Explode to array
$items = explode(',', $options['social_profiles']);
// Remove NULL, FALSE and Empty Strings ("") ( https://www.php.net/manual/en/function.array-filter.php#Hcom111091 )
$items = array_filter($items, 'strlen');
$out .= "<p id='$options[id]' class='$options[class]'>";
  	// Start loop
  	foreach ($items as $item) {
  	// Get clean url
	$getUrl = sanitizer()->text($item, ['reduceSpace' => true]);
  	// Remove ( https:// ) from url like ( https://twitter.com )
	$profileName = substr($getUrl, 8);
  	// Get first position ( .com )
	$pos = strpos($profileName, '.com/');
  	// Show clean icon name like: ( 'twitter', 'facebook')
	$profileName = substr($profileName, 0, $pos);

  	// Or cut the profileName in this way
	// $pos = strpos($getUrl, '.com/');
	// $profileName = substr($getUrl, 8, $pos - 8);

  // Prepare link to social profiles
	$out .= "\n<a class='social-item $profileName' title='$profileName' href='$getUrl' target='_blank' rel='noopener noreferrer'>";
	$out .= "<i data-feather='$profileName'></i></a>\n";
  }

  	$out .= "</p>";

	// Return all Social Profiles
	return $out;
}

/**
 * Return Site Info => Logo / Site Name / Page Title
 *
 * @param array|string $options Options to modify default behavior:
 *  - `home_url` (link): Home Page URL.
 *  - `logo_url` (link): Site logo URL.
 *  - `logo_alt` (string): Loago alt text.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function siteInfo($options = array())
{
// $out is where we store the markup we are creating in this function
	$out = '';

// Default Options
  $defaults = array(
	'home_url' => setting('home')->url,
	'logo_url' => pages('options')->logo ? pages('options')->logo->url : '',
	'logo_alt' => pages('options')->site_name
  );
// Merge Options
  	$options = _mergeOptions($defaults, $options);
// Display logo
	$out .= "<a href='$options[home_url]'>";
	$out .= "<img src='$options[logo_url]' alt='$options[logo_alt]'></a>";
	if (page()->template == 'home') {
		$out .=	 "<span id='site-name' class='site-name'>" . pages('options')->site_name . '</span>';
	} else {
		$out .=	 "<span id='page-title' class='site-name page-title'>/ " . page()->title . ' /</span>';
	}

// Return logo / Site Name
	return $out;
}

/**
 * Return search form
 *
 * @param array|string $options Options to modify default behavior:
 *  - `search_page` (link): search page URL.
 *  - `input_placeholder` (string): input placeholder text.
 *  - `search_label` (string): label text.
 *
 */
function searchForm($options = array())
{

// Default Options
$defaults = array(
  'search_page' => pages()->get('template=search')->url,
  'input_placeholder' => setting('search-placeholder'),
  'search_label' => setting('search-label')
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// return search form
return "
  <form id='search-f' class='p-20 search-f' action='$options[search_page]' method='get'>
	<label for='q'>$options[search_label]</label>
	<input type='search' name='q' class='s-input' id='q' placeholder='$options[input_placeholder] &hellip;' required>
  </form>";
}

/**
 *  Return Basic Pagination
 *  https://processwire.com/docs/front-end/markup-pager-nav/
 *
 * @param PageArray $results
 *
 */
function pagination(PageArray $results)
{
  return $results->renderPager(array(
	'nextItemLabel' => setting('next'),
	'previousItemLabel' => setting('previous'),
	'listMarkup' => "<ul class='MarkupPagerNav flex-center' style='list-style: none'>{out}</ul>",
	'itemMarkup' => "<li class='{class}' style='margin: 5px'>{out}</li>",
	'linkMarkup' => "<a href='{url}'><span>{out}</span></a>"
));
}

/**
 * Return Google Webmaster Tools Verification Code
 *
 * @param string $code
 *
 */
function gwCode($code)
{
// If code is empty return null
if(!$code) return;
// Return Google Verification Code
return "<meta name='google-site-verification' content='$code' />\n";
}

/**
 * Return Google Analytics Tracking Code
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 *
 * @param string $code {your-google-analytics-code}
 *
 */
function gaCode($code)
{
// If code is empty return null
if(!$code) return;
// Return Google Analytics Tracking Code
return "<script defer src='https://www.googletagmanager.com/gtag/js?id=UA-{$code}'></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-{$code}');
</script>\n\n";
}

/**
 * Return Google Fonts
 *
 * @param array|string $options Options to modify default behavior:
 *  - `fonts` (array): Font families from google fonts ( https://fonts.google.com/ ).
 *
 */
function googleFonts($options = array()) {

// Default Options
$defaults = array(
  'fonts' => ['Nunito:200,600','Hanalei','Butcherman'],
);
// Merge Options
$options = _mergeOptions($defaults, $options);

$fonts = "'" . implode("','" , $options['fonts']) . "'";

return "<script>
/* ADD GOOGLE FONTS WITH WEBFONTLOADER
  https://github.com/typekit/webfontloader
*/
WebFontConfig = {
		google: {
		families: [$fonts]
	}
};
(function(d) {
	var wf = d.createElement('script'), s = d.scripts[0];
	wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
	wf.async = true;
	s.parentNode.insertBefore(wf, s);
})(document);
</script>\n\n";
}

/**
 * Return Link to Edit Page
 *
 * @param array|string $options Options to modify default behavior:
 *  - `id` (string): Selector id.
 *  - `div_class` (string): Selector div class.
 *  - `link_class` (string): Selector link class.
 *  - `edit_text` (string): The name of the buttont.
 *  - `edit_url` (link): Url to edit the page
 *
 */
function editPage($options = array())
{
// if not Page Editable return null
if(!page()->editable()) return;

// Default Options
$defaults = array(
  'id' => 'edit-btn',
  'div_class' => 'edit-btn flex-center',
  'link_class' => 'link-button',
  'edit_text' => setting('edit'),
  'edit_url' => page()->editURL,
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// Display region debugging info
return "<div id='$options[id]' class='$options[div_class]'>
<a class='$options[link_class]' href='$options[edit_url]'>$options[edit_text]</a></div>";
}

/**
 * Return region debugging info
 *
 * @param array|string $options Options to modify default behavior:
 *  - `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function debugInfo($options = array())
{
// Default Options
$defaults = array(
	'id' => 'debug',
	'class' => 'container flex-center debug-bar'
);
// Merge Options
$options = _mergeOptions($defaults, $options);
// display region debugging info
  if(config()->debug && user()->isSuperuser()) {
	return "<div id='$options[id]' class='$options[class]'><!--PW-REGION-DEBUG--></div>";
  }
}

/*****************************************************************************************
 * Internal support functions
 *
 */

/**
 * Prepare and merge an $options argument
 *
 * - This converts PW selector strings data attribute strings to associative arrays.
 * - This converts non-associative attributes to associative boolean attributes.
 * - This merges $defaults with $options.
 *
 * @param array $defaults
 * @param array|string $options
 * @return array
 * @internal
 *
 */
function _mergeOptions(array $defaults, $options) {

	// allow for ProcessWire selector style strings
	// allow for Uikit data attribute strings
	if(is_string($options)) {
		$options = str_replace(';', ',', $options);
		$o = explode(',', $options);
		$options = array();
		foreach($o as $value) {
			if(strpos($value, '=')) {
				// key=value
				list($key, $value) = explode('=', $value, 2);
			} else if(strpos($value, ':')) {
				// key: value
				list($key, $value) = explode(':', $value, 2);
			} else {
				// boolean
				$key = $value;
				$value = true;
			}
			$key = trim($key);
			if(is_string($value)) {
				$value = trim($value);
				// convert boolean strings to real booleans
				$v = strtolower($value);
				if($v === 'false') $value = false;
				if($v === 'true') $value = true;
			}
			$options[$key] = $value;
		}
	}

	if(!is_array($options)) {
		$options = array();
	}

	foreach($options as $key => $value) {
		if(is_int($key) && is_string($value)) {
			// non-associative options convert to boolean attribute
			$defaults[$value] = true;
		}
	}

	return array_merge($defaults, $options);
}