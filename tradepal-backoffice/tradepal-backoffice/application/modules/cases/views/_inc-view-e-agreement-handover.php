<div class="view-toobar" >
  <a style="font-size: 14px;" href="<?php echo base_url('/api'); ?>/pdf_handover_acknowledgement/[[dataView.ID]]" target="_blank"> <i class="fa fa-file-pdf-o"></i> Handover Acknowledgement </a>
</div>

<div class="views">
  <table class="table-pdf table-pdf-header">
    <tr>
      <td width="100">
        <img ng-if="dataView.DealerRoot" src="[[CONST.img_host]][[dataView.DealerRoot.Logo]]" alt="" style="max-height: 80px; max-width: 100%">
      </td>
      <td class="companyName">
        [[dataView.DealerRoot.CompanyName]]
      </td>

      <td width="300">
        <table class="table-pdf">
          <tr>
            <td width="100"></td>
            <td width="200"></td>
          </tr>
          <tr>
            <td class="label">Date</td>
            <td class="value">[[ dataView.INS | dateTimeFormat ]]</td>
          </tr>
          <tr>
            <td class="label">Case ID</td>
            <td class="value">[[dataView.ID]]</td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

  <div style="height: 40px;"></div>
  <div class="table-pdf-title">VEHICLE HANDOVER ACKNOWLEDGEMENT  </div>
  <div style="height: 10px;"></div>


  <table class="table-pdf">
    <tr>
      <td width="220"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">TRADER</td>
      <td class="value">[[dataView.DealerRoot.CompanyName]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">ID</td>
      <td class="value">[[dataView.Dealer.CompanyRegistertionNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">PURCHASER'S NAME</td>
      <td class="value">[[dataView.Dealer.CompanyName]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MOBILE</td>
      <td class="value">[[dataView.Dealer.MobileNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3">
        <div style="height: 10px;"></div>
      </td>
    </tr>
    <tr>
      <td class="label">BUYER</td>
      <td class="value">[[dataView.Seller.Name]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">ID</td>
      <td class="value">[[dataView.Seller.IDNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">EMAIL</td>
      <td class="value">[[dataView.Seller.Email]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MOBILE</td>
      <td class="value">[[dataView.Seller.TelephoneNo]]</td>
      <td></td>
    </tr>
  </table>

  <div style="height: 40px;"></div>
  <div class="table-pdf-title">VEHICLE PARTICULARS </div>


  <table class="table-pdf">
    <tr>
      <td width="280"></td>
      <td width="300"></td>
      <td></td>
    </tr>
    <tr>
      <td class="label">REGISTRATION NO</td>
      <td class="value">[[dataView.VehicleNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">RETAIN THIS REGN. NO ?</td>
      <td class="value">[[dataView.ChangeRegNo  == '1' ? 'Yes' : 'No']]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">NEW REGN NO</td>
      <td class="value" >
        <div class="d-flex align-items-center">
          <div class="w-100">
            <input placeholder="NEW REGN NO" ng-model="dataView.RegNo" name="RegNo" type="text" class="form-control">

          </div>
          <div class="ml-2">
            <button class="btn btn-danger" type="button" ng-click="UPDATE_REGNO()">SAVE</button>
          </div>
        </div>
      </td>
      <td></td>

    </tr>
    <tr>
      <td class="label">MAKE & MODEL</td>
      <td class="value">[[dataView.VehicleMake || '-']] [[dataView.VehicleModel]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">FIRST REGISTRATION DATE</td>
      <td class="value">[[dataView.OriginalRegnDate | date: 'dd MMM yyyy' || '-']]</td>
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

  <div style="height: 40px;"></div>
  <div class="table-pdf-title">Handover Breakdown </div>


  <table class="table-pdf">
    <tr>
      <td width="430"></td>
      <td width="300"></td>
      <td></td>
    </tr>

<!---->
<!--    <tr>-->
<!--      <td class="label">PRICE AGREED</td>-->
<!--      <td class="value num">$ [[dataView.PriceAgreed | number:2 ]]</td>-->
<!--      <td></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--      <td class="label">DEPOSIT </td>-->
<!--      <td class="value num">$ [[dataView.DepositAmount | number:2 ]]</td>-->
<!--      <td></td>-->
<!--    </tr>-->
<!---->
<!--    <tr>-->
<!--      <td class="label">FULL SETTLEMENT OF OUTSTANDING CAR LOAN </td>-->
<!--      <td class="value num">[[dataView.FullSettlementofOutstandingCarLoan | number:2 ]</td>-->
<!--      <td></td>-->
<!--    </tr>-->
<!---->
<!--    <tr>-->
<!--      <td class="label">OTHER FEES </td>-->
<!--      <td class="value num">[[dataView.OtherFees | number:2 ]</td>-->
<!--      <td></td>-->
<!--    </tr>-->
<!---->
<!--    <tr>-->
<!--      <td class="label">BALANCE AMOUNT DUE TO SELLER </td>-->
<!--      <td class="value num"> $ [[dataView.OutstandingHirePurchaseBalance || 'N.A' ]]</td>-->
<!--      <td></td>-->
<!--    </tr>-->

    <tr>
      <td class="label">Buy-in car price</td>
      <td class="value num">$ [[dataView.PriceAgreed | number:2 ]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">Deposit</td>
      <td class="value num">$ [[dataView.DepositAmount | number:2 ]]</td>
      <td></td>
    </tr>

    <tr>
      <td class="label">Full Settlement</td>
      <td class="value num">[[dataView.OutstandingHirePurchaseBalance | number : 2]]</td>
      <td></td>
    </tr>

    <tr>
      <td class="label">Other Fees</td>
      <td class="value num">[[dataView.OtherFees | number : 2]]</td>
      <td></td>
    </tr>

    <tr>
      <td class="label">Balance Amount Due to Seller</td>
      <td class="value num"> [[dataView.AmountDue | number : 2]]</td>
      <td></td>
    </tr>
   

  </table>

  <div style="height: 20px;"></div>
  <div class="table-pdf-title" style="text-decoration: none!important">*  Important Note to Seller :</div>
  <div style="padding-left: 4px;">
    <div class="">
      For the Bank to undertake the above full settlement of outstanding car loan and balance
      amount due to you, please initiate the car title transfer to :-
    </div>

  </div>




  <table class="table-pdf">
    <tr>
      <td width="">
        <table class="table-pdf">
          <tr>
            <td width="100"></td>
            <td width=""></td>
            <td></td>
          </tr>
          <tr>
            <td class="label">ID Type :</td>
            <td class="value">[[dataView.Seller.SellerTypeID == '1' ? 'INDIVIDUAL' : 'COMPANY']]</td>
            <td></td>
          </tr>
          <tr>
            <td class="label">Name :</td>
            <td class="value">[[dataView.Seller.Name]]</td>
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
            <td class="value">[[dataView.Seller.IDNo]]</td>
            <td></td>
          </tr>
          <tr>
            <td class="label">MOBILE </td>
            <td class="value">[[dataView.Seller.TelephoneNo]]</td>
            <td></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <div style="height: 40px;"></div>
  <div class="table-pdf-title">Handover Details </div>

  <table class="table-pdf">
    <tr>
      <td class="label" width="300">Subject vehicle was collected by  </td>
      <td class="value" width="300">[[dataView.DealerRoot.CompanyName]]</td>
      <td></td>
    </tr>
  </table>

  <table class="table-pdf">
    <tr>
      <td width="">
        <table class="table-pdf">
          <tr>
            <td width="100" class="label">Dated </td>
            <td class="value">[[dataView.HandedOverDate | date: 'dd MMM yyyy' ]]</td>
            <td></td>
          </tr>
          <tr>
            <td class="label">Time </td>
            <td class="value">[[dataView.HandedOverTime | timeFormat]]</td>
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
            <td class="value">[[dataView.HandedOverPlace]]</td>
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

  <div style="height: 10px;"></div>



  

</div>

<!--@include('inc.modal-term-buy-sell')-->