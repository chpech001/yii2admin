<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 首页
 */ 
class home extends Controller {
    // 获取首页配置
    function getIndexinfo(){
        global $db;
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_indexinfo' LIMIT 1 ";
        $temp = $db->get_one($sql);
        $indexinfo = array();
        if ($temp['data']) {
            $indexinfo = json_decode($temp['data'],true);
        }
        return $indexinfo;
    }

    function indexAction() {
        // 获取首页接口数据
        $return = Comm::curl_get(C::$api_home);
        if (!$return) {
            die('首页接口获取失败');
        }
        $return = json_decode($return,true);
        if ($return['code']!=100 || !$return['result']) {
            die('首页接口信息获取出错');
        }

        $result = $return['result'];
        // 头图
        $slide = $result['slide'];
		if(!empty($slide)){
		  if($slide['interface_type']==16){$slide='';}
		}
        if (!$slide) {
            $top = $result['top'];
            foreach($top as $v) {
                if ($v && $v['interface_type']!=16) {
                    $slide = $v;
                    break;
                }
            }
        }
        $slide['url'] = Comm::getUrlByInterface($slide['interface_type'],$slide['interface_id'],$slide['link']);
        $slide_game = Comm::getGameData($slide['interface_id']);

        // 导航栏
        // $nav = $result['nav'];
        // if ($nav) {
        //     foreach($nav as $k=>$v) {
        //         $nav[$k]['url'] = Comm::getUrlByInterface($v['interface_type'],$v['interface_id'],$v['link']);
        //     }
        // }
        
        // new_game
        // $new_game = $result['new_game'];
        // if ($new_game) {
        //     $new_game['url'] = '';
        //     $new_game['tit_1'] = htmlspecialchars($new_game['tit_1']);
        //     $new_game['tit_2'] = htmlspecialchars($new_game['tit_2']);
        // }
        
        // custom
        $custom = $result['custom'];
        if ($custom) {
            $custom['url'] = Comm::getUrlByInterface($custom['interface_type'],$custom['interface_id'],$custom['link']);
        }

        // 模块链接地址
        $datalist = $result['data'];
        $itemsHtmls = $this->getIndexItemHtmls($datalist);

        // 首页配置
        $indexinfo = $this->getIndexinfo();

        ob_start();
        
        include TPL_PATH.'/home.php';
        $html = ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }

    // 获取首页头图
    function getIndexSlide($slide,$top){
        $data = array();
        if ($slide['pic']) {
            $data = $slide;
        }
        if (!$data) {
            foreach($top as $v) {
                if (!$v['pic']) {
                    continue;
                } else {
                    $data = $v;
                    break;
                }
            }
        }
        if (!$data) return '没有头图信息';

        $str  = '';
        $url = Comm::getUrlByInterface($data['interface_type'],$data['interface_id'],$data['link']);

        $str .= '<div class="recoItem">
    <a href="'.$url.'">
        <img class="img" src="'.($data['icon']?$data['icon']:$data['pic']).'" alt="'.$data['title'].'">
        <span class="mask"></span>
        <span class="tag">'.$data['tag'].'</span>
        <div class="detail">
            <em class="tit">'.$data['title'].'</em>
            <p class="desc">'.$data['intro'].'</p>
            <div class="gameinfo">
                <div class="pro"><img src="'.$data['userinfo']['avatar'].'" alt="'.$data['userinfo']['name'].'">'.$data['userinfo']['name'].'</div>
                <div class="total"><span class="download">'.$data['num_down'].'</span>'.($data['num_down'] && strpos($data['num_down'],'预约')===false ? '<span class="review">'.$data['num_down'].'</span>':'').'</div>
            </div>
        </div>
    </a>
</div>'.PHP_EOL;
        return $str;
    }

