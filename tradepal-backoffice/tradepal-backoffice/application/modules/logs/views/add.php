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
                        New <?php echo $page_text; ?>
                    </h3>
                    <?php $this->load->view('inc-bread.php'); ?>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <!--begin::Form-->
                        <form action="<?php echo base_url($page_url . '/submit'); ?>" method="post" id="submitForm" data-url="<?php echo base_url($page_url); ?>" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                            <input type="hidden" name="mode" value="<?php echo $act_mode; ?>" />
                            <div class="m-portlet__body">
                                <div class="bx-respone m--hides">
                                    <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="m-alert__icon">
                                            <i class="la la-clock-o"></i>
                                        </div>
                                        <div class="m-alert__text">
                                           Processing..
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" onclick="$('.bx-respone.m--hides').hide();" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>          
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Full Name
                                        </label>
                                        <input type="text" class="form-control m-input" name="full_name" placeholder="Full Name">
                                        <span class="m-form__help">
                                            Please fill your full name
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">
                                            Usernamee
                                        </label>
                                        <input type="text" class="form-control m-input" name="user_name" placeholder="Username">
                                        <span class="m-form__help">
                                            Please fill your username (use for login)
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label class="">
                                            Email
                                        </label>
                                        <input type="email" class="form-control m-input" name="email" placeholder="Email">
                                        <span class="m-form__help">
                                            Please fill your email address
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>
                                            Group:
                                        </label>
                                        <?php
                                        /* get data */
                                        $get_ulevel = $this->models->get_usertable('admin_group');
                                        ?>
                                        <select class="form-control m-input m-input--square" name="group_id" id="group_id">
                                            <option value="">Please select</option>
                                            <?php foreach($get_ulevel as $key => $row): ?>
                                                <option value="<?php echo $row['group_id']; ?>"><?php echo $row['group_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="m-form__help">
                                            Please select the group of user
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Password:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="password" name="password" class="form-control m-input" placeholder="Password">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            Please fill your password
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">
                                            Retype Password:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="password" name="password_confirmation" class="form-control m-input" placeholder="Retype Password">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            Please retype password again
                                        </span>
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
                                            <button type="reset" class="btn m-setfont__main btn-secondary" onclick="window.location.href='<?php echo base_url($page_url); ?>'">
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
