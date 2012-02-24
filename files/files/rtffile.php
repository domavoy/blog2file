<?php
class  RtfFile extends FileInterface{

  protected $rtf;
  protected $curSection;

  public function __construct($fileName){
    FileInterface::__construct($fileName);
    $this->rtf = new Rtf();
  }
  public function getDocumentExtension(){
    return '.rtf';
  }
  // generate contents
  public function renderMainPage($name, $address, $userpicAddress = ''){
    $this->curSection =  $this->rtf->addSection();
    $this->curSection->writeText('<b>'.$name.'</b>.', new Font(20,'Arial'), new ParFormat('center'));
    $this->curSection->writeText($address, new Font(16,'Arial'), new ParFormat('center'));
  }
  public function renderContentHeader(){
    $this->curSection =  $this->rtf->addSection();
    $this->curSection->writeText('<b>'.Lang::get(Lang::file_contents).'</b>.', new Font(20,'Arial'), new ParFormat('center'));
  }

  private $pageNum = 1;
  public function renderContent($title, $date){
    $this->curSection->writeText($this->pageNum++.'. '.$title, new Font(15,'Arial'), new ParFormat('left'));
    $this->curSection->writeText('<i>'.$date.'</i>', new Font(12,'Arial'), new ParFormat('left'));
  }

  public function renderTextHeader(){
    if($this->isPostNewPage == false){
      $this->curSection =  $this->rtf->addSection();
    }
  }

  public function renderPost($title, $date, $text){
    if($this->isPostNewPage){
      $this->curSection =  $this->rtf->addSection();
    }
    $this->curSection->writeText($title, new Font(15,'Arial'), new ParFormat('left'));
    $this->curSection->writeText('<i>'.$date.'</i>', new Font(12,'Arial'), new ParFormat('left'));

    if($this->isDownloadImages){
      $this->renderTextPostWithImages( $text);
    }else{
      $this->renderTextPost( $text);
    }
  }

  public function renderTextPost($text){
    $this->curSection->writeText(strip_tags(str_replace('<br />',"\r\n",$text)), new Font(10,'Arial'), new ParFormat('left'));
  }

  public function renderTextPostWithImages($text){
    $imgInfoArray = HtmlHelper::parseImageArray($text);
    // replace every links with our $this->IMG_PATTERN
    foreach($imgInfoArray as $imgInfo){
      $text = str_replace($imgInfo[0],FpdfFile::IMG_PATTERN,$text);
    }
    // split text on part, with $this->IMG_PATTERN delimeter
    $textData = split(FpdfFile::IMG_PATTERN, $text);
    // iterate by every text part(between images)
    $textPartCount = count($textData);
     
    for($i=0; $i < $textPartCount ; $i++ ){
      $this->curSection->writeText(strip_tags(str_replace('<br />',"\r\n",$textData[$i])), new Font(10,'Arial'), new ParFormat('left'));
/*
      if($i != ($textPartCount -1)){
        $imgUrl = $imgInfoArray[$i][1];
        $imgInfo = FileUtils::getImageInfo($imgUrl);
        if($imgInfo->type != 'gif'){
          $this->curSection->addImage($imgInfo->name, '', $imgInfo->width, $imgInfo->height);
        }
      }
*/
    }
  }

  public function renderEndPage(){

  }

  // save or stream data
  public function stream($name){
    $this->rtf->sendRtf($name);
  }

  public function save(){
    $this->rtf->save($this->fileName);
    return $this->fileName;
  }
}
?>