<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
commonHeader("Add a Database");

echo "<h3>";
blueFont ("Your are about to add a table to the ");
redFont  ("$DB");
bluefont (" database...");
echo "</h3>";

echo "<FORM ACTION='./add_table_response.php?DB=$DB' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

echo "<P><CENTER><TABLE BORDER='0' CELLSPACING='10' CELLPADDING='10'>";
echo "<TR><TD>";
blueFont("Name the table:");
echo "<br>";
echo "<INPUT TYPE='TEXT' NAME='Table'><BR>";
echo "</td>";
echo "<td>";
blueFont ("Fields and parameters:");
echo "<FONT FACE='Arial'><BR>";
echo "<TEXTAREA ROWS='10' COLS='60' NAME='commands'>";
echo "</TEXTAREA><br><br>";
echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";
echo "</FONT></TD></TR></TABLE><br><br>";
blueFont ("An example:");
echo "</center><br>";
echo "<pre>";
echo "Stuff VARCHAR(10) NOT NULL,<br>";
echo "Junk VARCHAR(25) NOT NULL,<br>";
echo "Things BIGINT NOT NULL AUTO_INCREMENT,<br>";
echo "PRIMARY KEY (THINGS)<br>";
echo "</pre><br><br>";


commonFooter();
?>
