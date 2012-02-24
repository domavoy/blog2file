<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Drop $Field from the $TA table?");

echo "<h1><center><font face='Arial' color='red'>WARNING:<br>";
echo "You are about to drop the </font>";
echo "<font face='Arial'>$Field</font>";
echo "<font face='Arial' color='red'> field from the<br></font>";
echo "<font face='Arial'>$TA</font>";
echo "<font face='Arial' color='red'> table!<br>";
echo "Are you sure?</font><br><br></center></h1>";
echo "<a href='./alter_table_remove_response.php?DB=$DB&TA=$TA&Field=$Field'>DO IT!</a><br>";
echo "<a href='./'>Just kidding</a><br>";

commonFooter();
?>
