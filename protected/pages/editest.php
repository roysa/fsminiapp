<?php

$this->layout = 'clear';
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Getting Started with Aloha Editor</title>
	<link rel="stylesheet" href="index.css" type="text/css">
	<link rel="stylesheet" href="/assets/edf56ba545331cc39babb881c4228013/css/aloha.css" type="text/css">
	<script src="/assets/edf56ba545331cc39babb881c4228013/lib/require.js"></script>
	<!--<script src="/assets/edf56ba545331cc39babb881c4228013/lib/aloha-config.js"></script>-->
	<script src="/assets/edf56ba545331cc39babb881c4228013/lib/vendor/jquery-1.7.2.js"></script>
	<script src="/assets/edf56ba545331cc39babb881c4228013/lib/aloha.js" data-aloha-plugins="common/ui,common/format,common/highlighteditables,common/link"></script>
</head>
<body>
	<div id="main">
		<div id="content"><p>Getting started with Aloha Editor!</p></div>
	</div>
	<script type="text/javascript">
	Aloha.ready( function() {
		Aloha.jQuery('#content').aloha();
	});
	</script>
</body>
</html>
