<?php

$email = isset($_POST['email']) ? $_POST['email'] : null;
$case = isset($_POST['case']) ? $_POST['case'] : null;
$comment = isset($_POST['comment']) ? $_POST['comment']: null;

if (!trim($email) || !preg_match('/@/', $email))
{
	// http_response_code(400);
	header('X-PHP-Response-Code: 400', true, 400);
	die(json_encode(array('error' => 'Please provide a valid email address.')));
}
else if (!trim($case) || ($case != 'Reconciliation' && $case != 'Audit' && $case != 'Land Registry' && $case != 'Loyalty Points'))
{
	// http_response_code(400);
	header('X-PHP-Response-Code: 400', true, 400);
	die(json_encode(array('error' => 'Please choose a case option.')));	
}

$ref = curl_init('https://permarec.wufoo.com/api/v3/forms/email-newsletter/entries.json'); 
curl_setopt($ref, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
curl_setopt($ref, CURLOPT_POST, true);
curl_setopt($ref, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ref, CURLOPT_POSTFIELDS, array('Field1' => $email, 'Field3' => $case, 'Field6' => $comment));     
curl_setopt($ref, CURLOPT_USERPWD, 'WAFM-5TE0-B0L7-12QU:X');
curl_setopt($ref, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ref, CURLOPT_SSL_VERIFYPEER, false);
//http://bugs.php.net/bug.php?id=47030
curl_setopt($ref, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ref, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ref);
$responseStatus = curl_getinfo($ref);
if ($responseStatus['http_code'] == 201)
{
	echo json_encode(array('error' => 'Sent'));

}
else
{

	// http_response_code(500);
	header('X-PHP-Response-Code: 500', true, 500);
	echo json_encode(array('error' => 'Internal server error' . var_dump($responseStatus)));
}

?>