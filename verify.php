<?php
$access_token = 'EAAIHkTfskeYBANUpwd6tZCOay6tbAMZClyx7qxMCD18ecpNpK3y544l9Utk0MqZASbjZCkmCzyE8AZAQxDnrMrQbwbNJ0KxxEwZBPwds27BwwoIdbOwD8ZCRrP2SANkZAESJ8RRblOAuceY8LVQXA6ncDDiOOIhj9FJu5MtOzV8NgMSNO14zRwz2';
$url = 'https://api.line.me/v1/oauth/verify';
$headers = array('Authorization: Bearer ' . $access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
