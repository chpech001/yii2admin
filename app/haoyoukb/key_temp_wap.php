<?php
header('Content-Type:text/html;charset=utf-8');
require_once($_SERVER['DOCUMENT_ROOT'].'/app/haoyoukb/common.php');

$yx_id = intval($_GET['id']);//游戏ID
if ( $yx_id == '87961' || $yx_id == '87235' ) {
    die();
}

if ( $yx_id > 0 ) {
    $key = $mem_pre.$yx_id;
    //$res = get_data($key,$yx_id);
    //if ( !$res ) {
    //    show404();
    //}
}else {
	show404();
}

die($key);
