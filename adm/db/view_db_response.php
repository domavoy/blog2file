<?
require("FaceMySQL.php");

$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Look at $DB ");

echo "<h3>";
blueFont ("Select an  option...");
echo "</h3>";

echo "<ul>";
echo "<li><a href='./view_table.php?DB=$DB&TA=$TA'>�������� ����� ������� <b>$TA</b></a></li>";
echo "<li><a href='./query.php?DB=$DB&TA=$TA'>���������� ������� <b>$TA</b></a></li>";
echo "<li><a href='./add_data.php?DB=$DB&TA=$TA'>�������� ����� ������ � ������� <b>$TA</b></a></li>";
echo "<li><a href='./update_data.php?DB=$DB&TA=$TA'>Update existing data in the <b>$TA</b> table</a></li>";
echo "<li><a href='./alter_table.php?DB=$DB&TA=$TA'>��������� ���� ������� <b>$TA</b></a></li>";
echo "<li><a href='./drop_table.php?DB=$DB&TA=$TA'>������� ������� <b>$TA</b> �� ���� ������</a></li>";
echo "</UL>";

commonFooter();
?>
