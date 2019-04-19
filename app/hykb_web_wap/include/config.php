<?php
defined('APP_PATH') or exit('Access Denied');

// 静态生成根目录
if (is_dir('/www/t.news.4399.com')) {
	$_sc_path = '/';// 生成路径
	$_sc_root = '/www/t.m.3839.com'; //生成路径根目录
    $_sc_base_url = '//t.m.3839.com'; //生成的静态文件域名
    $_view_base_url = 'http://t.m.3839.com';// 预览域名

    @define("DB_HOST",'localhost');
    @define("DB_USER",'root');
    @define('DB_PASSWORD','admin4399');
    @define('DB_NAME','news4399');

    @define('MEM_HOST'    ,'localhost');
	@define('MEM_PORT'    ,11211);
} elseif (is_dir('/www/m.3839.com')) {
	$_sc_path = '/';// 生成路径
	$_sc_root = '/www/m.3839.com';// 生成路径根目录
    $_sc_base_url = '//m.3839.com';// 生成的静态文件根域名
    $_view_base_url = 'http://sc.m.3839.com';// 预览域名

    // @define("DB_HOST",'192.168.1.209');
    // @define("DB_USER",'kb4399');
    // @define('DB_PASSWORD','kba82WW!dv0');
    // @define('DB_NAME','kuaibao');

    @define("DB_HOST",'115.238.73.89');
    @define("DB_USER",'my4399');
    @define('DB_PASSWORD','dP9#DL63P');
    @define('DB_NAME','news4399');


    @define('MEM_HOST'    ,'192.168.1.209');
	@define('MEM_PORT'    ,12000);
} elseif (is_dir('E:/')) {
	$_sc_path = '/';// 生成路径
	$_sc_root = $_SERVER['DOCUMENT_ROOT'];// 生成路径根目录
    $_sc_base_url = '//my.m.3839.com';// 生成的静态文件域名
    $_view_base_url = 'http://my.m.3839.com';// 预览域名

    @define("DB_HOST",'localhost');
    @define("DB_USER",'root');
    @define('DB_PASSWORD','admin4399');
    @define('DB_NAME','news4399');

    @define('MEM_HOST'    ,'localhost');
	@define('MEM_PORT'    ,11211);
}

@define('MEM_PRE','HYKB_WEB_WAP_');
@define('CDN_V',6.89);
class C{
    //首页接口
    static public $api_home = 'http://newsapp.5054399.com/cdn/android/recommend-home-1539-level-5.htm';

    //首页广告接口
    static public $api_home_prom = 'http://prom.5054399.com/promotion.php?page=home&ver=186&level=5';

    //推荐分类接口
    static public $api_home_promtag = 'http://newsapp.5054399.com/cdn/android/categoryall-home-140-level-5.htm';

	//新奇页面接口
	static public $api_newness= 'http://newsapp.5054399.com/cdn/android/discoverall-home-1538-level-5.htm';
	//分类聚合页相关接口(全部分类，热门推荐，最新更新，最高评分）
	static public $api_category='http://newsapp.5054399.com/cdn/android/categoryall-home-140-level-5.htm';
	static public $api_category_detail_hot='http://newsapp.5054399.com/cdn/android/hotdownload-home-141-id-{cid}-page-{p}-level-5.htm';
	static public $api_category_detail_new='http://newsapp.5054399.com/cdn/android/categorylist-home-140-id-{cid}-page-{p}-level-5.htm';
	static public $api_category_detail_star='http://newsapp.5054399.com/cdn/android/hotstar-home-141-id-{cid}-page-{p}-level-5.htm';
	//排行榜接口
	static public $api_top='http://newsapp.5054399.com/cdn/android/ranktop-home-140-type-{type}-level-5.htm';
	static public $api_hotmanu='http://newsapp.5054399.com/cdn/android/ranktop-hotmanu-140-type-manu-level-5.htm';//热门开发者
	static public $api_hotplayer='http://newsapp.5054399.com/cdn/android/ranktop-player-140-type-player-level-5.htm';//玩家排行榜
	//开发者详情
	// static public $api_kiother='http://t.newsapp.5054399.com/cdn/android/kiother-home-1536-uid-{uid}-level-5.htm';//获取开发者简单信息
	static public $api_kiother='http://newsapp.5054399.com/cdn/android/kiother-home-1536-uid-{uid}-level-5.htm';//获取开发者简单信息
	//static public $api_kigamed='http://newsapp.5054399.com/cdn/android/kigamed-home-1536-uid-{uid}-page-{p}-level-1.htm';//获取开发者游戏信息
	  static public $api_kigamed='http://newsapp.5054399.com/cdn/android/kigamet-home-1536-uid-{uid}-page-{p}-level-5.htm';//获取开发者游戏信息
	  // static public $api_kigamed='http://t.newsapp.5054399.com/cdn/android/kigamet-home-1536-uid-{uid}-page-{p}-level-5.htm';//获取开发者游戏信息
    //游戏详情接口
   static public $api_gameinfo = 'http://newsapp.5054399.com/cdn/android/gameintro-home-1541-id-{gameid}-packag--level-4.htm';//新接口
    // 热门搜索页
    static public $api_hot_search = 'http://newsapp.5054399.com/cdn/android/recommendsearch-home-144-level-5.htm';

    static public $api_xinqi = '';

    static public $api_fenlei = '';

    static public $api_heji = '';

    static public $api_ph_sugar = 'http://newsapp.5054399.com/cdn/android/ranktop-home-140-type-sugar-level-5.htm';

    //安利墙接口
    static public $api_commentwalllist='http://newsapp.5054399.com/cdn/android/commentwall-home-1542-page-{p}-level-1.htm';

   //合辑列表接口(2总分类列表，1标签列表，2标签分类列表）
    static public $api_collection_hot='http://newsapp.5054399.com/cdn/android/collection-home-1543-hot-1-page-{p}-level-5.htm';
    static public $api_collection_recent='http://newsapp.5054399.com/cdn/android/collection-home-1543-page-{p}-level-5.htm';
    static public $api_collection_tags='http://newsapp.5054399.com/cdn/android/collection-themetags-1543-level-5.htm';
    static public $api_collection_detail_hot='http://newsapp.5054399.com/cdn/android/collection-tagsList-1543-id-{cid}-hot-1-page-{p}-level-5.htm';
    static public $api_collection_detail_recent='http://newsapp.5054399.com/cdn/android/collection-tagsList-1543-id-{cid}-page-{p}-level-5.htm';
    //合辑文章详情接口
    static public $api_collection_detail_arc='http://newsapp.5054399.com/cdn/android/collectiondetail-home-145-id-{cid}-level-5.htm';


    static public $cdn_path = '//newsimg.5054399.com/hykb/static/hykb_web_wap/';
     // static public $cdn_path = '//t.news.4399.com/hykb/static/hykb_web_wap/';

    static public $app_down_url = '//www.3839.com/app.html';

    // 获取所有游戏ID接口
    static public $api_gids = 'http://newsapp.5054399.com/kuaibao/android/apidev.php';
    // static public $api_gids = "http://t.newsapp.5054399.com/kuaibao/android/apidev.php"; //测式地址
    // static public $api_gids = "http://ot.newsapp.5054399.com/kuaibao/android/apidev.php"; //ot正式地址
    // static public $api_gids = "http://newsapp.5054399.com/kuaibao/android/apidev.php"; //正式地址

    static public $table_game = 'hykb_web_game_wap';
    static public $table_game_link = 'hykb_web_gamelink_wap';
    static public $table_sysinfo = 'hykb_web_sysinfo';
    static public $table_game_push = 'hykb_web_game_wap_push';
}
