<?php
include '../app/hykb_web_wap/common.php';
$mode = urlencode(trim($_GET['m']));
$ac = htmlspecialchars(trim($_GET['ac']));

$ClassName = "search";
$classFile = INC_PATH.'/cls_'.$ClassName.'.php'; 
if (is_file($classFile)){
    require_once $classFile;
} else {
    die ("Access Denied!");
}

$modeC = new $ClassName($ac);