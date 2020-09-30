<?php

require('farmFactory.php');
session_start();
if(isset($_REQUEST['turn']))
$turn = $_REQUEST['turn'];

abstractFarmGameFactory::startFarmGame($turn)->goForAction();

$data = $_SESSION['farm_game'];

echo json_encode($data);
/*echo $data['recent_entity'].' is Fed!!'.$data['all_entity'][$data['recent_entity']]."<pre>";
print_r($data);*/
?>