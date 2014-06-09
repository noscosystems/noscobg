<?php

    namespace application\components;
    use \Yii;

    class Email
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
            $branch    =   \application\models\db\Branch::model()->findByPk(Yii::app()->user->branch);

            $branch_name = str_replace(" ", "_", $branch->name);

            $headers = "From: " . strip_tags($branch_name) . "\r\n";
            $headers .= "Reply-To: ". strip_tags($branch->email) . "\r\n";
 



            if(empty($customer_full->Contact->email)){
                echo 'no contact details';
                $comment = "Sorry no email address found for this customer";
                $text2 ='Email failed -';
                            \application\models\db\CustomerNotes::model()->quickNote($customer, $text2);
            }else
            {

            $number = $customer_full->Contact->email;



//          $number = 'clive.dann@gmail.com';  // ********  TEST  **************

                     $email = $number;

                    //  send sms
                            mail($email, $subject, $text, $headers);
                    //  create note
                            $text2 ='Email sent to '.$number.' -'.$text;
                            \application\models\db\CustomerNotes::model()->quickNote($customer, $text2);

                    // clear action if required

                    //  create log for billing

                     $comment = 'Email processed sucessfully';
            }
            // return $comment;

       }
        
        public function execute($text = null, $customer = null, $subject = null)
        {

        }


    }