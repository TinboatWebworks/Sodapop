<?php	?>


<style>
div.testModuleBox {
	
	outline: 1px solid blue;
	background-color: yellow;
	width: 300px;
	margin-left: 20px;
	padding: 5px;
	
}
</style>

<div class='testModuleBox'>
	This is happy a module called: <?php echo $modData['name']; ?><br />
	This is the data in it:<br />
	<?php print_r ($modData); ?>
</div>

