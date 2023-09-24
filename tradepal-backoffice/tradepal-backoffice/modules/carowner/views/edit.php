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
          
            <span ng-if="dataForm.SellerTypeID == 1">Individual</span>
            <span ng-if="dataForm.SellerTypeID == 2">Company</span>
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
          <div class="m-portlet" ng-init="REGISTER_SELLER_INIT( '<?php echo $edit_id; ?>' )">
            <!--begin::Form-->
            <form name="ngf" novalidate ng-submit="REGISTER_STEP_SELLER(ngf, '<?php echo $edit_id; ?>' )" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">


              <div class="m-portlet__body" style="padding: 20px; min-height: 300px">
                <div ng-if="!loading">

                <div class="row">

                  <div class="col-md-8">


                    <div class="row" ng-if="dataForm.SellerTypeID == 1">

                      <div class="form-group col-md-12">
                        <label class="col-form-label">ID Type <span class="red">*</span></label>
                        <div class="">
                          <select ng-model="dataForm.IDType" name="IDType" type="text" class="form-control custom-select" required>
                            <option value=""> -- Select ID Type --</option>
                            <option ng-repeat="item in SingaporeNRIC" value="[[item.ID]]"> [[item.Name]]</option>
                          </select>
                        </div>
                        <div class="error text-danger" ng-show="ngf.IDType.$dirty && ngf.IDType.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">ID No <span class="red">*</span></label>
                        <div class="d-flex align-items-center">
                          <div class="w-100">
                            <input placeholder="ID No" ng-model="dataForm.IDNo" name="IDNo" type="text" class="form-control" required ng-disabled="dataForm.Status == 'completed'">
                          </div>

                        </div>
                        <div class="error text-danger" ng-show="ngf.IDNo.$dirty && ngf.IDNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Name <span class="red">*</span></label>
                        <input ng-model="dataForm.Name" name="Name" type="text" class="form-control" placeholder="Name" required>
                        <div class="error text-danger" ng-show="ngf.Name.$dirty && ngf.Name.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Mobile No. <span class="red">*</span></label>
                        <input placeholder="Mobile No." ng-model="dataForm.TelephoneNo" name="TelephoneNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.TelephoneNo.$dirty && ngf.TelephoneNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="col-12"></div>

<!--                      <div class="form-group col-md-12">-->
<!--                        <label class="col-form-label"> New Password </label>-->
<!---->
<!--                        <input placeholder="Password" ng-model="dataForm.Password" name="newPassword" type="password" class="form-control" autocomplete="new-password">-->
<!--                        <div class="error text-danger" ng-show="ngf.newPassword.$dirty && ngf.newPassword.$invalid ">Please fill in information</div>-->
<!---->
<!--                      </div>-->
<!---->
<!--                      <div class="form-group col-md-12" ng-if="dataForm.Password">-->
<!--                        <label class="col-form-label">Confirm New Password <span class="red">*</span></label>-->
<!---->
<!--                        <input placeholder="Confirm Password" ng-model="dataForm.ConfirmPassword" name="ConfirmPassword" type="password" compare-to="dataForm.Password" class="form-control" required>-->
<!--                        <div class="error text-danger" ng-show="ngf.ConfirmPassword.$dirty && ngf.ConfirmPassword.$invalid ">Please fill in information</div>-->
<!---->
<!--                      </div>-->
<!--                      <div class="col-12"></div>-->

                    </div>

                    <div class="row" ng-if="dataForm.SellerTypeID == 2">


                      <div class="form-group col-md-12">
                        <label class="col-form-label">ID Type <span class="red">*</span></label>
                        <div class="">
                          <select ng-model="dataForm.IDType" name="IDType" type="text" class="form-control custom-select" required>
                            <option value=""> -- Select ID Type --</option>
                            <option ng-repeat="item in SingaporeNRIC" value="[[item.ID]]"> [[item.Name]]</option>
                          </select>
                        </div>
                        <div class="error text-danger" ng-show="ngf.IDType.$dirty && ngf.IDType.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Owner ID <span class="red">*</span></label>
                        <input ng-model="dataForm.IDNo" name="IDNo" type="text" class="form-control" placeholder="Owner ID" required>
                        <div class="error text-danger" ng-show="ngf.IDNo.$dirty && ngf.IDNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Company Name <span class="red">*</span></label>
                        <input ng-model="dataForm.Name" name="Name" type="text" class="form-control" placeholder="Company Name" required>
                        <div class="error text-danger" ng-show="ngf.Name.$dirty && ngf.Name.$invalid ">Please fill in information</div>
                      </div>

                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Telephone No. <span class="red">*</span></label>
                        <input placeholder="Telephone No." ng-model="dataForm.TelephoneNo" name="TelephoneNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.TelephoneNo.$dirty && ngf.TelephoneNo.$invalid ">Please fill in information</div>
                      </div>


                      <div class="form-group col-md-12 ">
                        <label class="col-form-label">Fax No. <span class="red">*</span></label>
                        <input placeholder="Fax No." ng-model="dataForm.FaxNo" name="FaxNo" type="text" class="form-control" required>
                        <div class="error text-danger" ng-show="ngf.FaxNo.$dirty && ngf.FaxNo.$invalid ">Please fill in information</div>
                      </div>


