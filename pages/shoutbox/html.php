<?php
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!empty($var)) {
	$user = User::getInfosUserAll($var->hash_key);
	$date = Common::TransformDate($var->date_msg, 'FULL', 'MEDIUM');
	$msg  = Common::getSmiley($var->msg);
?>
<li id="id_<?=$var->id;?>">
	<span><a href="#" style="color:<?=$user->user->color;?>;"><?=$user->user->username;?></a></span>
	<span><?=$msg;?></span>
	<i><?=$date;?></i>
	<?php
	if (!empty($var->file) or !empty($var->image)):
	echo '<div>';
	endif;
		if (!empty($var->file)):
		?>
		<a href="<?=$var->file;?>"><i class="fa-solid fa-paperclip" style="color: #74C0FC;"></i></a>
		<?php
		endif;
		if (!empty($var->image)):
		?>
		<a href="<?=$var->image;?>"><i class="fa-regular fa-image fa-flip-horizontal" style="color: #FFD43B;"></i></a>
		</a>
		<?php
		endif;
	if (!empty($var->file) or !empty($var->image)):
	echo '</div>';
	endif;
	?>
</li>
<?php
} else {
	echo 'true';
}
?>