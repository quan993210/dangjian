<?php
define('IN_APP', true);

//数据库信息配置
define("DB_HOST", 'rm-uf6626r586f38e3f5wo.mysql.rds.aliyuncs.com');
//define("DB_HOST", 'rm-uf6626r586f38e3f5.mysql.rds.aliyuncs.com');
define("DB_NAME", 'dangjian');
define("DB_USER", 'dangjian');
define("DB_PASS", 'j0QluaLhcIlVSeDS');
/*define("DB_HOST", 'localhost');
define("DB_NAME", 'dangjian');
define("DB_USER", 'root');
define("DB_PASS", 'root');*/
define("PREFIX",  '');

//编码配置
define('CHAR_SET', 'utf-8');

//模板配置
define('TEMPLATE',      'smarty');
define('TEMP_DANG', 	'temp/dangwei');
define('TEMP_PAGE', 	'temp/default');
define('TEMP_ADMIN',  	'temp/admin');
define('TEMP_COMPILE',	'temp/compiled');
define('TEMP_CACHE',	'temp/caches');
define('CACHE_TIME',	3600);
define('DEBUG_MODE',	1);
define('ADMIN_DIR', 	'admin/');
define('MEMBER_DIR', 	'member/');
define('DANG_DIR', 	'dangwei/');

//路径配置
define('FILE_PATH', '');
define('URL_PATH', 'http://' . $_SERVER['HTTP_HOST'] . FILE_PATH);
define('FRONT_TEMP_PATH', 'http://' . $_SERVER['HTTP_HOST'] . FILE_PATH . '/' . TEMP_PAGE);
define('ADMIN_TEMP_PATH', 'http://' . $_SERVER['HTTP_HOST'] . FILE_PATH . '/' . TEMP_ADMIN);
define('DANG_TEMP_PATH', 'http://' . $_SERVER['HTTP_HOST'] . FILE_PATH . '/' . TEMP_DANG);


//网站名称
define('WEB_NAME', '南昌锦路科技有限公司');
define('SYS_NAME', '锦路网站后台管理');

?>