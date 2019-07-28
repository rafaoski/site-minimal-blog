<?php namespace ProcessWire; ?>

<div class='container'>
<?php
	// Get Comments
	$comments = page()->comments;
	// comment list
	if (count($comments)) {

			echo $page->comments->render(array(
				'headline' => '<h3>' . setting('comment-text') . '</h3>',
				'commentHeader' => 'Posted by {cite} on {created}',
				'dateFormat' => 'm/d/y g:ia',
				'encoding' => 'UTF-8',
				'admin' => false, // shows unapproved comments if true
			));

		}

		// comments form with all options specified (these are the defaults)
		echo $page->comments->renderForm(array(
		'headline' => '<h3>' . setting('post-comment') . '</h3>',
		'successMessage' => "<p class='success'>Thank you, your submission has been saved.</p>",
		'errorMessage' => "<p class='error'>Your submission was not saved due to one or more errors. Please check that you have completed all fields before submitting again.</p>",
		'processInput' => true,
		'encoding' => 'UTF-8',
		'attrs' => array(
			'id' => 'CommentForm',
			'action' => './',
			'method' => 'post',
			'class' => '',
			'rows' => 5,
			'cols' => 50,
			),
		'labels' => array(
			'cite' => 'Your Name',
			'email' => 'Your E-Mail',
			'text' => 'Comments',
			'submit' => 'Submit',
		),
		// the name of a field that must be set (and have any non-blank value), typically set in Javascript to keep out spammers
		// to use it, YOU must set this with a <input hidden> field from your own javascript, somewhere in the form
		'requireSecurityField' => '', // not used by default
		));
?>

</div>
