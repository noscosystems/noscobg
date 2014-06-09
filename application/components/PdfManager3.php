<?php

namespace application\components;
use \Yii;


//  THE CLASS CAN BE FOUND IN       CHASER/APPLICATIONS/VENDOR/TECNICK.COM/TCPDF/TCPDF.PHP
class PdfManager3
{
    public $file;
    public $cid;
    public $value;
    public $interest;
    public $charges;
    public $payments;
    public $agreement;




public function __construct($cid,$file,$value,$interest,$charges,$payments,$agreement)// public function __construct($file)
{
//   var_dump($payments);
//   echo $payments;
  //  exit;

    $customer    = \application\models\db\Customer::model()->findByPk($cid);
    $branch      = \application\models\db\Branch::model()->findByPk($customer->branch);



//  echo 'customer id='.$cid.'<br>';
//  echo 'file ='.$file;
    //exit;

    if(!empty($file)){
        $txt = $file;
        //echo '<br>file exists<br>';
    }  ELSE { //Create text file  for contract payment table;
//echo '<br>creating dummy file';


// address  CUSTOMER
        $eg_text_6 = "address1,<br>address2,<br>towwn.";
        if(empty($customer->Address->address2))
           {    $eg_text_6 = "address1,<br> towwn.";  }
       $eg_text_6 = str_replace("address1", $customer->Address->flat.' '.$customer->Address->name.' '.$customer->Address->number.' '.$customer->Address->address1, $eg_text_6);
       $eg_text_6 = str_replace("address2", ' '.$customer->Address->address2, $eg_text_6);
       $eg_text_6 = str_replace("towwn", ' '.$customer->Address->town, $eg_text_6);
       $address = $eg_text_6;
       $PC = strtoupper($customer->Address->postcode);
       $PC = substr($PC, 0, -3)." ".substr($PC, -3);
       $eg_text_7 = "address<br> pc.";
       $eg_text_7 = str_replace("address", $address, $eg_text_7);
       $eg_text_7 = str_replace("pc", ' '.$PC, $eg_text_7);  

// ADDRESS BRANCH  & ORGANISATION
       $PCC = strtoupper($customer->Branch->Address->postcode);
       $PCC = substr($PCC, 0, -3)." ".substr($PCC, -3);

       $PCO = strtoupper($customer->Branch->Organisation->Address->postcode);
       $PCO = substr($PCO, 0, -3)." ".substr($PCO, -3);


//  claculate  APR  for PAYDAYLOAN
       if(count($payments)== 1){
               $charge = $charges+$interest;
               foreach($payments as $date => $amount) {
                        $no = ceil(($date - time())/86400);
                    }
               $cal = \application\components\Apr::cal($value,null,'365',$charge,$no);
            }
            else $cal = '0';

//$txt = "<strong><h1><center>Customer Payment plan</center></h1></strong><br><br><br>
//
//
//[sal] [firstname] [lastname]
//[address]
//[postcode]
//
//
//
//Total loan amount =£[value]
//
//";

      $txt=' <table border="0" style="width:100% border-bottom:1px solid #000">
          <tr>
             <td style="text-align: center;"><h1><strong>'
                 .$customer->Branch->name.
                 '</strong></h1></td>
             </tr>
             <tr>
                <td style="text-align: center; font-size:11px">'
                    .$customer->Branch->company_name.' T/A '.$customer->Branch->name.' -'.$customer->Branch->cheque_office_no.
                    '</td>
                </tr>

                <tr>    
                    <td style="text-align: center; font-size:11px">'
                        .$customer->Branch->Address->address1.', '.$customer->Branch->Address->address2.', '.$customer->Branch->Address->town.'. '.$PCC.
                        '.</td>
                    </tr>

                    <tr>    
                        <td style="text-align: center; font-size:10px"><I> Reg. Office '
                            .$customer->Branch->Organisation->Address->address1.', '.$customer->Branch->Organisation->Address->address2.', '.$customer->Branch->Organisation->Address->town.'. '.$PCO.
                            '.</I></td>
                        </tr>

                        <tr>
                            <td style="text-align: center;"><center><h1><font color="red"><strong>Schedule of payment(s) due</h1></center></strong></font>
                            </td>
                        </tr>

                        <tr>
                            <td  align="right" >'.Yii::app()->dateFormatter->formatDateTime(time(), 'long', null).'
                            </td>
                        </tr>
                    </table>


                    <table>
                     <tr>
                        <td>  '  . $customer->titleOption->name.' '.$customer->firstname.' '.$customer->lastname.'.</td>
                    </tr>
                    <tr>
                        <td><br>'.$eg_text_7.'

                        </td>
                    </tr>
                </table>
                ';

$total_repay=$value+$interest+$charges;

                        if($cal > 10 ){$apr2 = 'APR = '.$cal.'%';}

                        $txt1='<br><br><br>


                        <table>
                        	<tr>
                                <td colspan="2"> Agreement Number:- '.$agreement.' </td>                 
                            </tr>
                            <tr>
                                <td colspan="2"> Sum advanced = £'.number_format($value,2).'</td>
                            </tr>
                            <tr>
                                <td colspan="2"> Total to repay = £'.number_format($total_repay,2).'</td>
                            </tr>

                            <tr>
                                <td colspan="2">'.$apr2.'</td>
                            </tr>
                            
                            <br><br> 
                            <tr>
                                <td><strong>Amount</strong></td>
                                <td><strong>Due Date</strong></td>
                            </tr>

                        ';

                      //      if($payments !== null){
                        //        foreach($payments as $date => $amount){
                          //      $txt1 = $txt1. $date.'£'.$amount;
                            //    }
                           // }

                         if($payments != null) {
                    foreach($payments as $date => $amount) {
                        $txt1 = $txt1 . '<tr><td>  £' . number_format($amount,2) . '</td><td>' . date('l, jS F, Y', $date) . '</td></tr>';
                    }
                }



                        $txt2 = " 
                        </table>

                        <br><br><br><br>Sign  ______________________________________   Date  ___________________
                        ";

                        $txt3 = "<br>
                        ";
                        $txt= $txt.$txt1.$txt2.$txt3;
                                $txt = str_replace('[firstname]', $customer->firstname, $txt);
                                $txt = str_replace('[lastname]', $customer->lastname, $txt);
                                $txt = str_replace('[sal]', $customer->titleOption->name, $txt);
                                             $eg_text_6 = "address1\naddress2\ntowwn";if(empty($customer->Address->address2)){$eg_text_6 = "address1\ntowwn";  }
                                                        $eg_text_6 = str_replace("address1", $customer->Address->address1, $eg_text_6);
                                                        $eg_text_6 = str_replace("address2", $customer->Address->address2, $eg_text_6);
                                                        $eg_text_6 = str_replace("towwn", $customer->Address->town, $eg_text_6);
                                                        $address = $eg_text_6;
                                                        $PC = strtoupper($customer->Address->postcode);
                                                        $PC = substr($PC, 0, -3)." ".substr($PC, -3);
                                                        $eg_text_7 = "address\npc";
                                                        $txt = str_replace("[address]", $address, $txt);
                                                        $txt = str_replace("[postcode]", $PC, $txt);
                                $txt = str_replace('[value]', $value+$interest+$charges, $txt);
                                $txt = str_replace('[branchname]', $branch->name, $txt);
                                $txt = str_replace('[branchaddress]', $branch->Address->address1.' '.$branch->Address->address2.' '.$branch->Address->town.' '.$branch->Address->postcode, $txt);
                                $txt = str_replace('[branchtel]', $branch->rfm_telephone, $txt);
                }






    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NOSCO');
    $pdf->SetTitle('Nosco');
    $pdf->SetSubject('Document');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
    $pdf->setPrintHeader(false);
   //$pdf->setPrintFooter(false);
    $pdf->setPrintFooter(true);

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'test ', PDF_FONT_SIZE_DATA, ));
//$footer_txt = 'blaaaaa';
// $pdf->SetFooterData('$footer_txt', PDF_HEADER_LOGO_WIDTH, '$footer_txt', 'footer string');
//$pdf->setFooterData(array(0,$footer_txt,0), array(0,$footer_txt,128,$footer_txt));









// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT, true);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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


    $pos = strpos($txt, '</');
     if ($pos == false) { $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);} else
        {$pdf->writeHTML($txt, true, false, true, false, '');}


//  $pdf->writeHTML($txt, true, false, true, false, '');
//  $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
//  $pdf->writeHTML($txt, true, false, true, false, '');



//  detect document type
        $doc_type = 'X';
        $pos = strpos($txt, 'Schedule of payment(s) due');
        if ($pos == false) { $doc_type = 'X';} else
        {$doc_type = 'loanpaymentschedule';}

                                       // $cid = "x";
                                        $filename = $cid."_".$doc_type."_".time().".pdf";

                                        $filelocation = Yii::getPathOfAlias('webroot.documents.customer');//  WORKS ON BOTH
                                        $fileNL = $filelocation."/".$filename; // linux

                                        $pdf->Output($fileNL,'F');





// save details in documents table

                                        $document = new \application\models\db\Document;
                                        $document->attributes = array(
                                            'created'       => time(),
                                            //'document'        => $fileNL,
                                            'name'      => $filename,
                                            'description'   => 'Legal document',
                                            'branch'        => $customer->branch,
                                            'user'          => Yii::app()->user->id,
                                            'customer'      => $customer->id,
                                            //'plan'            => '00',
                                            );
                                        $document->save();
                                    

  $url= Yii::app()->createUrl('/documents/customer/');
      $url =$url.'/'.$filename;

 
     echo '<script type="text/javascript" language="Javascript">window.open("'.$url.'","_blank","toolbar=no, scrollbars=yes, resizable=yes, , width=820, height=800");</script>';
/*
$file = $fileNL;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);



    //exit;
}
*/





                                    }
                                    public function __execute()
                                    {
                                        return $fileNL;
                                    }
                                }
