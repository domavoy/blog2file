<?php
define('FPDF_FONTPATH','font/');
require_once 'fpdfalpha.php';
/**
 * FPDF class with HTML(in future :-) ) support
 * Contains Html support (writeHTML function) and Table of Contents support
 */
class HTMLPDF extends PDF_ImageAlpha
{
  var $B;
  var $I;
  var $U;
  var $HREF;

  /**
   * Constructor
   * @param $orientation String Page orientation
   * @param $unit
   * @param $format String page format (A4(210*297) by default)
   * @return void
   */
  public function __construct($orientation='P',$unit='mm',$format='A4')
  {
    //Call parent constructor
    $this->FPDF($orientation,$unit,$format);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->addFont('ArialMT','','arial.php');
    $this->SetFont('ArialMT','',15);
  }

  /**
   * Parse HTML code, and write into PDF
   * @param $html String Html code
   * @return void
   */
  function WriteHTML($html)
  {
    //HTML parser
    $html=str_replace("\n",' ',$html);
    $html=str_replace("<br />","\n",$html);
    $html = strip_tags($html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
      if($i%2==0)
      {
        //Text
        if($this->HREF)
        $this->PutLink($this->HREF,$e);
        else
        $this->Write(5,$e);
      }
      else
      {
        //Tag
        if($e{0}=='/')
        $this->CloseTag(strtoupper(substr($e,1)));
        else
        {
          //Extract attributes
          $a2=explode(' ',$e);
          $tag=strtoupper(array_shift($a2));
          $attr=array();
          foreach($a2 as $v)
          if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
          $attr[strtoupper($a3[1])]=$a3[2];
          $this->OpenTag($tag,$attr);
        }
      }
    }
  }

  function OpenTag($tag,$attr)
  {
    //Opening tag
    if($tag=='B' or $tag=='I' or $tag=='U')
    $this->SetStyle($tag,true);
    if($tag=='A')
    $this->HREF=$attr['href'];
    if($tag=='BR')
    $this->Ln(5);
  }

  function CloseTag($tag)
  {
    //Closing tag
    if($tag=='B' or $tag=='I' or $tag=='U')
    $this->SetStyle($tag,false);
    if($tag=='A')
    $this->HREF='';
  }

  function SetStyle($tag,$enable)
  {
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
    if($this->$s>0)
    $style.=$s;
  }

  function PutLink($URL,$txt)
  {
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
  }

  var $_toc=array();
  var $_numbering=false;
  var $_numberingFooter=false;
  var $_numPageNum=0;


  function AddPage($orientation='') {
    parent::AddPage($orientation);
    if($this->_numbering)
    $this->_numPageNum++;
  }

  function startPageNums() {
    $this->_numbering=true;
    $this->_numberingFooter=true;
  }

  function stopPageNums() {
    $this->_numbering=false;
  }

  function numPageNo() {
    return $this->_numPageNum;
  }

  function TOC_Entry($txt, $date, $level=0) {
    $this->_toc[]=array('t'=>$txt, 'd' => $date, 'l'=>$level, 'p'=>$this->numPageNo());
  }

  private $pageNum = 1;
  function insertTOC( $location=1,
  $label='Table of Contents'
  ) {
    //make toc at end
    $this->stopPageNums();
    $this->AddPage();
    $tocstart=$this->page;

    $this->SetFont('ArialMT','',28);
    // blog name
    $this->Cell(0,0,$label,0,0,'L');
    $this->Line(5,40,200,40);
    $this->Ln(20);


    foreach($this->_toc as $t) {

      $this->SetFont('ArialMT','',14);
      $this->SetTextColor(0,0,120);

      //Offset
      $level=$t['l'];
      if($level>0)
      $this->Cell($level*8);
      $weight='';
      if($level==0)
      $weight='B';
      $str=substr($this->pageNum++.'. '.$t['t'],0,55);
      $strsize=$this->GetStringWidth($str);
      $this->Cell($strsize+2, $this->FontSize+2, $str);

      //Filling dots
      $PageCellSize=$this->GetStringWidth($t['p'])+2;
      $w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-($strsize+2);
      $nb=$w/$this->GetStringWidth('.');
      $dots=str_repeat('.', $nb);
      $this->Cell($w, $this->FontSize+2, $dots, 0, 0, 'R');

      //Page number
      $this->Cell($PageCellSize, $this->FontSize+2, $t['p'], 0, 1, 'R');

      $this->SetFont('ArialMT','',7);
      $this->Ln(1);
      $this->SetTextColor(120);
      $this->Cell(0,0,$t['d'],0,0,'L');
      $this->Ln(4);

    }

    //grab it and move to selected location
    $n=$this->page;
    $n_toc = $n - $tocstart + 1;
    $last = array();

    //store toc pages
    for($i = $tocstart;$i <= $n;$i++){
      $last[]=$this->pages[$i];
    }

    //move pages
    for($i=$tocstart - 1;$i>=$location-1;$i--){
      $this->pages[$i+$n_toc]=$this->pages[$i];
    }

    //Put toc pages at insert point
    for($i = 0;$i < $n_toc;$i++){
      $this->pages[$location + $i]=$last[$i];
    }
  }

  function Footer() {
    if($this->numPageNo() >=1){
      $this->SetY(-15);
      $this->SetFont('', '', 10);
      $this->Cell(0, 7, Utils::utf8ToWin('Страница ').$this->numPageNo(), 0, 0, 'C');
      $this->Line(25,$this->GetY(),180,$this->GetY());
    }
  }
}
?>