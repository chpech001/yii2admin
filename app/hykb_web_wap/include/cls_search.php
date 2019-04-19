<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 搜索页
 */ 
class search extends Controller {
    function indexAction() {
        $return = Comm::curl_get(C::$api_hot_search);

        $game_keys = array();
        if ($return) {
             $return = json_decode($return,true);
            if ($return['code']==100 && $return['result']['game']) {
                $game_keys = $return['result']['game'];
            }
        }
        ob_start();
        include TPL_PATH.'/search.php';
        $html = ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }

    function searchResultAction(){
        $q1 = $q = trim($_REQUEST['q']);
        $q1 = htmlspecialchars($q1);
        $q = preg_replace("/[^\dA-Za-z\x{4e00}-\x{9fa5}]+/u", " ", $q);
        $q = trim($q);
        // $q = urldecode($q);
        $data = array();
        if ($q!='') {
            $page = intval($_REQUEST['page']);
            $page = max(1,$page);
            $result = $this->getApiResult($q,$page);
            $data = $result['data'];
            if (!is_array($data)) $data = array();
            
        }
        // print_r($data);echo '<pre/>';
        foreach($data as $k=>$v){
            // 游戏链接地址
            $data[$k]['url'] = Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
            // 游戏标签链接地址
            $data[$k]['tags'] = array_slice($data[$k]['tags'],0,3);
            foreach($data[$k]['tags'] as $m=>$t){
                $data[$k]['tags'][$m]['url'] = Comm::get_url('category','',array('id'=>$t['id'],'view_ishtml'=>1));
            }
            // 游戏状态
            if ($v['downinfo']['status']==1) {
                $data[$k]['status_str'] = '<a href="'.$data[$k]['url'].'" class="btn green">下载</a>';
            } else if ($v['downinfo']['status']==4) {
                $data[$k]['status_str'] = '<a href="'.$data[$k]['url'].'" class="btn yellow">预约</a>';
            } else if ($v['downinfo']['status']==3 || $data['status']==5) {
                $data[$k]['status_str'] = '<a href="'.$data[$k]['url'].'" class="btn green">查看详情</a>';
            } else if ($v['downinfo']['status'] == 6) {
                $data[$k]['status_str'] = '<a href="'.$data[$k]['url'].'" class="btn green">查看详情</a>';
            }
        }

        $str = '';
        foreach($data as $k=>$v){
		    if($v['is_level_hide']==2){$show='none';}else{$show='';}
            $str .= '<li style="display:'.$show.'">
            <a class="gameli" href="'.$v['url'].'">
                <img class="img" src="'.$v['icon'].'" alt="'.$v['title'].'下载">
                <div class="con">
                    <em class="name">'.$v['title'].'</em>
                    <p class="deta">';

                    foreach($v['tags'] as $m=>$t){
                        $str .= '<span>'.$t['title'].'</span>';
                    }

                    $str.='</p>
                    <p class="info">'.($v['score']?'<span class="spec">'.$v['score'].'分</span>':($v['size']||$v['num']?'':'暂无评分')).($v['size']?'<span>'.$v['size'].'</span>':'').($v['num']?'<span>'.$v['num'].'</span>':'').'</p>
                </div>
            </a>'.$v['status_str'].'</li>';
        }
        

        if ($_REQUEST['is_ajax']) {
            echo json_encode(array('data'=>$str,'nextpage'=>$result['nextpage']));
            die('');
        }
        
        ob_start();
        include TPL_PATH.'/search_result.php';
        $html = ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }

    function getApiResult($q,$page=1) {
        if ($page<0) $page=1;
        $url='http://so.3839.com/api/search/game';
        $post_data = array(
            'word'=>$q,
            'device'=>'hykb_web_wap',
            'ts'=>time(),
            'n'=>rand(1,999999999),
            'vc'=>179,
            'page'=>$page,
            'secure'=>'a082b0aa825aca598b772047f5976882'
        );
        krsort($post_data);
        $token=md5(implode("|",$post_data));
        $post_data['t']=$token;
        unset($post_data['secure']);
        $post_data = json_encode($post_data);
        $data=Comm::curl_post($url,$post_data);
        // print_r($data);
        $result = array();
        if ($data) {
            $data=json_decode($data,true);
            if ($data['code']==100 && $data['result']) {
                $result = $data['result'];
            }
        }

        return $result;
        
    }

    function safe_filter_so($str){
        $str= htmlspecialchars_decode($str);
        $reg = "/script|select|join|union|where|insert|delete|update|like|drop|create|modify|rename|alter|cas|load_file|outfile|truncate|declare|>|#|<|\&|css|\/|\s|\"|\'|\(|\)|prompt|=|%|\*/i";
        $str = preg_replace($reg," ",$str);
        return $str;
    }
	
   public function page404Action(){
	  echo "该游戏单未上架，2秒后回到游戏单首页...";
	  echo '<script language="javascript">setTimeout(function(){location.href="https://m.3839.com/heji/hot.html";},2000);</script>';
	  exit();
   } 	
	
	
	
	
	
}