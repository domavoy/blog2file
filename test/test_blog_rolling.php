<?php
$site[] = "http://community.livejournal.com/greg_house_ru/93279.html";
$site[] = "http://community.livejournal.com/greg_house_ru/93586.html";
$site[] = "http://community.livejournal.com/greg_house_ru/93800.html";
$site[] = "http://community.livejournal.com/greg_house_ru/94083.html";
$site[] = "http://community.livejournal.com/greg_house_ru/94264.html";

$site[] = "http://community.livejournal.com/greg_house_ru/94707.html";//
$site[] = "http://community.livejournal.com/greg_house_ru/95012.html";//
$site[] = "http://community.livejournal.com/greg_house_ru/95299.html";//
$site[] = "http://community.livejournal.com/greg_house_ru/95664.html";//
/* $site[] = "http://community.livejournal.com/greg_house_ru/95991.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/96102.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/96454.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/96733.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/96849.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/9699.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/97218.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/97645.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/97991.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/98233.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/98355.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/98654.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/99019.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/99341.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/9952.html";
 $site[] = "http://community.livejournal.com/greg_house_ru/99749.html";*/

function timer($shift = false)
{
  static $first = 0;
  static $last;

  $now = preg_replace('#^0(.*) (.*)$#', '$2$1', microtime());
  if (!$first) $first = $now;
  $res = $shift ? $now - $last : $now - $first;
  $last = $now;
  return $res;
}


echo '<pre>';

timer();
rollingCurl($site,'rollingCallback');
echo "rolling_curl: \t\t".timer(true)."\n";


function rollingCallback($url, $output) {
  //echo $url.", ".strlen($output)."\n";
}


/**
 * Load $urls links and call callback funciton for each url
 * @param $urls array of links
 * @param $callback callback function($url, $text)
 * @param $custom_options - custom options
 * @return boolean
 */
function rollingCurl($urls, $callback, $rolling_window = 5,  $custom_options = null) {

  // make sure the rolling window isn't greater than the # of urls
  $rolling_window = (sizeof($urls) < $rolling_window) ? sizeof($urls) : $rolling_window;

  echo 'Roll window = '.$rolling_window."\n";
  $master = curl_multi_init();
  $curl_arr = array();

  // add additional curl options here
  $std_options = array(CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_MAXREDIRS => 5);
  $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;

  // start the first batch of requests
  for ($i = 0; $i < $rolling_window; $i++) {
    $ch = curl_init();
    $options[CURLOPT_URL] = $urls[$i];
    curl_setopt_array($ch,$options);
    curl_multi_add_handle($master, $ch);
  }

  
  do {
    while(($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
    if($execrun != CURLM_OK)
    break;
    // a request was just completed -- find out which one
    while($done = curl_multi_info_read($master)) {

      $info = curl_getinfo($done['handle']);
      if ($info['http_code'] == 200)  {
        $output = curl_multi_getcontent($done['handle']);
        // request successful.  process output using the callback function.
        $callback($urls[$i-$rolling_window], $output);

        // start a new request (it's important to do this before removing the old one)
        $ch = curl_init();
        $options[CURLOPT_URL] = $urls[$i++];  // increment i
        curl_setopt_array($ch,$options);
        curl_multi_add_handle($master, $ch);

        // remove the curl handle that just completed
        curl_multi_remove_handle($master, $done['handle']);
      } else {

        // request failed.  add error handling.

      }
    }
  } while ($running);
  curl_multi_close($master);
  return true;
}








class HtmlHelper {

  /**
   * @Deprecated use HtmlHelper::getPage that can throw HttpPageNotFoundException
   * Return address content. On error return ''
   * @param $address
   * @return unknown_type
   */
  public static function getHtmlPage($address) {
    $page = '';
    try{
      $page = HtmlHelper::getPage($address) ;
    }catch(HttpPageNotFoundException $e){
    }
    return $page;
  }

  public static function getPage($url){
    $proxy='';
    $compression='gzip';
    $user_agent = 'Blog2fileCacheBot/1.0 (http://blog2file.com;support@blog2file.com;en)';
    $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
    $headers[] = 'Connection: Keep-Alive';
    $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';

    $process = curl_init($url);
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($process, CURLOPT_HEADER, 0);
    curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($process, CURLOPT_ENCODING , $compression);
    curl_setopt($process, CURLOPT_TIMEOUT, 90);
    if ($proxy) {
      curl_setopt($cUrl, CURLOPT_PROXY, 'proxy_ip:proxy_port');
    }
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
    $return = curl_exec ($process);
    $httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
    curl_close($process);
    if($httpCode != 200){
      throw new HttpPageNotFoundException($url);
    }
    return $return;
  }

  /**
   * Return image data. On error return predefined error image
   * @param $url String image address
   * @return array('filename','content')
   */
  private function getImageData($url){
    try{
      $imgContent = HtmlHelper::getImageContents($url);
      $filename = basename($url);
    }catch(HttpPageNotFoundException $e){
      $imgContent = HtmlHelper::getImageContents(Options::BROKEN_IMG_URL);
      $filename = basename(Options::BROKEN_IMG_URL);
    }
    return array('filename' => $filename,'content' => $imgContent);
  }

  /** Return image contents
   *    @url - image address, ex. www.idiot.ru/logo.gif
   */
  public static function getImageContents($url){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $rawdata=curl_exec ($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);
    if($httpCode != 200){
      throw new HttpPageNotFoundException($url);
    }
    return $rawdata;
  }

  /**
   * Return all image links from html text
   * @param $htmlText String html text
   * @return array of image data
   */
  public static function parseImageArray($htmlText){
    $imgArray = array();
    $parseData = array();
    preg_match_all('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'\s>]*)[^>]+>/i', $htmlText, $parseData, PREG_SET_ORDER);
    return $parseData;
  }
}
?>