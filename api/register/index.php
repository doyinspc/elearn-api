<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../../connect/common.php';
include '../../connect/connect.php';
$op = new Db;

$da = json_decode(file_get_contents("php://input"));
//POST REQUEST
if(isset($da) && !empty($da))
{
	
	$queries = $da->params;
	$dat = $queries->data;
	$cat = $queries->cat;
	$table = $queries->table;
	$data = array();
	
	$check_row = $op->selectOne($table, NULL, array('uniqueid'=>htmlspecialchars(strip_tags($dat->uniqueid)), 'passw'=>md5($dat->passw)));

	if($check_row && $check_row->id > 0)
	{
		//ROW EXIST
		//CREATE TOKEN
		$res = $check_row;
		$res->PATH_MAIN = PATH_MAIN;
		$res->PATH_IMAGE = PATH_IMAGE;
		http_response_code(200);
		echo json_encode($res);
	}
	else
	{
		//ROW DOES MOT EXIST
		//INSERT
		$arr = array();
		foreach($dat as $key => $value)
		{
			$arr[$key] = htmlspecialchars(strip_tags($value));
		}
		$arr['passw'] = md5($arr['passw']); 

		$insertID = $op->insert($table, $arr);
		if($insertID > 0)
		{
			// set response code - 200 OK
			$res = $op->selectOne($table, NULL, array('id'=>$insertID));
			$res->PATH_MAIN = PATH_MAIN;
			$res->PATH_IMAGE = PATH_IMAGE;
	    	http_response_code(200);
			echo json_encode($res);
		}else
		{
			// set response code - 404 Not found
		    http_response_code(404);
		    echo json_encode(array("message" => "No insert"));
		}
	}

}else
{
	// set response code - 404 Not found
	http_response_code(404);
	echo json_encode(array("message" => "No insert"));
}

?>