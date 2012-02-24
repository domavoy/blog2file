<?php
class HtmlFile extends FileInterface{
   var $buffer;

   public function __construct($fileName){
      FileInterface::__construct($fileName);
      $header = <<<EOD
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
      <html>
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Blog</title>
      </head>
      <body bgcolor="#ffffff">
EOD;

      $this->buffer.= $header;
   }

   public function getDocumentExtension(){
      return ".html";
   }

   public function renderMainPage($name, $address, $userpicAddress = ''){
      $this->buffer.= '<h1>'.$name.'</h1>';
      $this->buffer.= '<h3>'.$address.'</h3>';
   }

   public function renderContentHeader(){
   }

   public function renderContent($title, $date){
   }

   public function renderTextHeader(){
   }

   public function renderPost($title, $date, $text){
      $this->buffer.= '<h3>'.strip_tags($date).' - ';
      $this->buffer.= $title.'</h3>';
	  if($this->isDownloadImages){
         $this->renderTextPostWithImages( $text);
      }else{
         $this->renderTextPost( $text);
      }
   }
   
   public function renderTextPost($text){
    $this->buffer.= '<div>'. $text.'</div><br>';
   }
   
   public function renderTextPostWithImages($text){
    $this->buffer.= '<div>'. $text.'</div><br>';
   }

   public function renderEndPage(){
      $this->buffer.= "</body></html>";
   }

   public function stream($name){
      if(ob_get_length()){
         return;
      }
      header('Content-Type: application/x-download');
      if(headers_sent()){
         return;
      }
      header('Content-Length: '.strlen($this->buffer));
      header('Content-Disposition: attachment; filename="'.$name.'"');
      header('Cache-Control: private, max-age=0, must-revalidate');
      header('Pragma: public');
      ini_set('zlib.output_compression','0');
      echo $this->buffer;
   }

   public function save(){
      $f=fopen($this->fileName,'wb');
      if(!$f)
      $this->Error('Unable to create output file: '.$this->fileName);
      fwrite($f,$this->buffer,strlen($this->buffer));
      fclose($f);
      return $this->fileName;
   }
}
?>