<?php 
// if (strpos($_SERVER['HTTP_USER_AGENT'],'3533') === false) die("access error");
if(!defined("LOGIN_PASSWORD")){die("error defined pwd ");}
// $lifeTime = 60*60*6; 
// session_set_cookie_params($lifeTime); 
session_start();
$mem_key = "login_memcache_".LOGIN_PASSWORD;
$val = @intval($_SESSION[$mem_key]);
if($_POST['cc']!='login' && $val!=1){
    // @memcache_close($mem_conn);
    $str = array();
    $str[] = "<form action='' method='post'>";
    $str[] = "<input type='password' name='pas' />";
    $str[] = "<input type='hidden' name='cc' value='login'/>";
    $str[] = "<input type='hidden' name='c' value='l'/>";
    $str[] = "<input type='submit' value='登录'/>";
    $str[] = "</form>";
    echo implode("",$str);
    die();
}
if($_POST['cc']=='login' && $_POST['pas']!=LOGIN_PASSWORD){
    die("error pwd");
}
$_SESSION[$mem_key] = 1;