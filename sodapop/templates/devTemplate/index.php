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
	<a href="show.php?show=drwho"><? echo $language['show'];?> </a> | <a href="profile.php?user=1"><? echo $language['profile'];?></a> | <a href="episode.php?episode=1"><? echo $language['episode'];?></a>
</div>

<a href="info.php">info</a>

<div class="mainContent">
<? $application->loadPage();?>
</div>


<div class="footer">


</div>

</body>
</html>