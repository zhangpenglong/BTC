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






<link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/css/bootstrap.min.css" />

<style>
    .navbar {margin-bottom: 0; line-height: 50px; padding: 0 10px;}
    .navbar>input {width: 20%; display: inline;}
    .navbar>button {height: 34px; transform: translateY(-2px);}
    .layui-elem-quote {font-size: 15px;}
    .layui-form-label {padding: 9px 10px;}
</style>
<body>
    <div class="x-body">

     <blockquote class="layui-elem-quote">发送私信</blockquote>
        <nav class="navbar navbar-default">
         <input type="text" id="user_name" class="form-control" placeholder="请输出用户名" />
        <button typr="button" class="btn btn-default" id="searchBtn">搜索</button>

        <button typr="button" class="layui-btn layui-btn-normal" id="addBtn"><i class="layui-icon">&#xe608;</i> 发送</button>
             <table id="UserList" lay-filter="UserList"></table>
        </nav>
        
        <table id="UserList" lay-filter="UserList"></table>
    </div>

</body>


<script>

    layui.use('table', function () {
        // debugger
        var table = layui.table;
   
        var tableReload = table.render({
            elem: "#UserList",
            url: "<?php echo U('User/getSendList');?>",
            page: true,
            cols: [[
                {field: 'maincoin_id', title: 'ID', align: 'center', width:120, sort: true, fixed: 'left'}
                ,{field: 'user_name', title: '用户名', align: 'center', width: 120, templet: '#showLogo'}
                ,{field: 'en_content2', title: '英文标题', align: 'center', width: 140}
                ,{field: 'tw_content2', title: '中文标题', align: 'center', width: 140}
                ,{field: 'en_content', title: '英文内容', align: 'center', width: 140}
                ,{field: 'tw_content', title: '中文内容', align: 'center', width: 140}
                ,{title: '操作', width: 140, align: 'center', toolbar: '#operation'}
                ,{field: 'create_time', title: '私信时间', align: 'center', width: 140}
                
            ]],
            done: function (res) {
                console.log(res)
            }

        });
        // 监听工具栏的事件
        table.on('tool(UserList)', function (obj) {
            var data = obj.data;    // 获取当前数据
            var layEvent = obj.event;   // 获得 lay-event 对应的值
            var tr = obj.tr;    // 获得当前 tr 的 dom 对象

        // 查看
            if(layEvent == "lookBtn") {
                layer.open({
                    title: "发送内容",
                    content:"<div>发送内容繁体：</div>" + data.tw_content + "<div><br></div>" + "<div>发送内容英文：</div>" + data.en_content,
                    btn: ["关闭"],
                    yes: function (res){
                        layer.closeAll();
                    }
                });
            }

            if (layEvent == 'del') {
                layer.open({
                    title: '提示',
                    content: '确认删除？',
                    btn: '删除',
                    yes: function(res) {
                        layer.closeAll();

                        var u = '<?php echo U(deleted);?>';
                        var d = {
                            'information_id': data.information_id
                        };

                        layer.load();
                        $.post(u, d, function(res) {
                            layer.closeAll();
                            if (res.code == 0) {
                                layer.msg('删除成功', function() {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg('删除失败');
                            }
                        });
                    }
                });
            }
        });

        // 搜索
        function searchUser() {

            var url = "<?php echo U(userSendSearch);?>";
            var data = {
                user_name: $('#user_name').val()
            };

            layer.load(1);
            tableReload.reload({
                url: url,
                where: data,
                page: {
                    curr: 1
                },
                done: function (){
                    layer.closeAll();
                }
            });
        }

        // 搜索按钮
        $("#searchBtn").click(function () {
            searchUser();
        });

        // 当按下回车
        $(document).keypress(function (ev) {
            if( ev.keyCode == 13 ) {
                searchUser();
            }
        });

        var url = 'http://localhost:8081/Admin/User/userAdd.html';

            $("#addBtn").click(function(){
                layer.open({
                    type: 2,
                    title: "公告添加：",
                    content: url,
                    area: ['90%', '90%']
                });
            });

    });

</script>


<script type="text/html" id="operation" >
    <a class="layui-btn layui-btn-mini" lay-event="lookBtn">查看</a> 
    <a class="layui-btn layui-btn-mini layui-btn-danger" lay-event="del">删除</a> 

</script>

<script type="text/html" id="statusInfo">
    {{# if(d.status == 0) { }}
        <a style="color: green;">{{ d.status_name }}</a>
    {{# } else { }}
        <a style="color: red;">{{ d.status_name }}</a>
    {{# } }}
</script>