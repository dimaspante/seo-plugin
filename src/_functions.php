<?php

function textSize($text, $coding='') {
	if (extension_loaded('mbstring')) {
		$lenght = ($coding == '') ? mb_strlen($text) : mb_strlen($text, $coding);
	} else {
		$lenght = strlen($text);
	}
	
	return $lenght;
}

function wordCount($text, $coding='') {
	if (strlen(trim($text)) == 0) return 0;

	$count = 1 + textSize(preg_replace('`[^ ]`', '', $text), $coding);
	return $count;
}

function clearText($text) {
	if (is_bool($text)) return;
	
	$key = sha1($text);
	
	if (isset($clean[$key])) return $clean[$key];
	
	$text = utf8_decode($text);
	$text = str_replace(array("\xe2\x80\x98","\xe2\x80\x99","\xe2\x80\x9c","\xe2\x80\x9d","\xe2\x80\x93","\xe2\x80\x94","\xe2\x80\xa6"), array("'","'",'"','"','-','--','...'),$text);
	$text = str_replace(array(chr(145),chr(146),chr(147),chr(148),chr(150),chr(151),chr(133)),array("'","'",'"','"','-','--','...'),$text);
	$text = preg_replace('`([^0-9][0-9]+)\.([0-9]+[^0-9])`mis', '${1}0$2', $text);
	$text = preg_replace('`<script(.*?)>(.*?)</script>`is', '', $text);
	$text = preg_replace('`\</?(address|blockquote|center|dir|div|dl|dd|dt|fieldset|form|h1|h2|h3|h4|h5|h6|menu|noscript|ol|p|pre|table|ul|li)[^>]*>`is', '.', $text);
	$text = html_entity_decode($text);
	$text = strip_tags($text);
	$text = preg_replace('`(\r\n|\n\r)`is', "\n", $text);
	$text = preg_replace('`(\r|\n){2,}`is', ".\n\n", $text);
	$text = preg_replace('`[ ]*(\n|\r\n|\r)[ ]*`', ' ', $text);
	$text = preg_replace('`[",:;()/\`-]`', ' ', $text);
	$text = trim($text, '. ') . '.';
	$text = preg_replace('`[\.!?]`', '.', $text);
	$text = preg_replace('`([\.\s]*\.[\.\s]*)`mis', '. ', $text);
	$text = preg_replace('`[ ]+`', ' ', $text);
	$text = preg_replace('`([\.])[\. ]+`', '$1', $text);
	$text = trim(preg_replace('`[ ]*([\.])`', '$1 ', $text));
	$text = trim($text);

	$clean[$key] = $text;

	return $text;
}
