<?php
class HtmlZipFile extends HtmlFile {
  var $zip;

  CONST IMAGES_DIR = 'images';
  public function __construct($fileName){
    HtmlFile::__construct($fileName);
    Log::debug('HtmlZipFile: file name = '.$this->fileName);
    $this->zip = new ZipArchive;
    $this->zip->open($this->fileName, ZipArchive::OVERWRITE);
    $this->zip->addEmptyDir(HtmlZipFile::IMAGES_DIR);
  }

  public function getDocumentExtension(){
    return ".zip";
  }

  const IMG_PATTERN = '<blog2file:Image/>';

  public function renderTextPostWithImages($text){
    $this->buffer.='<div>';
    /* INSERT POST WITH IMAGES */
    $text =  html_entity_decode($text);
    $imgInfoArray = HtmlHelper::parseImageArray($text);
    // replace every links with our $this->IMG_PATTERN
    foreach($imgInfoArray as $imgInfo){
      $text = str_replace($imgInfo[0],HtmlZipFile::IMG_PATTERN,$text);
    }
    // split text on part, with $this->IMG_PATTERN delimeter
    $textData = split(HtmlZipFile::IMG_PATTERN, $text);
    // iterate by every text part(between images)
    $textPartCount = count($textData);
    for($i=0; $i < $textPartCount ; $i++ ){
      $this->buffer.=$textData[$i];
      if($i != ($textPartCount -1)){
        $imgUrl = $imgInfoArray[$i][1];
        $imageFileContent = HtmlHelper::getImageData($imgUrl);
        $imageFileName = mt_rand(100000,999999).'-'.$imageFileContent['filename'];
        $this->zip->addFromString(HtmlZipFile::IMAGES_DIR.'/'.$imageFileName, $imageFileContent['content']);
        $this->buffer.='<img src = "images/'.$imageFileName.'"/>';
      }
    }
    $this->buffer.='</div>';
  }

  public function save(){
    $this->zip->addFromString('index.htm',$this->buffer);
    $this->zip->close();
    return $this->fileName;
  }

  public function stream($name){
    $this->zip->addFromString('index.htm',$this->buffer);
    $this->zip->close();

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=".$this->fileName.";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($this->fileName));
    readfile($this->fileName);
  }
}
?>