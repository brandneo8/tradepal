<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BUY & SELL AGREEMENT</title>
</head>
<body>
<div class="e-agreemen ">

  <table class="table-pdf table-pdf-header" >
    <tr>
      <td width="100">
        <img src="https://admin.tradepal.sg<?php echo $case->DealerRoot['Logo'] ?>" alt="" style="height: 60px;" class="ng-scope">
      </td>
      <td class="companyName">
          <?php echo $case->DealerRoot['CompanyName'] ?>
      </td>
      <td width="300">
        <table class="table-pdf" >
          <tr>
            <td width="100"></td>
            <td width="200"></td>
          </tr>
          <tr>
            <td class="label">CASE ID</td>
            <td class="value"> <?php echo $case->ID; ?> </td>
          </tr>
          <tr>
            <td class="label">DATE</td>
            <td class="value"> <?php echo $case->INS; ?></td>
          </tr>
          
        </table>

      </td>
    </tr>
  </table>
  
  
  <div style="height: 20px;"></div>
  <div class="titles">
		<?php if ($case->Type == 'BUY'): ?>
    BUY &
		<?php endif; ?>
    SELL AGREEMENT </div>
  <div style="height: 10px;"></div>

  <table class="table-pdf">
    <tr>
      <td width="180"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">TRADER</td>
      <td class="value"><?php echo $case->DealerRoot['CompanyName'] ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">ID</td>
      <td class="value"><?php echo $case->Dealer['CompanyRegistertionNo'] ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">PURCHASER'S NAME</td>
      <td class="value"><?php echo $case->Dealer['CompanyName'] ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MOBILE </td>
      <td class="value"><?php echo $case->Dealer['MobileNo'] ?></td>
      <td></td>
    </tr>
    
  </table>
  <div style="height: 10px;"></div>

  <table class="table-pdf">
    <tr>
      <td width="180"></td>
      <td width="300"></td>
      <td></td>
    </tr>
		<?php if ($case->Type == 'BUY'): ?>
      <tr>
        <td class="label">BUYER</td>
        <td class="value"><?php echo $case->Seller['Name'] ?></td>
        <td></td>
      </tr>
		<?php endif; ?>
		<?php if ($case->Type == 'SELL'): ?>
      <tr>
        <td class="label">BUYER</td>
        <td class="value"><?php echo $case->Seller['Name'] ?></td>
        <td></td>
      </tr>
		<?php endif; ?>
    <tr>
      <td class="label">ID</td>
      <td class="value"><?php echo $case->Seller['IDNo'] ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">EMAIL</td>
      <td class="value"><?php echo $case->Seller['Email'] ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MOBILE </td>
      <td class="value"><?php echo $case->Seller['TelephoneNo'] ?></td>
      <td></td>
    </tr>
  </table>


  <div style="height: 10px;"></div>
  <div class="titles">VEHICLE PARTICULARS </div>
 
  <table class="table-pdf">
    <tr>
      <td width="200"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    
    <tr>
      <td class="label">REGISTRATION NO</td>
      <td class="value"><?php echo $case->VehicleNo ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">RETAIN THIS REGN. NO ?</td>
      <td class="value"><?php echo $case->ChangeRegNo == '1' ? 'Yes' : 'No' ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">NEW REGN NO</td>
      <td class="value"><?php echo $case->RegNo ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MAKE & MODEL</td>
      <td class="value"><?php echo $case->VehicleMake ?><?php echo $case->VehicleModel ?></td>
      <td></td>
    </tr>
		<?php if ($case->Type == 'SELL'): ?>
      <tr>
        <td class="label">CHASSIS NO</td>
        <td class="value"><?php echo $case->ChassisNo ?></td>
        <td></td>
      </tr>
      <tr>
        <td class="label">ENGINE NO</td>
        <td class="value"><?php echo $case->EngineNo ?></td>
        <td></td>
      </tr>
		<?php endif; ?>
    <tr>
      <td class="label">FIRST REGISTRATION DATE</td>
      <td class="value"><?php echo $case->OriginalRegnDate ?></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3" class="note">
        <div class=""></div>
        NOTE: FOR OTHER DETAILS PLEASE REFER TO LTA'S OFFICIAL WEBSITE ONEMOTORING.COM.SG
      </td>
    </tr>
  </table>


  <div style="height: 10px;"></div>


  <table class="table-pdf">
    <tr>
      <td width="400"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3" class="label">
          
          
          <?php if ($case->Type == 'BUY'): ?>
            FOR THIS AGREEMENT TO BE LEGALLY BINDING:- <br>
            SUBJECT TRADER AGREES TO BUY AND THE REGISTERED OWNER AGREES TO SELL THE
					<?php endif; ?>
          <?php if ($case->Type == 'SELL'): ?>
            FOR THIS AGREEMENT TO BE LEGALLY BINDING:- <br>
            SUBJECT TRADER AGREES TO BUY AND THE REGISTERED OWNER AGREES TO SELL THE
          <?php endif; ?>
        <br>
        VEHICLE AS FOLLOWS :

        <br><br>
      </td>
    </tr>

    <tr>
      <td class="label">PRICE AGREED </td>
      <td class="value num">$ <?php echo $case->PriceAgreed ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">DEPOSIT </td>
      <td class="value num">$ <?php echo $case->DepositAmount ?></td>
      <td></td>
    </tr>
      
      <?php if ($case->Type == 'BUY'): ?>
        <tr>
          <td class="label">ANY OUTSTANDING HIRE PURCHASE LOAN ?</td>
          <td class="value num">
              <?php if ($case->OutStandingHirePurchaseLoan == '1'): ?>
                <span>Yes
              <?php endif; ?>
              <?php if ($case->OutStandingHirePurchaseLoan == '0'): ?>
                <span>No</span>
              <?php endif; ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td class="label">IF YES, WHICH BANK/FINANCE CO? </td>
          <td class="value num">
						<?php if ($case->OutStandingHirePurchaseLoan == '1'): ?>
              <?php echo $case->Bank ?>
						<?php endif; ?>
          </td>
          <td></td>
        </tr>
      <?php endif; ?>
      <?php if ($case->Type == 'SELL'): ?>
