<?php

    namespace application\components;

    use \Yii;
    use \CException;
    use \application\models\db\Attachment;
    use \application\models\db\Customer;
    use \application\models\db\Document;

    class PDF extends \CComponent
    {

        /**
         * @access protected
         * @var \application\models\db\Attachment $attachment
         */
        protected $attachment;

        /**
         * @access protected
         * @var \application\models\db\Customer $customer
         */
        protected $customer;

        /**
         * @access protected
         * @param array $placeholders
         */
        protected $placeholders = array();


        /**
         * Constructor
         *
         * @throws CException
         * @access public
         * @param Attachment $attachment
         * @param Customer $customer
         * @param array $placeholders
         * @return void
         */
        public function __construct(Attachment $attachment, Customer $customer, array $placeholders = array())
        {
            if($attachment->isNewRecord || $customer->isNewRecord) {
                throw new CException(
                    Yii::t('application', 'PDF Component cannot use models that haven\'t been persisted to the database.')
                );
            }
            $this->attachment = $attachment;
            $this->customer = $customer;
            $this->placeholders = $placeholders;
            // Calculate some placeholders that should be included by default.
            $this->calculateDefaultPlaceholders();
        }


        /**
         * Add Placeholders
         *
         * @access public
         * @param array $placeholders
         * @return void
         */
        public function addPlaceholders(array $placeholders)
        {
            $this->placeholders = \CMap::mergeArray($this->placeholders, $placeholders);
        }


        /**
         * Get: Placeholders
         *
         * @access public
         * @return array
         */
        public function getPlaceholders()
        {
            $this->filterPlaceholders();
            return $this->placeholders;
        }


        /**
         * Filter Placeholders
         *
         * @access protected
         * @return void
         */
        protected function filterPlaceholders()
        {
            $placeholders = array();
            foreach($this->placeholders as $placeholder => $value) {
                // If the value is not a scalar value, or an object that implements __toString() then we don't want to
                // use it - it cannot be converted to a string.
                // We also don't want to use any placeholders that contain anything that isn't alphanumeric or
                // underscore characters.
                if(
                    !is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))
                 || !preg_match('/^[a-z\\d_]+$/', $placeholder = strtolower(trim($placeholder, '[]')))
                ) {
                    continue;
                }
                $placeholders[$placeholder] = $value;
            }
            $this->placeholders = $placeholders;
        }


        /**
         * Calculate Default Placeholders
         *
         * @access protected
         * @return void
         */
        protected function calculateDefaultPlaceholders()
        {
            $placeholders = array(
                'sal'               => $this->customer->titleOption->name,
                'firstname'         => $this->customer->firstname,
                'lastname'          => $this->customer->lastname,
                'fullname'          => $this->customer->fullname,
                'address'           => is_object($this->customer->address)
                    ? implode("\n", array(
                        $this->customer->address->address1,
                        $this->customer->address->address2,
                        $this->customer->address->town,
                    ))
                    : '',
                'postcode'          => is_object($this->customer->address)
                    ? strtoupper($this->customer->address->postcode)
                    : '',
                'branch'            => $this->customer->branch->name,
                'branch_address'    => '',
                'branch_postcode'   => '',
                'branch_tel'        => '',
            );
            $this->addPlaceholders($placeholders);
        }


        /**
         * Generate Document
         *
         * @throws CException
         * @access public
         * @return \application\models\db\Document
         */
        public function generateDocument()
        {
            $contents = $this->attachment->content;
            $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // Set document information.
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('NOSCO');
            $pdf->SetTitle('Nosco');
            $pdf->SetSubject('Document');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // Set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // Set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // Set font
            $pdf->SetFont('times', '', 11);
            $pdf->AddPage();
            strpos($txt, '</') === false
                ? $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0)
                : $pdf->writeHTML($txt, true, false, true, false, '');
            $file = tempnam(sys_get_temp_dir(), md5(microtime(true)));
            $pdf->Output($file,'F');
        }

    }
