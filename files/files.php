<?php
require_once 'files/fpdffile.php';
require_once 'files/htmlfile.php';
require_once 'files/htmlzipfile.php';
require_once 'files/rtffile.php';
require_once 'files/rtfzipfile.php';

/**
 * Supported files types list
 */
class FileType{
  const FPDF = 0;
  const HTML = 1;
  const HTMLZIP = 2;
  const RTF = 3;
  const RTFZIP = 4;
}
/*
 * Create FileInterface objects
 */
class FileFactory{
  /**
   * Return FileInterafce object
   * @param $fileTypeName - fileType, from FileType class
   * @param $fileName - fileName, to store, and return to user
   * @return FileInterface object
   */
  public function getByName($fileTypeName, $fileName){
    switch($fileTypeName){
      case FileType::FPDF:
        return new FpdfFile($fileName);
        break;
      case FileType::HTML:
        return new HtmlFile($fileName);
        break;
      case FileType::HTMLZIP:
        return new HtmlZipFile($fileName);
        break;
      case FileType::RTF:
        return new RtfFile($fileName);
        break;
      case FileType::RTFZIP:
        return new RtfZipFile($fileName);
        break;
      default:
        throw new FileTypeNotFoundException($fileTypeName);
        break;
    }
  }
}

/**
 * FileInterfaxe. Used for generate files
 */
abstract class  FileInterface{
  public $fileName;
  protected $isPostNewPage = false;
  protected $isDownloadImages = false;
   
  public function __construct($fileName){
    $this->fileName = $fileName.$this->getDocumentExtension();
  }

  public function setIsPostNewPage($isPostNewPage){
    $this->isPostNewPage = $isPostNewPage;
  }
   
  public function setIsDownloadImages($isDownloadImages){
    $this->isDownloadImages = $isDownloadImages;
  }
   
  abstract public function getDocumentExtension();
  // generate contents
  abstract public function renderMainPage($name, $address ,$userpicAddress = '');
  abstract public function renderTextHeader();
  abstract public function renderPost($title, $date, $text);
  abstract public function renderEndPage();
  // save or stream data
  abstract public function stream($name);
  abstract public function save();
}

class ImageInfo{
  var $name;
  var $type;
  var $width;
  var $height;

  public function __construct($name, $type, $width, $height){
    $this->name = $name;
    $this->type = $type;
    $this->width = $width;
    $this->height = $height;
  }
}

class FileUtils{
  public static function getImageInfo($imgUrl){
    try{
      HtmlHelper::getImageContents($imgUrl);
      $imgSizeInfo = @getimagesize($imgUrl);
      if($imgSizeInfo['mime'] == 'image/gif'){
        $imageType = 'gif';
      } else if ($imgSizeInfo['mime'] == 'image/jpeg'){
        $imageType = 'jpg';
      } else if ($imgSizeInfo['mime'] == 'image/png'){
        $imageType = 'png';
      }
    }
    catch(Exception $e){
      Log::warn('File processor: Failed to load image - '.$imgUrl);
      $imgUrl = Options::BROKEN_IMG_URL;
      $imgSizeInfo = array(20,20);
      $imageType = 'png';
    }
    return new ImageInfo(mt_rand(100000,999999).basename($imgUrl), $imageType, $imgSizeInfo[0] * 0.26, $imgSizeInfo[1] * 0.26);
  }
}
?>
