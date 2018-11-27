<?php
$access_token = "EAAIHkTfskeYBACZChtGRV00yEzI7wFVbZCkgURUNGVemWAfcIixEQvEIJTfoM5w4Rroia0ETYXZAyKVGcdij7OZBCxJwXqgasmW5cZB5rdLmgwok1WNMJeTtWK9hzfaQvuAKRZBxuqDp2t7qoC8qREkkF3Ty9v0gnDwxBRkVDMZCJNdXhcZCbZB0u";
$verify_token = "kindly_bot";
$hub_verify_token = null;
if(isset($_REQUEST['hub_challenge'])) {
 $challenge = $_REQUEST['hub_challenge'];
 $hub_verify_token = $_REQUEST['hub_verify_token'];
}
if ($hub_verify_token === $verify_token) {
 echo $challenge;
}
$input = json_decode(file_get_contents('php://input'), true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$message_to_reply = '';
/**
 * Some Basic rules to validate incoming messages
 */

$api_key="8p2sCX3uUX68RTYXkc4udJKsG3CeIQhI";
$url = 'https://api.mlab.com/api/1/databases/fb_bot_db/collections/fb_bot?apiKey='.$api_key.'';
$json = file_get_contents('https://api.mlab.com/api/1/databases/fb_bot_db/collections/fb_bot?apiKey='.$api_key.'&q={"question":"'.$message.'"}');
$data = json_decode($json);
$isData=sizeof($data);
if (strpos($message, 'สอนบอท') !== false) {
  if (strpos($message, 'สอนบอท') !== false) {
    $x_tra = str_replace("สอนบอท","", $message);
    $pieces = explode("|", $x_tra);
    $_question=str_replace("[","",$pieces[0]);
    $_answer=str_replace("]","",$pieces[1]);
    //Post New Data
    $newData = json_encode(
      array(
        'question' => $_question,
        'answer'=> $_answer
      )
    );
    $opts = array(
      'http' => array(
          'method' => "POST",
          'header' => "Content-type: application/json",
          'content' => $newData
       )
    );
    $context = stream_context_create($opts);
    $returnValue = file_get_contents($url,false,$context);
    $message_to_reply = 'ขอบคุณที่สอนบอทครับ';
  }
}else{
  if($isData >0){
   foreach($data as $rec){
     $message_to_reply = $rec->answer;
   }
  }else{
    $message_to_reply = 'ก๊าบบ บอทน้อยงงอ่ะ ยังไงรอสักครู่ให้ทางแอดมินมาตอบนะครับ';
  }
}
//API Url
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
//Initiate cURL.
$ch = curl_init($url);
//The JSON data.

if (strpos($message, 'เว็บบริษัท') !== false) {
	$jsonData = '{
		 "recipient":{
			"id":"'.$sender.'"
		},
		"message":{
		"attachment":{
		  "type":"template",
		  "payload":{
			"template_type":"button",
			"text":"'.$message_to_reply.'",
			"buttons":[
			  {
				"type":"web_url",
				"url":"https://www.google.com",
				"title":"Google ครับ",
				"webview_height_ratio": "full"
			  }
			]
		  }
		}
	  }
	}';
}
else{
	$jsonData = '{
		"recipient":{
			"id":"'.$sender.'"
		},
		"message":{
			"text":"'.$message_to_reply.'"
		}
	}';
}


//Encode the array into JSON.
$jsonDataEncoded = $jsonData;
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//Execute the request
if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
}
?>
