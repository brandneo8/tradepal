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
	
		<!-- END: Subheader -->
		<div class="m-content">
      <div class="page-noti" ng-init="getNoti(0)">
        <div class="heading"> Notification</div>
        <div class="accordion accordion-step" id="accordions" ng-if="dataTable.length > 0">
          <div class="card" ng-repeat="item in dataTable" ng-class="{ active : item.read == '0' }">
            <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC[[$index + 1]]" ng-click="readNoti(item, $index)">
              <div class="d-flex align-items-center">
                <div class="img pr-4">
                  <img src="/images/logoT.png" alt="" style="height: 40px;">
                </div>
                <div class="">
                  <h2>
                    [[item.Subject]]
                  </h2>

                  <p>[[item.INS | dateTimeFormat]]</p>
                </div>
              </div>

            </div>
            <div id="SEC[[$index + 1]]" class="collapse " data-parent="#accordions" >
              <div class="card-body">
                [[item.Detail]]
              
              </div>
            </div>
          </div>

        </div>

        <div class="card" ng-if="dataTable.length == 0">
          <div class="card-body"></div>
        </div>
      </div>
		</div>
	</div>
</div>
<!-- end:: Body -->
