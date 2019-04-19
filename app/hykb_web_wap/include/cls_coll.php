<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 合辑首页
 */ 
class coll extends Controller {
   private function getIndexinfo(){
        global $db;
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_indexinfo' LIMIT 1 ";
        $temp = $db->get_one($sql);
        $indexinfo = array();
        if ($temp['data']) {
            $indexinfo = json_decode($temp['data'],true);
        }
        return $indexinfo;
    }

    //生成合辑页面
    public function collAction(){

        $type=$_REQUEST['type'];
        if(!in_array($type,array('recent','hot'))){die("参数错误");}

        if($type=='hot'){
            $api_coll=C::$api_collection_hot;
        }else{
            $api_coll=C::$api_collection_recent;
        }

        $catename='';
        $head_xx=array();
        $gamelist=array();

        for($p=1;$p<=10;$p++){

            $gapi=str_replace('{p}',$p,$api_coll);
            $return=Comm::curl_get($gapi,600);
            $return=json_decode($return,true);
            $list=$return['result']['data']['all']['list'];
            if($return['code']!=100){ die('合辑页面接口信息获取出错');}
            if(empty($list)){break;}
            if($p==1){
                $catename=$return['result']['data']['all']['title'];
                $head_xx[]=$return['result']['data']['head'];
            }

            $gamelist=array_merge($gamelist, $list);
        }

        $indexinfo = $this->getIndexinfo();
        ob_start();

        include TPL_PATH.'/coll_index.php';

        $html=ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        $html = preg_replace('#http://fs.img4399.com#','//fs.img4399.com',$html);
        $html = preg_replace('#http://imga.3839.com#','//imga.3839.com',$html);
        echo $html;
        die('');
    }

    //合辑标签页面
    public function tagsAction(){

        $type=$_REQUEST['type'];
        if(!in_array($type,array('recent','hot'))){die("参数错误");}

        $tags_list=array();

        $api_tags=C::$api_collection_tags;
        $return=Comm::curl_get($api_tags,1800);
        $return2=json_decode($return,true);

        if($return2['code']==100 && $return2['result']){

            $tags_list = array_merge($tags_list, $return2['result']);
        }

        $indexinfo = $this->getIndexinfo();

        ob_start();

        include TPL_PATH.'/coll_tages.php';

        $html=ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }

    //生成单个分类页面
    public function collDetailAction(){

        $id=intval($_REQUEST['id']);
        $type=$_REQUEST['type'];
        $typemode=array('recent','hot');
        if(!in_array($type,$typemode) || empty($id)){
            die('Access Denied');
        }
        if($type=='hot'){$api=C::$api_collection_detail_hot;}
        if($type=='recent'){$api=C::$api_collection_detail_recent;}

        $api=str_replace('{cid}',$id,$api);
        $catename='';
        $gamelist=array();

        for($p=1;$p<=10;$p++){

            $gapi=str_replace('{p}',$p,$api);
            $return=Comm::curl_get($gapi,1800);
            $return=json_decode($return,true);
            $list=$return['result']['data']['all']['list'];
            if($return['code']!=100){ die('合辑页面接口信息获取出错');}
            if(empty($list)){break;}
            if($p==1){$catename=$return['result']['data']['all']['title'];}

            $gamelist=array_merge($gamelist, $list);
        }

        $head_xx=array();
        $sgapi=str_replace('{p}',1,C::$api_collection_hot);
        $return2=Comm::curl_get($sgapi,1800);
        $return2=json_decode($return2,true);
        $head_xx[]=$return2['result']['data']['head'];

        ob_start();
        include TPL_PATH.'/coll_detail.php';
        $html=ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        $html = preg_replace('#http://fs.img4399.com#','//fs.img4399.com',$html);
        $html = preg_replace('#http://imga.3839.com#','//imga.3839.com',$html);
        echo $html;
        die('');
    }

    //生成合辑文章信息页面
    public function ArcdetailAction(){
        //   http://t.m.3839.com/app/hykb_web_wap/index.php?m=coll&ac=arcdetail&id=217&view_ishtml=1
        $id=intval($_REQUEST['id']);
        if(!$id){
            die('Access Denied');
        }

        $data = array(
            'c' => 'collectiondetail',
            'a' => 'home',
            'timestamp' => time(),
            'version' => '1.4.5',
            'id' =>$id,
            'level' =>5,
        );
        $secret = 'd263319194a6f3830bb21f6892245ebf';
        $data['token'] = md5( '#' . $data['version'] . '&' . $secret . '*' . $data['timestamp'] . '|' );
        $api = "http://newsapp.5054399.com/kuaibao/android/apiadmin.php"; //正式地址
        $return=Comm::curl_post($api, json_encode($data));
        if(!$return){die("获取合辑详情接口数据失败");}
        $return=json_decode($return,true);
        $arc_list=$return['result'];

        if($return['code']!=100 || empty($arc_list)){ die("获取合辑详情数据失败");}
        ob_start();
        include TPL_PATH.'/coll_arc.php';
        $html=ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }
}