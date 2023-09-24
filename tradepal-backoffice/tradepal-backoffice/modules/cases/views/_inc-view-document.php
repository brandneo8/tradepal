
  <form class="form" name="ngf4" novalidate ng-submit="CASE_FORM_DOC(ngf4, '<?php echo $this->session->scu_id; ?>', 'LoanDocument')">
    
<!--    <div class="form-group row">-->
<!--      <label class="col-md-3 col-form-label"> Document 1 <span class="red">*</span></label>-->
<!--      <div class="col-md-9">-->
<!--        <input type="file" class="form-control" id="LoanDocument1" name="LoanDocument1" ng-model="dataForm.LoanDocument1">-->
<!--        <div class="error text-danger" ng-show="ngf4.LoanDocument1.$dirty && ngf4.LoanDocument1.$invalid ">Please fill in information</div>-->
<!--        <a style="padding-top: 10px; font-size: 10px;" ng-if="dataView.LoanDocument1" target="_blank" href="/uploads/loandoc/[[dataView.LoanDocument1]]">View Document</a>-->
<!--      </div>-->
<!--    </div>-->

    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 1 <span class="red">*</span></label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="LoanDocument1" name="LoanDocument1"  ng-model="dataForm.LoanDocument1"
                   onchange="angular.element(this).scope().changeFile(this,'LoanDocument1','1')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG.LoanDocument1.name && !dataView.LoanDocument1">No file chosen</div>
            <div ng-if="IMG.LoanDocument1.name">New File : [[IMG.LoanDocument1.name]]</div>
            <div ng-if="dataView.LoanDocument1">
              File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.LoanDocument1]]">[[dataView.LoanDocument1]]</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 2 </label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="LoanDocument2" name="LoanDocument2"  ng-model="dataForm.LoanDocument2"
                   onchange="angular.element(this).scope().changeFile(this,'LoanDocument2','1')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG.LoanDocument2.name && !dataView.LoanDocument2">No file chosen</div>
            <div ng-if="IMG.LoanDocument2.name">New File : [[IMG.LoanDocument2.name]]</div>
            <div ng-if="dataView.LoanDocument2">
              File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.LoanDocument2]]">[[dataView.LoanDocument2]]</a>
            </div>
          </div>
        </div>
      </div>
    </div>

   
    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 3 </label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="LoanDocument3" name="LoanDocument3"  ng-model="dataForm.LoanDocument3"
                   onchange="angular.element(this).scope().changeFile(this,'LoanDocument3','1')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG.LoanDocument3.name && !dataView.LoanDocument3">No file chosen</div>
            <div ng-if="IMG.LoanDocument3.name">New File : [[IMG.LoanDocument3.name]]</div>
            <div ng-if="dataView.LoanDocument3">
              File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.LoanDocument3]]">[[dataView.LoanDocument3]]</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 4 </label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="LoanDocument4" name="LoanDocument4"  ng-model="dataForm.LoanDocument4"
                   onchange="angular.element(this).scope().changeFile(this,'LoanDocument4','1')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG.LoanDocument4.name && !dataView.LoanDocument4">No file chosen</div>
            <div ng-if="IMG.LoanDocument4.name">New File : [[IMG.LoanDocument4.name]]</div>
            <div ng-if="dataView.LoanDocument4">
              File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.LoanDocument4]]">[[dataView.LoanDocument4]]</a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 5 </label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="LoanDocument5" name="LoanDocument5"  ng-model="dataForm.LoanDocument5"
                   onchange="angular.element(this).scope().changeFile(this,'LoanDocument5','1')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG.LoanDocument5.name && !dataView.LoanDocument5">No file chosen</div>
            <div ng-if="IMG.LoanDocument5.name">New File : [[IMG.LoanDocument5.name]]</div>
            <div ng-if="dataView.LoanDocument5">
              File : <a target="_blank" href="[[CONST.img_host]]/uploads/loandoc/[[dataView.LoanDocument5]]">[[dataView.LoanDocument5]]</a>
            </div>
          </div>
        </div>
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



