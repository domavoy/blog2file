<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once('../libs/libs.php');
require_once('../task/task.php');



$daemonState = getDaemonState();

Checker::setRequestHandler('startDaemon',  'StateAction::startDaemon');
Checker::setRequestHandler('stopDaemon',  'StateAction::stopDaemon');
Checker::setRequestHandler('clearTables', 'StateAction::clearTables');
Checker::setRequestHandler('deleteLogs', 'StateAction::deleteLogs');

Checker::setRequestHandler('getDaemonLog', 'StateAction::getDaemonLog');
Checker::setRequestHandler('getUsersLog', 'StateAction::getUsersLog');
Checker::setRequestHandler('getTasksLog', 'StateAction::getTasksLog');

class StateAction{

  public static function startDaemon(){
    system(Options::daemonCmd);
    Header('Location: state.php');
  }

  public static function stopDaemon(){
    setDaemonStopMark();
    Header('Location: state.php');
  }

  public static function clearTables(){
    $db = Database::getConnection();
    $prepQuery = $db->prepare('truncate table b2f_task_blog');
    $prepQuery->execute();
    $prepQuery = $db->prepare('truncate table b2f_task_cache');
    $prepQuery->execute();
    $prepQuery = $db->prepare('truncate table b2f_task_file');
    $prepQuery->execute();
    $prepQuery = $db->prepare('truncate table b2f_task_schedule');
    $prepQuery->execute();
  }

  public static function deleteLogs(){
    try{ unlink(Options::daemonLogFile); }catch(Exception $e){}
    try{ unlink(Options::daemonUsersFile); }catch(Exception $e){}
    try{ unlink(Options::tasksFile); }catch(Exception $e){}
    try{ unlink(Options::mapFile); }catch(Exception $e){}
  }

  public static function getDaemonLog(){
    Utils::createZipFlow(Options::daemonLogFile,'logs/daemonLog.zip');
  }

  public static function getUsersLog(){
    Utils::createZipFlow(Options::daemonUsersFile,'logs/usersLog.zip');
  }

  public static function getTasksLog(){
    Utils::createZipFlow(Options::tasksFile,'logs/tasksLog.zip');
  }
}
require_once("../tmpl/header.php");
require_once("./head.php");
?>
<div class="pageContent faq">

<h1><a href="./state.php">Daemon state: <b><?=$daemonState;?></a></h1>


<table>
	<tr valign="top">
		<th>Daemon actions:</th>
		<td>
		<form id="startDaemon" action="" method="GET"><input type="hidden"
			name="startDaemon" /> <a href="#"
			onclick="document.getElementById('startDaemon').submit(); return false;">Start</a>
		</form>
		</td>
		<td>
		<form id="stopDaemon" action="" method="GET"><input type="hidden"
			name="stopDaemon" /> <a href="#"
			onclick="document.getElementById('stopDaemon').submit(); return false;">Stop</a>
		</form>
		</td>
		<td>
		<form id="clearTables" action="" method="GET"><input type="hidden"
			name="clearTables" /> <a href="#"
			onclick="document.getElementById('clearTables').submit(); return false;">Clear
		Tables</a></form>
		</td>
		<td>
		<form id="deleteLogs" action="" method="GET"><input type="hidden"
			name="deleteLogs" /> <a href="#"
			onclick="document.getElementById('deleteLogs').submit(); return false;">Delete
		logs</a></form>
		</td>
	</tr>
</table>


<table>
	<tr valign="top">
		<th align = "left">Zipped logs:</th>
		<td>
		<form id="getDaemonLog" action="" method="GET">
		<input type="hidden"
			name="getDaemonLog" /> <a href="#"
			onclick="document.getElementById('getDaemonLog').submit(); return false;">Daemon</a>
		&nbsp;
		</form>
		</td>
		<td>
		<form id="getTasksLog" action="" method="GET">
		<input type="hidden"
			name="getTasksLog" /> <a href="#"
			onclick="document.getElementById('getTasksLog').submit(); return false;">Tasks</a>
		&nbsp;
		</form>
		</td>
		<td>
		<form id="getUsersLog" action="" method="GET">
		<input type="hidden"
			name="getUsersLog" /> <a href="#"
			onclick="document.getElementById('getUsersLog').submit(); return false;">Users</a>
		&nbsp;
		</form>
		</td>
	</tr>
	<tr>
		<td colspan = "4">
    		<a href = "<?=Options::daemonLogFile?>"><?=Options::daemonLogFile?></a><br/>
    		<a href = "<?=Options::tasksFile?>"><?=Options::tasksFile?></a><br/>
    		<a href = "<?=Options::daemonUsersFile?>"><?=Options::daemonUsersFile?></a><br/>
    		<a href = "<?=Options::daemonStateFile?>"><?=Options::daemonStateFile?></a><br/>
			<a href = "<?=Options::daemonCronFile?>"><?=Options::daemonCronFile?></a>			
		</td>
	</tr>
</table>
<?php
require_once("../tmpl/footer.php");
?>