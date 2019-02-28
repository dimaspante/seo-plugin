<?php
session_start();

if(!isset($_SESSION['i18n'])) $_SESSION['i18n'] = strip_tags(substr($lang,0,5));

if(file_exists(__DIR__.'/../src/lang/'.$_SESSION['i18n'].'.php')){
	include_once __DIR__.'/../src/lang/'.$_SESSION['i18n'].'.php';
}
