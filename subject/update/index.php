<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../common.php';
include '../../connect/connect.php';
$op = new Db;

$dat = json_decode(file_get_contents("php://input"));
$id = $dat['id'];
$POST = $dat['data'];

//POST REQUEST
if(isset($POST) && !empty($POST) && is_array($POST))
{
	$arr = array();
	foreach($POST as $key => $value)
	{
		$arr[$key] = htmlspecialchars(strip_tags($value));
	}

	$insertID = $op->update(TABLE_NAME, $arr, array('id'=>$id));
	$row = $op->selectOne(TABLE_NAME, NULL, array('id' =>$id))
	if($insertID == 1)
	{
		// set response code - 200 OK
    	http_response_code(200);
		echo json_encode(array("data" => $row));
	}else
	{
		// set response code - 404 Not found
	    http_response_code(404);
	    echo json_encode(array("message" => "No insert"));
	}
}

?>