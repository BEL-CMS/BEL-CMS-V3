<?php
use BelCMS\Requires\Common;
?>
<section id="belcms_section_mails">
	<div id="belcms_section_mails_list">
		<?php include 'menu.php'; ?>
	</div>
	<div id="belcms_section_mails_msg">
		<h3>Sujet : <?=$mails[0]->subject;?></h3>
		<?php
		foreach ($mails as $v):
		?>
		<div class="belcms_section_mails_msg">
			<div class="belcms_section_mails_message">
				<div class="belcms_section_mails_message_infos">
					<ul>
						<li>De <b>Stive</b> a <b>stilin</b></li>
						<li><?=$v->time_msg;?></li>
					</ul>
					<div class="belcms_section_mails_message_content">
						<?=$v->message;?>
					</div>
					<div class="belcms_section_mails_message_file">
						<input type="text" value="https//<?=$_SERVER['HTTP_HOST'];?><?=$v->upload;?>">
					</div>
				</div>
			</div>
		</div>
		<?php
		endforeach;
		?>
		<form action="Mails/Reply" id="form_mails" method="post" enctype="multipart/form-data">
			<label><?=constant('UPLOAD');?> (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
			<input type="file" name="upload">
			<textarea class="bel_cms_textarea_simple" name="message"></textarea>
			<input type="hidden" name="id" value="<?=$mails[0]->mail_id;?>">
			<input type="hidden" name="subject" value="<?=$mails[0]->subject;?>">
			<input type="hidden" name="author" value="<?=$mails[0]->status->author_send;?>">
			<input type="submit" class="belcms_btn belcms_bg_grey " value="<?=constant('SUBMIT');?>">
		</form>
	</div>
</section>