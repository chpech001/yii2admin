<?php
require 'common.php';
$mode = urlencode(trim($_GET['m']));
$ac = htmlspecialchars(trim($_GET['ac']));

$allow_mode = array('home','game_detail');
/***
if (!in_array($mode, $allow_mode)) {
    die('Access Denied!!');
}
*/
$ClassName = Comm::getModeName($mode);
$classFile = INC_PATH.'/cls_'.$ClassName.'.php'; 
if (is_file($classFile)){
    require_once $classFile;
} else {
    die ("Access Denied!");
}

$modeC = new $ClassName($ac);

