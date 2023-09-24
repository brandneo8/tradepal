<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
	<!-- BEGIN: Left Aside -->
	<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn">
		<i class="la la-close"></i>
	</button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">
		<?php $this->load->view('inc-menu');?>
	</div>
	<!-- END: Left Aside -->
	<div class="m-grid__item m-grid__item--fluid m-wrapper">
		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title ">
						Dashboard
					</h3>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->

		<!-- END: Subheader -->
		<div class="m-content">
			<!--begin:: Widgets/Stats-->
			<div class="m-portlet ">
				<div class="m-portlet__body  m-portlet__body--no-padding">
					<div class="row m-row--no-padding m-row--col-separator-xl">

<!--						<div class="col-md-12 col-lg-6 col-xl-4">-->
<!--							<!--begin::Total Profit-->
<!--							<div class="m-widget24">-->
<!--								<div class="m-widget24__item">-->
<!--									<h3 class="m-widget24__title">-->
<!--										Partners-->
<!--									</h3>-->
<!--									<br>-->
<!--									<span class="m-widget24__desc">-->
<!--										All partners in system-->
<!--									</span>-->
<!--									<span class="m-widget24__stats m--font-brand">-->
<!--										--><?php //// echo $get_data = $this->db->count_all_results('partners'); ?>
<!--									</span>-->
<!--									<div class="m--space-30"></div>-->
<!--									<div class="m-widget24__desc">-->
<!--										<a href="--><?php //echo base_url('members'); ?><!--" class="btn btn-outline-primary m-btn m-btn--outline-2x">Go to Manage</a>-->
<!--									</div>-->
<!--									<div class="m--space-30"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!--end::Total Profit-->
<!--						</div>-->
<!---->
<!--						<div class="col-md-12 col-lg-6 col-xl-4">-->
<!--							<!--begin::Total Profit-->
<!--							<div class="m-widget24">-->
<!--								<div class="m-widget24__item">-->
<!--									<h3 class="m-widget24__title">-->
<!--										Agent-->
<!--									</h3>-->
<!--									<br>-->
<!--									<span class="m-widget24__desc">-->
<!--										All agent in system-->
<!--									</span>-->
<!--									<span class="m-widget24__stats m--font-brand">-->
<!--										--><?php //// echo $get_data = $this->db->count_all_results('agents'); ?>
<!--									</span>-->
<!--									<div class="m--space-30"></div>-->
<!--									<div class="m-widget24__desc">-->
<!--										<a href="--><?php //echo base_url('agents'); ?><!--" class="btn btn-outline-primary m-btn m-btn--outline-2x">Go to Manage</a>-->
<!--									</div>-->
<!--									<div class="m--space-30"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!--end::Total Profit-->
<!--						</div>-->
<!---->
<!--						<div class="col-md-12 col-lg-6 col-xl-4">-->
<!--							<!--begin::Total Profit-->
<!--							<div class="m-widget24">-->
<!--								<div class="m-widget24__item">-->
<!--									<h3 class="m-widget24__title">-->
<!--										Members-->
<!--									</h3>-->
<!--									<br>-->
<!--									<span class="m-widget24__desc">-->
<!--										All member in system-->
<!--									</span>-->
<!--									<span class="m-widget24__stats m--font-brand">-->
<!--										--><?php //// echo $get_data = $this->db->count_all_results('members'); ?>
<!--									</span>-->
<!--									<div class="m--space-30"></div>-->
<!--									<div class="m-widget24__desc">-->
<!--										<a href="--><?php //echo base_url('members'); ?><!--" class="btn btn-outline-primary m-btn m-btn--outline-2x">Go to Manage</a>-->
<!--									</div>-->
<!--									<div class="m--space-30"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!--end::Total Profit-->
<!--						</div>-->

					</div>
				</div>
			</div>
			<!--end:: Widgets/Stats-->

		</div>
	</div>
</div>
<!-- end:: Body -->