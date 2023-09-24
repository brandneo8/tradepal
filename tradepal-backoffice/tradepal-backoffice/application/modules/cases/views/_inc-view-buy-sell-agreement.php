<div class="view-toobar" ng-if="dataView.StatusOri != '1' && dataView.StatusOri != '3'">
  <a style="font-size: 14px;" href="<?php echo base_url('/api'); ?>/pdf_buy_sell_agreement/[[dataView.ID]]" target="_blank"> <i class="fa fa-file-pdf-o"></i> Buy & Sell Agreement </a>
  <span style="padding-left: 6px; padding-right: 6px;">|</span>
  <a style="font-size: 14px;" href="<?php echo base_url('/api'); ?>/pdf_term_buy_sell_agreement/[[dataView.ID]]" target="_blank"> <i class="fa fa-file-pdf-o"></i> Terms & Conditions </a>
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


  <div style="height: 20px;"></div>
  <div class="table-pdf-title">BUY & SELL AGREEMENT</div>
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
      <td class="label">NAME SALES REP.</td>
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
      <td class="label">SELLER</td>
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

  <div style="height: 20px;"></div>
  <div style="height: 10px;"></div>
  <div class="table-pdf-title">VEHICLE'S BRIEF PARTICULARS</div>


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
    <tr>
      <td class="label">NO. OF TRANSFER</td>
      <td class="value">[[dataView.NoOfTransfers || '-']]</td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3" class="note">
        <strong>NOTE</strong> : FOR OTHER DETAILS PLEASE REFER TO LTA'S OFFICIAL WEBSITE ONEMOTORING.COM.SG
      </td>
    </tr>
  </table>

  <div style="height: 20px;"></div>


  <form class="form" name="ngf" novalidate ng-submit="UPDATE_CASEBL(ngf)">
    <table class="table-pdf">
      <tr>
        <td width="450"></td>
        <td width="300"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="3" class="label">
          <div class="mb-2"> FOR THIS AGREEMENT TO BE LEGALLY BINDING:-</div>
          <div class="">SUBJECT TRADER AGREES TO BUY AND THE REGISTERED OWNER AGREES TO SELL THE</div>
          <div class="">VEHICLE AS FOLLOWS :</div>
          <div style="height: 10px;"></div>
        </td>
      </tr>
      <tr>
        <td class="label">PRICE AGREED</td>
        <td class="value num">$ [[dataView.PriceAgreed | number:2 ]]</td>
        <td></td>
      </tr>
      <tr>
        <td class="label">DEPOSIT</td>
        <td class="value num">$ [[dataView.DepositAmount | number:2 ]]</td>
        <td></td>
      </tr>Undertaking
      <tr>
        <td class="label"> ANY OUTSTANDING HIRE PURCHASE LOAN ?</td>
        <td class="value num ">
        
         [[dataView.OutStandingHirePurchaseLoan == '1' ? 'Yes' : 'No']]
        </td>
        <td></td>
      </tr>
      <tr>
        <td class="label">IF YES, WHICH BANK/FINANCE CO?</td>
        <td class="value num pl-0 pr-0 pb-2">
          <div ng-if="dataView.OutStandingHirePurchaseLoan == '1' ">
<!--            [[dataView.Bank || ' ']]-->
            <input placeholder="Bank" ng-model="dataView.Bank" name="Bank" type="text" class="form-control text-right"  >

          </div>
        </td>
        <td></td>
      </tr>

      
      <tr>
        <td class="label" style="padding-bottom: 15px;">OUTSTANDING HIRE PURCHASE BALANCE</td>
        <td class="value num pl-0 pr-0 pb-2">
          <input placeholder="Outstanding Hire Purchase Balance" ng-model="dataView.OutstandingHirePurchaseBalance" name="OutstandingHirePurchaseBalance" type="text" class="form-control text-right" ng-change="CHANGE_CASEBL()"  required>
        </td>
        <td></td>
      </tr>
      <tr>
        <td class="label">OTHER FEES</td>
        <td class="value num pl-0 pr-0 pb-2">
          <input placeholder="OTHER FEES" ng-model="dataView.OtherFees" name="OtherFees" type="text" class="form-control text-right" numbers-only ng-change="CHANGE_CASEBL()">
        </td>
        <td></td>
      </tr>
      <tr>
        <td class="label">BALANCE AMOUNT DUE TO SELLER</td>
        <td class="value num">$ [[BalanceAmount | number:2]]</td>
        <td></td>

      </tr>

     
      <tr>
        <td></td>
        <td class="text-right">
          <button class="btn btn-danger" type="submit">
            SAVE
          </button>
        </td>
        <td></td>
      </tr>
    </table>
  </form>

  <div style="height: 30px;"></div>
  <div style="padding-left: 8px;">
    <div class=""><b>IMPORTANT NOTE :</b></div>
    <div style="height: 4px;"></div>
    <div class="">1. Above details declared by seller are true and accurate</div>
    <div class="">2. Any accident or traffic offences occuring before the handover of vehicle shall be borne by seller</div>
    <div class="">3. If the seller wishes to withdraw from this agreement, the seller agrees to compensate the Trader (buyer) an amount equal to twice of the deposit paid.</div>
    <div class="">4. Handover of the vehicle to be arranged at a later date after all necessary checks</div>
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST2 " class="status-log mt-2">
    Accept Important Note  [[CASE_STATUS_LOG_DATA.ST2.INS | dateTimeFormat]]
  </div>

  <div style="height: 40px;"></div>
  <div style="padding-left: 8px;"><b>Remark : </b> <span class="label">[[dataView.Remark]]</span></div>
  <div style="height: 40px;"></div>


  <div class="view-all-rights">
<!--    Accreditation by Bank <br>-->
    All rights reserved by TradePal SG Pte Ltd
  </div>

  <div style="height: 10px;"></div>


  <div ng-if="CASE_STATUS_LOG_DATA.ST2 " class="text-center status-log">
    [[CASE_STATUS_LOG_DATA.ST2.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST2.INS | dateFormat]]
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST3 " class="text-center status-log red">
    [[CASE_STATUS_LOG_DATA.ST3.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST3.INS | dateFormat]]
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST4 " class="text-center status-log ">
    [[CASE_STATUS_LOG_DATA.ST4.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST4.INS | dateFormat]]
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST5 " class="text-center status-log red">
    [[CASE_STATUS_LOG_DATA.ST5.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST5.INS | dateFormat]]
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST6 " class="text-center status-log ">
    [[CASE_STATUS_LOG_DATA.ST6.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST6.INS | dateFormat]]
  </div>
  <div ng-if="CASE_STATUS_LOG_DATA.ST7 " class="text-center status-log ">
    [[CASE_STATUS_LOG_DATA.ST7.StatusText]]
    [[CASE_STATUS_LOG_DATA.ST7.INS | dateFormat]]
  </div>


</div>