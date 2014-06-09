<?php

namespace application\components;
use \Yii;

class Pdfstatement
{
    public $file;
    public $cid;
    public $value;
    public $interest;
    public $charges;
    public $payments;

public function __construct($cid,$file,$value,$interest,$charges,$payments)// public function __construct($file)
{

	
$transactions = \application\models\db\Transaction::model()->findAllByAttributes(array('customer'=>$cid),array('order'=>'date ASC'));
    	$customer = \application\models\db\Customer::model()->findByPk($cid);
// address  CUSTOMER
        $eg_text_6 = "number hname address1,<br>address2,<br>towwn.";
        if(empty($customer->Address->address2))
           {    $eg_text_6 = "number hname address1,<br>towwn.";  }
       $eg_text_6 = str_replace("number", $customer->Address->number, $eg_text_6);
       $eg_text_6 = str_replace("hname", $customer->Address->name, $eg_text_6);
       $eg_text_6 = str_replace("address1", $customer->Address->address1, $eg_text_6);
       $eg_text_6 = str_replace("address2", $customer->Address->address2, $eg_text_6);
       $eg_text_6 = str_replace("towwn", $customer->Address->town, $eg_text_6);
       $address = $eg_text_6;
       $PC = strtoupper($customer->Address->postcode);
       $PC = substr($PC, 0, -3)." ".substr($PC, -3);
       $eg_text_7 = "address<br>pc.";
       $eg_text_7 = str_replace("address", $address, $eg_text_7);
       $eg_text_7 = str_replace("pc", $PC, $eg_text_7);  

// ADDRESS BRANCH  & ORGANISATION
       $PCC = strtoupper($customer->Branch->Address->postcode);
       $PCC = substr($PCC, 0, -3)." ".substr($PCC, -3);

       $PCO = strtoupper($customer->Branch->Organisation->Address->postcode);
       $PCO = substr($PCO, 0, -3)." ".substr($PCO, -3);


       $test=null;
       $balance=null;


//   trying to find the agreement numbers to the loan or loans that are now in debt  this used to be in the debt table in a CSV  
//  find the plan
//	$plan =  \application\models\db\Plan::model()->findByPk($transactions['0']);


// find the debt
       $agreement_no='';
       $debts =  \application\models\db\debts\Debt::model()->findAllByAttributes(array('customer'=>$cid));
       foreach($debts as $debt){
           $agreement_no = $debt->agreement.', '.$agreement_no ;
           // $agreement_no ++;

       }


       foreach($transactions as $transaction) {
           $balance=$transaction->value + $balance;
           if($transaction->method !=null){$trans_method = $transaction->methodOption->name ;}else { $trans_method = " - ";}

           $test1 = '<tr><td>'.Yii::app()->dateFormatter->formatDateTime($transaction->date, 'short', null).'</td>
           <td colspan ="2">'.$transaction->details.'</td>
           <td>'.$trans_method.'</td>
           <td align="right">'.number_format($transaction->value,2).' </td>
           <td align="right"> '.number_format($balance,2).'</td>
       </tr>
       '
       ;
       $test = $test.$test1;
   }


//   The  HTML statement 
   $statement =
   '<div>
   <body>
       <table border="0" style="width:100% border-bottom:1px solid #000">
          <tr>
             <td style="text-align: center;"><h1><strong>'
                 .$customer->Branch->name.' '.$cid.
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
                            <td style="text-align: center;"><center><h1><font color="red"><strong>STATEMENT</h1></center></strong></font>
                            </td>
                        </tr>

                        <tr>
                            <td  align="right" >'.Yii::app()->dateFormatter->formatDateTime(time(), 'long', null).'
                            </td>
                        </tr>
                    </table>


                    <table>
                     <tr>
                        <td>'.$customer->titleOption->name.' '.$customer->firstname.' '.$customer->lastname.'.</td>
                    </tr>
                    <tr>
                        <td><br>'.$eg_text_7.'

                        </td>
                    </tr>
                </table>


                <br/><br/><br/><br/>

                <table>
                 <tr>
                    <td>
                       Agreement Number(s): '.$agreement_no.'
                   </td>


               </tr>
           </table>

           <br/><br/>

           <table>
             <tr>
                <td>  Date </td>
                <td colspan ="2">  Description </td>
                <td>  Payment method </td>
                <td align="right">£  Amount </td>
                <td align="right">£  Balance    </td>
            </tr>
            <tr>
                <td colspan="6">
                   <hr width=100%>
               </td>
           </tr>

           '.$test.'
       </table>
   </body>

</div>
';
$text = $statement;
$file = $statement;
$txt = $statement;
/////$PDF = new \application\components\PdfManager3($customer->id,$text,null,null,null,null);
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NOSCO');
    $pdf->SetTitle('Nosco');
    $pdf->SetSubject('Document');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
    $pdf->setPrintHeader(false);
   // $pdf->setPrintFooter(false);

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, ' ', PDF_FONT_SIZE_DATA, ));

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


//  detect document type
        $doc_type = 'X';
        $pos = strpos($txt, 'STATEMENT');
        if ($pos == false) { $doc_type = 'X';} else
        {$doc_type = 'statement';}

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
                                            'hash'          => 'FU',
                                            'name'      => $filename,
                                            'description'   => 'Statement Printed',
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

?>	<!--<script type="text/javascript" language="Javascript">window.open('documents/customer/2611_statement_1389286670.pdf');</script> --> <?php

////exit;
$file=$text;
//echo $file;
$filename = \application\models\db\Document::model()->findAllByAttributes(array('customer'=>$_GET['id']),array('order'=>'created DESC'));
$filename = $filename['0']->name;
$filename = 'documents/customer/'.$filename;
//$this->redirect(array('/documents/customer/2611_statement_1389285599.pdf'));
//$this->redirect(filename);
// header("Location: $filename");
//echo '<script> window.location="documents/customer/614_statement_1389875615.pdf"; </script> ';
echo '<script type="text/javascript" language="Javascript">window.open("documents/customer/614_statement_1389875615.pdf");</script>';
exit;
*/




                                    }
                                   
                                }
