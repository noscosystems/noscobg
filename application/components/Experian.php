<?php

    namespace application\components;

    use \Yii;
    use \CException;
    use \CComponent as Component;
    use \application\models\db\Application;
    use \application\models\db\Experian as ExperianModel;

    class Experian extends Component
    {

        /**
         * @var boolean $live
         */
        private $live = false;

        /**
         * @var \application\models\db\Application $application
         */
        protected $application;

        /**
         * @var array $payload
         */
        protected $payload;

        /**
         * @var integer $model
         */
        private $model;


        /**
         * Constructor
         *
         * @access public
         * @param \application\models\db\Application $application "The application model."
         * @param \application\models\db\Experian $model "The Experian model that the response should be saved to."
         * @return void
         */
        public function __construct(Application $application, ExperianModel $model = null)
        {
            $this->live = PRODUCTION && (int) Yii::app()->user->branch !== 1;
            if($application->isNewRecord) {
                throw new CException(
                    Yii::t('chaser', 'An existing application from the database is required. Please save the application and try again.')
                );
            }
            $this->application = $application;
            $this->model = is_object($model)  && !$model->isNewRecord && $model->customer == $application->customer
                ? $model
                : new ExperianModel;
            if($this->model->isNewRecord) {
                $this->model->attributes = array(
                    'customer' => $application->customer,
                    'application' => $application->id,
                    'created' => time(),
                    'type' => 220,
                );
                if(!$this->model->save()) {
                    throw new CException(Yii::t(
                        'application',
                        'Could not create a new Experian model to save the results in.'
                    ));
                }
            }
        }


        /**
         * Get: Certificate Path
         *
         * @access protected
         * @return string
         */
        protected function getCertificatePath()
        {
            return '/home/noscosys/certificates/experian/' . ($this->live ? 'live' : 'uat');
        }


        /**
         * Get: Save Directory
         *
         * @access protected
         * @param boolean $creditCheck "Whether or not we want the save directory for a full credit check."
         * @return string
         */
        protected function getSaveDirectory($creditCheck = false)
        {
            $segments = array(
                'application',
                'data',
                'experian',
                $creditCheck ? 'credit' : 'auth',
            );
            $path = Yii::getPathOfAlias(implode('.', $segments));
            // If the save path does not exist, attempt to create the directory.
            if(!is_dir($path)) {
                // Attempt to create the save directory (with permissions of 755 [drwxr-xr-x] allowing nested
                // directories).
                mkdir($path, 0755, true);
            }
            return $path;
        }


        /**
         * Fetch Token
         *
         * @access protected
         * @return string
         */
        protected function token()
        {
            // Define the ID used to identify the piece of information inside the cache that we want. We could have up to
            // two tokens in the cache (one for Live and one for UAT).
            $cache_id = 'experian_security_token:' . ($this->live ? 'live' : 'uat');
            // Fetch the information we want from the cache.
            $experian_security_token = Yii::app()->cache->get($cache_id);
            // If the cache did not return a usable piece of information, it means that it has either not been set or
            // that it has expired.
            if(!$experian_security_token) {
                // Create a new instance of the CurlWithCertificate class, setting the appropriate certificates. Don't
                // forget to pass the private key, and the password; not just the certificate.
                $curl = new \PHPerian\CurlWithCertificate;
                $curl->setCertificatePassword('nosco42');
                $curl->setCertificate($this->getCertificatePath() . '/nosco.crt');
                $curl->setPrivateKey($this->getCertificatePath()  . '/nosco.key');

                // Define the data that we are going to send to Experian in this token request.
                // Grab the XML body that is sent to Experian in the POST request from the static file saved within the
                // application (inside the data folder).
                $request_xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n"
                  . '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org'
                  . '/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><STS xmlns="http'
                  . '://www.uk.experian.com/WASP/"><authenticationBlock><![CDATA[<WASPAuthenticationRequest><Applicatio'
                  . 'nName>NOSCNoscoU01U</ApplicationName><AuthenticationLevel>CertificateAuthentication,IPAuthenticati'
                  . 'on</AuthenticationLevel><AuthenticationParameters /></WASPAuthenticationRequest>]]></authenticatio'
                  . 'nBlock></STS></soap:Body></soap:Envelope>';
                // Specify the headers to be sent in the POST request (the first (zero-index) header is the URL to send
                // the request to).
                $headers = array(
                    $this->live
                        ? 'https://secure.wasp.uk.experian.com/WASPAuthenticator/tokenService.asmx'
                        : 'https://secure.wasp.uat.uk.experian.com/WASPAuthenticator/tokenService.asmx',
                    'content type' => 'text/xml; charset=utf-8',
                    'content length' => strlen($request_xml),
                    'SOAPAction' => '"http://www.uk.experian.com/WASP/STS"',
                );
                // Send the token request to Experian's authenticator service, and catch the response returned.
                $token_xml = $curl->post($headers, $request_xml);
                // Now that we have a response from Experian's authentication server, we need to parse the XML document
                // that it returned. Somewhere buried deep is our token that we want!
                $experian_security_token = false;
                $document = new \DOMDocument('1.0', 'utf-8');
                // Load the XML into the DOMDocument so that we may access it as an object.
                if($document->loadXML($token_xml->body)) {
                    // Fetch all the elements that have a tagname of "STSResult".
                    $sts_result = $document->getElementsByTagName('STSResult');
                    // There should only be one element with a tagname of "STSResult", otherwise how would we know which
                    // token to use?
                    if($sts_result->length === 1) {
                        // Grab the value in Experian's STSResult, and check that it only contains hexadecimal
                        // characters, and hyphens as byte separators.
                        $token_value = $sts_result->item(0)->nodeValue;
                        if(preg_match('/^[a-fA-F0-9\\-]+$/', $token_value)) {
                            // Trim the token value and encode it into a usable value.
                            $experian_security_token = base64_encode(trim($token_value));
                            // Since we have a usable value, set it in the cache for one hour to be used in subsequent calls
                            // to Experian.
                            Yii::app()->cache->set($cache_id, $experian_security_token, 3600);
                        }
                    }
                }
                // If either the XML data returned from Experian could not be parsed (incorrectly formatted) or that the
                // correct number of STSResult elements could not be found, the Experian security token will be false
                // and nothing will be entered into the cache.
            }
            // Return the Experian security token, regardless of whether it came from cache or Experian's token service.
            return $experian_security_token;
        }


        /**
         * Fetch Date from Timestamp
         *
         * @access protected
         * @param integer $timestamp "The UNIX timestamp to be converted."
         * @return object
         */
        protected function date($timestamp)
        {
            return (object) array(
                'year'  => (int) date('Y', $timestamp),
                'month' => (int) date('n', $timestamp),
                'day'   => (int) date('j', $timestamp),
            );
        }


        /**
         * Get Customer Details as Experian Payload
         *
         * @access protected
         * @return array
         */
        protected function getPayload()
        {
            if(is_object($this->payload)) {
                return $this->payload;
            }

            // Fetch the customers addresses, but limit it to only 3.
            $addressModels = array_slice($this->application->Customer->Addresses, 0, 3);
            $addresses = array();
            $i = 0;
            foreach($addressModels as $address) {
                $addresses[] = (object) array(
                    'postcode'      => $address->postcode,
                    'flatNumber'    => $address->flat,
                    'houseNumber'   => $address->number,
                    'houseName'     => $address->name,
                    'months'        => $address->months,
                );
            }

            $payload = array(
                'firstname' => $this->application->Customer->firstname,
                'lastname'  => $this->application->Customer->lastname,
                'gender'    => $this->application->Customer->gender,
                'dob'       => $this->date($this->application->Customer->dob),
                'id'        => $this->application->Customer->id,
                'submember' => $this->application->Customer->Branch->submember,
                'account'   => $this->application->Customer->Branch->client,
                'addresses' => $addresses,
                'amount'    => $this->application->amount,
                'duration'  => $this->application->months ?: 1,
                'type'      => $this->application->type,
            );

            $this->payload = (object) $payload;
            return $this->payload;
        }


        /**
         * PHPerian
         *
         * Generate the required XML for the Experian Web Service request.
         *
         * @access protected
         * @param boolean $creditCheck "Whether or not this XML generation is for a a full credit check or not."
         * @return string
         */
        protected function phperian($creditCheck = false)
        {
            // Fetch the token to use. Return false if one could not be determined as there is no point in continuing.
            $token = $this->token();
            if(!is_string($token)) {
                #return false;
                $token = 'faketoken';
            }
            // Create a new instance of the PHPerian Request class.
            $request = new \PHPerian\Request;
            // Set verbose mode. This way we can catch any errors and log them; keeping a record of bad data.
            $request->verbose();
            // Set the access token for the request.
            $request->token($token);
            // Create the applicant block.
            $applicant = $request->createApplicant(
                $this->getPayload()->firstname,
                $this->getPayload()->lastname
            );
            // Populate the applicant block with basic details.
            $applicant->gender($this->getPayload()->gender ? 'M' : 'F');
            $applicant->dateOfBirth(
                $this->getPayload()->dob->year,
                $this->getPayload()->dob->month,
                $this->getPayload()->dob->day
            );
            // Iterate through the customer's addresses and associate them with the applicant.
            // Grab todays date as a Unix timestamp.
            $date = time();
            foreach($this->getPayload()->addresses as $status => $address) {
                $status = $status === 0 ? true : $status;
                // Create a new location block for this address.
                $location = $request->createLocationDetails(\PHPerian::LOCATION_UK);
                // Populate the location block with address details.
                $location->postcode(strtoupper($address->postcode));
                if(!is_null($address->flatNumber) && $address->flatNumber) {
                    $location->flat($address->flatNumber);
                }
                if(!is_null($address->houseNumber) && $address->houseNumber) {
                    $location->houseNumber($address->houseNumber);
                }
                if(!is_null($address->houseName) && $address->houseName) {
                    $location->houseName($address->houseName);
                }
                // Create a residency block to associate the location block with the applicant block.
                $residency = $request->createResidency($applicant, $location, $status);
                // Calculate when they finished living at the current address in the iteration. If it's the current
                // address it will be today's date, else it will be the beginning of the succeeding residency.
                $to = $this->date($date);
                $residency->dateTo($to->year, $to->month, $to->day);
                // Calculate when they started living at the current address in the iteration. This will be the amount
                // of years and months they lived at this address taken away from when they finished.
                // Specify a maximum number of years that a residency can last. Learnt this from experience. Had a
                // customer that entered they had lived at their property for ~32000 months (moving in around 700BC).
                // Idiots.
                $maxYears = 50;
                $date = strtotime('- ' . ($address->months <= ($maxYears * 12) ? $address->months : ($maxYears *12)) . ' months', $date);
                $from = $this->date($date);
                $residency->dateFrom($from->year, $from->month, $from->day);
            }
            // Create the Third Party Data block and fill in its attributes.
            $request->createThirdPartyData()
                ->optOut(false);
            // Create the Control block and fill in its attributes.
            $control = $request->createControl()
                ->userIdentity('NSCustomer' . $this->getPayload()->id)
                ->reprocessFlag(true)
                ->authenticatePlus(!$creditCheck)
                ->fullFBL(true)
                ->detect(true)
                ->interactiveMode('OneShot');
            if(!$creditCheck) {
                $control->showAuthenticate(true);
            }
            // If the branch that the currently logged in user has a CAIS identifier, use that.
            if(isset($this->getPayload()->submember) && preg_match('/^\\d+$/', $this->getPayload()->submember)) {
                // The current system will send the submember as "4" and not "004". This should fix that error.
                $length = strlen($this->getPayload()->submember);
                $submember = str_repeat("0", 3 - $length) . $this->getPayload()->submember;
                $control->clientBranchNumber($submember);
            }
            if(isset($this->getPayload()->account) && preg_match('/^[a-zA-Z]\\d{4}$/', $this->getPayload()->account)) {
                $control->clientAccountNumber($this->getPayload()->account);
            }
            // Decide what the application type should be, defaulting to a general enquiry.
            $application_type = \PHPerian::APPLICATION_TYPE_ENQUIRY;
            /*
            if(isset($this->getPayload()->type)) {
                switch((int) $this->getPayload()->type) {
                    case 1:
                        $application_type = \PHPerian::APPLICATION_TYPE_HOME_CREDIT;
                        break;
                    case 2:
                    case 3:
                        $application_type = \PHPerian::APPLICATION_TYPE_UNSECURED_PERSONAL_LOAN;
                        break;
                    case 4:
                        $application_type = \PHPerian::APPLICATION_TYPE_FURTHER_ADVANCE;
                        break;
                    case 9:
                        $application_type = \PHPerian::APPLICATION_TYPE_DEBT_RECOVERY;
                        break;
                }
            }
            /**/
            $application = $request->createApplication($application_type)
                ->applicationChannel(\PHPerian::APPLICATION_CHANNEL_INTERNET)
                ->searchConsent(true);
            if(isset($this->getPayload()->amount)) {
                $application->amount($this->getPayload()->amount);
            }
            /*
            if(isset($this->getPayload()->duration)) {
                $application->term($this->getPayload()->duration);
            }
            /**/
            // Generate the XML to be send in the body of the POST request, and return it as a string.
            return $request->xml();
        }


        /**
         * Run Authenticate
         *
         * @access public
         * @return \application\models\db\Experian
         */
        public function authenticate()
        {
            $this->model->type = 220;
            try {
                $xml = $this->phperian();
                $filepath = str_replace('response', 'request', $this->model->authenticateFilePath);
                file_put_contents($filepath, $xml);
                $response = $this->request($xml);
                $this->dumpResponse($response, $filename);
                if(
                    strpos($response, '</OneShotFailure>') !== false
                 || (strpos($response, '</ErrorCode>') !== false && strlen($response) < 1536)
                ) {
                    $this->model->successful = 0;
                    $this->model->save();
                    Yii::record(
                        Yii::LOG_AUTH_ERROR,
                        Yii::t(
                            'application',
                            'Experian: Failed Authenticate for {customer}.',
                            array(
                                '{customer}' => implode(' ', array(
                                    $this->payload->firstname,
                                    $this->payload->lastname
                                )),
                            )
                        )
                    );
                    return null;
                }
            }
            catch(CException $e) {
                $filepath = $this->model->authenticateFilePath;
                file_put_contents($filepath, $response);
                $this->model->successful = 0;
                $this->model->save();
                    Yii::record(
                        Yii::LOG_AUTH_ERROR,
                        Yii::t(
                            'application',
                            'Experian: Failed Authenticate for {customer}.',
                            array(
                                '{customer}' => implode(' ', array(
                                    $this->payload->firstname,
                                    $this->payload->lastname
                                )),
                            )
                        )
                    );
                return false;
            }
            $filepath = $this->model->authenticateFilePath;
            file_put_contents($filepath, $response);
            $this->model->successful = 1;
            $this->model->save();
            Yii::record(
                $this->live ? Yii::LOG_AUTH : Yii::LOG_AUTH_UAT,
                Yii::t(
                    'application',
                    'Experian: Authenticate for {customer}.',
                    array(
                        '{customer}' => implode(' ', array(
                            $this->payload->firstname,
                            $this->payload->lastname
                        )),
                    )
                )
            );
            return $this->model;
        }

        /**
         * Dump Response
         *
         * @access protected
         * @param string $response "The XML response returned by Experian."
         * @param string $filename "The filename that should be used to save this response. Optional."
         * @return void
         */
        protected function dumpResponse($response, $filename = null)
        {
            $filename = is_string($filename)
                ? $filename
                : sha1(microtime(true));
            $dir = Yii::getPathOfAlias('application.data.dump.response');
            if(!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            file_put_contents($dir . '/' . $filename . '.xml', $response);
        }

        /**
         * Dump Request
         *
         * @access protected
         * @param string $request "The XML request sent to Experian."
         * @param string $filename "The filename that should be used to save this request. Optional."
         * @return void
         */
        protected function dumpRequest($request, $filename = null)
        {
            $filename = is_string($filename)
                ? $filename
                : sha1(microtime(true));
            $dir = Yii::getPathOfAlias('application.data.dump.request');
            if(!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            file_put_contents($dir . '/' . $filename . '.xml', $request);
        }


        /**
         * Run Credit Check
         *
         * @access public
         * @return \application\models\db\Experian
         */
        public function creditCheck()
        {
            $this->model->type = 221;
            try {
                $xml = $this->phperian(true);
                $filepath = str_replace('response', 'request', $this->model->creditFilePath);
                file_put_contents($filepath, $xml);
                $response = $this->request($xml);
                $this->dumpResponse($response, $filename);
                if(
                    strpos($response, '</OneShotFailure>') !== false
                 || (strpos($response, '</ErrorCode>') !== false && strlen($response) < 1536)
                ) {
                    $this->model->successful = 0;
                    $this->model->save();
                    Yii::record(
                        Yii::LOG_CHECK_ERROR,
                        Yii::t(
                            'application',
                            'Experian: Failed Credit Check for {customer}.',
                            array(
                                '{customer}' => implode(' ', array(
                                    $this->payload->firstname,
                                    $this->payload->lastname
                                )),
                            )
                        )
                    );
                    return null;
                }
            }
            catch(CExeption $e) {
                $filepath = $this->model->creditFilePath;
                file_put_contents($filepath, $response);
                $this->model->successful = 0;
                $this->model->save();
                Yii::record(
                    Yii::LOG_CHECK_ERROR,
                    Yii::t(
                        'application',
                        'Experian: Failed Credit Check for {customer}.',
                        array(
                            '{customer}' => implode(' ', array(
                                $this->payload->firstname,
                                $this->payload->lastname
                            )),
                        )
                    )
                );
                return false;
            }
            $filepath = $this->model->creditFilePath;
            file_put_contents($filepath, $response);
            $this->model->successful = 1;
            $this->model->save();
            Yii::record(
                $this->live ? Yii::LOG_CHECK : Yii::LOG_CHECK_UAT,
                Yii::t(
                    'application',
                    'Experian: Credit Check for {customer}.',
                    array(
                        '{customer}' => implode(' ', array(
                            $this->payload->firstname,
                            $this->payload->lastname
                        )),
                    )
                )
            );
            return $this->model;
        }


        /**
         * Request
         *
         * @access protected
         * @param string $xml "The XML generated, that should be sent to Experian."
         * @return boolean
         */
        protected function request($xml)
        {
            // Create a new instance of the CurlWithCertificate class, setting the appropriate certificates. Don't
            // forget to pass the private key, and the password; not just the certificate.
            $curl = new \PHPerian\CurlWithCertificate;
            $curl->setCertificatePassword('nosco42');
            $curl->setCertificate($this->getCertificatePath() . '/nosco.crt');
            $curl->setPrivateKey($this->getCertificatePath()  . '/nosco.key');
            // Specify the headers to be sent in the POST request (the first (zero-index) header is the URL to send
            // the request to).
            $headers = array(
                $this->live
                    // URL to Experian's Live Web Services.
                    ? 'https://scems.uk.experian.com/experian/wbsv/v100/interactive/interactive.asmx'
                    // URL to Experian's UAT Web Services.
                    : 'https://scems.uat.uk.experian.com/experian/wbsv/v100/interactive.asmx',
                'content type' => 'text/xml; charset=utf-8',
                'content length' => strlen($xml),
                'SOAPAction' => '"http://www.uk.experian.com/experian/wbsv/peinteractive/interactive"',
            );
            // Perform the request and return the reponse.
            return $curl->post($headers, $xml)->body;
        }

    }
