<?php

    namespace application\components;

    use \Yii;

    class PdfManager2
    {

        public $file;
        public $cid;
        public $value;
        public $interest;
        public $charges;
        public $payments;

        /**
         * @access protected
         * @var \application\models\db\Document $document
         */
        protected $document;

        /**
         * Get: Document
         *
         * @access public
         * @return \application\models\db\Document
         */
        public function getDocument()
        {
            return $this->document;
        }

        /**
         * Constructor
         *
         * @access public
         * @param integer $cid
         * @param string $file
         * @param float $value
         * @param float $interest
         * @param float $charges
         * @param array $payments
         * @return void
         */
        public function __construct($cid, $file, $value, $interest, $charges, $payments = array())
        {
 
            $customer    = \application\models\db\Customer::model()->findByPk($cid);
            $branch      = \application\models\db\Branch::model()->findByPk($customer->branch);

            // If the attachment contents has been specified, use that.
            if(!empty($file)) {
                $txt = $file;
            }
            // Otherwise generate some attachment contents to use.
            else {
                $txt = "<h1>Customer Payment Plan</h1>

<p>
[sal] [firstname] [lastname]<br />
[address]<br />
[postcode]
</p>

<p>
Total loan amount is £[value]
</p>

";

                $txt1="";
                if($payments != null) {
                    foreach($payments as $date => $amount) {
                        $txt1 = $txt1 . '<li>&pound;' . $amount . ' on ' . date('l, jS F, Y', $date) . "</li>\n";
                    }
                }
                $txt2 = " Sign ______________________________________&nbsp;&nbsp;&nbsp;Date ___________________<br />";
                $txt3 = "<br />[branchname]<br />[branchaddress]<br />Tel:- [branchtel]";
                $txt = $txt . '<ul>' . $txt1 . '</ul>' . $txt2 . $txt3;
                $txt = str_replace('[firstname]', $customer->firstname, $txt);
                $txt = str_replace('[lastname]', $customer->lastname, $txt);
                $txt = str_replace('[sal]', $customer->titleOption->name, $txt);
                $eg_text_6 = "address1<br /> address2<br /> towwn";
                if(empty($customer->Address->address2)) {
                    $eg_text_6 = "address1\n towwn";
                }
                $eg_text_6 = str_replace("address1", $customer->Address->flat.' '.$customer->Address->name.' '.$customer->Address->number.' '.$customer->Address->address1, $eg_text_6);
                $eg_text_6 = str_replace("address2", $customer->Address->address2, $eg_text_6);
                $eg_text_6 = str_replace("towwn", $customer->Address->town, $eg_text_6);
                $address = $eg_text_6;
                $PC = strtoupper($customer->Address->postcode);
                $PC = substr($PC, 0, -3) . " " . substr($PC, -3);
                $eg_text_7 = "address<br /> pc";
                $txt = str_replace("[address]", $address, $txt);
                $txt = str_replace("[postcode]", strtoupper($PC), $txt);
                $txt = str_replace('[value]', $value + $interest + $charges, $txt);
                $txt = str_replace('[branchname]', $branch->name, $txt);
                $txt = str_replace('[branchaddress]', $branch->Address->address1 . ' ' . $branch->Address->address2 . ' ' . $branch->Address->town . ' ' . $branch->Address->postcode, $txt);
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
            $pdf->setPrintFooter(false);
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            // set auto page breaks
            $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
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
            if($pos == false) {
                $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
            }
            else {
                $pdf->writeHTML($txt, true, false, true, false, '');
            }
            $temp_file = tempnam(sys_get_temp_dir(), 'pp_');
            $pdf->Output($temp_file, 'F');
            try {
                $document = new \application\models\db\Document;
                $document->attributes = array(
                    'created'       => time(),
                    'document'      => $temp_file,
                    'name'          => 'PaymentPlan_' . preg_replace('/[^a-zA-Z]/', '', $customer->fullName) . '_' . time() . '.pdf',
                    'description'   => 'Generated payment plan contract',
                    'branch'        => $customer->branch,
                    'user'          => Yii::app()->user->id,
                    'customer'      => $customer->id,
                );
                if($document->save()) {
                    $this->document = $document;
                }
            }
            catch(\Exception $e) {
                // Couldn't save the document, stop doing stuff.
                return;
            }
            // WE HAVE FINISHED. RETURN HERE SO THAT THE OUTPUT BEFORE THE HEADERS GETS
            // SENT. IT IS EVIL. SO I DELETED IT.
        }

        public function __execute()
        {
            return $fileNL;
        }

    }
