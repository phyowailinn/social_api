<?php  

define('APP_URL', 'http://');
define('FACEBOOK', 'https://graph.facebook.com');
define('FB_APP_ID', '');
define('FB_APP_SECREAT', '');
define('FB_APP_VERSION', '');
define('FB_PERMISSIONS', json_encode([
		'user_posts'
	]));
define('FB_TITLE_FIELD', 'posts');
define('FB_PAGE_NAME', '');

define('FB_REVIEW_FIELDS','{created_time,story,message,picture,comments{message,from},likes},rating_count,ratings{reviewer,review_text,rating}');

define('FB_PAGE_FIELDS', '{created_time,story,message,picture,comments{message,from},likes},access_token');

define('INSTAGRAM', 'https://api.instagram.com');
define('IN_APP_VERSION', '');
define('IN_CLIENT_ID', '');
define('IN_CLIENT_SCREAT', '');
define('IN_REQ_URI', APP_URL.'/instagram');
define('IN_END_POINT', 'users/self/media/recent');