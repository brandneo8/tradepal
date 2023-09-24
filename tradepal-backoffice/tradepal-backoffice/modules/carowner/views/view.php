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
            Car Owner Detail
          </h3>
					<?php $this->load->view('inc-bread.php', ['dealer_name' => ' Car Owner Detail']); ?>
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
            <label class="col-md-2 col-form-label">Type</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['SellerTypeID'] == 1 ? 'INDIVIDUAL' : 'COMPANY'; ?></div>
            </div>
          </div>
					
					<?php if ($info_data['SellerTypeID'] == 1): ?>
            <div class="form-group row">
              <label class="col-md-2 col-form-label">ID Type</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['IDType']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label"> ID No</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['IDNo']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label"> Name</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['Name']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label"> Mobile No.</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['TelephoneNo']; ?></div>
              </div>
            </div>
					<?php endif; ?>
					
					<?php if ($info_data['SellerTypeID'] == 2): ?>
            <div class="form-group row">
              <label class="col-md-2 col-form-label"> ID Type</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['IDType']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label"> Owner ID</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['IDNo']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label"> Company Name</label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['Name']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label">Telephone No. </label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['TelephoneNo']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label">Fax No. </label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['FaxNo']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label">Contact Name </label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['ContactName']; ?></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label">Contact Mobile </label>
              <div class="col-md-9">
                <div class="text-view">  <?php echo $info_data['ContactMobile']; ?></div>
              </div>
            </div>
					
					<?php endif; ?>


          <div class="form-group row">
            <label class="col-md-2 col-form-label"> Postal Code</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['PostalCode']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label"> Blk/Hse No</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['BlkHseNo']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Street </label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['Street']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label"> Unit</label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['Unit']; ?></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2 col-form-label">Building Name </label>
            <div class="col-md-9">
              <div class="text-view">  <?php echo $info_data['BuildingName']; ?></div>
            </div>
          </div>


          <div class="form-group row" ng-init="initLightGallery('lightgallery')">
            <label class="col-md-2 col-form-label">Profile Image</label>
            <div class="col-md-9">

              <div class="row list-img" id="lightgallery">
                <?php if ($info_data['ProfileImage']) : ?>
                <div class="col-6 col-sm-4 col-md-4">
                  <a href="<?php echo $info_data['ProfileImage']; ?>" class="light-link" data-sub-html="Profile Image">

                    <div class="item">
                      <div class="img-view" style="max-height: 200px !important">
                        <img ng-src="<?php echo $info_data['ProfileImage']; ?>" alt="">
                      </div>
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
