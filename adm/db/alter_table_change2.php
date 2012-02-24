<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Alter the $TA table");

echo "<h3>";
blueFont ("Your are about to alter the ");
redFont  ("$TA");
bluefont (" table...");
echo "</h3>";

echo "<FORM ACTION='./alter_table_change_response.php?DB=$DB&TA=$TA&Field=$Field' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

echo "<P><CENTER><TABLE BORDER='0' CELLSPACING='10' CELLPADDING='10'>";
echo "<TR><TD>";
blueFont("Name the field:");
echo "<br>";
echo "<INPUT TYPE='TEXT' NAME='NewField' value='$Field' size='30'><BR>";
echo "</td>";
echo "<td>";
blueFont ("New parameters:");
echo "<BR>";
echo "<INPUT TYPE='TEXT' NAME='NewValue' size='50'>";
echo "</TD></TR></TABLE></center><br>";
echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'><br><br>";
blueFont ("<center>An example:</center>");
echo "<br>";
echo "<pre>";
echo "Stuff VARCHAR(10) NOT NULL<br>";
echo "</pre><br><br>";


commonFooter();
?>
