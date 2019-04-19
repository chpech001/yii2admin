<?php
defined('APP_PATH') or exit('Access Denied');
class make extends Controller {

    function init(){
        global $_view_base_url,$_sc_base_url,$_sc_root,$db;
        $this->view_base_url = $_view_base_url;
        $this->sc_base_url = $_sc_base_url;
        $this->sc_root = $_sc_root;
        $this->db = $db;
    }

    function IndexAction() {
        $home_view_url = Comm::get_view_url('home');
        include ADMIN_TPL_PATH.'/make_index.php';
    }

    // 生成首页
    function makeIndexAction() {
        $view_url = Comm::get_view_url('home');
        $make_url = Comm::get_url('home','',array('view_ishtml'=>1));
        echo '抓取地址：'.$view_url.'<br>';

        $html = Comm::curl_get($view_url,10);
        if (strlen($html)<500) {
            // Comm::log('err_make_index_'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '首页生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>';
        
        // Comm::log('success_make_index','生成成功');
    }

    // 生成指定游戏ID/IDS的详情页
    function makeGameDetailAction(){
        $ids = $_REQUEST['ids'];
        if (!$ids) {
            die('参数错误');
        }
        $ids = str_replace('|',',',$ids);
        $ids = explode(',',$ids);
        $ids = $this->arrayMapRecursive('intval',$ids);
        if (!$ids) {
            die('参数错误');
        }

        foreach($ids as $id) {
            $r = $this->makeOneGameDetail($id,false);
            if ($r['code']==1) {
                $sql = "UPDATE ".C::$table_game." SET status=9 WHERE gameid='{$id}'";
                $this->db->query($sql);
                echo '<br>游戏ID['.$id.']，生成成功，<a href="'.$r['url'].'?t='.time().'" target="_blank">点击查看</a>';
            } else {
                if (strpos($r['msg'],'show_url')===0) {
                    $sql = "UPDATE ".C::$table_game." SET status=98 WHERE gameid='{$id}'"; //show_url错误
                    $this->db->query($sql);
                    if ($this->delGameFile($id)) {
                        echo '<br/>游戏ID['.$id.']，show_url为1，删除已存在文件';
                    } else {
                        echo '<br/>游戏ID['.$id.']，show_url为1，不生成';
                    }
                } else {
                    $sql = "UPDATE ".C::$table_game." SET status=99 WHERE gameid='{$id}'"; //生成错误
                    $this->db->query($sql);
                    echo '<br>游戏ID['.$id.']，生成失败 (返回内容：'.$r['msg'].')';
                }
            }
        }
    }
    
    // 中断生成所有游戏详情页操作
    function stopMakeAllUpdateAction() {
        $sql = "UPDATE ".C::$table_game." SET status=4";
        $this->db->query($sql);
        echo '中断成功，你可以进行操作了。';
    }

    // 同步游戏，生成所有游戏详情页
    function makeAllGameDetailAction() {
        set_time_limit(0);
        echo '<h2>正在通过接口获取所有游戏ID...</h2>';
        $ids = $this->getApiGameIds();
        if (!$ids) die('游戏ID获取失败');
        
        echo '<h2>正在同步游戏ID...</h2>';
        $ids_arr = array_chunk($ids,2000,true);
        
        //初始化状态5[待处理]；新增状态为1，更新状态为2；更新其它状态为5的状态为3（删除状态）
        $sql = "select count(*) as c from ".C::$table_game." WHERE status=5";
        $tmp = $this->db->get_one($sql);
        if ($tmp['c']>0) {
            echo '可能有其它程序或人员在进行些操作中，待处理完后，才可进行此操作。<br>';
            echo '也可进行中断后进行此操作，<a href="?m=make&ac=stop_make_all_update" onclick="return confirm(\'确定要中断其它程序或人员进行此操作吗？\')" target="_blank">中断其它人员进行此操作</a>';
            die('');
        }

        $sql = "UPDATE ".C::$table_game." SET status=5";
        $this->db->query($sql);

        $insert_num = $update_num = $del_num = 0;
        foreach($ids_arr as $a) {
            $ids2 = array();
            $update_ids = array();
            $del_ids = array();
            $insert_ids = array();

            $sql = "SELECT gameid FROM ".C::$table_game." WHERE gameid IN (".implode(',',$a).")";
            $query = $this->db->query($sql);
            while($query && $rs = mysql_fetch_assoc($query)) {
                $ids2[$rs['gameid']] = $rs['gameid'];
            }
            foreach($a as $id1) {
                if ($ids2[$id1]) {//更新ID
                    $update_ids[$id1] = $id1;
                    $update_num++;
                } else {//插入ID
                    $insert_ids[$id1] = $id1;
                    $insert_num++;
                }
            }
            //插入游戏，状态为1
            if ($insert_ids) {
                $strs = array();
                foreach ($insert_ids as $id) {
                    $strs[] = "('{$id}',1)";
                }

                $strs = implode(',',$strs);
                $sql = "INSERT INTO ".C::$table_game."(gameid,status) VALUES {$strs}";
                $this->db->query($sql);
                // echo '插入游戏 <font color=red>'.count($insert_ids).'</font>：'.implode(',',$insert_ids).'<br>';
            }
            //更新游戏状态，状态为2
            if ($update_ids) {
                $sql = "UPDATE ".C::$table_game." SET status=2 WHERE gameid IN(".implode(',',$update_ids).")";
                $this->db->query($sql);
                // echo '待更新游戏 <font color=red>'.count($update_ids).'</font><br>';
            }
        }

        echo '插入游戏: <font color=red>'.$insert_num.'</font> <br>';//['.implode(',',$insert_ids).']

        echo '待更新游戏: <font color=red>'.$update_num.'</font><br>';

        // 插入与更新状态更新完毕，更新其余待处理状态为3[删除状态]
        $sql = "UPDATE ".C::$table_game." SET status=3 WHERE status=5";
        $this->db->query($sql);
        $del_num = intval($this->db->affected_rows());
        if ($del_num) {
            echo '待删除游戏 <font color=red>'.$del_num.'</font><br>';
        }

        echo '<h2>正在生成，请勿关闭页面！</h2>';
        header("refresh:1;url=?m=make&ac=make_all_game_html&page=1");
        die();
    }

    // 根据数据库分页生成游戏静态页
    function makeAllGameHtmlAction() {
        set_time_limit(0);
        $page_size = 20;
        $page = intval($_GET['page']);
        if ($page<=0) {
            echo '<h2>正在生成，请勿关闭页面！</h2>';
            header("refresh:1;url=?m=make&ac=make_all_game_html&page=1");
            die();
        }

        // 生成顺序：1、插入[状态1]]；2、更新[状态2]；3、删除[状态3]
        $type = intval($_REQUEST['type']);
        if (!$type) $type = 1;
        if (!in_array($type,array(1,2,3))) die('生成参数有误');
        if ($type==1) {
            echo '<br/><h3>正在生成插入数据</h3>';
        } elseif ($type==2) {
            echo '<br/><h3>正在生成更新数据</h3>';
        } elseif ($type==3) {
            echo '<br/><h3>正在删除下架数据</h3>';
        }

        if ($type==1 || $type==2) {
            $sql = "SELECT * FROM ".C::$table_game." WHERE status='{$type}' ORDER BY gameid ASC LIMIT 0,{$page_size}";
        } elseif ($type==3) {
            $sql = "SELECT * FROM ".C::$table_game." WHERE status='{$type}' ORDER BY gameid ASC";
        }
        $query = $this->db->query($sql);
        $ids = array();
        $t1 = microtime(true);
        while($query && $rs = mysql_fetch_assoc($query)) {
            $ids[] = $rs['gameid'];
        }

        $is_finish = ($type==3 && !$ids);

        if ($ids) {
            if ($type==1 || $type==2) {
                $ok_ids = $err_ids = $showurl_ids = array();
                foreach($ids as $id) {
                    $r = $this->makeOneGameDetail($id,true);
                    if ($r['code']==1) {
                        $sql = "UPDATE ".C::$table_game." SET status=9 WHERE gameid='{$id}'";
                        $this->db->query($sql);
                        echo '<br/>游戏ID['.$id.']，生成成功，<a href="'.$r['url'].'?t='.time().'" target="_blank">点击查看</a>';
                        $ok_ids[] = $id;
                    } else {
                        if (strpos($r['msg'],'show_url')===0) {
                            $sql = "UPDATE ".C::$table_game." SET status=98 WHERE gameid='{$id}'";
                            $this->db->query($sql);
                            if ($this->delGameFile($id)) {
                                echo '<br/>游戏ID['.$id.']，show_url为1，删除已存在文件';
                            } else {
                                echo '<br/>游戏ID['.$id.']，show_url为1，不生成';
                            }
                        } else {
                            $sql = "UPDATE ".C::$table_game." SET status=99 WHERE gameid='{$id}'";
                            $this->db->query($sql);
                            echo '<br/>游戏ID['.$id.']，生成失败 (返回内容：'.$r['msg'].')';
                            $err_ids[] = $id;
                        }
                        
                    }
                }
                if ($ok_ids) {
                    echo '<br/>本页生成成功:<font color=red>'.count($ok_ids).'</font>';
                }
                if ($showurl_ids) {
                    echo '<br/>本页show_url不展示:<font color=red>'.count($showurl_ids).'</font>';
                }
                if ($err_ids) {
                    echo '<br/>本页生成失败:<font color=red>'.count($err_ids).'</font>';
                }
            } elseif ($type==3) {
                $del_num = 0;
                $del_ids2 = array();
                foreach($ids as $id) {
                    if ($this->delGameFile($id)) {
                        echo '<br/>删除文件['.$id.']';
                    }
                    $del_num++;
                    $del_ids2[] = $id;
                }
                if ($del_num) {
                    $sql = "DELETE FROM ".C::$table_game." WHERE gameid IN(".implode(',',$del_ids2).") ";
                    $this->db->query($sql);
                    Comm::log('del_make_gamedetail_'.date("Ymd"),'删除游戏：'.implode(',',$del_ids2));
                    echo '<br/>本页共删除<font color=red>'.$del_num.'</font>游戏';
                }

                $is_finish = true;

            }
        }

        if ($is_finish) {
            $ids = $this->get_err_make_gameids();
            echo "<br/>更新完毕";
            if ($ids) {
                echo "<br/>以下游戏生成失败，正在重新生成".PHP_EOL;
                foreach($ids as $id) {
                    $r = $this->makeOneGameDetail($id,true);
                    if ($r['code']==1) {
                        $sql = "UPDATE ".C::$table_game." SET status=9 WHERE gameid='{$id}'";
                        $this->db->query($sql);
                        echo '<br/>游戏ID['.$id.']，生成成功，<a href="'.$r['url'].'?t='.time().'" target="_blank">点击查看</a>';
                    } else {
                        echo '<br/>游戏ID['.$id.']，生成失败 (返回内容：'.$r['msg'].')';
                    }
                }
            }
            die('');
        } else {
            if (!$ids) {
                if ($type==1) {
                    header("refresh:1;url=?m=make&ac=make_all_game_html&type=2&page=1");
                    echo '<br/>正在加载，请稍等...<font color=red>插入数据生成完毕</font>，一秒后自动跳转(更新数据生成)~~~';
                } elseif ($type==2) {
                    header("refresh:1;url=?m=make&ac=make_all_game_html&type=3&page=1");
                    echo '<br/>正在加载，请稍等...<font color=red>更新数据生成完毕</font>，一秒后自动跳转(删除下载游戏)~~~';
                } 
            } else {
                $t = round(microtime(true) - $t1,2);
                echo '<br/>本页用时'.$t;
                header("refresh:1;url=?m=make&ac=make_all_game_html&type={$type}&page=".($page+1));
                $action = '';
                if ($type==1) $action = '插入';
                if ($tyep==2) $action = '更新';
                echo '<br/>正在生成'.$action.'数据，请稍等...一秒后自动跳转~~~';
            }
        }
    }

    function get_err_make_gameids() {
        $sql = "SELECT * FROM ".C::$table_game." WHERE status=99 ";
        $query = $this->db->query($sql);
        $ids = array();
        while($query && $rs = mysql_fetch_assoc($query)) {
            $ids[] = $rs['gameid'];
        }
        return $ids;
    }

    // 生成单个详情页
    function makeOneGameDetail($id,$islog=false){
        $id = intval($id);
        if ($id<=0) {
            return array('code'=>0,'msg'=>'游戏ID错误');
        }

        $view_url = Comm::get_view_url('game_detail','',array('id'=>$id));
        $make_url = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$id));
        
        $html = Comm::curl_get($view_url,10);
        if (strlen($html)<500) {
            if ($islog) Comm::log('err_make_gamedetail_'.date("Ymd"),'生成失败,游戏ID['.$id.']：'.$html);
            return array('code'=>0,'msg'=>$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        return array('code'=>1,'url'=>$this->sc_base_url.$file);
    }

    function getApiGameIds() {
        $data = array(
            'c' => 'apiselect',
            'a' => 'getGamesGids',
            'timestamp' => time(),
            'version' => '1.4.0',
        );
        $secret = 'd263319194a6f3830bb21f6892245ebf';
        $data['token'] = md5( '#' . $data['version'] . '&' . $secret . '*' . $data['timestamp'] . '|' );

        $ids = array();
        $return = Comm::curl_post(C::$api_gids, json_encode($data));
        if ($return) {
            $return = json_decode($return, true);
            if ($return['code']== 100 && $return['result']) {
                $ids = $return['result'];
            }
        }
        return $ids;
    }

    function delGameFile($gameid) {
        $file = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$gameid));
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        $file = $this->sc_root."/{$file}";
        $flag = 0;
        if (is_file($file)) {
            @unlink($file);
            $flag = 1;
        }
        return $flag;
    }

}