    // 获取首页头图下方推荐广告
    function getIndexPromGame() {
        $return = Comm::curl_get(C::$api_home_prom);
        if (!$return) {
            return '';
        }
        $return = json_decode($return,true);
        if ($return['code']==100 && $return['gameinfo']) {
            $data = $return['gameinfo'][0];
        }

        $url = Comm::get_url('game_detail','',array('id'=>$data['gameid']));
                
        $str .= '<div class="box">'.PHP_EOL;
        $str .= '<div class="menu">
                        <em class="all-icon eclipse_v"></em>
                        <a href="'.$data['coopurl'].'"><div class="author-des"><em class="bubble"></em><em class="all-icon mark_o"></em>'.$data['cooptitle'].'</div></a>
                    </div>';
        $str .= '    <div class="top">'.PHP_EOL;
        $str .= '            <a href="'.$url.'"><img class="icon" src="'.$data['icon'].'" alt="'.$data['gamename'].'下载"></a>'.PHP_EOL;
        $str .= '            <div class="title">'.PHP_EOL;
        $str .= '                <p><a href="'.$url.'">'.$data['gamename'].'</a></p>'.PHP_EOL;
        $str .= '                <p>';
        foreach($data['tags'] as $m=>$t) {
            if ($m>=3) break;
            $str .= '<label>'.$t.'</label>';
        }

        $str .= '</p>'.PHP_EOL;
        $str .= '            </div>'.PHP_EOL;
        $str .= '    </div>'.PHP_EOL;
        $str .= '    <div class="cover">'.PHP_EOL;
        $str .= '        <a href="'.$url.'"><img src="'.$data['bigicon'].'" alt="'.$data['gamename'].'安卓版"></a>'.($data['tips']?'<div class="cover-tag">'.$data['tips'].'</div>':'').PHP_EOL;
        $str .= '    </div>'.PHP_EOL;
        $str .= '    <p class="bottom"><span>';
        if ($data['num'] && strpos($data['num'],'预约')===false) {
            $str .= '<label><em class="icon_download_1 all-icon"></em>'.$data['num'].'</label>';
        }
        $str .= '<label><em class="icon_commentary_1 all-icon"></em>'.$data['comment'].'</label>';
        $str .= '</span>'.$data['description'];
        $str .= '</p>'.PHP_EOL;
        $str .= '</div>'.PHP_EOL;

        return $str;
    }

