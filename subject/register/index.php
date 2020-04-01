<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../common.php';
include '../../connect/connect.php';
$op = new Db;

//POST REQUEST
if(isset($_POST) && !empty($_POST) && is_array($_POST))
{
	$dat = json_decode(file_get_contents("php://input"));
	$arr = array();
	foreach($_POST as $key => $value)
	{
		$arr[$key] = htmlspecialchars(strip_tags($value));
	}

	$insertID = $op->insert(TABLE_NAME, $arr);
	if($insertID > 0)
	{
		// set response code - 200 OK
    	http_response_code(200);
		echo json_encode(array("data" => $insertID));
	}else
	{
		// set response code - 404 Not found
	    http_response_code(404);
	    echo json_encode(array("message" => "No insert"));
	}
}

?>