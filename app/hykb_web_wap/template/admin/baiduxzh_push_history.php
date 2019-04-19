<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge,chrome=1" />
    <title>后台-通用设置</title>
    <link rel="stylesheet" href="http://newsimg.5054399.com/app/aolaxing/web/third/bootstrap/css/bootstrap.min.css"/>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div class="row" style="margin:0 auto; width:960px;">
    <div class="span12">
        <table class="table table-striped table-bordered table-hover" style="width:100%;">
        <tr>
        <th class="span2" style="text-align:center;">游戏ID</th>
        <th style="text-align:center;">推送地址</th>
        <th style="text-align:center;">发布日期<br>(首次生成时间)</th>
        <th style="text-align:center;">推送时间</th>
        <th style="text-align:center;">推送类型</th>
        </tr>
        <?php 
        $_api_types = array(
            1=>'新增',
            2=>'历史',
            3=>'新增',
            4=>'原创',
            5=>'历史',
        );
        foreach($list as $v){?>
        <tr>
        <td class="span2" style="text-align:center;"><?=$v['gameid']?></td>
        <td style="text-align:center;"><?=$v['gameurl']?></td>
        <td style="text-align:center;"><?=date("Y-m-d H:i:s",$v['addtime'])?></td>
        <td style="text-align:center;"><?=date("Y-m-d H:i:s",$v['push'])?></td>
        <td style="text-align:center;"><?=$_api_types[$v['push_type']]?></td>
        <?php }?>
        </table>
</div>

</body>
</html>
