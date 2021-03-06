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
    .layui-select {width : 180px;}
</style>
<body>
    <div class="x-body">
        <blockquote class="layui-elem-quote">订单列表</blockquote>
        <nav class="navbar navbar-default">
            <select class="layui-select" name="orderType">
              <option value="">请选择订单类型</option>
              <option value="0">买入订单</option>
              <option value="1">卖出订单</option>
            </select>
            <button typr="button" class="btn btn-default" id="searchBtn">搜索</button>
        </nav>
        <table id="OrderListAll" lay-filter="OrderListAll">
        </table>
    </div>
</body>
<script>

    layui.use(['table'], function () {
        var data;
        var table = layui.table;
        var tableReload = table.render({
            elem: "#OrderListAll",
            url: "<?php echo U(getOrderListAll);?>",
            page: true,
            id: 'orderListTable',
            cols: [[
                 {field: 'system_order', title: '订单号', align: 'center', width:140, sort: true, fixed: 'left'}
                ,{field: 'order_type_name', title: '订单类型', align: 'center', width: 120, sort: true}
                ,{field: 'status_name', title: '订单状态', align: 'center', width: 120, sort: true,
                  templet: '#statusInfo'}
                ,{field: 'user_name', title: '用户名', align: 'center', width: 100, sort: true}
                ,{field: 'currency_type_name', title: '交易币种', align: 'center', width: 100, sort: true}
                ,{field: 'number', title: '数量', align: 'center', width: 100, sort: true}
                ,{field: 'price', title: '总价', align: 'center', width: 100}
                ,{field: 'remark', title: '审核意见', align: 'center', width: 127, sort: true}
                ,{field: 'create_time', title: '创建时间', align: 'center', width: 100, sort: true}
                ,{title: '操作', width: 100, align: 'center', toolbar: '#operation', fixed: 'right'}
            ]],
            done: function(res) {
                data = res;
            }
        });

        // 监听工具栏的事件
        table.on('tool(OrderListAll)', function (obj) {
            var data = obj.data;    // 获取当前数据
            var layEvent = obj.event;   // 获得 lay-event 对应的值
            var tr = obj.tr;    // 获得当前 tr 的 dom 对象

            // 查看
            if(layEvent == "lookBtn") {
                var unit = "";
                if (data.money_currency_type == 1) {
                    unit = "TWD"
                }else if (data.money_currency_type == 2) {
                    unit = "HKD"
                }else if (data.money_currency_type == 3){
                    unit = "USD"
                }

                var payment = parseInt(data.payment_type) == 1 ? '银行转账' : '余额支付'
                layer.open({
                    title: "订单详细",
                    content: "交易币种：" + data.currency_type_name + "</br>"
                    + "数量：" + data.number + "</br>"
                    + "单价：" + data.unit_price + "</br>"
                    + "订单价值：" + data.price + unit + "</br>"
                    + "支付类型" + payment,
                    btn: ["关闭"],
                    yes: function (res){
                        layer.closeAll();
                    }
                });
            }

        });

        $('#searchBtn').click(function(){
            search();
        });

        // 搜索
        function search() {

            var url = "<?php echo U(getOrderListAll);?>";
            var data = {
                order_type: $('[name=orderType]').val(),
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

    });
</script>


<script type="text/html" id="operation" >
    <a class="layui-btn layui-btn-mini" lay-event="lookBtn">查看</a>
</script>

<script type="text/html" id="statusInfo">
    {{# if(d.status == 0) { }}
        <a style="color: green;">{{ d.status_name }}</a>
    {{# } else if(d.status == 1) { }}
        <a style="color: red;">{{ d.status_name }}</a>
    {{# } else if(d.status == 2) { }}
        <a style="color: #983905;">{{ d.status_name }}</a>
    {{# } else { }}
        <a style="color: gray;">{{ d.status_name }}</a>
    {{# } }}
</script>