<?php
function createZipFlow($fileName, $zipName){
  try{
    if(!file_exists($fileName)){
      return;
    }
    
    $zip = new ZipArchive;
    $zip->open($zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
    $zip->addFromString($fileName,file_get_contents($fileName));
    $zip->close();

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=".basename($zipName).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($zipName));
    readfile($zipName);

  }
  catch(Exception $e){
  }
}

createZipFlow('tesvt.php', 'aa.zip');
?>