<html>
<head>

<link rel="stylesheet" type="text/css" media="screen" href="<? echo $sodapop->template['path'] ?>/css/style.css">

</head>
<body>


<?php
echo "
	<div class='tempName'>
		" . $sodapop->language['tempName'] . ":" . $sodapop->template['name'] . "
		<br />" .
		$sodapop->language['labelVersion'] . $sodapop->config['appVersion'] . "
		
	</div>";
	
$sodapop->modPosition('login');

$sodapop->modPosition('menu');
?>



<?php $sodapop->modPosition("test"); ?>

<div class="mainContent">
<? echo $sodapop->output; ?>
</div>



<div class="footer">


</div>

</body>
</html>