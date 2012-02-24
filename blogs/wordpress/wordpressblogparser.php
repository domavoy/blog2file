<?php
class WordpressBlogParser {
   public function getBlogParserInfo(BlogAnalyserInfo $blogInfo,$postPageText){


      preg_match_all("/<div class=\"entry\">(.*)<p class=\"postmetadata/si", $postPageText, $parserInfoRawArray, PREG_SET_ORDER);

      return new BlogParserInfo(1, $blogInfo->date_m,$blogInfo->title,$blogInfo->link, $parserInfoRawArray[0][1]);
   }
}
?>