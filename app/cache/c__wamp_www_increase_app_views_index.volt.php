<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->tag->getTitle(); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
		<?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
		<?php echo $this->tag->stylesheetLink('css/styles.css'); ?>
		<?php echo $this->tag->javascriptInclude('js/jquery.min.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
        <?php echo $jquery; ?>
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