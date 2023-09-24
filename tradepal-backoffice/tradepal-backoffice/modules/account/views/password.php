
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
                        <?php echo $page_text; ?>
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
                            <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
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
                                            Username
                                        </label>
                                        <input type="text" class="form-control m-input" name="full_name" placeholder="Username" value="<?php echo ($this->session->userdata('scu_firstname') == '' ? $this->session->userdata('scu_firstname') : $this->session->userdata('scu_firstname')); ?>" disabled="disabled">
                                        <span class="m-form__help">
                                            You can not change username
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>
                                            Current Password:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="password" name="old_password" class="form-control m-input" placeholder="Current Password">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            Please fill your current password
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            New Password:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="password" name="new_password" class="form-control m-input" placeholder="New Password">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            Please fill your new password
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">
                                            Retype new Password:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="password" name="new_password2" class="form-control m-input" placeholder="Retype new Password">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            Please retype your new password
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
                                            <button type="reset" class="btn m-setfont__main btn-secondary">
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