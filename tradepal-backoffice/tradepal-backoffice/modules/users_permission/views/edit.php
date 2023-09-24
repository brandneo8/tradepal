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
                                            Group Name:
                                        </label>
                                        <?php
                                        /* get data */
                                        $get_groupinfo = $this->models->get_groupinfo($info_data['group_id']);
                                        ?>
                                        <input type="text" class="form-control m-input" name="group_id" placeholder="Please select group name" value="<?php echo $get_groupinfo['group_name']; ?>" disabled="disabled">
                                        <span class="m-form__help">
                                            Please select group name
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php $user_permission = json_decode($info_data['permission_data'], true); ?>
                                    <?php $get_usersystem = $this->models->get_system_master(); ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped bordered">

                                            <thead>
                                            <th class="text-center" width="30"></th>
                                            <th class="text-left">Modules</th>
                                            <th width="200" class="text-left">Controller</th>
                                            <th width="40" class="text-center">View</th>
                                            <th width="40" class="text-center">Create</th>
                                            <th width="40" class="text-center">Edit</th>
                                            <th width="40" class="text-center">Delete</th>
                                            </thead>
                                            <tbody>
                                            <?php foreach($get_usersystem as $key => $row): ?>
                                                <tr>
                                                    <td class="text-center">&nbsp;</td>
                                                    <td class="text-left"><span class="m-badge m-badge--danger m-badge--wide">main</span>&nbsp;&nbsp;<?php echo $row['sm_name']; ?></td>
                                                    <td class="text-left"><span class="m-badge m-badge--warning m-badge--wide"><a href="<?php echo base_url($row['sm_controller']); ?>" target="_blank"><?php echo $row['sm_controller']; ?></a></span></td>
                                                    <td class="text-center"><input name="view_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['view'])) ? 'checked':''); ?> /></td>
                                                    <td class="text-center"><input name="add_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['add'])) ? 'checked':''); ?> /></td>
                                                    <td class="text-center"><input name="edit_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['edit'])) ? 'checked':''); ?> /></td>
                                                    <td class="text-center"><input name="del_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['delete'])) ? 'checked':''); ?> /></td>
                                                </tr>
                                                <?php $get_usersystem_sub = $this->models->get_system_salve($row['sm_id']); ?>
                                                <?php foreach($get_usersystem_sub as $key => $row): ?>
                                                    <tr>
                                                        <td class="text-center">&nbsp;</td>
                                                        <td class="text-left" style="padding-left: 40px;"><span class="m-badge m-badge--metal m-badge--wide">sub</span>&nbsp;&nbsp;<?php echo $row['sm_name']; ?></td>
                                                        <td class="text-left"><span class="m-badge m-badge--warning m-badge--wide"><a href="<?php echo base_url($row['sm_controller']); ?>" target="_blank"><?php echo $row['sm_controller']; ?></a></span></td>
                                                        <td class="text-center"><input name="view_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['view'])) ? 'checked':''); ?> /></td>
                                                        <td class="text-center"><input name="add_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['add'])) ? 'checked':''); ?> /></td>
                                                        <td class="text-center"><input name="edit_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['edit'])) ? 'checked':''); ?> /></td>
                                                        <td class="text-center"><input name="del_per[]" value="<?php echo $row['sm_id']; ?>" type="checkbox" <?php echo (in_array($row['sm_id'], explode(',', $user_permission['delete'])) ? 'checked':''); ?> /></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                    
                                            </tbody>
                                        </table>
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
