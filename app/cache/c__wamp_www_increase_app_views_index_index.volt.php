<?php echo $this->getContent(); ?>

<h1>Congratulations!</h1>

<p>You're now flying with Phalcon. Great things are about to happen!</p>
<a class="btn btn-default">Default</a>&nbsp;
<a class="btn btn-primary">Primary</a>&nbsp;
<a class="btn btn-success">Success</a>&nbsp;
<a class="btn btn-info">Info</a>&nbsp;
<a class="btn btn-warning">Warning</a>&nbsp;
<a class="btn btn-danger">Danger</a>
<br/>
<br/>
Link to user 1 projects: <?php echo $this->tag->linkTo(array('user/projects/1', 'User1')); ?><br/>
Link to author 1 projects: <?php echo $this->tag->linkTo(array('author/projects/1', 'Author1')); ?>