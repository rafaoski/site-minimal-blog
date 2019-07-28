<?php namespace ProcessWire; ?>

<div id='hero' data-pw-remove></div>

<div id="content-body" class='content-body'>

	<div class="contact-body flex-center">
		<div class='contact-info'>
			<!-- If you want to have more control over the data, create three text fields ( phone, e_mail, adress ) and assign to this template
			Finally, delete unnecessary comments ...
			<ul>
			<li><b><?php // echo setting('phone') ?>:</b> <?php // echo page('phone') ?></li>
			<li><b><?php // echo setting('e-mail') ?>:</b>
				<a href='mailto:<?php // echo page('e_mail') ?>'><?php // echo page('e_mail') ?></a></li>
			<li><b><?php // echo setting('adress') ?>:</b> <?php // echo page('adress') ?></li>
			</ul> -->
			<?= page()->body ?>
		</div>

		<?= page('google_map') ?>

	</div>

</div>