<!--                      <div class="col-12"></div>-->
<!---->
<!--                      <div class="form-group col-md-12">-->
<!--                        <label class="col-form-label"> New Password </label>-->
<!---->
<!--                        <input placeholder="Password" ng-model="dataForm.Password" name="newPassword" type="password" class="form-control" autocomplete="new-password">-->
<!--                        <div class="error text-danger" ng-show="ngf.newPassword.$dirty && ngf.newPassword.$invalid ">Please fill in information</div>-->
<!---->
<!--                      </div>-->
<!---->
<!--                      <div class="form-group col-md-12" ng-if="dataForm.Password">-->
<!--                        <label class="col-form-label">Confirm New Password <span class="red">*</span></label>-->
<!---->
<!--                        <input placeholder="Confirm Password" ng-model="dataForm.ConfirmPassword" name="ConfirmPassword" type="password" compare-to="dataForm.Password" class="form-control" required>-->
<!--                        <div class="error text-danger" ng-show="ngf.ConfirmPassword.$dirty && ngf.ConfirmPassword.$invalid ">Please fill in information</div>-->
<!---->
<!--                      </div>-->
<!--                      <div class="col-12"></div>-->


                    </div>


                  </div>

                  <div class="col-md-4">

                    <div class="form-group ">
                      <label class="col-form-label">Profile Image </label>


                      <div class="upload-box">

                        <div ng-if="IMG.ProfileImage.base64" class="img" style="background-image: url('data:image/png;base64,[[IMG.ProfileImage.base64]]'); height: 200px;"></div>
                        <div ng-if="!IMG.ProfileImage.base64" class="img" style="background-image: url('[[CONST.img_host]][[IMG.PImage]]'); height: 200px;"></div>
                        <input type="file" ng-model="IMG.ProfileImage" name="ProfileImage"
                               base-sixty-four-input accept="image/*">
                        <button type="button" class="btn-upload">
                          <i class="fa fa-cloud-upload"></i>
                          UPLOAD
                        </button>
                      </div>
                      <div class="error text-danger" ng-show="ngf.ProfileImage.$dirty && ngf.ProfileImage.$invalid ">Please fill in information</div>
                    </div>
                  </div>


                </div>


                <div class="row">


                  <div class="form-group col-md-6">
                    <label class="col-form-label">Postal Code <span class="red">*</span></label>

                    <div class="d-flex align-items-center">
                      <div class="w-100 mr-2">
                        <input placeholder="Postal Code" numbers-only ng-model="dataForm.PostalCode" name="PostalCode" type="text" class="form-control" required>
                      </div>
                      <div class=" ml-auto ">
                        <button type="button" class="btn btn-danger btn-o btn-form " ng-click="onPostalCode()" style="min-width: 150px">
                          <i class="fa fa-search mr-1"></i>
                          Search
                        </button>
                      </div>
                    </div>
                    <div class="error text-danger" ng-show="ngf.PostalCode.$dirty && ngf.PostalCode.$invalid ">Please fill in information</div>
                  </div>
                  <div class="col-12"></div>


                  <div class="form-group col-md-6">
                    <label class="col-form-label">Blk/Hse No <span class="red">*</span></label>
                    <input placeholder="BlkHseNo" ng-model="dataForm.BlkHseNo" name="BlkHseNo" type="text" class="form-control" required>
                    <div class="error text-danger" ng-show="ngf.BlkHseNo.$dirty && ngf.BlkHseNo.$invalid ">Please fill in information</div>
                  </div>


                  <div class="form-group col-md-6">
                    <label class="col-form-label">Street <span class="red">*</span></label>
                    <input placeholder="Street" ng-model="dataForm.Street" name="Street" type="text" class="form-control" required>
                    <div class="error text-danger" ng-show="ngf.Street.$dirty && ngf.Street.$invalid ">Please fill in information</div>
                  </div>


                  <div class="form-group col-md-6">
                    <label class="col-form-label">Unit <span class="red">*</span></label>
                    <input placeholder="Unit" ng-model="dataForm.Unit" name="Unit" type="text" class="form-control" required>
                    <div class="error text-danger" ng-show="ngf.Unit.$dirty && ngf.Unit.$invalid ">Please fill in information</div>
                  </div>


                  <div class="form-group col-md-6">
                    <label class="col-form-label">Building Name </label>
                    <input placeholder="Building Name" ng-model="dataForm.BuildingName" name="BuildingName" type="text" class="form-control">
                    <div class="error text-danger" ng-show="ngf.BuildingName.$dirty && ngf.BuildingName.$invalid ">Please fill in information</div>
                  </div>


                </div>

                <div class="row" ng-if="dataForm.SellerTypeID == 2">


                  <div class="col-12"></div>

                  <div class="form-group col-md-6 ">
                    <label class="col-form-label">Contact Name <span class="red">*</span></label>
                    <input placeholder="Contact Name" ng-model="dataForm.ContactName" name="ContactName" type="text" class="form-control" required>
                    <div class="error text-danger" ng-show="ngf.ContactName.$dirty && ngf.ContactName.$invalid ">Please fill in information</div>
                  </div>

                  <div class="form-group col-md-6 ">
                    <label class="col-form-label">Contact Mobile <span class="red">*</span></label>
                    <input placeholder="Contact Mobile" ng-model="dataForm.ContactMobile" name="ContactMobile" type="text" class="form-control" required>
                    <div class="error text-danger" ng-show="ngf.ContactMobile.$dirty && ngf.ContactMobile.$invalid ">Please fill in information</div>
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
