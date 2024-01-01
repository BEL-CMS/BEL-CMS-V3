<?php
	header('Content-Type: application/json');
	$ajax = Array(
		'articles',
		'articles_content',
		'ban',
		'comments',
		'config',
		'config_pages',
		'config_tpl',
		'donations',
		'donations_receive',
		'downloads',
		'downloads_cat',
		'emoticones',
		'games',
		'groups',
		'guestbook',
		'interaction',
		'mails',
		'mails_blacklist',
		'mails_msg',
		'mails_unsubscribe',
		'maintenance',
		'market',
		'market_address',
		'market_cat',
		'market_link',
		'market_img',
		'market_sold',
		'market_order',
		'market_tva',
		'newsletter',
		'newsletter_send',
		'newsletter_tpl',
		'page_forum',
		'page_forum_post',
		'page_forum_posts',
		'page_forum_threads',
		'page_news',
		'page_news_cat',
		'page_shoutbox',
		'page_stats',
		'page_survey',
		'page_survey_author',
		'page_survey_quest',
		'paypal',
		'paypal_purchase',
		'users',
		'users_gaming',
		'users_groups',
		'users_page',
		'users_profils',
		'users_social',
		'visitors',
		'widgets'
	);
	echo json_encode($ajax);