    // 获取首页数据模块html
    function getIndexHtmlByType($data,$d_index) {
        $str = '';
        switch($data['type']) {

            case '0'://游戏详情
                $url = Comm::get_url('game_detail','',array('id'=>$data['id']));
                $tag_str = '';
                foreach($data['tags'] as $m=>$t) {
                    if ($m>=3) break;
                    $tag_str .= '<span>'.$t['title'].'</span>';
                }
                
                $str .= '<div class="item">'.PHP_EOL;
                $str .= '    <a href="'.$url.'"><div class="itemhd">'.PHP_EOL;
                $str .= '        <div class="item-game">'.PHP_EOL;
                $str .= '            <img src="'.$data['downinfo']['icon'].'" alt="'.$data['title'].'下载">'.PHP_EOL;
                $str .= '            <div class="deta">'.PHP_EOL;
                $str .= '                <em class="name">'.$data['title'].'</em>'.PHP_EOL;
                $str .= '                <div class="tags">'.$tag_str.'</div>'.PHP_EOL;
                $str .= '            </div>'.PHP_EOL;
                $str .= '        </div>'.PHP_EOL;
                $str .= '    </div>'.PHP_EOL;
                $str .= '    <div class="img"><img src="'.$data['pic'].'" alt="'.$data['title'].'安卓版">'.$this->get_date_tag($data['time']).'</div><div class="desc">'.$data['intro'].'</div>'.PHP_EOL;
                $str .= '    <div class="gameinfo">'.PHP_EOL;
                $str .= '        <div class="pro"><img src="'.$data['userinfo']['avatar'].'" alt="'.$data['userinfo']['name'].'">'.$data['userinfo']['name'].'</div>'.PHP_EOL;
                $str .= '        <div class="total">'.($data['num_download'] && strpos($data['num_download'],'预约')===false?'<span class="download">'.$data['num_download'].'</span>':'').'<span class="review">'.$data['num_comment'].'</span></div>'.PHP_EOL;
                $str .= '    </div></a>'.PHP_EOL;
                $str .= '</div>'.PHP_EOL;
                return $str;
                                                                                                
            break;

            case '99'://换一换
                $str .= '<div class="item huan">'.PHP_EOL;
                $str .= '    <div class="itemhd" id="hh_hd">'.PHP_EOL;
                foreach($data['host_list'] as $k=>$v) {

                    $url = Comm::get_url('game_detail','',array('id'=>$v['id']));
                    $data['host_list'][$k]['url'] = $url;

                    $str .= '        <div class="item-game"'.($k==0?'':' style="display:none"').'>'.PHP_EOL;
                    $str .= '            <a href="'.$url.'"><img src="'.$v['icon'].'" alt="'.$v['title'].'下载"></a>'.PHP_EOL;
                    $str .= '            <div class="deta">'.PHP_EOL;
                    $str .= '                <a href="'.$url.'"><em class="name">'.$v['title'].'</em></a>'.PHP_EOL;
                    $str .= '                <div class="tags">'.PHP_EOL;
                    foreach($v['tags'] as $m=>$t) {
                        if ($m>=3) break;
                        $str .= '                    <span>'.$t['title'].'</span>';
                    }
                    $str .= '                </div>'.PHP_EOL;
                    $str .= '            </div>'.PHP_EOL;
                    $str .= '        </div>'.PHP_EOL;
                }
                $str .= '        <a class="btn-change" id="hh_btn">换一换</a>'.PHP_EOL;
                $str .= '    </div>'.PHP_EOL;

                $str .= '<div id="hh_list">'.PHP_EOL;
                foreach($data['host_list'] as $k=>$v) {
                    $url = $v['url'];

                    $str .= '<div'.($k==0?'':' style="display:none"').'>'.PHP_EOL;
                    $str .= '    <a href="'.$url.'"><div class="img"><img src="'.$v['pic'].'" alt="'.$v['title'].'安卓版"></div><div class="desc">'.$v['intro'].'</div>'.PHP_EOL;
                    $str .= '    <div class="gameinfo">'.PHP_EOL;
                    $str .= '        <div class="pro"><img src="'.$v['userinfo']['avatar'].'" alt="'.$v['userinfo']['name'].'">'.$v['userinfo']['name'].'</div>'.PHP_EOL;
                    $str .= '        <div class="total">'.PHP_EOL;
                    if ($v['num_download'] && strpos($data['num_download'],'预约')===false) {
                        $str .= '            <span class="download">'.$v['num_download'].'</span>'.PHP_EOL;
                    }
                    $str .= '            <span class="review">'.$v['num_comment'].'</span>'.PHP_EOL;
                    $str .= '        </div>'.PHP_EOL;
                    $str .= '    </div></a>'.PHP_EOL;
                    $str .= '</div>'.PHP_EOL;
                }
                $str .= '</div>'.PHP_EOL;

                $str .= '</div>'.PHP_EOL;

                return $str;
            break;

            case '10':
                $url = '';
                if ($data['id'] && $data['type']) {
                    $url = Comm::getUrlByInterface($data['type'],$data['id'],$data['link']);
                }
                $str .= '<div>'.PHP_EOL;

                $str .= '   <div class="tithd"><em>'.$data['title'].'</em><!--<a class="more" href="'.$url.'">全部</a>--></div>'.PHP_EOL;
                $str .= '   <div class="reco-hot">'.PHP_EOL;
                $str .= '    <ul class="swiper-wrapper">'.PHP_EOL;
                foreach($data['month_list'] as $k=>$v) {
                    $url = Comm::get_url('game_detail','',array('id'=>$v['id']));
                    $str .= '        <li class="swiper-slide">'.PHP_EOL;
                    $str .= '            <a href="'.$url.'">'.PHP_EOL;
                    $str .= '                <div class="hd">'.PHP_EOL;
                    $str .= '                    <img src="'.$v['icon'].'" alt="'.$v['title'].'下载">'.PHP_EOL;
                    $str .= '                    <div class="con">'.PHP_EOL;
                    $str .= '                        <em>'.$v['title'].'</em>'.PHP_EOL;
                    $str .= '                        <div class="star">'.PHP_EOL;
                    $str .= '                            <div class="starbar">'.PHP_EOL;
                    $str .= '                                <span style="width: '.(floatval($v['star'])*10).'%"></span>'.PHP_EOL;
                    $str .= '                            </div>'.PHP_EOL;
                    $str .= '                            <span class="score">'.$v['star'].'分</span>'.PHP_EOL;
                    $str .= '                        </div>'.PHP_EOL;
                    $str .= '                    </div>'.PHP_EOL;
                    $str .= '                </div>'.PHP_EOL;
                    $str .= '                <p class="desc">'.$v['intro'].'</p>'.PHP_EOL;
                    $str .= '                <div class="info">'.PHP_EOL;
                    $str .= '                    <span>'.$v['desc_num'].'</span>'.PHP_EOL;
                    $str .= '                    <span>'.str_replace(' size="20"','',$v['desc_time']).'</span>'.PHP_EOL;
                    $str .= '                </div>'.PHP_EOL;
                    $str .= '            </a>'.PHP_EOL;
                    $str .= '        </li>'.PHP_EOL;
                }
                $str .= '    </ul>'.PHP_EOL;
                $str .= '   </div>'.PHP_EOL;
                
                $str .= '</div>'.PHP_EOL;

                return $str;
            break;

            case '7'://合辑
                // $url = '';
                // if ($data['id'] && $data['type']) {
                //     $url = Comm::getUrlByInterface($data['type'],$data['id']);
                // }
                // $str .= '<div class="item">'.PHP_EOL;
                // $str .= '    <div class="tit">'.$data['title'].'</div>'.PHP_EOL;
                // $str .= '    <div class="img">'.PHP_EOL;
                // $str .= '        <img src="'.$data['icon'].'" alt="'.$data['title'].'">'.PHP_EOL;
                // $str .= '        <span class="tag">合集</span>'.PHP_EOL;
                // $str .= '    </div>'.PHP_EOL;
                // $str .= '    <div class="desc">'.$data['description'].'</div>'.PHP_EOL;
                // $str .= '    <div class="gameinfo">'.PHP_EOL;
                // $str .= '        <div class="pro"><img src="'.$data['userinfo']['avatar'].'" alt="'.$data['userinfo']['name'].'">'.$data['userinfo']['name'].'</div>'.PHP_EOL;
                // $str .= '        <div class="total">'.PHP_EOL;
                // if ($data['good']) $str .= '            <span class="praise">'.$data['good'].'</span>'.PHP_EOL;
                // if ($data['num_comment']) $str .= '            <span class="review">'.$data['num_comment'].'</span>'.PHP_EOL;
                // $str .= '        </div>'.PHP_EOL;
                // $str .= '    </div>'.PHP_EOL;
                // $str .= '</div>'.PHP_EOL;

                return $str;
            break;

            case '11'://热门游戏更新
                $url = '';
                if ($data['id'] && $data['type']) {
                    $url = Comm::getUrlByInterface($data['type'],$data['id'],$data['link']);
                }

                $str .= '<div>'.PHP_EOL;
                $str .= '    <div class="tithd">'.PHP_EOL;
                $str .= '        <em>热门游戏更新</em>'.PHP_EOL;
                // $str .= '        <a class="more pop_btn" rel="toapp">全部</a>'.PHP_EOL;
                $str .= '    </div>'.PHP_EOL;
                $str .= ''.PHP_EOL;
                $str .= '    <div class="reco-update">'.PHP_EOL;
                $str .= '        <ul class="swiper-wrapper">'.PHP_EOL;
                foreach($data['hot_list'] as $k=>$v) {
                    $url = Comm::get_url('game_detail','',array('id'=>$v['id']));
                    $game = Comm::getGameData($v['id']);
                    $str .= '            <li class="swiper-slide">'.PHP_EOL;
                    $str .= '                <a href="'.$url.'">'.PHP_EOL;
                    $str .= '                <img src="'.$v['icon'].'" alt="'.$game['title'].'">'.PHP_EOL;
                    $str .= '                <div class="mask"></div>'.PHP_EOL;
                    $str .= '                <em class="tit">'.$v['title'].'</em>'.PHP_EOL;
                    $str .= '                </a>'.PHP_EOL;
                    $str .= '            </li>'.PHP_EOL;
                }
                $str .= '        </ul>'.PHP_EOL;
                $str .= '    </div>'.PHP_EOL;
                $str .= '</div>'.PHP_EOL;

                return $str;
            break;

            case '9'://合辑推荐
                // $url = Comm::get_url('coll','list');

                // $str .= '<div>'.PHP_EOL;
                // $str .= '    <div class="tithd">'.PHP_EOL;
                // $str .= '        <em>精选合辑</em>'.PHP_EOL;
                // $str .= '        <a class="more" href="'.$url.'">全部</a>'.PHP_EOL;
                // $str .= '    </div>'.PHP_EOL;
                // $str .= '    <div class="reco-heji">'.PHP_EOL;
                // $str .= '        <ul class="swiper-wrapper">'.PHP_EOL;
                // foreach($data['coll_list'] as $k=>$v) {
                //     $url = Comm::get_url('coll','detail',array('id'=>$v['id']));
                //     $str .= '            <li class="swiper-slide">'.PHP_EOL;
                //     $str .= '                <a href="'.$url.'">'.PHP_EOL;
                //     $str .= '                    <img src="'.$v['icon'].'" alt="'.$v['title'].'">'.PHP_EOL;
                //     $str .= '                    <div class="mask"></div>'.PHP_EOL;
                //     $str .= '                    <em class="tit">'.$v['title'].' </em>'.PHP_EOL;
                //     if ($v['good']) $str .= '                    <span class="praise">'.$v['good'].'</span>'.PHP_EOL;
                //     $str .= '                </a>'.PHP_EOL;
                //     $str .= '            </li>'.PHP_EOL;
                // }
                // $str .= '        </ul>'.PHP_EOL;
                // $str .= '    </div>'.PHP_EOL;
                // $str .= '</div>'.PHP_EOL;

                return $str;
            break;

            default:
                // return '<div>没有相关数据类型</div>';
            break;
        }
    }

