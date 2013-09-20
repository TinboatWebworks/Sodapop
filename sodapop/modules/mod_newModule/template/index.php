<?php	?>


<style>
div.moduleBox {
	
	outline: 1px solid blue;
	background-color: #cccccc;
	width: 300px;
	margin-left: 20px;
	padding: 5px;
	
}
</style>

<div class='moduleBox'>
	This is a module called: <?php echo $modData['name']; ?><br />
	This is the data in it:<br />
	<?php print_r ($modData); ?>
</div>

