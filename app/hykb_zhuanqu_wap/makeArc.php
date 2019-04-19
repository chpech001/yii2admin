<?php
error_reporting(0);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('TEST', is_dir('/www/t.m.3839.com/'));

$ac = trim(strval($_POST['ac']));
if(!in_array($ac, array('hykb_index', 'hykb_index2'))){
	die('ac error');
}

$zq_id = intval($_POST['zq_id']);
if(!$zq_id){
	die('empty zq_id');
}

$parameter = array(
	'ac' => $ac,
	'zq_id' => $zq_id,
	'time' => intval($_POST['time']),
);

ksort($parameter);

$apiToken = md5(implode('|', $parameter) . 'x4gvgp7xihh4');
$getToken = trim(strval($_POST['token']));
if($getToken !== $apiToken){
	die('token illegal');
}

if(time() - $parameter['time'] > 300){
	die('token expire');
}

$url = 'http://' . (TEST ? 't.news.4399' : 'news.4399swf') . '.com/app/comm/syptzt2/preview.php?ac=' . $ac . '&zq_id=' . $zq_id . '&type=1';
$content = getCurl($url);
if($content && strlen($content) > 500){
    $relative_path = '/zhuanqu/' . ($zq_id % 1000) . '/' . $zq_id . '.htm';
	$file_path = ROOT_PATH . $relative_path;
	filePutContents($file_path, $content);
    $url = (TEST ? 'http://t.m.3839.com' : 'https://m.3839.com') . $relative_path;
    echo '<a target="_blank" href="' . $url . '">' . $url . '</a>';
} else {
    echo '生成失败';
}

function getCurl($url, $post_data = array()){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 6);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if ($post_data) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	$resp = curl_exec($ch);
	curl_close($ch);
	return $resp;
}

function filePutContents($path, $content){
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    $is_writable = is_file($path) ? is_writable($path) :  is_writable($dir);
    if (!$is_writable) {
        header('Content-Type:text/html;charset=gbk');
        die('<font color="red">没有写入权限，请联系技术！</font>');
    }
    file_put_contents($path,$content);
}
