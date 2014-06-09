<?php

    namespace application\components;
    use \Yii;

    class Sms
    {
        public $text;
        public $customer;
        public $subject;


        public function __construct($text, $customer, $subject)
        {
            $this->text = $text;
            $this->customer = $customer;
            $this->subject = $subject;
 
            $customer_full  =   \application\models\db\Customer::model()->findByPk($customer);
            $user      =   Yii::app()->user->id;
            $branch    =   \application\models\db\Branch::model()->findByPk($user);

            $branch_name = str_replace(" ", "_", $branch->name);

            $headers = "From: " . strip_tags($branch_name) . "\r\n";
            // $headers .= "Reply-To: ". strip_tags($branch->email) . "\r\n";
 



            if(empty($customer_full->Contact->mobile)){
                echo 'no contact details';
                $comment = "Sorry no mobile number found for this customer";
                $text2 ='SMS failed -';
                            \application\models\db\CustomerNotes::model()->quickNote($customer, $text2);
            }else
            {

           $number = $customer_full->Contact->mobile;

//$number = '07879335994';  // ********  TEST  **************

                     $email = $number.".kfskkhmn30380@24xgateway.com";

                    //  send sms
                            mail($email, $subject, $text, $headers);
                    //  create note
                            $text2 ='SMS sent to '.$number.' -'.$text;
                            \application\models\db\CustomerNotes::model()->quickNote($customer, $text2);
                    // clear action if required

                    Yii::record(Yii::LOG_SMS, $text);

                     $comment = 'SMS processed sucessfully';
            }
            // return $comment;

       }
        
        public function execute($text = null, $customer = null, $subject = null)
        {

        }


    }


/*
     public function actionSmsSend() //NOT WORKING  REMOVE
                                    {
                                        //$customer    = \application\models\db\Customer::model()->findByAttributes(array('id'=>$_POST['cid']));
                                        // $number  =  $customer->Contact->mobile;
                                // FOR TEST 
                                            $number = '07879335994';
                                        $subject ='';
                                        $text = $_POST['smsmessage'];
                                        $email = $number.".kfskkhmn30380@24xgateway.com";
                                        $headers = "From: NOSCO\r\n";
                                        // Send sms
                                        mail($email, $subject, $text, $headers);
                                        //echo' mail sent'; 
                                       //  save in log
                                       //  create note
                                        }
*/