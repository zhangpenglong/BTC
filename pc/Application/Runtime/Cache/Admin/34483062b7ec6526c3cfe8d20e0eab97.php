<?php if (!defined('THINK_PATH')) exit();?><head>
	<meta charset="UTF-8">
	<title>后台管理系统</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/css/font.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/css/xy.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/plug-in/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/xadmin.css" />

	<script type="text/javascript" src="http://localhost:8081/Public/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="http://localhost:8081/Public/js/vue.min.js"></script>
    <script type="text/javascript" src="http://localhost:8081/Public/plug-in/layui/layui.js"></script>
	<script type="text/javascript" src="http://localhost:8081/Public/js/xadmin.js"></script>
    <script type="text/javascript" src="http://localhost:8081/Public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://localhost:8081/Public/js/md5.js"></script>
    <script type="text/javascript" src="http://localhost:8081/Public/js/config.js"></script>
    <script type="text/javascript" src="http://localhost:8081/Public/js/function.js"></script>
    

	<!--[if lt IE 9]>
        alert("你的浏览器版本，请更换浏览器，推荐谷歌");
    <![endif]-->
</head>





<script type="text/javascript" src="http://localhost:8081/Public/js/jquery.qrcode.min.js"></script>
<style>
    .layui-elem-quote{font-size: 15px;}
    .num, .name, .wx_access{font-size: 18px; color: #666; font-family: '微软雅黑';}
    .right {margin: 0 15px 0 30px;}
    .layui-btn {background-color: #62b900;}
    .item {height: 40px; line-height: 40px;}
    .show-cotent {width: 100%; height: 100%; padding-top: 20px; box-sizing: border-box; text-align: center;}
    .show-code {width: 180px; height: 180px; margin: 0 auto;}
    .layui-icon, .iconfont {color: #505050;}
    .oldpass,.newpass,.surepass{font-size:16px; margin-left:15%; display:inline-block;}
    .layui-input {display: inline; width: 65%; position: relative; left: 20%; border:1px solid #ddd; font-size:13px; }
    .layui-btn-normal{position: relative; left: 60%; margin: 20px 0 0 0; width: 100px;}
    .changepass {padding: 20px; }
    .switch-box{
        position: relative;
    }
    .layui-switch{
        position: absolute;
        right: 20px;
        top: 5px;
    
    }
    .item {
        width: 120px;
    }

</style>
<body>
    <div class="x-body">
    <div class="switch-box">
      <div class="layui-form">
      <blockquote class="layui-elem-quote">客服管理</blockquote>
       
        </div>
        <div class="layui-form  layui-switch">
         <input type="checkbox" id="service_switch" lay-filter= "service_switch"  lay-skin="switch" lay-text="开启|关闭">
         </div>
    </div>
        
        
        <div style="display: flex; flex-direction: row;">
            <div class="item">
                <i class="iconfont" >&#xe6b8;</i>
                <span style="font-size: 17px; color: #666;">客服名字</span>
            </div>
            <div class="content">
                <span class="name"></span>
            </div>
            
        </div>
        <hr class="hr15"/>
        <hr class="hr1"/>
        <span class="site-demo-button" >
            <button data-method="offset" id="layerDemo" data-type="auto" class="layui-btn" style="background-color: #009688 !important;">信息修改</button>
            <span class="right"></span>     <!--添加空格防止拥挤-->            
        </span>
       
        
        
    </div>

</body>

<script>

    var url = "<?php echo U(serviceInfo);?>";
    var code;

    // 修改网站信息
    layui.use(['layer','form'],function() {

        var layer = layui.layer;
        var form = layui.form;

        $.ajax({
        url : url,
        type: 'get',
        success: function (res) {

            if ( res.data.length == 0 ) {
                layer.msg('信息！', {icon: 5});
                return false;
            }

            $(".name").html(res.data[0]['name']);
            $('.tel').html(res.data[0]['tel']);
            $('.wechat').html(res.data[0]['wechat']);
            $('.qq').html(res.data[0]['qq']);

            if (res.data.service_status == 0) {
                $('#service_switch')[0]['checked'] = true;
            }else{
                $('#service_switch')[0]['checked'] = false;
            }
            form.render('checkbox');

        }
        });
        form.on('switch(service_switch)',function(obj){

            if (obj.elem.checked) {//如果开启
                $.post('<?php echo U(serviceSwicth);?>',{service_status : '0'},function(data){
                    if (data.code == '0') {
                        layer.open({
                            title: "开启状态",
                            content: "开启成功！",
                            btn: ["关闭"],
                         });
                    }else{
                        layer.open({
                            title: "开启状态",
                            content: "开启失败！",
                            btn: ["关闭"],
                         });
                    }

                });
            }else{
                $.post('<?php echo U(serviceSwicth);?>',{service_status : '1'},function(data){
                    if (data.code == '0') {
                        layer.open({
                            title: "开启状态",
                            content: "关闭成功！",
                            btn: ["关闭"],
                         });
                    }else{
                        layer.open({
                            title: "开启状态",
                            content: "关闭失败！",
                            btn: ["关闭"],
                         });
                    }

                });
            }

        });

        $('#layerDemo').on('click', function () {

            layer.open({
                type: 2,
                title: '客服设置',
                area: ['500px', '400px'],
                content: '<?php echo U(ServiceUp);?>',
                btnAlign: 'c',
                yes: function () {
                    layer.closeAll();
                }
            });
            $('#code').attr('src', code);
        });
    });
   
</script>