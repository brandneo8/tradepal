<div ng-if="dataView.StatusOri >=  '21'">

  <strong style="font-size: 18px;"> Money transferred to car owner  : </strong>
  <div style="height: 20px;"></div>



  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Money transferred to car owner  </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.MoneyTransferredCarOwner | number: 2 ]]</div>
    </div>
  </div>

  
  
  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Date </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.MoneyTransferredDate | date : 'dd MMM yyyy' ]]</div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Time </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.MoneyTransferredTime || '-']]</div>
    </div>
  </div>

  
  

</div>



<div ng-if="dataView.StatusOri ==  '20' ">
  <form class="form" name="ngf2" novalidate ng-submit="CASE_MONEY_TRANSFERRED(ngf2, '<?php echo $this->session->scu_id; ?>')">


    <div class="form-group row" >
      <label class="col-md-3 col-form-label">Money transferred to car owner</label>
      <div class="col-md-9">
        <input placeholder="Money transferred to car owner" ng-model="dataForm.MoneyTransferredCarOwner" name="MoneyTransferredCarOwner" required type="text" class="form-control ">
        <div class="error text-danger" ng-show="ngf2.MoneyTransferredCarOwner.$dirty && ngf2.MoneyTransferredCarOwner.$invalid ">Please fill in information</div>
      </div>
    </div>
    
    <div class="form-group row">
      <label class="col-md-3 col-form-label"> Date </label>
      <div class="col-md-9">
        [[dataForm.MoneyTransferredDate | date : 'dd MMM yyyy']]
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-3 col-form-label"> Time

      </label>
      <div class="col-md-9">
        <div class="">
          [[dataForm.MoneyTransferredTime]]
        </div>
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


</div>



