<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
commonHeader("$DB Options");
$DB = $_REQUEST['DB'];
echo "<b>";
blueFont ("��� �� ������ ������ � ");
redFont ("$DB");
blueFont ("?");
echo "</b><br><br>";

echo "<ul>";
echo "<li><a href='./view_db.php?DB=$DB'>���������� ���������� <b>$DB</b></a></li>";
echo "<li><a href='./add_table.php?DB=$DB'>�������� ����� ������� � <b>$DB</b> database</a></li>";
echo "<li><a href='./drop.php?DB=$DB'>������� <b>$DB</b> ���� ������</a></li>";

echo "</ul>";

commonFooter();
?>
