<?php

function getEmailHeader($from, $type = 'plain', $charset = 'utf-8'){
	$from = (!isset($from)) ? getNoReplayServerEmailAddress() : $from;
	$uniqid   = md5(uniqid(time()));
	$headers  = 'From: '.$from."\n";
	$headers .= 'Reply-to: '.$from."\n";
	$headers .= 'Return-Path: '.$from."\n";
	$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\n";
	$headers .= 'MIME-Version: 1.0'."\n";
	$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\n";
	$headers .= 'X-Priority: 3'."\n";
	$headers .= 'X-MSMail-Priority: Normal'."\n";
	$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'."\n";
	$headers .= '------------'.$uniqid."\n";
	$headers .= 'Content-type: text/'.$type.';charset='.$charset.''."\n";
	$headers .= 'Content-transfer-encoding: 7bit';
	return $headers;
}

function getNoReplayServerEmailAddress(){
	return 'no-reply@'.str_replace('www.', '', $_SERVER['SERVER_NAME']);
}