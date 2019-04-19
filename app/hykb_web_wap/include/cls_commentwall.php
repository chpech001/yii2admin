<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 安利墙
 */ 
class commentwall extends Controller {

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
   public function indexAction(){

       //获取安利墙页面接口数据
       $wall_list=array();
       $user_list=array();
       $api=C::$api_commentwalllist;

       for($p=1;$p<=15;$p++){

           $gapi=str_replace('{p}',$p,$api);
           $return=Comm::curl_get($gapi,600);
           $return=json_decode($return,true);

           if($return['code']==100 && $return['result']['data']){

               $wall_list=array_merge($wall_list, $return['result']['data']);
           }
       }

      foreach ($wall_list as $k=>$v){  //特殊处理下 游戏单

           if($v['colleciton_id']){

               $wall_list[$k]['game']['icon']=$v['collection_info']['icon'];
               $wall_list[$k]['game']['title']=$v['collection_info']['title'];

               $wall_list[$k]['tags'][0]['title']='游戏单';
               $wall_list[$k]['avatar']=$v['collection_info']['userinfo']['avatar'];
           }
      }

       $gapi2=str_replace('{p}',1,$api);
       $return2=Comm::curl_get($gapi2,600);
       $return2=json_decode($return2,true);

       if($return2['code']==100 && $return2['result']['users']){

           $user_list = array_merge($user_list, $return2['result']['users']);
       }

       $indexinfo = $this->getIndexinfo();

       ob_start();

       include TPL_PATH.'/commentwall.php';

       $html=ob_get_contents();
       ob_clean();
       $html = Comm::reHtml($html);
       $html = preg_replace('#http://fs.img4399.com#','//fs.img4399.com',$html);
       $html = preg_replace('#http://imga.3839.com#','//imga.3839.com',$html);
       echo $html;
       die('');
   }


    public function anliCollAction(){

        //获取合集页面接口数据
        $heji_list=array();
        $api_heji=C::$api_collection_recent;

        for($p=1;$p<=10;$p++){

            $gapi=str_replace('{p}',$p,$api_heji);
            $return=Comm::curl_get($gapi,600);
            $return=json_decode($return,true);

            if($return['code']==100 && $return['result']['data']['all']['list']){

                $total_num=$return['result']['data']['collection_num'];

                $heji_list=array_merge($heji_list, $return['result']['data']['all']['list']);
            }
        }


        $indexinfo = $this->getIndexinfo();

        ob_start();

        include TPL_PATH.'/anli_coll.php';

        $html=ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);

        $html = preg_replace('#http://fs.img4399.com#','//fs.img4399.com',$html);
        $html = preg_replace('#http://imga.3839.com#','//imga.3839.com',$html);
        echo $html;
        die('');
    }
}