<?php


require_once './config.php';

require_once './lib/DB/Database.php';
require_once './lib/DB/Equipment.php';
require_once './lib/DB/EquipmentDao.php';

require_once './lib/Util/DateUtil.php';
require_once './lib/Util/SimpleImage.php';
require_once './lib/Util/SessionUtil.php';

Database::Open();

SessionUtil::start();

if(isset($_GET['equipId'])){
	
	$equipment = EquipmentDao::getEquipmentByID($_GET['equipId']);
	
	if(!$equipment){
		$image = new SimpleImage();
		$image->load("./images/notfound.png");
		header('Content-Type: image/png');
		echo $image->output();
		Database::Close();
		exit();
	}else{
		if(file_exists("./images/".$equipment->picture)){
			$image_info = getimagesize("./images/".$equipment->picture);
			$image_type = $image_info[2];
			if( $image_type == IMAGETYPE_JPEG ) {
				header('Content-Type: image/jpeg');
			} elseif( $image_type == IMAGETYPE_GIF ) {
				header('Content-Type: image/gif');
			} elseif( $image_type == IMAGETYPE_PNG ) {
				header('Content-Type: image/png');
			}
			echo file_get_contents("./images/".$equipment->picture);
		}else{
			$image = new SimpleImage();
			$image->load("./images/notfound.png");
			header('Content-Type: image/png');
			echo $image->output();
			Database::Close();
			exit();
		}
	}
}

Database::Close();

?>