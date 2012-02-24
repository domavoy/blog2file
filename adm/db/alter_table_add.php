<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Add a field to the $TA table");

echo "<h3>";
blueFont ("Your are about to add a field to the ");
redFont  ("$TA");
bluefont (" table...");
echo "</h3>";

echo "<FORM ACTION='./alter_table_add_responce.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

echo "<P><CENTER><TABLE BORDER='0' CELLSPACING='10' CELLPADDING='10'>";
echo "<TR><TD>";
blueFont("Name the new field:");
echo "<br>";
echo "<INPUT TYPE='TEXT' NAME='Field' SIZE='30'><BR>";
echo "</td>";
echo "<td>";
blueFont ("New field parameters:");
echo "<br>";
echo "<INPUT TYPE='TEXT' NAME='Values' SIZE='50'>";
echo "</td></tr></table><br><br>";
echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'><br><br>";
blueFont ("An example:");
echo "</center><br>";
echo "<pre>";
echo "Stuff VARCHAR(10) NOT NULL<br>";
echo "</pre><br><br>";


commonFooter();
?>
