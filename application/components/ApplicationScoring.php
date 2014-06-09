<?php

    namespace application\components;

    class ApplicationScoring
    {

        private $application;

        public function __construct($model)
        {
            if(is_object($model)){
                $this->application = $model;
            } else {
                // Return the object as NULL to allow the page to render;
                return NULL;
            }
        }

        public function generate()
        {
            // Set Score and Max
            $score = 0; $max = 0; $percent = 0;

            $address = $this->generateAddress();
            $employment = $this->generateEmployment();
            $financial = $this->generateFinancial();
            $loan = $this->generateLoan();
            $bankCcj = $this->generateBankruptcyCCJ();

            $score += $address[0] + $employment[0] + $financial[0] + $loan[0] + $bankCcj[0];
            $max   += $address[1] + $employment[1] + $financial[1] + $loan[1] + $bankCcj[1];
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;

            $score = round($score);
            $max = round($max);
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }

        public function generateAddress()
        {
            $max = 0;
            $score = 0;
            $percent = 0;
            $application = $this->application;
            $customer = $application->Customer;

            // The first address can reward max 100 points
            $max += 100;

            // Check if the first address has been filled in
            if($customer->Addresses && isset($customer->Addresses[0])){
                // 10 points awarded for every year stayed at their primary address, max points allowed is 100, no points given after 5 years
                $years = $customer->Addresses[0]->months / 12;
                $score1 = ($years * 20);
                if($score1 > 100) $score1 = 100;
                $score += $score1;

                // If the model has been at their primary address for less than 3 years
                if($years < 3){
                    // 100 max points is added on to compensate for second address
                    $max += 100;

                    // Check to make sure that a seconds address has even been supplied
                    if(isset($customer->Addresses[1])){
                        // Same formula as the first address
                        $years = $customer->Addresses[1]->months / 12;
                        $score2 = ($years * 20);
                        if($score2 > 100) $score2 = 100;
                        $score += $score2;
                    }
                }
            }

            if($application->residential){
                $scoreResidential = $application->residentialOption->data['score'];
                $score += $scoreResidential;
                $max += 100;
            }

            $score = round($score);
            $max = round($max);
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }

        public function generateEmployment()
        {
            $max = 0;
            $score = 0;
            $percent = 0;
            $application = $this->application;
            $customer = $application->Customer;

            // Check if the customer has actually got any employment information
            if($application->employment){

                // Add 100 points for the employment type
                $max += 100;
                // Add on the score
                $score += $application->employmentOption->data['score'];
            

                if($application->job_description){
                    // Job Description Points (100 Max)
                    $max += 100;
                    $score += $application->jobDescriptionOption->data['score'];
                }

                if($application->Benefits){
                    foreach($application->Benefits as $benefit){
                        $score += $benefit->data['score'];
                    }
                    $max += (count($application->Benefits) * 10);
                }
            }

            $score = round($score);
            $max = round($max);
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }

        public function generateFinancial()
        {
            $max = 0;
            $score = 0;
            $percent = 0;
            $application = $this->application;
            $customer = $application->Customer;

            // Check if the customer has a financial record
            if($application->income){
                // Work out income, outcome and displosable
                $income = ($application->income); // Add more if there are more in the future
                $outgoing = (
                        $application->expense_rent +
                        $application->expense_council +
                        $application->expense_phone +
                        $application->expense_tv +
                        $application->expense_general +
                        $application->expense_utilities +
                        $application->expense_travel +
                        $application->expense_maintenance +
                        $application->expense_other 
                    );
                $disposable = $income - $outgoing;

                // Check if the customer has specified that they have had a previous loan
                if($application->expense_other > 0){
                    // Add the loan to the dispoable as if they never took it out.
                    $temp_disposable = ($disposable + $application->expense_other);
                    // Work out the percentage of the loan against the disp
                    $percent = ($application->expense_other / $temp_disposable) * 100;
                    // If the loan is below 0, negate it to make it positive but double it
                    if($percent < 0) $percent = -($percent * 2);
                    // Finally subtract the result from the current score
                    $score -= $percent;
                }

                // Work out the customers score based on the disposable income
                // Max points awarded for the disposable is 100
                $max += 100;
                // If the score is positive then auto reward 50 points
                if($disposable > 0) $score += 50;
                // Work out the bonus of disposable to the income
                $percent = (($disposable / $income) * 100) / 2;
                $score += $percent;

            }

            $score = round($score);
            $max = round($max);
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }


        public function generateLoan()
        {
            $max = 0;
            $score = 0;
            $percent = 0;
            $application = $this->application;
            $customer = $application->Customer;

            $max += 100;
            $score += $application->methodOption->data['score'];

            $score = round($score);
            $max = round($max);
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }

        public function generateBankruptcyCCJ()
        {
            $max = 0;
            $score = 0;
            $percent = 0;
            $application = $this->application;

            if($application->bankrupt != NULL && $application->ccj != NULL){
                $max += 100;
                if($application->bankrupt == 0) $score += 50;
                if($application->ccj == 0)      $score += 50;
            }

            $score = round($score);
            $max = round($max);
            if($score != 0 && $max != 0) $percent = ($score / $max) * 100;
            $percent = round($percent);

            return array(
                $score,
                $max,
                $percent,
            );
        }
    }