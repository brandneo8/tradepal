<!--<div class="view-toobar" ng-if="dataView.StatusOri != '101' && dataView.StatusOri != '103'">-->
<!--  <a style="font-size: 14px;" href="--><?php //echo base_url('/api'); ?><!--/pdf_buy_sell_agreement/[[dataView.ID]]" target="_blank"> <i class="fa fa-file-pdf-o"></i> Buy & Sell Agreement </a>-->
<!--  <span style="padding-left: 6px; padding-right: 6px;">|</span>-->
<!--  <a style="font-size: 14px;" href="--><?php //echo base_url('/api'); ?><!--/pdf_term_buy_sell_agreement/[[dataView.ID]]" target="_blank"> <i class="fa fa-file-pdf-o"></i> Terms & Conditions </a>-->
<!--</div>-->

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
  <div class="table-pdf-title">SALES AGREEMENT</div>
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
      <td class="value">[[dataView.DealerRoot.CompanyRegistertionNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">NAME SALES REP.</td>
      <td class="value">[[dataView.DealerRoot.CompanyName]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MOBILE</td>
      <td class="value">[[dataView.DealerRoot.MobileNo]]</td>
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
      <td class="value">[[dataView.NRIC]]</td>
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
      <td width="220"></td>
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
      <td class="value">[[dataView.ChangeRegNo == '1' ? 'Yes' : 'No']]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">NEW REGN NO</td>
      <td class="value">[[dataView.RegNo]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MAKE & MODEL</td>
      <td class="value">[[dataView.VehicleMake || '-']] [[dataView.VehicleModel]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">CHASSIS NO</td>
      <td class="value">[[dataView.ChassisNo || '-']]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">ENGINE NO</td>
      <td class="value">[[dataView.EngineNo || '-']]</td>
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


  <table class="table-pdf">
    <tr>
      <td width="380"></td>
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
      <td class="label">PRICE SOLD</td>
      <td class="value num">$ [[dataView.PriceAgreed | number:2 ]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">DEPOSIT </td>
      <td class="value num">$ [[dataView.DepositAmount | number:2 ]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label">MODE OF PAYMENT</td>
      <td class="value num"> [[dataView.ModeOfPayment]]</td>
      <td></td>
    </tr>
    <tr>
      <td class="label"> CAR LOAN REQUIRED?</td>
      <td class="value num">
       
        [[dataView.SellHirePurchaseLoan == '1' ? 'Yes' : 'No']]

      </td>
      <td></td>
    </tr>
<!--    <tr>-->
<!--      <td class="label">BANK</td>-->
<!--      <td class="value num">-->
<!--        <span ng-if="dataView.SellHirePurchaseLoan == '1' "> [[dataView.SellBankFinanceCompany || ' ']]</span>-->
<!---->
<!--      </td>-->
<!--      <td></td>-->
<!--    </tr>-->

<!--    <tr>-->
<!--      <td class="label">  LOAN AMOUNT</td>-->
<!--      <td class="value num">-->
<!--        [[dataView.SellHowMuchHirePurchaseLoan  || '-']]-->
<!--      </td>-->
<!--      <td></td>-->
<!--    </tr>-->
 
    <!--    <tr>-->
    <!--      <td class="label">(SETTLEMENT AMOUNT TO BE CONFRIMED)</td>-->
    <!--      <td class="value num">-->
    <!--        <span ng-if="dataView.SellHirePurchaseLoan == '1'">-</span>-->
    <!--        <span ng-if="dataView.SellHirePurchaseLoan != '1'">[[dataView.SellHowMuchHirePurchaseLoan || 'TO BE CONFIRMED ']]</span>-->
    <!--        -->
    <!--      </td>-->
    <!--      <td></td>-->
    <!--    </tr>-->
    <tr>
      <td class="label">BALANCE PAYABLE</td>
      <td class="value num"> $ [[dataView.SellBalancePayableToDealer || 'N.A' ]]</td>
      <td></td>
    </tr>
<!--    <tr>-->
<!--      <td class="label">FULL SETTLEMENT OF OUTSTANDING CARLOAN</td>-->
<!--      <td class="value num"> [[dataView.FullSettlementofOutstandingCarLoan || '' ]]</td>-->
<!--      <td></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--      <td class="label">OTHER FEES</td>-->
<!--      <td class="value num"> [[dataView.OtherFees || '' ]]</td>-->
<!--      <td></td>-->
<!--    </tr>-->

  </table>


  <div style="height: 30px;"></div>

  <div style="padding-left: 8px;">
    <div class=""><b>IMPORTANT NOTE :</b></div>
    <div style="height: 4px;"></div>
    <div class="">  1. Above detaitsdeclared by seller are true and accurate</div>
    <div class=""> 2. Any accident or traffic offences occurring pefore the handover
      of vehicle shall be borne by seller</div>
    <div class=""> 3. If the seller wishes to withdraw from this agreement, the seller
      agrees to compensate the Trader (buyer) an amount equal to
      twice of the deposit paid.</div>
    <div class="">  4. Handover of the venicteto be arranged at a later date after all
      necessary checks</div>
    <div class=""> 5. Loan applied subject to approval</div>
  </div>

  <div ng-if="CASE_STATUS_LOG_DATA.ST102 " class="status-log mt-2">
    Accept Important Note [[CASE_STATUS_LOG_DATA.ST102.INS | dateTimeFormat]]
  </div>

  <div style="height: 40px;"></div>
  <div style="padding-left: 8px;"><b>Remark : </b> <span class="label">[[dataView.Remark]]</span></div>
  <div style="height: 40px;"></div>

  <div style="height: 30px;"></div>
  <div class="form-group ">
    <label class=" col-form-label">1. Approved Advise from End Financing Back </label>
    <div>
      File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.DocAgreement1]]">[[dataView.DocAgreement1]]</a>
    </div>

  </div>

  <div class="form-group ">
    <label class="col-form-label">2. Buyer Detail </label>
    <div>
      File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.DocAgreement2]]">[[dataView.DocAgreement2]]</a>
    </div>
  </div>


  <div class="form-group ">
    <label class="col-form-label"> 3. Buyer NRIC/ID </label>
    <div>
      File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.DocAgreement3]]">[[dataView.DocAgreement3]]</a>
    </div>
  </div>

  <div class="form-group ">
    <label class="col-form-label"> 4. Dealer Sales Agreement </label>
    <div>
      File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.DocAgreement4]]">[[dataView.DocAgreement4]]</a>
    </div>
  </div>
  
  <div style="height: 30px;"></div>
  <div class="view-all-rights">
    AGREED, ACCEPTED AND CONFIRMED BY BUYER
  </div>


  <div style="height: 20px;"></div>

  <div class="text-center ">
    <div ng-if="CASE_STATUS_LOG_DATA.ST101 " class="status-log">
      [[CASE_STATUS_LOG_DATA.ST101.StatusText | caseStatus]]
      [[CASE_STATUS_LOG_DATA.ST101.INS | dateTimeFormat]]
    </div>
    <div ng-if="CASE_STATUS_LOG_DATA.ST102 " class="status-log">
      [[CASE_STATUS_LOG_DATA.ST102.StatusText | caseStatus]]
      [[CASE_STATUS_LOG_DATA.ST102.INS | dateTimeFormat]]
    </div>
    <div ng-if="CASE_STATUS_LOG_DATA.ST103 " class="status-log red">
      [[CASE_STATUS_LOG_DATA.ST103.StatusText | caseStatus]]
      [[CASE_STATUS_LOG_DATA.ST103.INS | dateTimeFormat]]
    </div>
  </div>


  <div style="height: 40px;"></div>
</div>


