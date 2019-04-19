<?php
defined('APP_PATH') or exit('Access Denied');
class index extends Controller {

    function indexAction(){
        include ADMIN_TPL_PATH.'/index.php';
    }

    function topAction(){
        include ADMIN_TPL_PATH.'/top.php';
    }

    function menuAction(){
        include ADMIN_TPL_PATH.'/menu.php';
    }

}