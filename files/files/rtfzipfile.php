<?php
require_once("rtffile.php");

class RtfZipFile extends RtfFile{
  
   public function __construct($fileName){
      RtfFile::__construct($fileName);
      $this->fileName = $fileName.$this->getDocumentExtension();
   }
   
   public function getDocumentExtension(){
      return ".zip";
   }

   public function save(){
      $zip = new ZipArchive;
      $res = $zip->open($this->fileName, ZipArchive::OVERWRITE);
      if ($res === TRUE) {
         $zip->addFromString('blog.rtf',$this->rtf->getContent());
         $zip->close();
      }
      return $this->fileName;
   }

   public function stream($name){
      $zip = new ZipArchive;
      $res = $zip->open($this->fileName, ZipArchive::OVERWRITE);
      if ($res === TRUE) {
         $zip->addFromString($name.'.rtf',$this->rtf->getContent());
         $zip->close();
         header("Pragma: public");
         header("Expires: 0");
         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
         header("Cache-Control: private",false);
         header("Content-Type: application/zip");
         header("Content-Disposition: attachment; filename=".basename($name).";" );
         header("Content-Transfer-Encoding: binary");
         header("Content-Length: ".filesize($this->fileName));
         readfile($this->fileName);
      }
   }
}
?>