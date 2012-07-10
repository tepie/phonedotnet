<?php

/** 
 * Grabs blog pages from Weebly or gives 404 message
**/
$ch = curl_init();
$nTimeout = 20;
$sUrl = "http://www.dragndropbuilder.com/weebly/apps/404/404.php";
$aryPost = array();
$aryPost['REQUEST_URI'] = $_ENV[ 'HTTP_X_REWRITE_URL' ] ? $_ENV[ 'HTTP_X_REWRITE_URL' ] : 
  ($_SERVER[ 'HTTP_X_REWRITE_URL' ] ? $_SERVER[ 'HTTP_X_REWRITE_URL' ] : $_SERVER['REQUEST_URI']);
if ($_COOKIE['is_mobile'] && !$_COOKIE['disable_mobile']) {
	$aryPost['REQUEST_URI'] = "/mobile" . $aryPost['REQUEST_URI'];
}
$aryPost['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
$aryPost['user_id'] = file_get_contents( 'userid.txt' );
curl_setopt( $ch, CURLOPT_URL, $sUrl );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $aryPost );
curl_setopt( $ch, CURLOPT_USERAGENT, 'WEEBLY/1.0' );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $nTimeout );
$sContents = curl_exec($ch);
curl_close($ch);

if( strpos( $sContents, "Error 404" ) === false )
{
    header("Status: 200 OK", true, 200);
}

print $sContents;
?>
