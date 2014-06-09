<?php

namespace application\components;
use \Yii;

class PdfManager
{
	public $file;



public function __construct()// public function __construct($file)
{
// fetch file  (  from session for now but look to pass)
	$file = @$_SESSION['letter'];
	$txt = $file;




	$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('NOSCO');
	$pdf->SetTitle('Nosco');
	$pdf->SetSubject('Document');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//    require_once(dirname(__FILE__).'/lang/eng.php');
//    $pdf->setLanguageArray($l);
//}

// ---------------------------------------------------------

// set font
	$pdf->SetFont('times', '', 11);

// add a page
	$pdf->AddPage();

// set some text to print
//$txt = <<<EOD
//TCPDF Example 002

//Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
//EOD;
//$file = @$_SESSION['letter'];
//$txt = $file;
// print a block of text using Write()
	$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

// ---------------------------------------------------------


?>
 <!--<iframe width="600" height="800">-->
 <?php


 //   save to file to a file
									/*	$filename= "{$membership->id}.pdf"; 
								         $filelocation = "D:\\wamp\\www\\project\\custom";//windows
								              $filelocation = "/var/www/project/custom"; //Linux

								        $fileNL = $filelocation."\\".$filename;//Windows
								            $fileNL = $filelocation."/".$filename; //Linux

								        $this->pdf->Output($fileNL,'F');
								    */    
 		//file name =
 			$cid = "x";
 		$filename = $cid."_4_".time().".pdf";
 	//$filename = "test.PDF";
 	//	$filelocation = "documents/customer";
 		$filelocation = Yii::getPathOfAlias('webroot.documents.customer');
 		$fileNL = $filelocation."/".$filename;
 		$pdf->Output($fileNL,'F');
 	//	echo $file;

 	//Close and output PDF document
//	$pdf->Output('example_002.pdf', 'I');
//	header("Content-type: application/pdf"); 
//	header("Content-Disposition: attachment; filename=example_002.pdf"); 
//	readFile(example_002.pdf);
?>
<!--</iframe>-->
<?php

}
public function __execute()
	{

		return $fileNL;
	}



}