<?php
@define("DB_NEWS_HOST",'115.238.73.89');
@define("DB_NEWS_USER",'my4399');
@define('DB_NEWS_PASSWORD','dP9#DL63P');
@define('DB_NEWS_NAME','news4399');

if ( is_dir('/www/t.3839.com/') ) {
    @define('MEM_HOST','localhost');
    @define('MEM_PORT',11211);
}else {
    @define('MEM_HOST','192.168.1.209');
    @define('MEM_PORT',12000); 
}

