<?php

use BelCMS\Requires\Common;
?>
<section id="belcms_section_mails">
	<div id="belcms_section_mails_list">
		<?php include 'menu.php'; ?>
	</div>
	<div id="belcms_section_mails_msg">
		<h3>Boite de réception</h3>
		<div class="belcms_section_mails_msg">
			<?php
			foreach ($data as $key => $value):
			?>
			<div class="belcms_section_mails_list">
				<a href="Mails/ReadMsg/<?=$value->mail_id;?>">
					<img src="<?=$value->avatar;?>">
					<span class="belcms_section_mails_list_name"><?=$value->username;?></span>
					<span class="belcms_section_mails_list_text"><?=$value->msg->subject;?></span>
					<span class="belcms_section_mails_list_date"><?=$value->time_msg;?></span>
				</a>
			</div>
			<?php
			endforeach;
			?>
		</div>
	</div>
</section>