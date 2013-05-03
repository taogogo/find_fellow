<?php
require ('./inc/gPoint.php');
include('./inc/func.php');

	$myHome = new gPoint();	// Create an empty point
	$myHome->setLongLat(-121.85831, 37.43104);	// I live in sunny California :-)
	echo "I live at: "; $myHome->printLatLong(); echo "<br>";
echo "distance:" . $myHome->distanceFrom(-121.85831, 37.43104);

$i = array('getete'=>'ddd"<>d','gaga' => array( 'dongdong"' ) );
print_r( iaddslashes(  $i ) );
print_r( $i );
echo get_browser();
?>

<?php
$agent = $_SERVER["HTTP_USER_AGENT"];
if(strpos($agent,"MSIE 8.0"))
echo "Internet Explorer 8.0";
else if(strpos($agent,"MSIE 7.0"))
echo "Internet Explorer 7.0";
else if(strpos($agent,"MSIE 6.0"))
echo "Internet Explorer 6.0";
else if(strpos($agent,"Firefox/3"))
echo "Firefox 3";
else if(strpos($agent,"Firefox/2"))
echo "Firefox 2";
else if(strpos($agent,"Chrome"))
echo "Google Chrome";
else if(strpos($agent,"Safari"))
echo "Safari";
else if(strpos($agent,"Opera"))
echo "Opera";
else echo $agent;
?>