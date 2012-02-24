<?
//-----------------------------------------------
$DBHost="localhost";
$DBUser="root";
$DBPass="";
//-----------------------------------------------
function Connect ()
{
	global $DBHost,$DBUser,$DBPass;
}
//-----------------------------------------------
function commonHeader ($title)
{
	echo "<HTML><BODY BGCOLOR='#FFFFFF'>";
	echo "<TITLE>FaceMySQL - $title</TITLE><br><br>";
}
//-----------------------------------------------
function commonFooter ()
{
	echo "<center><font face='Arial'><br><hr width='70%'><br>";
	echo "| <a href='./'>Домой</a>";
	echo "<br><br></font></center></body></html>";
}
//-----------------------------------------------
function blueFont ($text)
{
	echo "<font face='Arial' color='blue'>$text</font>";
}
//-----------------------------------------------
function redFont ($text)
{
	echo "<font face='Arial' color='red'>$text</font>";
}
//-----------------------------------------------
?>
