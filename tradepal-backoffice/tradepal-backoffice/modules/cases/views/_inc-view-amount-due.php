<div class="pl-2 pr-2">

  <p class="font-weight-bold mb-4">Undertaking and Important Instructions
    <a tabindex="0" class="ml-1" style="cursor: pointer"
       data-content="Work with your Dealer to full settle any loan owed to your financing bank/financial institution on your used car (“Car”) to be sold to your dealer (assuming you have taken financing on your Car);"
       role="button" data-toggle="popover" data-trigger="focus">
      <i class="fa fa-info-circle red "></i>
    </a>
  </p>

  <p>Thank you for using TradePal!</p>
  <p>By agreeing with your chosen used car dealer (“Dealer”) to use the TradePal platform to facilitate your used car transaction, TradePal will undertake to transfer to you directly for the outstanding amount due for your car.

    <a tabindex="0" class="ml-1" style="cursor: pointer"
       data-content="Reimburse any outstanding amount of money owed to you after deducting the agreed sale price for your Car with your Dealer from Item 1 above, and any other agreed ancillary costs associated with your Car’s transaction with your Dealer. Assuming no unexpected complications with this process, this outstanding amount will be reimbursed directly to your personal bank account by our participating bank(s) / financial institution(s)."
       role="button" data-toggle="popover" data-trigger="focus">
      <i class="fa fa-info-circle red "></i>
    </a>

  </p>
  <p class="font-weight-bold">Important Steps:</p>
  <p>It is important that you follow and adhere to the following these steps in the TradePal platform to facilitate the smooth processing of the reimbursement of any outstanding amount of money to you:</p>
  <p>1. Provide your Bank and Account Number:
    <a tabindex="0" class="ml-1" style="cursor: pointer"
       data-content="Provide your designated bank’s details and your bank account number for our participating bank(s) / financial institution(s) to transfer the balance payment to you. Only TradePal and our participating bank(s) / financial institution(s) will see this information."
       role="button" data-toggle="popover" data-trigger="focus">
      <i class="fa fa-info-circle red "></i>
    </a>
  </p>

  <div ng-if="dataView.StatusOri !=  '9'">

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Car Reg. No.</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.VehicleNo]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Buy-in car price</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.PriceAgreed | number : 2]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Less Deposit</label>
      <div class="col-md-9">
        <div class="text-view">[[dataView.DepositAmount | number : 2]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Less Full Settlement</label>
      <div class="col-md-9">
        <div class="text-view">[[dataView.OutstandingHirePurchaseBalance | number : 2]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Balance Amount Due to Seller</label>
      <div class="col-md-9">
<!--        <div class="text-view"> [[BalanceAmount | number : 2]]</div>-->
        <div class="text-view"> [[dataView.AmountDue | number : 2]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Dealer Advance</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.BankAmount | number : 2]]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Bank</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.CarOwnerBankName || '-']]</div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Bank Account No</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.CarOwnerBankAccountNo || '-']]</div>
      </div>
    </div>

    <div class="">

      <p>2. Set and Appointment date and Time to handover.
        <a tabindex="0" class="ml-1" style="cursor: pointer"
           data-content="Set an “Appointment Date” and a “Time of Handover” of your Car to your Dealer. Appointments can only be set on weekdays (Monday to Fridays) between 9am to 5pm based on our participating bank(s) / financial institution(s) operating hours."
           role="button" data-toggle="popover" data-trigger="focus">
          <i class="fa fa-info-circle red "></i>
        </a>
      </p>
      <p>3. Initiate Transfer of your Car Title to TP/CIMB - UEN 2019XXXXXXX Tel: 64888888
        <a tabindex="0" class="ml-1" style="cursor: pointer"
           data-content="After your Dealer has confirmed your proposed “Appointment Date” and a “Time of  Handover” of your Car via the TradePal platform, you will be asked to “Initiate Transfer of your Car’s Legal Title” via onemotoring.com to TradePal - UEN 2019XXXXXXX Tel: 648888884.  This is in consideration to TradePal for providing the financial advance to your Dealer to enable the successful completion of the transaction for the sale of your Car."
           role="button" data-toggle="popover" data-trigger="focus">
          <i class="fa fa-info-circle red "></i>
        </a>
      </p>
      <p>4. Outstanding amount due to you transfer directly to your designated Bank and account number.
        <a tabindex="0" class="ml-1" style="cursor: pointer"
           data-content="Upon confirmation of the successful transfer of your Car’s Legal Title to TradePal, our participating bank(s) / financial institution(s) will undertake to transfer the outstanding amount (Item 2 above) that is due to you directly to your designated Bank and account number."
           role="button" data-toggle="popover" data-trigger="focus">
          <i class="fa fa-info-circle red "></i>
        </a>
      </p>
      <p>5. Dealer will meet you to take over the car at the appointed Time and Date.
        <a tabindex="0" class="ml-1" style="cursor: pointer"
           data-content="Thereafter, your Dealer will meet you at the agreed “Appointment Date” and “Time of Handover” to take over the physical possession of your Car. This marks the successful completion of the transaction via the TradePal platform."
           role="button" data-toggle="popover" data-trigger="focus">
          <i class="fa fa-info-circle red "></i>
        </a>
      </p>
    </div>

  </div>
  <div ng-if=" dataView.StatusOri ==  '9' ">
    <form class="form" name="ngf2" novalidate ng-submit="CASE_FORM_AMOUNTDUE(ngf2, '<?php echo $this->session->scu_id; ?>')">


      <div class="form-group row">
        <label class="col-md-3 col-form-label">Car Reg. No.</label>
        <div class="col-md-9">
          <div class="text-view"> [[dataView.VehicleNo]]</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Buy-in car price</label>
        <div class="col-md-9">
          <div class="text-view"> [[dataView.PriceAgreed | number : 2]]</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Less Deposit</label>
        <div class="col-md-9">
          <div class="text-view">- [[dataView.DepositAmount | number : 2]]</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Less Full Settlement</label>
        <div class="col-md-9">
          <div class="text-view">- [[dataView.OutstandingHirePurchaseBalance | number : 2]]</div>
        </div>
      </div>
      
      
      
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Balance Amount Due to Seller<span class="red">*</span></label>
        <div class="col-md-6">
          <input  placeholder="Balance Amount Due to Seller " ng-model="dataForm.AmountDue" name="AmountDue" type="text" class="form-control " required>
          <div class="error text-danger" ng-show="ngf2.AmountDue.$dirty && ngf2.AmountDue.$invalid ">Please fill in information</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Dealer Advance</label>
        <div class="col-md-9">
          <div class="text-view"> [[dataView.BankAmount | number : 2]]</div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label">Bank</label>
        <div class="col-md-9">
          <div class="text-view"> [[dataView.CarOwnerBankName || '-']]</div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label">Bank Account No</label>
        <div class="col-md-9">
          <div class="text-view"> [[dataView.CarOwnerBankAccountNo || '-']]</div>
        </div>
      </div>


     


      <div class="mb-2">

        <p>2. Set and Appointment date and Time to handover.
          <a tabindex="0" class="ml-1" style="cursor: pointer"
             data-content="Set an “Appointment Date” and a “Time of Handover” of your Car to your Dealer. Appointments can only be set on weekdays (Monday to Fridays) between 9am to 5pm based on our participating bank(s) / financial institution(s) operating hours."
             role="button" data-toggle="popover" data-trigger="focus">
            <i class="fa fa-info-circle red "></i>
          </a>
        </p>
        <p>3. Initiate Transfer of your Car Title to TP/CIMB - UEN 2019XXXXXXX Tel: 64888888
          <a tabindex="0" class="ml-1" style="cursor: pointer"
             data-content="After your Dealer has confirmed your proposed “Appointment Date” and a “Time of  Handover” of your Car via the TradePal platform, you will be asked to “Initiate Transfer of your Car’s Legal Title” via onemotoring.com to TradePal - UEN 2019XXXXXXX Tel: 648888884.  This is in consideration to TradePal for providing the financial advance to your Dealer to enable the successful completion of the transaction for the sale of your Car."
             role="button" data-toggle="popover" data-trigger="focus">
            <i class="fa fa-info-circle red "></i>
          </a>
        </p>
        <p>4. Outstanding amount due to you transfer directly to your designated Bank and account number.
          <a tabindex="0" class="ml-1" style="cursor: pointer"
             data-content="Upon confirmation of the successful transfer of your Car’s Legal Title to TradePal, our participating bank(s) / financial institution(s) will undertake to transfer the outstanding amount (Item 2 above) that is due to you directly to your designated Bank and account number."
             role="button" data-toggle="popover" data-trigger="focus">
            <i class="fa fa-info-circle red "></i>
          </a>
        </p>
        <p>5. Dealer will meet you to take over the car at the appointed Time and Date.
          <a tabindex="0" class="ml-1" style="cursor: pointer"
             data-content="Thereafter, your Dealer will meet you at the agreed “Appointment Date” and “Time of Handover” to take over the physical possession of your Car. This marks the successful completion of the transaction via the TradePal platform."
             role="button" data-toggle="popover" data-trigger="focus">
            <i class="fa fa-info-circle red "></i>
          </a>
        </p>
      </div>


      <div class="text-center">

        <div class="form-action">
          <button class="btn btn-r btn-danger btn-submit " type="submit">
            SUBMIT
          </button>
        </div>

        <div style="height: 40px;"></div>

      </div>
    </form>
  </div>
</div>