<?php
defined('APP_PATH') or exit('Access Denied');
class Controller{
    
    protected $ac      = '';
    protected $_t_vars = array();
    
    public function __construct($ac){
        $this->ac = trim(strtolower($ac));
        $this->ac = $this->ac ? $this->ac : 'index';
        $action   = $this->getActionName($this->ac);
        if (!method_exists($this, $action)) {
            die('Access Denied!!');
        }
        if (method_exists($this, 'init')) {
            $this->init();
        }
        $this->$action();
    }
    
    /**
     * 获取Action名称(下划线转驼峰法)
     * @param string $str
     * <code>
     * getActionName('make_html'); // 'make_html' -> 'makeHtmlAction';
     * </code>
     * @return string
     */
    public function getActionName($str){
        $str    = ucwords(str_replace('_', ' ', trim($str)));
        $str{0} = strtolower($str{0});
        return str_replace(' ','',$str).'Action';
    }
    
    /**
     * 模版变量赋值
     * @param  string $name 
     * @param  mixed $val  
     * @return void
     */
    protected function assign($name, $val = null){
        if (is_array($name)) {
            $this->_t_vars = array_merge($this->_t_vars, $name);
        } else {
            $this->_t_vars[$name] = $val;
        }
    }

    /**
     * 判断模板是否存在
     * @param string $tpl_name
     * @return bool
     */
    protected function isTplExist($tpl_name = ''){
        if (strpos($tpl_name,'..') !== false) {
            return false;
        }
        $tpl_path = TPL_PATH."{$tpl_name}.php";
        return is_file($tpl_path);
    }

    /**
     * 获取模板路径
     * @param string $tpl_name
     * @return string
     */
    protected function getTplPath($tpl_name = ''){
        return TPL_PATH."{$tpl_name}.php";
    }
    
    /**
     * 显示模版
     * @param  string $tpl_name 模板名称
     * @return void
     */
    protected function display($tpl_name = ''){
        if (!$tpl_name) {
            $tpl_name = $this->ac;
        }
        if (strpos($tpl_name,'..') !== false || !$this->isTplExist($tpl_name)) {
            die('template not exist');
        }
        $tpl_path = $this->getTplPath($tpl_name);
        extract($this->_t_vars, EXTR_OVERWRITE);
        $this->_t_vars = array();
        include $tpl_path;
    }

    /**
     * GBK转UTF8
     * @param array|string $arr
     * @return array|string
     */
    protected function gbk2Utf8($arr){
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $arr[$key] = $this->gbk2Utf8($value);
            }
        } else if (is_string($arr)) {
            $arr = iconv('gbk', 'utf-8//IGNORE', $arr);
        }
        return $arr;
    }

    /**
     * Utf8转GBK
     * @param array|string $arr
     * @return array|string
     */
    protected function utf82Gbk($arr){
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $arr[$key] = $this->utf82Gbk($value);
            }
        } else if (is_string($arr)) {
            $arr = iconv('utf-8', 'gbk//IGNORE', $arr);
        }
        return $arr;
    }


    /**
     * Ajax方式返回数据到客户端
     * @param  mixed $data 要返回的数据
     * @return void
     */
    protected function ajaxReturn($data){
        $data = $this->gbk2Utf8($data);
        die(json_encode($data));
    }

    /**
     * js提示信息
     * @param string $msg
     * @param string $url
     * @param bool|true $exit
     */
    protected function jsAlert($msg = '', $url = '', $exit = true){
        $msg = str_replace("'","\\'",$msg);
        echo "<script type='text/javascript'>alert('{$msg}');</script>";
        if ($exit) {
            $js = 'history.back(-1);';
            if ($url) {
                $url = str_replace("'",'',$url);
                $js = "window.location = '{$url}';";
            }
            echo "<script type='text/javascript'>{$js}</script>";
            die();
        }
    }

    /**
     * 操作错误跳转的快捷方法
     * @param string $msg 错误信息
     * @param string $url 页面跳转地址
     * @return void
     */
    protected function error($msg, $url = ''){
        if (IS_AJAX) {
            $data = array();
            $data['code']   = 'error';
            $data['info']   = $msg;
            $data['url']    = $url;
            $this->ajaxReturn($data);
        } else {
            $this->jsAlert($msg, $url);
        }
    }
    
    /**
     * 操作成功跳转的快捷方法
     * @param string $msg 提示信息
     * @param string $url 页面跳转地址
     * @return void
     */
    protected function success($msg, $url = ''){
        if (IS_AJAX) {
            $data = array();
            $data['code']   = 'success';
            $data['info']   = $msg;
            $data['url']    = $url;
            $this->ajaxReturn($data);
        } else {
            $this->jsAlert($msg, $url);
        }
    }

    /**
     * 获取GET/POST的值
     * (默认用trim,htmlspecialchars,mysql_real_escape_string这几个函数依次过滤)
     * <code>
     * getRequestVal('get.id',0,'intval') // $_GET['id']
     * getRequestVal('post.name') //$_POST['name']
     * getRequestVal('get.')  //$_GET
     * getRequestVal('post.') //$_POST
     * </code>
     * @param string $name    变量的名称 支持指定类型
     * @param string $default 不存在的时候默认值
     * @param string $filters 参数过滤方法(多个函数之间用逗号分隔)
     * @return mixed
     */
    protected function getRequestVal($name, $default = '', $filters = 'trim,htmlspecialchars,mysql_real_escape_string'){
        $method = 'param';
        if (strpos($name,'.')) {
            list($method,$name) = explode('.',$name,2);
        }
        switch (strtolower($method)) {
            case 'get':
                $input = $_GET;
                break;
            case 'post':
                $input = $_POST;
                break;
            default:
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'POST':
                        $input = $_POST;
                        break;
                    default:
                        $input = $_GET;
                        break;
                }
                break;
        }
        $filters = explode(',',$filters);
        if ($name == '') {
            $data = $input;
        } elseif (isset($input[$name])) {
            $data = $input[$name];
        } else {
            $data = $default;
        }
        if (get_magic_quotes_gpc()) {
            $data = $this->arrayMapRecursive('stripslashes', $data);
        }
        if ($filters) {
            foreach($filters as $filter){
                if (function_exists($filter)) {
                    $data = is_array($data) ? $this->arrayMapRecursive($filter,$data) : $filter($data); // 参数过滤
                }
            }
        }
        return $data;
    }

    /**
     * 递归调用函数
     * @param  string $filter 函数名
     * @param  mixed $data    数据对象
     * @return mixed
     */
    protected function arrayMapRecursive($filter, $data){
        $result = array();
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $result[$key] = is_array($val)
                    ? $this->arrayMapRecursive($filter, $val)
                    : $filter($val);
            }
        } else {
            $result = $filter($data);
        }
        return $result;
    }
}