    function getIndexItemHtmls($datalist) {
        $htmls = array();
        $i = 0;
        foreach($datalist as $k=>$data) {
            $i++;
            if ($i>10) {
                $htmls[] = $this->reHtmlHide($this->getIndexHtmlByType($data,$k));
            } else {
                $htmls[] = $this->getIndexHtmlByType($data,$k);
            }
        }
        return $htmls;
    }

    // 隐藏图层
    function reHtmlHide($str) {
        // $str = preg_replace(array('<div class="box">','<div>'),array('<div class="box" style="display:none">','<div style="display:none">'),$str);
        $str = preg_replace('/^<div/i','<div style="display:none"',$str);
        $str = str_replace("src=","lz_src=",$str);
        return $str;
    }

    function get_date_tag($game_time) {
        if ($game_time>0) {
            $today_start_time = strtotime(date("Y-m-d",time()));
            $diff_time = time() - $game_time;
            if ($diff_time<60) {
                $date_str = '刚刚';
            } elseif ($game_time>=$today_start_time) {
                $date_str = '今天';
            } elseif ($game_time>=$today_start_time-86400) {
                $date_str = '昨日';
            } 
            // elseif ($diff_time<3600) {
            //     $date_str = ceil($diff_time/60).'分钟前';
            // } elseif ($game_time<=strtotime('Y-m-d 23:59:59',time())) {
            //     $date_str = ceil($diff_time/3600).'小时前';
            // } elseif (date("Y",time()) == date("Y",$game_time)) {
            //     $date_str = date('m-d H:i',$game_time);
            // } 
            else {
                $date_str = date("Y.m.d",$game_time);
            }
        }

        $date_str = '<span class="tag">'.$date_str.'</span>';

        return $date_str;
    }
}