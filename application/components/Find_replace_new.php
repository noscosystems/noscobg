<?php

    namespace application\components;
    use \Yii;

    //  usage  $document = \application\components\Find_replace_new::replace($customer_id,$action_id,$document,$loan_id,$debt_plan_id,$court_id);
    //    					$court_id is only used from the ccj page and is null on all other occations
    //						$action_id usually provides the $debt_plan_id (plan) or the $loan_id
    //						NOTE these are all strings not objects or arrays
    //						IF the $action component has a plan number then this is a debt and relates to the debt plan
    class Find_replace_new
    {
    	public static function  replace($customer_id,$action_id,$content,$loan_id,$debt_plan_id,$court_id)
        {
			//  GET DOCUMENT

					//	$content = $document;

        	// find customer details
        	if(isset($customer_id))
        		{$cid=$customer_id ;}
        		 else 
	        		{
	        			if(isset($action_id))
	        				{$action = \application\models\db\Action::model()->findByPk($action_id);
	        					$cid=$action->customer;
	        				}

	        		}
		        if(empty($cid))
		        	{ 
		        	// error
		        	}else
		        	{
		        		$customer = \application\models\db\Customer::model()->findByPk($cid);
		        	}

		       // find detail re the customers home branch

		        
		      // customer address
							$address_text = "flath numberh name address1,\naddress2,\ntowwn";
							if(empty($eg_Result2['address2']))
								{    $address_text = "flath numberh nameh address1,\ntowwn";  }
							$address_text = str_replace("flath", $customer->Address->flat, $address_text);
							$address_text = str_replace("numberh", $customer->Address->number, $address_text);
							$address_text = str_replace("nameh", $customer->Address->name, $address_text);

							$address_text = str_replace("address1", $customer->Address->address1, $address_text);
							$address_text = str_replace("address2", $customer->Address->address2, $address_text);
							$address_text = str_replace("towwn", $customer->Address->town, $address_text);
							$address = $address_text;
							$PC = strtoupper($customer->Address->postcode);
							$PC = substr($PC, 0, -3)." ".substr($PC, -3);
							$address_pc_text = "address.\npc.";
							$address_pc_text = str_replace("address", $address, $address_pc_text);
							$address_pc_text = str_replace("pc", $PC, $address_pc_text); 

				// court letters
							// see if customer is in the CCJ table
			

						$ccj= \application\models\db\Ccj::model()->findByAttributes(array('cid' => $customer->id));
						if(isset($ccj))	
							{
								//var_dump($ccj);
								//exit;
							//		[ccj number]			z
							//		[local court name]		z
							//		[local court address]	z
							//		[ccj date]				z
							//		[total debt]			z
							//		[aoe issue fee]			z

									$content = str_replace("[ccj number]",$ccj->claim_no,$content);	
									if(isset($court_id))
										{
											$court_address = \application\models\db\Courts::model()->findByPk($court_id);
										} else
										{
											if(!empty($ccj))
										{
											if($ccj->court_name == 'northampton'){$court_id = 5;}else{$court_id=$ccj->court_name;}
											$court_address = \application\models\db\Courts::model()->findByPk($court_id);
										} 
										}
									
									$content = str_replace("[local court name]",$court_address->court_name,$content);								
										$court_address_2 = "a1,\na2,\ntowwn.\npc2";
											$court_address_2 = str_replace("a1", $court_address->court_address1, $court_address_2);
											$court_address_2 = str_replace("a2", $court_address->court_address2, $court_address_2);
											$court_address_2 = str_replace("towwn", $court_address->court_town, $court_address_2);
											$court_address_2 = str_replace("pc2", $court_address->court_pc, $court_address_2);
									$content = str_replace("[local court address]",$court_address_2,$content);
									$content = str_replace("[ccj date]",$ccj->date_applied,$content);
									$content = str_replace("[total debt]",$ccj->claim_value,$content);
									$content = str_replace("[aoe issue fee]",'100.00',$content);
									$content = str_replace("['claim_value']",$ccj->claim_value,$content);
									$content = str_replace("[claim_value]",$ccj->claim_value,$content);
									$content = str_replace("['claim_costs']",$ccj->claim_costs,$content);
									$content = str_replace("[claim_costs]",$ccj->claim_costs,$content);
								}

				// see if action is set
						if(isset($action_id))
							{ $action=\application\models\db\Action::model()->findByPk($action_id);}
								else
							{ $action=null;}

				//  load loan   and loan plan objects  fom the action model  loan
						if(!empty($loan_id))
						{
							//$expression = $action->loan || $loan_id ;
							// if(!empty($expression)){
							//	if(isset($action->loan))
							//		{ $loan=\application\models\db\Loan::model()->findByPk($action->loan);}
							//			else
									 $loan=\application\models\db\Loan::model()->findByPk($loan_id);
								$plan = $loan->currentPlan;
								$content = str_replace("[agreement number]",$loan->agreement,$content);
								$content = str_replace("[agreement date]",Yii::app()->dateFormatter->formatDateTime($loan->created, 'short', null),$content);
								$content = str_replace("[total overdue amount]",number_format($plan->nextPaymentAmount,2),$content);
								$content = str_replace("[late sum]",$plan->nextPaymentAmount,$content);
								$content = str_replace("[total debt]",$plan->totalOwed,$content);
								$content = str_replace("[late amount]",$plan->nextPaymentAmount,$content);
								$content = str_replace("[amount due]",$plan->totalOwed,$content);
								$content = str_replace("[default charge]",$customer->Branch->Organisation->charge_initial_loan_debt_default,$content);
						//}
						/*
	********************* need to go through all attachments **********************
							[total overdue amount]   tick
							[unsatisfied value]
							[default date]
							[initial debt]
							[letter charge]
							[court charge]
							[cheque number]
							[drawer name]
							[reason]
							[make]
							[model]
							[imei]
							[serial]
							[return cheque charge]
							[surcharge]
							[agreement date]
							[total debt]
							[missed payment charge]
							[late sum]
							[period payment]
						*/
				}

				//  debt transation details
						$transaction = \application\models\db\Transaction::model()->findAllByAttributes(array('customer' => $cid));
							$balance='';
							foreach($transaction as $amount )
								{
									$balance = $balance + $amount->value;								
								}

				// load debt   and  debt plan objects
					if(isset($debt_plan_id))
					{
							//$expression1 = $action->debt || $debt_plan_id || $action->plan ;
							//if(isset($expression1)){
								$agreement_no = '';
								//if(isset($action->plan))
									//{ $debt_plan=\application\models\db\debts\Plan::model()->findByPk($action->plan);}
									//	else { 
										$debt_plan2=\application\models\db\debts\Plan::model()->findByPk($debt_plan_id);
									//}
								$debts  =\application\models\db\debts\Debt::model()->findAllByAttributes(array('plan'=>$debt_plan2->id));
				//$content = str_replace("I","XXXXXXXXXXXXXXXXXXX",$content);//  TEST
									foreach($debts as $debt){
											$agreement_no = $agreement_no.' '.$debt->agreement.',';
									}
									$content = str_replace("[total debt]",number_format($balance,2),$content);
									$content = str_replace("[missed payment charge]",number_format($customer->Branch->Organisation->charge_missed_payment,2),$content);
									$content = str_replace("[agreement number]",$agreement_no.' ',$content);
									$content = str_replace("[agreement date]",Yii::app()->dateFormatter->formatDateTime($debts['0']->original_date, 'short', null),$content);
									$content = str_replace("[initial debt]",number_format($balance,2),$content);
									$content = str_replace("[default date]",Yii::app()->dateFormatter->formatDateTime($debts['0']->defaulted_date, 'short', null),$content);
									$content = str_replace("[default charge]",$customer->Branch->Organisation->charge_initial_loan_debt_default,$content);
//var_dump($debt_plan2);exit;
									$content = str_replace("[period payment]",number_format($debt_plan2->per_installment,2),$content);
									$content = str_replace("[late sum]",number_format($debt_plan2->totalOutstanding,2),$content);
									$content = str_replace("[outstanding balance]",number_format($debt_plan2->totalOwed,2),$content);
									$content = str_replace("[payment plan number]",$debt_plan2->id,$content);
									$content = str_replace("[amount due]",number_format($debt_plan2->totalOwed,2),$content);
									$content = str_replace("[payment due]",number_format($debt_plan2->per_installment,2),$content);

							}
						/*
						[total overdue amount]   tick
							[unsatisfied value]
							[default date]
							[initial debt]
							[letter charge]
							[court charge]
							[cheque number]
							[drawer name]
							[reason]
							[make]
							[model]
							[imei]
							[serial]
							[return cheque charge]
							[surcharge]
							[agreement date]
							[total debt]
							[missed payment charge]
							[late sum]
							[period payment]
						*/
			//		}



				//  load  branch information
					$branch = $customer->Branch;

				// load user information
					$user= \application\models\db\User::model()->findByPk(Yii::app()->user->id);

				//    start   find and replace

				//  user and branch elements
						$content = str_replace("[staff]",$user->firstname,$content);
						$content = str_replace("[staff surname]",$user->lastname,$content);
						$content = str_replace("[branch name]",$user->Branch->name,$content);
						$content = str_replace("[branch tel]",$branch->cheque_office_no,$content);
						$content = str_replace("[company name]",$branch->company_name,$content);
						$content = str_replace("[rfm tel]",$branch->rfm_telephone,$content);
						$content = str_replace("[rfm name]",$branch->rfm_firstname,$content);
						$content = str_replace("[rfm lastname]",$branch->rfm_lastname,$content);
					//	[company address] // address of organisation
						$company_address_text = "numberh nameh address1\naddress2\ntowwn";
						$company_address_text = str_replace("numberh",$user->Branch->Organisation->Address->number,$company_address_text);
						$company_address_text = str_replace("nameh",$user->Branch->Organisation->Address->name,$company_address_text);
						$company_address_text = str_replace("address1",$user->Branch->Organisation->Address->address1,$company_address_text);
						$company_address_text = str_replace("address2",$user->Branch->Organisation->Address->address2,$company_address_text);
						$company_address_text = str_replace("townh",$user->Branch->Organisation->Address->address2,$company_address_text);
							$PC_c = strtoupper($user->Branch->Organisation->Address->postcode);
							$PC_c = substr($PC_c, 0, -3)." ".substr($PC_c, -3);
						$company_address_full =  "address\npc";
							$company_address_full = str_replace("address", $company_address_text, $company_address_full);
							$company_address_full = str_replace("pc", $PC_c, $company_address_full); 
						$content = str_replace("[company address]",$company_address_full,$content);
					//	[branch address]  // address of BRANCH
						$branch_address_text = "numberh name address1\naddress2\ntowwn";
						$branch_address_text = str_replace("numberh",$user->Branch->Address->number,$branch_address_text);
						$branch_address_text = str_replace("nameh",$user->Branch->Address->name,$branch_address_text);
						$branch_address_text = str_replace("address1",$user->Branch->Address->address1,$branch_address_text);
						$branch_address_text = str_replace("address2",$user->Branch->Address->address2,$branch_address_text);
						$branch_address_text = str_replace("townh",$user->Branch->Address->address2,$branch_address_text);
							$PC_c = strtoupper($user->Branch->Address->postcode);
							$PC_c = substr($PC_c, 0, -3)." ".substr($PC_c, -3);
						$branch_address_full =  "address\npc";
							$branch_address_full = str_replace("address", $branch_address_text, $branch_address_full);
							$branch_address_full = str_replace("pc", $PC_c, $branch_address_full);

				// customer elements
						$content = str_replace("[date]", date('jS M Y') , $content);
						$content = str_replace("[full address]", $address_pc_text, $content); 
						$content = str_replace("[sol]",$customer->titleOption->name,$content);
						$content = str_replace("[fn]",$customer->firstname,$content);
						$content = str_replace("[mn]",$customer->middlename,$content);
						$content = str_replace("[ln]",$customer->lastname.'.',$content);

				// new for MCOL letter
			//         $content = str_replace("[company user id]",$user->firstname,$content);
			//         $content = str_replace("[branch suffix]",$user->firstname,$content);
			//         $content = str_replace("[initial debt]",$user->firstname,$content);
			//         $content = str_replace("[default date]",$user->firstname,$content);
			//         $content = str_replace("[default charge]",$user->firstname,$content);

				// debt
			//         $content = str_replace("[make]",$action->Customer->titleOption->name,$content);
			//         $content = str_replace("[model]",$action->Customer->titleOption->name,$content);
			//         $content = str_replace("[imei]",$action->Customer->titleOption->name,$content);

				//loan or debt?
			//          $content = str_replace("[agreement number]",$action->Customer->titleOption->name,$content);
			//          $content = str_replace("[agreement date]",$action->Customer->titleOption->name,$content);

				// Debt plan
				//  from debt plan, select loans to get all agreement numbers
			//  		$content = str_replace("[agreement number]",$debt_plan->name,$content);// cound be loop od debts
		
			
				return $content;

		}   
    }
