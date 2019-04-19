<?php
include 'common.php';
$mode = urlencode(trim($_GET['m']));
$ac = $_GET['ac'];

if (!$mode) $mode = 'index';

$ClassName = Comm::getModeName($mode);
$classFile = INC_PATH.'/admin/cls_'.$ClassName.'.php'; 
if (is_file($classFile)){
    require_once $classFile;
} else {
    die ("Access Denied!");
}

$modeC = new $ClassName($ac);

