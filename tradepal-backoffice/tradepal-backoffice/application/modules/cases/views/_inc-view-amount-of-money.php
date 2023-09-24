<!--<div ng-if="dataView.StatusOri !=  '6'">-->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Signed full settlement</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view" ng-if="dataView.SignedFullSettlement">-->
<!--        <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.SignedFullSettlement | trustSrc]]">[[dataView.SignedFullSettlement]]</a>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Front ID photo</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view" ng-if="dataView.FrontIDPhoto">-->
<!--        <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.FrontIDPhoto | trustSrc]]">[[dataView.FrontIDPhoto]]</a>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Back ID photo</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view" ng-if="dataView.BackIDPhoto">-->
<!--        <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.BackIDPhoto | trustSrc]]">[[dataView.BackIDPhoto]]</a>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Buy-in car price</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view"> [[dataView.PriceAgreed | number : 2 || '-']]</div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Advance requested</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view"> [[dataView.LoanRequested | number : 2 || '-']]</div>-->
<!--    </div>-->
<!--  </div>-->
<!--  -->
<!--  <div class="form-group row">-->
<!--    <label class="col-md-3 col-form-label">Amount</label>-->
<!--    <div class="col-md-9">-->
<!--      <div class="text-view"> [[dataView.BankAmount | number : 2 || '-']]</div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!--<div ng-if="dataView.StatusOri ==  '6'">-->
  <form class="form" name="ngf3" novalidate ng-submit="CASE_FORM_BANKAMOUNT(ngf3, '<?php echo $this->session->scu_id; ?>')">

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Signed full settlement</label>
      <div class="col-md-9">
        <div class="text-view" ng-if="dataView.SignedFullSettlement">
          <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.SignedFullSettlement | trustSrc]]">[[dataView.SignedFullSettlement]]</a>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Front ID photo</label>
      <div class="col-md-9">
        <div class="text-view" ng-if="dataView.FrontIDPhoto">
          <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.FrontIDPhoto | trustSrc]]">[[dataView.FrontIDPhoto]]</a>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Back ID photo</label>
      <div class="col-md-9">
        <div class="text-view" ng-if="dataView.BackIDPhoto">
          <a target="_blank" href="[[CONST.img_host + '/uploads/files/' + dataView.BackIDPhoto | trustSrc]]">[[dataView.BackIDPhoto]]</a>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Buy-in car price</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.PriceAgreed | number : 2 || '-']]</div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3 col-form-label">Advance requested</label>
      <div class="col-md-9">
        <div class="text-view"> [[dataView.LoanRequested | number : 2 || '-']]</div>
      </div>
    </div>
    
    <div class="form-group row">
      <label class="col-md-3 col-form-label"> Amount <span class="red">*</span></label>
      <div class="col-md-9">
        <input numbers-only placeholder="Amount" ng-model="dataForm.BankAmount" name="BankAmount" type="text" class="form-control " required>
        <div class="error text-danger" ng-show="ngf3.BankAmount.$dirty && ngf3.BankAmount.$invalid ">Please fill in information</div>
      </div>
    </div>
    
    <div class="form-group row">
      <label class="col-md-3 col-form-label"></label>
      <div class="col-md-9">
        <div class="form-action">
          <button class="btn btn-r btn-danger btn-submit " type="submit">
            SAVE
          </button>
        </div>

        <div style="height: 40px;"></div>
      </div>
    </div>
    
  </form>
<!--</div>-->


