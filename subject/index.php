<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PATCH, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include 'common.php';
include '../connect/connect.php';
$op = new Db;
//GET REQUEST

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$queries = array();
	parse_str($_SERVER['QUERY_STRING'], $queries);
	$query = $queries['data'];
	$cat = $queries['cat'];
	$table = $queries['table'];
	$token = $queries['token'];
	$data = array();

	if($cat == 'all')
	{
		$data = $op->select(TABLE_NAME, NULL, $query);
	}

	if($cat == 'cat')
	{
		$data = $op->select(TABLE_NAME, NULL, $query);
	}

	if($cat == 'one')
	{
		$data = $op->selectOne(TABLE_NAME, NULL, $query);
	}
	
	if(is_array($data) && count($data) > 0 )
	{
		// set response code - 200 OK
    	http_response_code(200);
		echo json_encode($data);
	}
	else
	{
	    // set response code - 404 Not found
	    http_response_code(404);
	    echo json_encode(array("message" => "No found."));
	}	
}



?>