<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
  <!-- BEGIN: Left Aside -->
  <button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
  </button>
  <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">
    <!-- BEGIN: Aside Menu -->
		<?php $this->load->view('inc-menu'); ?>
    <!-- END: Aside Menu -->
  </div>
  <!-- END: Left Aside -->
  <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
      <div class="d-flex align-items-center">
        <div class="mr-auto">
          <h3 class="m-subheader__title m-setfont__main m-subheader__title--separator">
            Edit <?php echo $page_text; ?>

            <span > [[is_staff ? 'Staff' : '' ]]</span>

          </h3>
					<?php $this->load->view('inc-bread.php'); ?>
        </div>
      </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
      <div class="row">
        <div class="col-lg-12">

          <div class="loading-wrap" ng-show="loading">
            <div class="loading"></div>
          </div>


          <!--begin::Portlet-->
          <div class="m-portlet" ng-init="INFO_DEALER_INIT( '<?php echo $edit_id; ?>' )">
            <!--begin::Form-->
            <form name="ngf" novalidate ng-submit="INFO_DEALER(ngf, '<?php echo $edit_id; ?>' )" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">


              <div class="m-portlet__body" style="padding: 20px; min-height: 300px">
                <div ng-if="!loading">

                  <div ng-if="!is_staff">

                    <div class="row">

                      <div class="form-group col-md-6">
                        <label class="col-form-label">Company Name <span class="red">*</span></label>
                        <input ng-model="dataForm.CompanyName" name="CompanyName" type="text" class="form-control" placeholder="Company Name" required>
                        <div class="error text-danger" ng-show="ngf.CompanyName.$dirty && ngf.CompanyName.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Company Registertion No. <span class="red">*</span></label>
                        <input placeholder="UEN" ng-model="dataForm.CompanyRegistertionNo" name="CompanyRegistertionNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.CompanyRegistertionNo.$dirty && ngf.CompanyRegistertionNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Company Email <span class="red">*</span></label>
                        <input placeholder="CompanyEmail" ng-model="dataForm.CompanyEmail" name="CompanyEmail" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.CompanyEmail.$dirty && ngf.CompanyEmail.$invalid ">Please fill in information</div>
                      </div>


                      <div class="col-12"></div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Postal Code <span class="red">*</span></label>
                        <div class="d-flex align-items-center">
                          <div class="w-100 mr-2">
                            <input placeholder="Postal Code" numbers-only ng-model="dataForm.Poscode" name="Poscode" type="text" class="form-control" required>
                          </div>
                          <div class=" ml-auto ">
                            <button type="button" class="btn btn-danger btn-o btn-form " ng-click="onPoscode()" style="min-width: 130px">
                              <i class="fa fa-search mr-1"></i>
                              Search
                            </button>
                          </div>
                        </div>
                        <div class="error text-danger" ng-show="ngf.Poscode.$dirty && ngf.Poscode.$invalid ">Please fill in information</div>
                      </div>

                      <div class="col-12"></div>

                      <div class="form-group col-md-6">
                        <label class="col-form-label">Blk/Hse No <span class="red">*</span></label>
                        <input placeholder="BlkHseNo" ng-model="dataForm.BlockHouseNo" name="BlockHouseNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.BlockHouseNo.$dirty && ngf.BlockHouseNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Street <span class="red">*</span></label>
                        <input placeholder="Street" ng-model="dataForm.Street" name="Street" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.Street.$dirty && ngf.Street.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Unit </label>
                        <input placeholder="Unit" ng-model="dataForm.Unit" name="Unit" type="text" class="form-control">
                        <div class="error text-danger" ng-show="ngf.Unit.$dirty && ngf.Unit.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Building Name </label>
                        <input placeholder="Building Name" ng-model="dataForm.BuildingName" name="BuildingName" type="text" class="form-control">
                        <div class="error text-danger" ng-show="ngf.BuildingName.$dirty && ngf.BuildingName.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Use Foreign Add </label>
                        <input placeholder="Use Foreign Add" ng-model="dataForm.UseForeignAdd" name="UseForeignAdd" type="text" class="form-control">
                        <div class="error text-danger" ng-show="ngf.UseForeignAdd.$dirty && ngf.UseForeignAdd.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6">
                        <label class="col-form-label">Mobile Number <span class="red">*</span></label>
                        <input placeholder="Mobile Number" ng-model="dataForm.MobileNo" name="MobileNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.MobileNo.$dirty && ngf.MobileNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6 ">
                        <label class="col-form-label">Telephone No. <span class="red">*</span></label>
                        <input placeholder="Telephone No." ng-model="dataForm.TelHome" name="TelHome" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.TelHome.$dirty && ngf.TelHome.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-6 ">
                        <label class="col-form-label">Fax No. <span class="red">*</span></label>
                        <input placeholder="Fax No." ng-model="dataForm.FaxNo" name="FaxNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.FaxNo.$dirty && ngf.FaxNo.$invalid ">Please fill in information</div>
                      </div>


                    </div>
                    
                    <div class="row">

                      <div class="form-group  col-md-6">
                        <label class="col-form-label">Dealer Logo</label>
                        <div class="upload-box">
                          <div ng-if="IMG.DealerLogo.base64" class="img" style="background-image: url('data:image/png;base64,[[IMG.DealerLogo.base64]]'); height: 200px;"></div>
                          <div ng-if="!IMG.DealerLogo.base64" class="img" style="background-image: url('[[CONST.img_host]][[IMG.Logo]]'); height: 200px;"></div>
                          <input type="file" ng-model="IMG.DealerLogo" name="DealerLogo" base-sixty-four-input accept="image/*">
                          <button type="button" class="btn-upload"><i class="fa fa-cloud-upload"></i> UPLOAD</button>
                        </div>

                        <div class="error text-danger" ng-show="ngf.DealerLogo.$dirty && ngf.DealerLogo.$invalid ">Please fill in information</div>
                      </div>

                      <div class="form-group col-md-6">
                        <label class="col-form-label">Icon </label>
                        <div class="upload-box">
                          <div ng-if="IMG.Icon.base64" class="img" style="background-image: url('data:image/png;base64,[[IMG.Icon.base64]]'); height: 200px;"></div>
                          <div ng-if="!IMG.Icon.base64" class="img" style="background-image: url('[[CONST.img_host]][[IMG.IconShow]]'); height: 200px;"></div>
                          <input type="file" ng-model="IMG.Icon" name="Icon" base-sixty-four-input accept="image/*">
                          <button type="button" class="btn-upload"><i class="fa fa-cloud-upload"></i> UPLOAD</button>
                        </div>
                        <div class="error text-danger" ng-show="ngf.Icon.$dirty && ngf.Icon.$invalid ">Please fill in information</div>
                      </div>


                    </div>
                    
                  </div>
                  <div ng-if="is_staff">

                    <div class="row" >

                      <div class="col-md-8">
                        <div class="form-row">
                        
                          <div class="form-group col-md-12">
                            <label class="col-form-label">Full Name <span class="red">*</span></label>
                            <input ng-model="dataForm.CompanyName" name="FullName" type="text" class="form-control" placeholder="Full Name " required>
                            <div class="error text-danger" ng-show="ngf.FullName.$dirty && ngf.FullName.$invalid ">Please fill in information</div>
                          </div>


                          <div class="form-group col-md-12">
                            <label class="col-form-label">Mobile <span class="red">*</span></label>

                            <input placeholder="Mobile" ng-model="dataForm.MobileNo" name="Mobile" type="text" class="form-control" required>
                            <div class="error text-danger" ng-show="ngf.Mobile.$dirty && ngf.Mobile.$invalid ">Please fill in information</div>

                          </div>
                          <div class="col-12"></div>

                         
                          <div class="form-group col-md-12">
                            <label class="col-form-label">Email <span class="red">*</span></label>
                            <input placeholder="CompanyEmail" ng-model="dataForm.Email" name="Email" type="text" class="form-control" disabled>
                            <div class="error text-danger" ng-show="ngf.Email.$dirty && ngf.Email.$invalid ">Please fill in information</div>
                          </div>
                          <div class="col-12"></div>






                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group ">
                          <label class="col-form-label">Profile image<span class="red">*</span></label>
                          <div class="upload-box">
                            <div ng-if="IMG.Logo.base64" class="img" style="background-image: url('data:image/png;base64,[[IMG.Logo.base64]]'); height: 200px;"></div>
                            <div ng-if="!IMG.Logo.base64" class="img" style="background-image: url('[[CONST.img_host]][[IMG.Logo]]'); height: 200px;"></div>
                            <input type="file" ng-model="IMG.Logo" name="Logo" base-sixty-four-input accept="image/*">
                            <button type="button" class="btn-upload"><i class="fa fa-cloud-upload"></i> UPLOAD</button>
                          </div>

                          <div class="error text-danger" ng-show="ngf.Logo.$dirty && ngf.Logo.$invalid ">Please fill in information</div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions--solid">
                  <div class="row">
                    <div class="col-lg-12">
                      <button type="submit" class="btn m-setfont__main btn-success">
                        Save
                      </button>
                      <button type="button" class="btn m-setfont__main btn-secondary" onclick="window.location.href='<?php echo base_url($page_url); ?>'">
                        Cancel
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!--end::Form-->
          </div>
          <!--end::Portlet-->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end:: Body -->
