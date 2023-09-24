

<div ng-if="dataView.StatusOri !=  '4'">
  <div class="form-group row">
    <label class="col-md-3 col-form-label">Deposit by</label>
    <div class="col-md-9">
      [[dataView.HPDepositType || '-']]
    </div>
  </div>

  <div class="form-group row" ng-if="dataForm.HPDepositType == 'cheque' ">
    <label class="col-md-3 col-form-label">Cheque No.</label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HPChequeNo | number : 2 || '-']]</div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 col-form-label">Hire Purchase Amount</label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HPAmount | number : 2 ]]</div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 col-form-label">Balance Due</label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HPBalanceDue || '-']]</div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 col-form-label">Vechice will be delivered on</label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HPDeliveredOn || '-']]</div>
    </div>
  </div>

</div>
<div ng-if=" dataView.StatusOri ==  '4' ">
  <form class="form" name="ngf2" novalidate ng-submit="CASE_FORM_HP(ngf2, '<?php echo $this->session->scu_id; ?>')">
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Deposit by <span class="red">*</span></label>
      <div class="col-md-9">
        <div class="">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadio1" name="HPDepositType" class="custom-control-input" ng-model="dataForm.HPDepositType" value="cash">
            <label class="custom-control-label" for="customRadio1">Cash</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadio2" name="HPDepositType" class="custom-control-input" ng-model="dataForm.HPDepositType" value="cheque">
            <label class="custom-control-label" for="customRadio2">Cheque</label>
          </div>
        </div>
        <div class="error text-danger" ng-show="ngf2.HPDepositType.$dirty && ngf2.HPDepositType.$invalid ">Please fill in information</div>

      </div>
    </div>

    <div class="form-group row" ng-if="dataForm.HPDepositType == 'cheque' ">
      <label class="col-md-3 col-form-label">Cheque No.</label>
      <div class="col-md-9">
        <input placeholder="Cheque No" ng-model="dataForm.HPChequeNo" name="HPChequeNo" type="text" class="form-control ">
        <div class="error text-danger" ng-show="ngf2.HPChequeNo.$dirty && ngf2.HPChequeNo.$invalid ">Please fill in information</div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Hire Purchase Amount <span class="red">*</span></label>
      <div class="col-md-9">
        <input numbers-only placeholder="Hire Purchase Amount" ng-model="dataForm.HPAmount" name="HPAmount" type="text" class="form-control " required>
        <div class="error text-danger" ng-show="ngf2.HPAmount.$dirty && ngf2.HPAmount.$invalid ">Please fill in information</div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Balance Due <span class="red">*</span></label>
      <div class="col-md-9">
        <input numbers-only placeholder="Balance Due " ng-model="dataForm.HPBalanceDue" name="HPBalanceDue" type="text" class="form-control " required>
        <div class="error text-danger" ng-show="ngf2.HPBalanceDue.$dirty && ngf2.HPBalanceDue.$invalid ">Please fill in information</div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Vechice will be delivered on <span class="red">*</span></label>
      <div class="col-md-9">
        <input placeholder="Vechice will be delivered on" ng-model="dataForm.HPDeliveredOn" name="HPDeliveredOn" type="text" class="form-control " required>
        <div class="error text-danger" ng-show="ngf2.HPDeliveredOn.$dirty && ngf2.HPDeliveredOn.$invalid ">Please fill in information</div>
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-3 col-form-label"></label>
      <div class="col-md-9">
        <div class="form-action">
          <button class="btn btn-r btn-danger btn-submit " type="submit">
            SUBMIT
          </button>
        </div>

        <div style="height: 40px;"></div>
      </div>
    </div>
  </form>
</div>