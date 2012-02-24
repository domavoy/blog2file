<?php
try{

require_once('session.php');

// unset  analzyer task id
unset($_SESSION['currentAnalyzerTaskId']);
if(!CurSession::checkParserTask()){
  // unset paser task id
  unset($_SESSION['currentParserTaskId']);
}
require_once("tmpl/header.php");
?>

<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">
  



<form action="step1.php" class="new_inbox" id="mainForm" method="GET">


<div class="field" ><span class="gray">
<?=Lang::get(Lang::index_enter_address)?></span>
<br/>
</div>

<input class="text" id="blogaddress" name="blogaddress"
	value="<?=Lang::get(Lang::index_url)?>"  type="text" />



<div style="float: center; width: 500px; margin-top: 1em;">
<div class="gray" style="padding-bottom: 0.3em; font-size: 0.8em;"><?=Lang::get(Lang::index_options)?></div>

<!--
  <?=Lang::get(Lang::index_file_type)?>&nbsp;
  <select name="filetype">
  	<option value="0">PDF</option>
  	  <option value="2">HTML</option>  
  	<option value="4">RTF</option>
  </select>
  <br />
-->

<input checked="checked" id="checkPostNewPages" name="checkPostNewPages"
	type="checkbox" value="true" /> <label for="checkPostNewPages"><?=Lang::get(Lang::index_new_post)?></label><br />

<!--
<input id="isDownloadImages" name="isDownloadImages" type="checkbox"
	value="false" /> <label for="isDownloadImages"><?=Lang::get(Lang::index_images)?></label></div>
-->

<div style="text-align: center; clear: both;"><input type="submit"
	name="submitToStep1" class="button" value="<?=Lang::get(Lang::index_download)?>" /></div>
<div id="debug"></div>
</form>


<?php
require_once("tmpl/footer.php");
}catch(Exception $e){
  Log::error('Exception on index page: '.$e);
  Location::goToError();
}
?>