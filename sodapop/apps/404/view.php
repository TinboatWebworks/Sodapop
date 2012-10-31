<?php

class viewApp extends view {

	public function viewApp($data) {

		echo $language['whatPage'] . $data['pageName'];
	}
	
}
?>

