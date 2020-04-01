<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PATCH, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include '../common.php';
include '../../connect/connect.php';
$op = new Db;
//GET REQUEST
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$param = json_decode(file_get_contents("php://input"));
	$param['active'] = 0;
	$data = $op->select(TABLE_NAME, NULL, $param);
	if(is_array($data) && count($data) > 0)
	{
		// set response code - 200 OK
    	http_response_code(200);
		echo json_encode(array("data" => $data));	
	}
	else
	{
	    // set response code - 404 Not found
	    http_response_code(404);
	    echo json_encode(array("message" => "No Data."));
	}	
}


?>