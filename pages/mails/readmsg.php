<?php
use BelCMS\Requires\Common;
use BelCMS\User\User;

if ($type == 'archive') {
	$link = '<a href="Mails/Close/'.$mails[0]->mail_id.'" class="red belcms_tooltip_left" data="Clore le sujet"><i class="fa-solid fa-trash-arrow-up"></i></a>';
} else if ($type == 'close') {
	$link = '';
} else if ($type == 'read') {
	$link = '<a href="Mails/Close/'.$mails[0]->mail_id.'" class="red belcms_tooltip_left" data="Clore le sujet"><i class="fa-solid fa-trash-arrow-up"></i></a>
			 <a href="Mails/Archiving/'.$mails[0]->mail_id.'" class="blue belcms_tooltip_left" data="Archiver le sujet"><i class="fa-solid fa-box-open"></i></a>';
}
?>
<section id="belcms_section_mails">
	<div id="belcms_section_mails_list">
		<?php include 'menu.php'; ?>
	</div>
	<div id="belcms_section_mails_msg">
		<h3>Sujet : <?=$mails[0]->subject;?>
			<?=$link;?>
		</h3>
		<?php
		foreach ($mails as $v):
			$user = User::getInfosUserAll($v->author);
			$user = $user->user->username;
		?>
		<div class="belcms_section_mails_msg">
			<div class="belcms_section_mails_message">
				<div class="belcms_section_mails_message_infos">
					<ul>
						<li>De <b><?=$user;?></b></li>
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
		if ($type != 'close'):
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
		<?php
		endif;
		?>
	</div>
</section>