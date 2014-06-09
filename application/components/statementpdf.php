 <?php

namespace application\components;
use \Yii;

class Statementpdf
{
    public $file;
    public $cid;
    public $value;
    public $interest;
    public $charges;
    public $payments;

public function __construct()// public function __construct($file)
{
 $customer = \application\models\db\Customer::model()->findByPk($_GET['id']);
                                            $transactions = $transaction;


                                            // address  CUSTOMER
                                            $eg_text_6 = "address1,<br>address2,<br>towwn.";
                                            if(empty($eg_Result2['address2']))
                                                {    $eg_text_6 = "address1,<br>towwn.";  }
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


                                            //   trying to find the agreement numbers to the loan or loand that are now in debt  this used to be in the debt table in a CSV  
                                            //  find the plan
                                            //  $plan =  \application\models\db\Plan::model()->findByPk($transactions['0']);


                                            // find the debt
                                            $agreement_no = " ";
                                            $debts =  \application\models\db\Debt::model()->findAllByAttributes(array('customer'=>$_GET['id']));
                                            if(!empty($debts)){
                                            foreach($debts as $debt){
                                                $agreement_no = $debt->agreement;
                                                $agreement_no ++;
                                                }
                                            }else {$agreement_no = " ";}
                                            foreach($transactions as $transaction) {
                                                $balance=$transaction->value + $balance;

                                                $test1 = '<tr><td>'.Yii::app()->dateFormatter->formatDateTime($transaction->date, 'short', null).'</td>
                                                <td colspan ="2">'.$transaction->details.'</td>
                                                <td>'.$transaction->method.'</td>
                                                <td align="right">'.number_format($transaction->value,2).' </td>
                                                <td align="right"> '.number_format($balance,2).'</td>
                                            </tr>
                                            '
                                            ;
                                            $test = $test.$test1;
                                            }


                                            $statement =
                                            '<div>
                                            <body>
                                                <table border="0" style="width:100% border-bottom:1px solid #000">
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
                                                $PDF = new \application\components\PdfManager3($customer->id,$text,null,null,null,null);

                                                $file = $text;
                                            /*
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
                                            */