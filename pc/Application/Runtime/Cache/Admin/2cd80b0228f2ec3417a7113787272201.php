<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" href="http://localhost:8081/Public/plug-in/layui-v2.3.0/layui/css/layui.css" />
<script type="text/javascript" src="http://localhost:8081/Public/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="http://localhost:8081/Public/plug-in/layui-v2.3.0/layui/layui.js"></script>
<style>
	.x-body {padding: 20px;}
	.layui-form-mid {padding: 0 !important;}
	.start {background-color:#1aa414;}
	.stop {background-color:#ff2e2e;}
</style>

<body>
    <div class="x-body layui-form">
        <blockquote class="layui-elem-quote">开盘设置(涨: <span id="rise"></span>, 跌: <span id="fall"></span>)</blockquote>
        <nav class="navbar navbar-default">
        	<button class="layui-btn" id="switch-btn" onclick="switchState()">获取中...</button>
    		<button class="layui-btn layui-btn-normal" onclick="restore()">还原</button>
        </nav>
        <table id="opentable" lay-filter="opentable"></table>
    </div>
</body>

<script>
	layui.use(['form', 'table'], function() {
		var form = layui.form;
		var table = layui.table;

		// 监听select
		form.on('select(open)', function(data) {
			console.log(data)
		})

		// 监听switch
		form.on('switch(switch-set)', function(data) {
			var u = '<?php echo U("control");?>';
			var d = { number: this.value };
			d.set = data.elem.checked ? 0 : 1;

			layer.load(2);
			$.post(u, d, function(res) {
				layer.closeAll();
				var icon = res.code == 0 ? 6 : 5;
				layer.msg(res.msg, {icon: icon, time: 1200})
				init();
			})
		})

		// 表格数据
		table.render({
			elem: '#opentable',
			url: '<?php echo U("set");?>',
			page: true,
			limit: 12,
			cols: [[
				{field: 'number', title: '期数', width: 80, align: 'center'},
				{field: 'time', title: '开盘时间', width: 140, align: 'center'},
				{field: 'set', title: '开盘设置', width: 120, align: 'center', templet: '#switch-set'}
			]]
		});
	})

	// 点击切换盘市状态
	var switchState = function() {
		var u = '<?php echo U("closeset");?>';
		var d = {};
		d.set = $('#switch-btn').hasClass('stop') ? 1 : 0;
		layer.load(2)
		$.post(u, d, function(res) {console.log(res)
			layer.closeAll();
			var icon = res.code == 0 ? 6 : 5;
			layer.msg(res.msg, {icon: icon, time: 1200});
			if (icon == 5) return false;

			$('#switch-btn').hasClass('stop')
				? $('#switch-btn').removeClass('stop').addClass('start').text('点击开盘')
				: $('#switch-btn').removeClass('start').addClass('stop').text('点击休市');
		})
	}

	// 开盘数据还原
	var restore = function() {
		var u = '<?php echo U("restore");?>';
		layer.confirm('还原会将所有开盘数据重置为涨，您确认这么做？', {title: '警告', icon: 7}, function() {
			layer.closeAll();
			layer.load(2);
			$.get(u, function(res) {
				layer.closeAll();
				if (res == 288) {
					layer.msg('全部还原成功', {icon: 6, time: 1200});
					location.reload();
					return false;
				}
				layer.msg('还原失败', {icon: 5, time: 1500})
			})
		});
	}

	// 统计数据
	var init = function() {
		var u = '<?php echo U("init");?>';
		$.get(u, function(res) {
			$('#rise').text(res.rise);
			$('#fall').text(res.fall);
			res.state == 1
				? $('#switch-btn').removeClass('stop').addClass('start').text('点击开盘')
				: $('#switch-btn').removeClass('start').addClass('stop').text('点击休市');
		})
	}

	// init
	init();
</script>

<script type="text/html" id="switch-set">
	<input lay-filter="switch-set" type="checkbox" lay-skin="switch" lay-text="涨|跌" value="{{d.number}}" {{d.set == 0 ? 'checked' : ''}}>
</script>