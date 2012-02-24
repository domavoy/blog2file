<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
commonHeader("Drop $DB?");

echo "<h1><center><font face='Arial' color='red'>WARNING:<br>";
echo "you are about to drop the </font>";
echo "<font face='Arial'>$DB</font>";
echo "<font face='Arial' color='red'> database!<br>";
echo "Are you sure?<br><br></font></center></h1>";
echo "<a href='./drop_response.php?DB=$DB'>DO IT!</a><br>";
echo "<a href='./'>Just kidding</a><br>";

commonFooter();
?>
