
  <form class="form" name="ngf8" novalidate ng-submit="CASE_FORM_DOC(ngf8, '<?php echo $this->session->scu_id; ?>', 'FinalLoanDocument')">
    


    <div class="form-group row">
      <label class="col-md-3  col-form-label"> Document 1 <span class="red">*</span></label>
      <div class="col-md-9">
        <div class="btn-uploads-wrap d-flex align-items-center">
          <div class="btn-uploads">
            <button type="button" class="btn">Choose File</button>
            <input input-file type="file" id="FinalLoanDocument1" name="FinalLoanDocument1"  ng-model="dataForm.FinalLoanDocument1"
                   onchange="angular.element(this).scope().changeFile(this,'FinalLoanDocument1','2')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG2.FinalLoanDocument1.name && !dataView.FinalLoanDocument1">No file chosen</div>
            <div ng-if="IMG2.FinalLoanDocument1.name">New File : [[IMG2.FinalLoanDocument1.name]]</div>
            <div ng-if="dataView.FinalLoanDocument1">
              File : <a target="_blank" href="[[CONST.api_local]]/uploads/loandoc/[[dataView.FinalLoanDocument1]]">[[dataView.FinalLoanDocument1]]</a>
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
            <input input-file type="file" id="FinalLoanDocument2" name="FinalLoanDocument2"  ng-model="dataForm.FinalLoanDocument2"
                   onchange="angular.element(this).scope().changeFile(this,'FinalLoanDocument2','2')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG2.FinalLoanDocument2.name && !dataView.FinalLoanDocument2">No file chosen</div>
            <div ng-if="IMG2.FinalLoanDocument2.name">New File : [[IMG2.FinalLoanDocument2.name]]</div>
            <div ng-if="dataView.FinalLoanDocument2">
              File : <a target="_blank" href="[[CONST.api_local]]/uploads/loandoc/[[dataView.FinalLoanDocument2]]">[[dataView.FinalLoanDocument2]]</a>
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
            <input input-file type="file" id="FinalLoanDocument3" name="FinalLoanDocument3"  ng-model="dataForm.FinalLoanDocument3"
                   onchange="angular.element(this).scope().changeFile(this,'FinalLoanDocument3','2')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG2.FinalLoanDocument3.name && !dataView.FinalLoanDocument3">No file chosen</div>
            <div ng-if="IMG2.FinalLoanDocument3.name">New File : [[IMG2.FinalLoanDocument3.name]]</div>
            <div ng-if="dataView.FinalLoanDocument3">
              File : <a target="_blank" href="[[CONST.api_local]]/uploads/loandoc/[[dataView.FinalLoanDocument3]]">[[dataView.FinalLoanDocument3]]</a>
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
            <input input-file type="file" id="FinalLoanDocument4" name="FinalLoanDocument4"  ng-model="dataForm.FinalLoanDocument4"
                   onchange="angular.element(this).scope().changeFile(this,'FinalLoanDocument4','2')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG2.FinalLoanDocument4.name && !dataView.FinalLoanDocument4">No file chosen</div>
            <div ng-if="IMG2.FinalLoanDocument4.name">New File : [[IMG2.FinalLoanDocument4.name]]</div>
            <div ng-if="dataView.FinalLoanDocument4">
              File : <a target="_blank" href="[[CONST.api_local]]/uploads/loandoc/[[dataView.FinalLoanDocument4]]">[[dataView.FinalLoanDocument4]]</a>
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
            <input input-file type="file" id="FinalLoanDocument5" name="FinalLoanDocument5"  ng-model="dataForm.FinalLoanDocument5"
                   onchange="angular.element(this).scope().changeFile(this,'FinalLoanDocument5','2')" >
          </div>
          <div class="file-desc">
            <div ng-if="!IMG2.FinalLoanDocument5.name && !dataView.FinalLoanDocument5">No file chosen</div>
            <div ng-if="IMG2.FinalLoanDocument5.name">New File : [[IMG2.FinalLoanDocument5.name]]</div>
            <div ng-if="dataView.FinalLoanDocument5">
              File : <a target="_blank" href="[[CONST.api_local]]/uploads/loandoc/[[dataView.FinalLoanDocument5]]">[[dataView.FinalLoanDocument5]]</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div style="height: 30px;"></div>

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
  



