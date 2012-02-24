<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Drop $TA from $DB?");

echo "<h1><center><font face='Arial' color='red'>ААААААААА !!!!!!<br>";
echo "Вы хотите удалить</font>";
echo "<font face='Arial' color='red'> таблицу $TA<br></font>";
echo "Вы уверены ??????</font><br><br></center></h1>";
echo "<a href='./drop_table_response.php?DB=$DB&TA=$TA'>Замочить</a><br>";
echo "<a href='./'>Не а, я испугался :-)</a><br>";

commonFooter();
?>
