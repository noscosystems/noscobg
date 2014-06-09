<?php

namespace application\components;
use \Yii;

// ***************************************  USAGE  *****************************************************************************//
// $cal = \application\components\Apr::cal($loan,$i,$period,$charge,$no);                                                       //
//  WHERE                                                                                                                       //
//          $loan   = The sum advanced to customer in £                                                                         //
//          $i      = The fixed interest % NOTE  normally you would have either the interenst OR the charges                    //
//          $period = This is the time sale between payments i.e                                                                //
//                                  365 for payday loans.                                                                       //
//                                  52 for weekly term loans ,                                                                  //
//                                  26 for fortnightly term loans and                                                           //
//                                  12 for monthly term loans                                                                   //
//          $charge  = This is the difference between the sum advanced to the customer and the total amount to be repaid        //
//                          NOTE  normally you would have either the interenst OR the charge                                    //
//        $days-  $no = For payday loans it is the number or days the loan is taken out.                                         //
//                          For term loans it is the number of payment the custome has to make                                  //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Apr
{
    public static function  cal($loan,$i,$period,$charge,$no) //  think abut adding $type t for term p for payday
    {
        // if the charges are empty and a fixed loan interest rate is quoted we need to calculate the charges
                if( (!empty($i)) && (empty($charge)) )
            {
                $charge = ($loan * $i) /100 ;
            }
           
                //  This is the calulation for PAYDAY loan
                //  The $period hase to be 365 for this calulation to be used
                    if($period == 365)
                        {                               
                            //   formular from ben        apr = -[ [ [loan/loan+charges]^[365/days] -1  ] * [ [loan/loan+charges]^[-365/days] ] ]  
                            /*   ORIGINAL CALULATION PLEASE KEEP   
                                    $apr_step1  = $loan/($loan+$charge);
                                    $apr_step2  = $period/$no;
                                    $apr_step2b = -$period/$no;
                                    $apr_step3  = pow($apr_step1,$apr_step2)-1;
                                    $apr_step4  = pow($apr_step1,$apr_step2b);
                                    $apr_step5  = $apr_step3 * $apr_step4;
                                    $apr = number_format($apr_step5 * 100,0); // round down and convert to percentage
                            */
                            // all in one
                             $apr= number_format((((pow(($loan/($loan+$charge)),($period/$no)))-1) * (pow(($loan/($loan+$charge)),(-$period/$no))))*100,0);                          
                        }
                        else
                        {
                            // APR calulation for term loans 

                            /*APR calculation Example: 
                                A $300,000 loan with $4,000 other fees and an annual interest rate 5%, the payback term is 10 years.
                                The monthly payment = (300000 + 4000) * 0.05 * (1 + 0.05)120 / ((1 + 0.05)120 - 1) = 3224.39
                                The total payment = 3224.39 * 120 = 386927
                                The total interest = 386927 - 300000 = 86927
                                The Direct-ratio APR is 5.241%.
                                The Constant-ratio APR is 5.747%.
                                The N-ratio APR is 5.307%. 
                            */

                            // apr for weekley
                                if($no == 52){
                                    // we need the interest per period

                                }


                            // apr for fortnightly
                                if($no == 26){
                                     // we need the interest per period
                                }



                            // apr for monthly
                                if($no == 12){
                                     // we need the interest per period
                  //                  $p=$loan // principle borrowed
                   //                 $a=$period // payment per period
                   //                 $r=$i // interest rate
                   //                 $no=$no // number if payments

                   //                     for ($x=0; $x<=$no; $x++)
                   //                         {
                    //                            //echo "The number is: $x <br>";
                    //                        } 

                                }





                        }

       $apr = str_replace("-","",$apr);
       $apr = str_replace(",","",$apr);
        return $apr;
    }

}