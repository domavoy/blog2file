<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Drop $TA from $DB?");

echo "<h1><center><font face='Arial' color='red'>��������� !!!!!!<br>";
echo "�� ������ �������</font>";
echo "<font face='Arial' color='red'> ������� $TA<br></font>";
echo "�� ������� ??????</font><br><br></center></h1>";
echo "<a href='./drop_table_response.php?DB=$DB&TA=$TA'>��������</a><br>";
echo "<a href='./'>�� �, � ��������� :-)</a><br>";

commonFooter();
?>
