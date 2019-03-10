<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>幣淘微平臺</title>
	<!--强制让文档的宽度与设备的宽度保持1:1，并且文档最大的宽度比例是1.0，且不允许用户点击屏幕放大浏览；--> 
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<!--iphone设备中的safari私有meta标签，它表示：允许全屏模式浏览--> 
	<meta content="yes" name="apple-mobile-web-app-capable">
	<!--iphone的私有标签，它指定的iphone中safari顶端的状态条的样式--> 
	<meta content="black" name="apple-mobile-web-app-status-bar-style"> 

	<link rel="stylesheet" href="/Public/home/bocai/m.css" />
	<script src="http://192.168.0.137:8081/Public/js/config.js"></script>
	<script src="http://192.168.0.137:8081/Public/js/jquery-3.2.1.min.js"></script>
	<script src="http://192.168.0.137:8081/Public/js/jquery.cookie.js"></script>
	<script src="http://192.168.0.137:8081/Public/js/sonic.js"></script>
	<script src="http://192.168.0.137:8081/Public/plug-in/layer_mobile/layer.js"></script>
	<script src="/Public/home/bocai/echarts.min.js"></script>
	<script src="/Public/home/bocai/mkdata.js"></script>
	<script src="https://cdn.bootcss.com/pako/1.0.6/pako.min.js"></script>
</head>
<body>
	<header>
		<ul class="clearfix">
			<li onclick="w.jump('/')">首頁</li>
			<li onclick="w.jump('<?php echo U(trend);?>')">走勢</li>
			<li onclick="w.jump('<?php echo U(mlog);?>')">交易記錄</li>
		</ul>
	</header>

	<div class="price">
		<ul class="clearfix">
			<li>
				<span class="title">C</span>
				<span class="number">0.0000</span>
			</li>
			<li>
				<span class="title">O</span>
				<span class="number">0.0000</span>
			</li>
			<li>
				<span class="title">L</span>
				<span class="number">0.0000</span>
			</li>
			<li>
				<span class="title">H</span>
				<span class="number">0.0000</span>
			</li>
		</ul>
	</div>
	
	<div class="timek">
		<ul class="clearfix">
			<li><span class="active">1M</span></li>
			<li><span>5M</span></li>
			<li><span>30M</span></li>
			<li><span>1H</span></li>
			<li><span>1D</span></li>
		</ul>
	</div>

	<div class="container" id="k"></div>

	<div class="dets">
		<div class="execute">
			<div class="mt-10 issue">
				<div>期號</div>
				<div class="number">0</div>
			</div>
			<div class="mt-10 time">
				<div>倒計時</div>
				<div class="number">00:00</div>
			</div>
			<div class="mt-10 execute-price">
				<div>執行價</div>
				<div class="number">0.0000</div>
			</div>
			<div class="mt-10 last-price">
				<div>成交價</div>
				<div class="number">0.0000</div>
			</div>
		</div>
		<div class="deal">
			<div class="balance">账户餘額：<span>0.00</span></div>
			<div class="direction border">
				<div class="dealactive">漲</div>
				<div>跌</div>
			</div>
			<div class="input mt-10">
				<input type="number" name="money" placeholder="請輸入下注金額">
			</div>
			<div class="confirm mt-10" onclick="w.order()">下注</div>
		</div>
	</div>

	<script>
		w.run()
	</script>
</body>
</html>