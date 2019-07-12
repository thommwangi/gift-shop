<?php
		header("Content-Type: application/json");
		$response ='{
			"ResultCode":0,
			"ResultDesc":"Confirmation Recieved Successfully"
		}';
		//Data
		$mpesaResponse = file_get_contents('php://input');
		//log the response
		$logfile="M_PESAResponse.txt";
		$jsonMpesaResponse = json_decode($mpesaResponse,true);
		//write to file
		$log =fopen($logfile, 'a');
		fwrite($log, $mpesaResponse);
		fclose($log);

		echo $response;

?>