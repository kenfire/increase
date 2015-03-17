<!DOCTYPE html>
<html>
	<head>
		<title>Increase</title>
		<?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
		<?php echo $this->tag->stylesheetLink('css/styles.css'); ?>
		<?php echo $this->tag->javascriptInclude('js/jquery.min.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
	</head>
	<body>
	<div class="bs-docs-header">
		<div class="container">
			<div class="header">
				<h1>Increase</h1>
				<p>Manage the progress of your projects, improve communication with customers.</p>
			</div>
		</div>
	</div>
	<div class="second-header"></div>
	<div class="container">
		<ol class="breadcrumb">
				<li><a href="index"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home</a></li>
			</ol>
	</div>
	<div class="container">
		<?php echo $this->getContent(); ?>
	</div>
</body>
</html>