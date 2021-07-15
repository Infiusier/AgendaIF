<?php
	
	# core files
	$core = ['Ini','Scan','Core','Atom','Module','TEngine','Session'];

	# import all of core
	foreach($core as $file){
		require_once "core/src/" . $file . ".php";
	}

	$app = new Atom();
	$global_files = Scan::dir($app->path() . "/global/src");
	if( !empty($global_files) ){
		foreach($global_files as $file){
			$phpExtension = strpos($file, ".php");
			if( $phpExtension ){
				require_once $file;
			}
		}
	}

	# adicionando autoload do vendor
	require $app->path() . "/vendor/autoload.php";
	
?>