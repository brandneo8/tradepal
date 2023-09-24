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
                        <form action="<?php echo base_url($page_url . '/submit'); ?>" method="post" id="submitForm" data-url="<?php echo base_url($page_url . '/edit/' . $edit_id); ?>" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
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
                                            Subject
                                        </label>
                                        <input type="text" class="form-control m-input" name="NotiSubject" placeholder="Subject" value="<?php echo $info_data['NotiSubject']; ?>">
                                        <span class="m-form__help">
                                            Please fill the subject
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Detail
                                        </label>
                                        <textarea class="form-control" rows="5" name="NotiDetail" placeholder="Detail" style="height: 170px;"><?php echo $info_data['NotiDetail']; ?></textarea>
                                        <span class="m-form__help">
                                            Please fill the detail
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <label class="col-12 col-form-label">Notification</label>
                                            <div class="col-12">
                                                <span class="m-switch m-switch--outline m-switch--success">
                                                    <label>
                                                        <input type="checkbox" name="Notify" value="1" <?php echo ($info_data['Notify'] == 1 ? 'checked':''); ?> />
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <label class="col-12 col-form-label">Noti Car Owner</label>
                                            <div class="col-12">
                                                <span class="m-switch m-switch--outline m-switch--success">
                                                    <label>
                                                        <input type="checkbox" name="NotiCarOwner" value="1" <?php echo ($info_data['NotiCarOwner'] == 1 ? 'checked':''); ?> />
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <label class="col-12 col-form-label">Noti Dealer</label>
                                            <div class="col-12">
                                                <span class="m-switch m-switch--outline m-switch--success">
                                                    <label>
                                                        <input type="checkbox" name="NotiDealer" value="1" <?php echo ($info_data['NotiDealer'] == 1 ? 'checked':''); ?> />
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-lg-3">
                                    <div class="row">
                                      <label class="col-12 col-form-label">Noti Tradepal</label>
                                      <div class="col-12">
                                        <span class="m-switch m-switch--outline m-switch--success">
                                          <label>
                                            <input type="checkbox" name="NotiAdmin" value="1" <?php echo ($info_data['NotiAdmin'] == 1 ? 'checked':''); ?> />
                                            <span></span>
                                          </label>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Tradepal Email
                                        </label>
                                        <textarea class="form-control" rows="5" name="NotiTradepal" placeholder="exammail1@tradepal.com, exammail2@tradepal.com, exammail3@tradepal.com" style="height: 170px;"><?php echo $info_data['NotiTradepal']; ?></textarea>
                                        <span class="m-form__help">
                                            Please fill the tradepal email
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Bank Email
                                        </label>
                                        <textarea class="form-control" rows="5" name="NotiBank" placeholder="exammail1@bank.com, exammail2@bank.com, exammail3@bank.com" style="height: 170px;"><?php echo $info_data['NotiBank']; ?></textarea>
                                        <span class="m-form__help">
                                            Please fill the bank email
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
