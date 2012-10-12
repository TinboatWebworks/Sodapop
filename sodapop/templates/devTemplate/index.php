<html>
<head>

<link rel="stylesheet" type="text/css" media="screen" href="<? echo $template['path'] ?>/css/style.css">

</head>
<body>


<?php
echo "
	<div class='tempName'>
		" . $language['tempName'] . ":" . $template['name'] . "
		<br />" .
		$language['labelVersion'] . $config['appVersion'] . "
		
	</div><br />";
?>

<div class="menu">
	<a href="show?show=drwho"><? echo $language['show'];?> </a> | <a href="profile?user=1"><? echo $language['profile'];?></a> | <a href="episode?episode=1"><? echo $language['episode'];?></a>
</div>

<?php $application->modPosition("test") ?>

<div class="mainContent">
<? $application->loadPage();?>
</div>


<div class="footer">


</div>

</body>
</html>