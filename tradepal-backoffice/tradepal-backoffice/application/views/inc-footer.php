<!-- begin::Footer -->
<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								<?php echo COPYNAME; ?>
							</span>
						</div>
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
		</div>
		<!-- end:: Page -->
        
        <!--begin::Page Resources -->
		<script src="<?php echo base_url('assets/demo/default/custom/header/actions.js'); ?>" type="text/javascript"></script>
        <!--end::Page Resources -->
        <!--begin::Page Vendors -->
		<script src="<?php echo base_url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js'); ?>" type="text/javascript"></script>
		<!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
		<script src="<?php echo base_url('assets/app/js/dashboard.js'); ?>" type="text/javascript"></script>
		<!--end::Page Snippets -->
		<!--begin::custom load -->
		<?php echo $js; ?>

<!--<script src="https://tradepal.sg/assets/js/vendor-site.js" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/libs/angular/angular.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/libs/lightgallery/js/lightgallery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/libs/angular-base64-upload/dist/angular-base64-upload.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/libs/app.js'); ?>" type="text/javascript"></script>

		<!--end::custom load -->
	</body>
	<!-- end::Body -->
</html>