<?php
try{
  require_once('session.php');
  require_once('libs/libs.php');
  require_once('task/task.php');
  require_once('blogs/blogs.php');
  require_once('files/files.php');

  // parse params
  $blogAddress = Checker::getRequest('blogaddress');
  if(trim($blogAddress) == ''){
     Location::goToIndex();
  }
  $isDownloadImages = Checker::getRequestValues('isDownloadImages', true, false);
  $isPostNewPage = Checker::getRequestValues('checkPostNewPages', true, false);

  // if file type not entered the == null. If filetype==null set default = 0(PDF)
  $fileType = Checker::getRequest('filetype', false);
  if($fileType == null){
    $fileType = 0;
  }

  // now only Lj
  //TODO: NEWBLOG: if you added new blogs support, need to change these lines
  $blogType = 'livejournal';
  // create new Analzyer task

  // check address availability
  if(!BlogFactory::checkAddressAvailability($blogAddress)){
    require_once("tmpl/header.php");
    echo '<div class="pageContent root"><div class="createForm" style = "padding-left: 50px">';
    echo '<h2>'.Lang::get(Lang::analyse_check_notfound,$blogAddress).'</h2><br/>';
    echo '<a href = "/">'.Lang::get(Lang::analyse_check_gomain).'</a>';
    echo '</div></div>';
    require_once("tmpl/footer.php");
    exit();
  }

  // check tasks for this user
  if(CurSession::checkParserTask()){
    require_once("tmpl/header.php");
    echo '<div class="pageContent root"><div class="createForm" style = "padding-left: 50px">';
    echo Lang::get(Lang::analyze_msg_many_blogs);
    echo '</div></div>';
    require_once("tmpl/footer.php");
    exit();
  }else{
    CurSession::clearParserTask();
  }

  try{
    $blog = BlogFactory::getByName($blogType, $blogAddress);
  }catch(BlogTypeNotFoundException $e){
    Log::error('Analyze page: Failed to create Blog object, because blogType not found(type/address = '.$blogType.'/'.$blogAddress.')');
    Location::goToError();
  }
  // used to create fileTask. Send to status.php using GET/POST
  $blogName = $blog->getUserName();
  $blogTitle = $blog->getTitle();

  try{
    $blogNormalAddress = $blog->getAddress();
    $blogCacheId = TaskCache::isAnalyzer($blogType, $blogNormalAddress);
    if($blogCacheId >= 0){
      $calendarData = TaskCache::getAnalyzer($blogCacheId);
      $analyzerJsonData = json_encode(BlogTask::updateCalendarData($calendarData,Options::CURRENT_YEAR, $blog));
    }else{
      // no data in cache -> create new analyzer task
      if(isset($_SESSION['currentAnalyzerTaskId'])){
        $taskId = $_SESSION['currentAnalyzerTaskId'];
      }else{
        $taskId = BlogTask::createAnalyzerTask($blogType, $blogAddress);
        Users::setTaskToUser(CurSession::getUserName(),  $taskId);
        $_SESSION['currentAnalyzerTaskId'] =  $taskId;
      }
    }
  }catch(Exception $e){
    Log::error('UI: Failed to create analyser task dur error: '.$e);
    print_r($e);
    exit();
  }



  // save analyzer data
  $_SESSION['blogtype'] = $blogType;
  $_SESSION['blogaddress'] = $blogAddress;
  // save parser data
  $_SESSION['filetype'] = $fileType;
  $_SESSION['isDownloadImages'] = $isDownloadImages;
  $_SESSION['checkPostNewPages'] = $isPostNewPage;

  require_once("tmpl/header.php");
?>

<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">

<div id="endAnalyseMessage" align="center"><span class="gray"><?=Lang::get(Lang::end_analyze_header).$blogAddress;?></span> <br /></div>
<div id="analyseMessage" align="center"><span class="gray"><?=Lang::get(Lang::analyze_header).$blogAddress;?></span> <br />
<img src="static/ajax_loader.gif" /></div>


<form action="status.php" method="GET">
<div class="gray" style = "align:center">
  <div class="accessible_news_slider business_as_usual" id="analyzerInfo">
    <p class="back"><a href="#" title="Back">&laquo; back</a></p>
    <p class="next"><a href="#" title="Next">next &raquo;</a></p>
    <a name="skip_to_news"></a>
  </div>
</div>

<input type="hidden" name="blogName" value="<?=$blogName;?>" />
<input type="hidden" name="blogTitle" value="<?=$blogTitle;?>" />
<div  style="text-align: center;">
  <input class="button" style = "font-size: 2em;" type="submit" id="submitToStep2" name="submitToStep2" value="<?=Lang::get(Lang::analyze_download)?>" />
</div>
</form>

<script>
var $j = jQuery.noConflict();
$j('#submitToStep2').hide();
$j('#analyzerInfo').hide();
$j('#endAnalyseMessage').hide();

<?php
if($blogCacheId >= 0){
 ?>
    var jsonInfo = '<?=$analyzerJsonData?>';
    $j('#analyzerInfo').show();
	$j("#analyzerInfo").append(json2calendar(jsonInfo.parseJSON()));
	$j("#analyzerInfo" ).accessNews({
        headline : "<?=Lang::get(Lang::analyze_select_monthes)?>",
        speed : "slow",
		slideBy : 2
    });
	showData();
 <?php
 }else{
 ?>
var updateAnalyzerTaskIntervalId = setInterval('updateBlogAnalyzerTask()',<?=Options::analyzerTaskUpdateInterval;?>);
var isAnalyzerTaskUpdated = false;
var htmlData = '';

// update analyzer percent
function updateBlogAnalyzerTask(){
	if(isAnalyzerTaskUpdated == false){
    	$j.ajax({
    		url: "ajax.php?getCalendar=<?=$taskId;?>",
         	cache: false,
         	async: false,
         	success: function(html){
    			var info = html.parseJSON();
    			if(info[0] == 1){
        			htmlData = info[1];
        			if(htmlData == 1){
        				$j('#analyseMessage').html('<h2><?=Lang::get(Lang::analyse_no_data, $blogAddress)?></h2>');
        				$j('#analyseMessage').append('<br/><a href="/"><?=Lang::get(Lang::analyse_check_gomain)?></a>');
        				$j('#analyseMessage').show();
        		       	clearInterval(updateAnalyzerTaskIntervalId);
						return;
            		}
    				isAnalyzerTaskUpdated = true;
    			}
             }
        });
	}else{
		$j('#analyzerInfo').show();
		$j('#analyzerInfo').append(json2calendar(htmlData));
       	$j('#analyzerInfo').accessNews({
        	headline : "<?=Lang::get(Lang::analyze_select_monthes)?>",
          	speed : "slow",
        	slideBy : 2
       	});
       	showData();
       	clearInterval(updateAnalyzerTaskIntervalId);
	}
}

<?php
 }
 ?>

 function showData(){
	$j('#analyseMessage').hide();
    $j('#analyzerInfo').show();
    $j('#submitToStep2').show();
    $j('#endAnalyseMessage').show();
 }

//convert JSON response from ajax script, to HTML code
 function json2calendar(jsonCalendarData){
 	var calendar = '<ul>';
 	// monthes list
	var monthList= new Array(
 	    '<?=Lang::get(Lang::analyze_m_January)?>',
 	    '<?=Lang::get(Lang::analyze_m_February)?>',
 	    '<?=Lang::get(Lang::analyze_m_March)?>',
 	    '<?=Lang::get(Lang::analyze_m_April)?>',
 	    '<?=Lang::get(Lang::analyze_m_May)?>',
 	    '<?=Lang::get(Lang::analyze_m_Jule)?>',
 	    '<?=Lang::get(Lang::analyze_m_Juliy)?>',
 	    '<?=Lang::get(Lang::analyze_m_August)?>',
 	    '<?=Lang::get(Lang::analyze_m_Semptember)?>',
 	    '<?=Lang::get(Lang::analyze_m_October)?>',
 	    '<?=Lang::get(Lang::analyze_m_November)?>',
 	    '<?=Lang::get(Lang::analyze_m_December)?>'
	);
     $j.each(jsonCalendarData, function(year, monthObj) {
      	calendar += '<li>';
 		calendar +='<div style = "display: inline;">';
         calendar+='<div><b>'+year+'</b></div>';

		var repArr = new Array();
		repArr["01"] = "0";
		repArr["02"] = "1";
		repArr["03"] = "2";
		repArr["04"] = "3";
		repArr["05"] = "4";
		repArr["06"] = "5";
		repArr["07"] = "6";
		repArr["08"] = "7";
		repArr["09"] = "8";
		repArr["10"] = "9";
		repArr["11"] = "10";
		repArr["12"] = "11";

		var repArr1 = new Array();
		repArr1["0"] = "01";
		repArr1["1"] = "02";
		repArr1["2"] = "03";
		repArr1["3"] = "04";
		repArr1["4"] = "05";
		repArr1["5"] = "06";
		repArr1["6"] = "07";
		repArr1["7"] = "08";
		repArr1["8"] = "09";
		repArr1["9"] = "10";
		repArr1["10"] = "11";
		repArr1["11"] = "12";

		var newarr = new Array();
		$j.each(monthObj, function(month, count){
			newarr[repArr[month]] = count;
		});



         $j.each(newarr, function(month, count) {
         	var id = year + '_' + repArr1[month] + '_' + count;
          	var monthId = monthList[new Number(month) ];
          	//var lab = monthId+'_' + count + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          	var lab = monthId+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          	if(count != 0){
          		calendar+='<div>';
          		calendar+='<input type=checkbox name="month['+id+']" id = "month['+id+']"/>';
          		calendar+='<label for="month['+id+']">'+lab+'</label>';
          		calendar+='</div>';
              }else{
 				calendar+='<div>&nbsp;</div>';
             }
         });
         calendar +='</div>';
     	calendar += '</li>';
 	});

     calendar += '</ul>';
    	return calendar;
 }
</script>
 <?php
 require_once("tmpl/footer.php");
}catch(Exception $e){
  Log::error('Exception on calendar page: '.$e);
  Location::goToError();
}
?>