<!--        For this agreement to be legally binding <br>-->
<!--        Subject Buyer agrees to buy and the Dealer agrees to sell the vehicle as follows-->

        <tr>
          <td class="label"> ANY OUTSTANDING HIRE PURCHASE LOAN ?</td>
          <td class="value num">
              <?php if ($case->SellHirePurchaseLoan == '1'): ?>
                Yes
              <?php endif; ?>
              <?php if ($case->SellHirePurchaseLoan == '0'): ?>
                No
              <?php endif; ?>


          </td>
          <td></td>
        </tr>

        <tr>
          <td class="label">IF YES, WHICH BANK/FINANCE CO? </td>
          <td class="value num">
						<?php if ($case->OutStandingHirePurchaseLoan == '1'): ?>
							<?php echo $case->SellBankFinanceCompany ?>
							
						<?php endif; ?>
          </td>
          <td></td>
        </tr>

        <tr>
          <td class="label">MODE OF PAYMENT</td>
          <td class="value num">
						
							<?php echo $case->ModeOfPayment ?>
			
					
          </td>
          <td></td>
        </tr>

        <tr>
          <td class="label">CAR LOAN REQUIRED? </td>
          <td class="value num">
						<?php if ($case->SellHirePurchaseLoan == '1'): ?>
              Yes
						<?php endif; ?>
						<?php if ($case->SellHirePurchaseLoan == '0'): ?>
              No
						<?php endif; ?>
          </td>
          <td></td>
        </tr>
      <?php endif; ?>
	
		<?php if ($case->Type == 'BUY'): ?>
      <tr>
        <td class="label">OUTSTANDING HIRE PURCHASE BALANCE </td>
        <td class="value num">$ <?php echo number_format($case->OutstandingHirePurchaseBalance, 2 )?></td>
        <td></td>
      </tr>
    
		<?php endif; ?>
		<?php if ($case->Type == 'BUY'): ?>
      <tr>
        <td class="label">OTHER FEES </td>
        <td class="value num">$ <?php echo $case->OtherFees ?></td>
        <td></td>
      </tr>
	
		<?php endif; ?>
    <tr>
        <?php if ($case->Type == 'BUY'): ?>
          <td class="label">BALANCE AMOUNT DUE TO SELLER</td>
        <?php endif; ?>
        <?php if ($case->Type == 'SELL'): ?>
          <td class="label">BALANCE PAYABLE</td>
        <?php endif; ?>
      <td class="value num pl-0 pr-0 pb-2">
          $  <?php echo ($case->PriceAgreed - $case->DepositAmount) - $case->OutstandingHirePurchaseBalance - $case->OtherFees ?>
      </td>
      <td></td>
    </tr>
	
		

  </table>
	<?php if ($case->Type == 'BUY'): ?>
  <div style="height: 10px;"></div>
  <div style="padding-left: 4px;">
    <div class=""><b>IMPORTANT NOTE :</b></div>
    <div style="height: 4px;"></div>
  <div class="">1. Above details declared by seller are true and accurate</div>
  <div class="">2. Any accident or traffic offences occuring before the handover of vehicle shall be borne by seller</div>
  <div class="">3. If the seller wishes to withdraw from this agreement, the seller agrees to compensate the Trader (buyer) an amount equal to twice of the deposit paid.</div>
  <div class="">4. Handover of the vehicle to be arragned at a later date after all necessary checks</div>
  </div>
	<?php endif; ?>
	<?php if ($case->Type == 'SELL'): ?>
    <div style="height: 30px;"></div>
    <div style="padding-left: 8px;">
      <div class=""><b>IMPORTANT NOTE :</b></div>
      <div style="height: 4px;"></div>
      <div class="">1. Above details declared by seller are true and accurate</div>
      <div class="">2. any accident or traffic offences before the handover of vehicle shall be borne by seller</div>
      <div class="">3. if the seller changed his/her mind and want to withdraw from this agreement, the seller agreed to compensate the Trader (buyer) an amount equal to twice of th deposit paid.</div>
      <div class="">4. Handover of the vehicle to be arranged at a later date after all due diligence checked.</div>
      <div class=""> 5. Loan applied subject to approval</div>
    </div>
	
	<?php endif; ?>
  <div style="height: 20px;"></div>
  <div style="padding-left: 8px;"><b>Remark : </b> <span class="label"><?php echo $case->Remark ?></span></div>
  <div style="height: 40px;"></div>


  <div class="view-all-rights">
    <br>
    AGREED, ACCEPTED AND CONFIRMED BY BUYER
    <br>
  </div>

  <div style="height: 10px;"></div>


</div>
</body>
</html>




