<?php
error_reporting(0);	

if ( is_dir('/www/t.3839.com/') ) {
	@define("DB_NEWS_HOST",'115.238.73.89');
	@define("DB_NEWS_USER",'my4399');
	@define('DB_NEWS_PASSWORD','dP9#DL63P');
	@define('DB_NEWS_NAME','news4399');

	@define("DB_KB_HOST",'localhost');
	@define("DB_KB_USER",'kb4399');
	@define('DB_KB_PASSWORD','admin4399');
	@define('DB_KB_NAME','kuaibao');

    @define('MEM_HOST','localhost');
    @define('MEM_PORT',11211);
}else {
	@define("DB_NEWS_HOST",'115.238.73.89');
	@define("DB_NEWS_USER",'my4399');
	@define('DB_NEWS_PASSWORD','dP9#DL63P');
	@define('DB_NEWS_NAME','news4399');

	@define("DB_KB_HOST",'127.0.0.1');
	@define("DB_KB_USER",'kb4399');
	@define('DB_KB_PASSWORD','kba82WW!dv0');
	@define('DB_KB_NAME','kuaibao');

    @define('MEM_HOST','localhost');
    @define('MEM_PORT',12000); 
}

