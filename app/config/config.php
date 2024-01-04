<?php
# DB Params
define('DB_HOST', 'aws.connect.psdb.cloud');
define('DB_USER', 'zoe2ch9wl2iha105w2bx');
define('DB_PASS', 'pscale_pw_MxLzQchRhZL2IOKf3llvHhYdzZb4GsDZq1YUecppADl');
define('DB_NAME', 'purple_posts');

# App Root
define('APPROOT', dirname(dirname(__FILE__))); 
# URL Root
define('URLROOT', 'mysql://root@127.0.0.1:3306/purple_posts');
# Site Name
define('SITENAME', 'PurplePost');

// DEBUG MODE Settings
define('DEBUG', false);
error_reporting(E_ALL);

ini_set('display_errors', DEBUG ? 'On' : 'Off');



# LOCAL DEV
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'purple_posts');
// define('APPROOT', dirname(dirname(__FILE__)));
// define('URLROOT', 'http://localhost/purplepost');
// define('SITENAME', 'PurplePost');
// define('DEBUG', true);