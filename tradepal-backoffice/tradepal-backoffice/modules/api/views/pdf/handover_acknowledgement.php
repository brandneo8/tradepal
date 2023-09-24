<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Handover Acknowledgement</title>
</head>
<body>
<div class="e-agreemen handover">

  <table class="table-pdf table-pdf-header" >
    <tr>
      <td width="100">
        <img src="https://admin.tradepal.sg/<?php echo $case->DealerRoot['Logo'] ?>" alt="" style="height: 60px;" class="ng-scope">
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
  <div class="titles">VEHICLE HANDOVER ACKNOWLEDGEMENT  </div>
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
	
      <tr>
        <td class="label">BUYER</td>
        <td class="value"><?php echo $case->Seller['Name'] ?></td>
        <td></td>
      </tr>
	
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

  <div style="height: 20px;"></div>
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
      <td class="value"><?php echo $case->ChangeRegNo  == '1' ? 'Yes' : 'No' ?></td>
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
    <tr>
      <td class="label">FIRST REGISTRATION DATE</td>
      <td class="value"><?php echo $case->OriginalRegnDate ?></td>
      <td></td>
    </tr>
  </table>


  <div style="height: 10px;"></div>
  <div style="padding-left: 4px;">
    <div class="">
      In accordance with the Buy & Sell Agreement between subject Trader and the Seller,
      the trader hereby acknowledges the receipt of subject vehicle and shall be responsible for
      fines, summons, fees or any claim arising from subject vehicle from the time and date stated
      in this acknowledgement.
    </div>
   
  </div>




  <div style="height: 20px;"></div>
  <div class="titles">Handover Breakdown</div>


  <table class="table-pdf">
    <tr>
      <td width="350"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    

    <tr>
      <td class="label">Buy-in car price</td>
      <td class="value num">$ <?php echo $case->PriceAgreed ?></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">Deposit </td>
      <td class="value num">$ <?php echo $case->DepositAmount ?></td>
      <td></td>
    </tr>
    
    <tr>
      <td class="label">Full Settlement </td>
      <td class="value num"><?php echo number_format($case->OutstandingHirePurchaseBalance, 2 )?></td>
      <td></td>
    </tr>

    <tr>
      <td class="label">Other Fees </td>
      <td class="value num"><?php echo $case->OtherFees ?></td>
      <td></td>
    </tr>

    <tr>
      <td class="label">Balance Amount Due to Seller </td>
      <td class="value num">$ <?php echo $case->AmountDue; ?></td>
      <td></td>
    </tr>

    
  </table>

  <div style="height: 20px;"></div>
  <div class="titles" style="text-decoration: none!important">*  Important Note to Seller :</div>
  <div style="padding-left: 4px;">
    <div class="">
      For the Bank to undertake the above full settlement of outstanding car loan and balance
      amount due to you, please initiate the car title transfer to :-
    </div>

  </div>


  <table class="table-pdf">
    <tr>
      <td width="400">
        <table class="table-pdf">
          <tr>
            <td width="100"></td>
            <td width=""></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">ID Type :</td>
            <td class="value"><?php echo $case->Seller['SellerTypeID'] == '1' ? 'INDIVIDUAL' : 'COMPANY' ?></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">Name :</td>
            <td class="value"><?php echo $case->Seller['Name'] ?></td>
            <td></td>
          </tr>
        </table>
      </td>
      <td>
        <table class="table-pdf">
          <tr>
            <td width="100"></td>
            <td width=""></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">ID</td>
            <td class="value"><?php echo $case->Seller['IDNo'] ?></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">MOBILE </td>
            <td class="value"><?php echo $case->Seller['TelephoneNo'] ?></td>
            <td></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <div style="height: 20px;"></div>
  <div class="titles">Handover Details </div>
  
  <table class="table-pdf">
    <tr>
      <td class="label" width="250">Subject vehicle was collected by  </td>
      <td class="value" width="300"><?php echo $case->DealerRoot['CompanyName'] ?></td>
      <td></td>
    </tr>
  </table>

  <table class="table-pdf">
    <tr>
      <td width="400">
        <table class="table-pdf">
          <tr>
            <td width="100" class="label">Dated </td>
            <td class="value"><?php echo $case->HandoverDate ?></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">Time </td>
            <td class="value"><?php echo $case->HandoverTime ?></td>
            <td></td>
          </tr>
        </table>
      </td>
      <td>
        <table class="table-pdf">
          
          <tr>
            <td  width="100" class=""></td>
            <td class=""></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">Location </td>
            <td class="value"><?php echo $case->HandoverLocation ?></td>
            <td></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>


  <div style="height: 40px;"></div>


  <div class="view-all-rights">
    Confirmed by Seller
  </div>




</div>
</body>
</html>




