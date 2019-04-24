<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/plug-in/layui-v2.3.0/layui/css/layui.css" />
<script type="text/javascript" src="http://localhost:8081/Public/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="http://localhost:8081/Public/plug-in/layui-v2.3.0/layui/layui.js"></script>
<style>
	.x-body {padding: 20px;}
	.layui-form-mid {padding: 0 !important;}
	.start {background-color:#1aa414;}
	.stop {background-color:#ff2e2e;}
	.layui-table-view .layui-form-checkbox, .layui-table-view .layui-form-radio, .layui-table-view .layui-form-switch {height: 18px;}
	.layui-form-switch i {height:12px;}
	.layui-form-switch em {top:-1; margin-left:20px;}
	.right {float:right;}
	.layui-form-select {float:right;}
	.refresh {margin-right:5px;}
	.total {width:100%;}
	.total>div {text-align:center; margin:5px 0 15px 0; border:1px solid #d5d5d5; padding:12px 0; border-right:0; height:80px;}
	.total>div:nth-last-child(1) {border-right:1px solid #d5d5d5;}
	.total>div>div:nth-child(1) {margin-bottom: 5px; font-size: 24px; color: #4aa9db;}
</style>

<body>
    <div class="x-body layui-form">
        <blockquote class="layui-elem-quote">下注记录</blockquote>

        <div class="navbar layui-row total">
  			<div class="layui-col-md4">
    			<div><?php echo ($data["balance"]); ?></div>
    			<div>客户余额</div>
  			</div>
  			<div class="layui-col-md4">
    			<div><?php echo ($data["profit"]); ?></div>
    			<div>平台盈利</div>
  			</div>
  			<div class="layui-col-md4">
    			<div><?php echo ($data["bets"]); ?>人</div>
    			<div>下注人数</div>
  			</div>
		</div>

        <nav class="navbar navbar-default">
        	<div class="layui-input-inline">
        		<input type="text" name="user_name" placeholder="请输入用户名称" autocomplete="off" class="layui-input">
        	</div>
    		<button class="layui-btn layui-btn-normal" id="search">搜索</button>
    		<button class="layui-btn" onclick="manualLottery()">手动开奖</button>

    		<div class="right">
    			<select name="last_direction" class="layui-input-inline" lay-filter="direction">
  					<option value="">开奖状态</option>
  					<option value="1">已开奖</option>
  					<option value="2">已中奖</option>
  					<option value="3">未中奖</option>
				  	<option value="-1">未开奖</option>
				</select> 
    			<button class="layui-btn layui-btn-normal refresh" onclick="refresh()">刷新</button>
    		</div>
        </nav>

        <table id="opentable" lay-filter="opentable"></table>
    </div>
</body>

<script>
	layui.use(['form', 'table'], function() {
		var form = layui.form;
		var table = layui.table;

		// 分类搜索
		form.on('select(direction)', function(data) {
			var data = {
				type: 1,
				last_direction: data.value
			}	

			search(data)		
		})

		// 表格数据
		var tableIns = table.render({
			elem: '#opentable',
			url: '<?php echo U("betslog");?>',
			page: true,
			size: 'sm',
			limit: 30,
			totalRow: true,
			limits: [30,60,90,120],
			cols: [[
				{field: 'order_id', title: '订单号', width: 120, align: 'center'},
				{field: 'user_name', title: '用户', width: 100, align: 'center'},
				{field: 'money', title: '下注金额', width: 100, align: 'center', totalRow: true},
				{field: 'buy_number', title: '期数', width: 60, align: 'center'},
				{field: 'buy_direction_name', title: '购买方向', width: 80, align: 'center'},
				{field: 'last_direction_name', title: '最终方向', width: 80, align: 'center'},
				{field: 'last_money', title: '中奖金额', width: 100, align: 'center', totalRow: true},
				{field: 'execute_price', title: '执行值', width: 100, align: 'center'},
				{field: 'last_price', title: '最终值', width: 100, align: 'center'},
				{field: 'buy_time', title: '购买时间', width: 150, align: 'center'},
				{field: 'last_time', title: '开奖时间', width: 140, align: 'center'},
				{templet: '#operation', title: '操作', width: 70, align: 'center', fixed: 'right'},
			]]
		});

		// 搜索按钮
		$('#search').click(function() {
			var data = {
				type: 0,
				user_name: $('[name=user_name]').val()
			};

			search(data)
		})

		var search = function(data) {
			tableIns.reload({
				url: '<?php echo U("betslogsearch");?>',
				where: data
			})
		}

		table.on('tool(opentable)', function(obj) {
			var data = obj.data

			if (obj.event == 'open') {
				layer.confirm('确认开奖？', {offset: '100px'}, function() {
					layer.closeAll()
					var u = '<?php echo U("manualLottery");?>'
					var d = {'order_id': data.order_id}

					layer.load(2, {offset: '100px'})
					$.post(u, d, function(res) {
						layer.closeAll()
						if (res.code == 0) {
							layer.msg(res.msg + "，请手动刷新查看数据", {icon: 6, time: 1500, offset: '100px'})
							return ;
						}

						layer.msg(res.msg, {icon: 5, offset: '100px'})
					})
				})
			}
		})
	})

	var refresh = function() {
		window.location.reload();
	}

	var manualLottery = function() {
		layer.open({
			type: 2,
			content: '<?php echo U("manual-lottery");?>',
			area: ['500px', '400px'],
			offset: '100px'
		})
	}
</script>

<script type="text/html" id="operation">
	<a class="layui-btn layui-btn-xs" lay-event="open">开奖</a>
</script>