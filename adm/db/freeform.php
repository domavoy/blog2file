<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Alter a table");

echo "<h3>";
blueFont ("Your are about to alter the ");
redFont  ("$TA");
bluefont (" table...");
echo "</h3>";

echo "<FORM ACTION='./freeform_response.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

echo "<P><CENTER><TABLE BORDER='0' CELLSPACING='10' CELLPADDING='10'>";
echo "<TR><TD>";
blueFont ("Enter commands in free-form:");
echo "<FONT FACE='Arial'><BR>";
echo "<TEXTAREA ROWS='10' COLS='60' NAME='commands'>";
echo "</TEXTAREA><br><br>";
echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";
echo "</FONT></TD></TR></TABLE><br><br>";
blueFont ("An example:");
echo "</center><br>";
echo "<pre>";
echo "ALTER TABLE $TA<br>";
echo "ADD<br>";
echo "Things BIGINT NOT NULL<br>";
echo "</pre><br><br>";


commonFooter();
?>
