<html>
<head>

<link rel="stylesheet" type="text/css" media="screen" href="<? echo $sodapop->template['path'] ?>/css/style.css">

</head>
<body>
<br />

<div class="mainBody">

<?php $sodapop->modPosition('login'); ?>
<div class="menuBar">
<img src="http://localhost/~brad/git/Sodapop/sodapop/templates/devTemplate/images/sodapopSplashLogoSmaller.png" /> Demonstration Site

<?php
$sodapop->modPosition('menu');
?>
</div>


<?php $sodapop->modPosition("test"); ?>

<div class="mainContent">
<? echo $sodapop->output; ?>
</div>



<div class="footer">
<?php
echo "
	<div class='tempName'>
		" . $sodapop->language['tempName'] . ":" . $sodapop->template['name'] . "
		<br />" .
		$sodapop->language['labelVersion'] . $sodapop->config['appVersion'] . "
		
	</div>";
	?>

</div>
</div>

<br /><br /><br />
</body>
</html>