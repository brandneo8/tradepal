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
            Dealer Detail
          </h3>
					<?php $this->load->view('inc-bread.php', ['dealer_name' => ' Dealer Detail']); ?>
        </div>
      </div>

    </div>
    <!-- END: Subheader -->
    <div class="m-content">
      <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
          <!--begin: Search Form -->

          <!--          --><?php // print_r($info_data); ?>


          <div class="form-group row">
            <label class="col-md-2 col-form-label">Company Name</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['CompanyName']; ?></div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label">Company Registertion No.</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['CompanyRegistertionNo']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Company Email</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['CompanyEmail']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Postal Code</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['Poscode']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Blk/Hse No</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['BlockHouseNo']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Street</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['Street']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Unit</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['Unit']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Building Name</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['BuildingName']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Use Foreign Add</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['UseForeignAdd']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Mobile Number</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['MobileNo']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Telephone No.</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['TelHome']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Fax No.</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['FaxNo']; ?></div>
            </div>
          </div>


          <div class="form-group row" ng-init="initLightGallery('lightgallery')">
            <label class="col-md-2 col-form-label"> Image</label>
            <div class="col-md-9">

              <div class="row list-img" id="lightgallery">
								<?php if (!empty($info_data['Logo'])) : ?>
                  <div class="col-6 col-sm-4 col-md-4">
                    <a href="<?php echo $info_data['Logo']; ?>" class="light-link" data-sub-html="Logo">
                      <div class="item">
                        <div class="img-view" style="max-height: 200px !important">
                          <img ng-src="<?php echo $info_data['Logo']; ?>" alt="">
                        </div>
                        <div class="label">Logo</div>
                      </div>
                    </a>
                  </div>
								<?php endif; ?>
								<?php if (!empty($info_data['Icon'])) : ?>
                  <div class="col-6 col-sm-4 col-md-4">
                    <a href="<?php echo $info_data['Icon']; ?>" class="light-link" data-sub-html="Icon'">

                      <div class="item">
                        <div class="img-view" style="max-height: 200px !important">
                          <img ng-src="<?php echo $info_data['Icon']; ?>" alt="">
                        </div>
                        <div class="label">Icon</div>
                      </div>
                    </a>

                  </div>
								<?php endif; ?>

              </div>


            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>
<!-- end:: Body -->
