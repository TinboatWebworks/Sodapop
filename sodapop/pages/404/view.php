<?php

class viewPage extends view {

	public function viewPage($data) {

		echo $language['whatPage'] . $data['pageName'];
	}
	
}
?>

