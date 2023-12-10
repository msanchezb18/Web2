<?php
	header("Content-Type:application/json");
	header("Accept:application/json");

	$method = $_SERVER['REQUEST_METHOD'];
	$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

	include_once('codigos/conexion.inc');
	switch ($method){
		case 'PUT':
			if(sizeof($request)==2){
				if($request[1]=='task'){
					include_once("code/modtarea.inc");
				}
			}
			break;
	  	case 'POST':
			if(sizeof($request)==1){
				if($request[0]=='signup'){
					include_once("codigos/signup.inc");
				}
			}else if(sizeof($request)==2){
				if($request[1]=='task'){
					include_once("code/addtarea.inc");
				}
			}
			break;
	  	case 'GET':
			if(sizeof($request)==3){
				if($request[0]=='login'){
					include_once("code/login.inc");
				}
			}else if(sizeof($request)==2){
				if($request[1]=='me'){
					include_once("code/me.inc");
				}else if($request[1]=='task'){
					include_once("code/lsttarea.inc");
				}
			}else{
				deliver_response(204,"No Content","Your request is empty.");
			}
			break;
	   	case 'DELETE':
			if(sizeof($request)==2){
				if($request[1]=='task'){
					include_once("code/deltarea.inc");
				}
			}
			break;
	    default:
			deliver_response(405,"Method not allowed","");
			break;
	}// switch end

	/*----------------------------------------------------------------------*/
	/*Declarate http response functions or methods
	/*----------------------------------------------------------------------*/
	function deliver_response($status, $status_message,$data){
		header("HTTP/1.1 $status $status_message");

		$response["status"]=$status;
		$response["status_message"]=$status_message;
		$response["data"]=$data;
		$response["author"]="Kelunie";

		$json_response=json_encode($response);
		echo $json_response;
	}
?>









