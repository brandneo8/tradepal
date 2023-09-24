<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
            <?php echo SITENAME; ?> -  เข้าสู่ระบบ
		</title>
		<meta name="description" content="Backoffice System">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex">
    
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Prompt:300,400,500,600,700","Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
		<link href="<?php echo base_url('assets/vendors/base/vendors.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/demo/default/base/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<!-- <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico'); ?>" /> -->
	</head>
	<!-- end::Head -->
	<!-- end::Body -->
	<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
					<div class="m-stack m-stack--hor m-stack--desktop">
						<div class="m-stack__item m-stack__item--fluid">
							<div class="m-login__wrapper">
								<div class="m-login__logo">
									<a href="<?php echo base_url(); ?>">
										<img src="<?php echo base_url('assets/img/logo.png'); ?>" style="max-width: 120px;">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head">
										<h3 class="m-login__title">
											Sign In To Admin
										</h3>
									</div>
									<form class="m-login__form m-form" id="loginProcess" action="<?php echo base_url('login/auth'); ?>" method="post" autocomplete="off" data-baseurl="<?php echo base_url(); ?>">
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="text" placeholder="Username" name="sch_user" autocomplete="off" style="padding-left: 10px; padding-right: 10px;">
										</div>
										<div class="form-group m-form__group">
											<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="sch_password" style="padding-left: 10px; padding-right: 10px;">
										</div>
										<div class="row m-login__form-sub">
											<div class="col m--align-left">
												<label class="m-checkbox m-checkbox--focus">
													<input type="checkbox" name="remember">
													Remember me
													<span></span>
												</label>
											</div>
											<div class="col m--align-right">
												
											</div>
										</div>
										<div class="m-login__form-action">
											<button id="m_login_signin_submit" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air">
												Sign In
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(<?php echo base_url('assets/img/bg1.jpg'); ?>);">
					<div class="m-grid__item m-grid__item--middle">
						<h3 class="m-login__welcome"></h3>
						<p class="m-login__msg"></p>
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
    	<!--begin::Base Scripts -->
		<script src="<?php echo base_url('assets/vendors/base/vendors.bundle.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/demo/default/base/scripts.bundle.js'); ?>" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
		<script src="<?php echo base_url('assets/snippets/custom/pages/user/login.js'); ?>" type="text/javascript"></script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>