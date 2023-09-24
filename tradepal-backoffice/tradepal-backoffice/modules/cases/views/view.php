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
                      Case Detail
                    </h3>
                    <?php $this->load->view('inc-bread.php', ['dealer_name' => $info_data['dealer_name'] . ' - ' . $edit_id]); ?>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content" >
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet" >
                        <!--begin::Form-->
                      <div class="loading-wrap" ng-show="loading">
                        <div class="loading"></div>
                      </div>
                      <div class="page-view" ng-init="CASE_VIEW_ALL_INIT('<?php echo $edit_id ?>') " style="padding: 20px;">

                        <!-- <div class="row">

                          <div class="col-3">
                            <div class="form-group">
                              <label class="col-form-label">Status for test </label>
                              <select ng-model="dataView.StatusOri" name="Status" type="text" class="form-control custom-select" ng-change="isShowCase()" required>
                                <option value=""> -- Select Status --</option>
                                <option ng-repeat="item in CASE_STATUS_ARR" value="[[item.ID]]"> [[item.Name]]</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        -->

                        <div class="page-content" ng-if="!loading">
                         

                          <div class="sec-step sec-step-case sec-step-case-admin" ng-if="dataView.Type == 'BUY'">
                            <div class="row">
<!--                              <div class="step-item col-md-auto"  ng-repeat="item in CASE_STEP_ITEM" ng-class="{ active : item.status.indexOf(dataView.StatusOri) >= 0 }">-->
                              <div class="step-item col-md-auto" ng-repeat="item in CASE_STEP_ITEM" ng-class="{
                              active : item.tab + '_BODY' == IS_TAB  &&  IS_TABS == ''  ||    item.tab  == IS_TAB  &&  IS_TABS == ''  || item.tab == IS_TABS
                              }">
                              <span class="icon">[[$index + 1]]</span>[[item.name]]
                              </div>
                            </div>
                          </div>



                          <div class="accordion accordion-step" id="accordions" >

                           
                            <div class="card" ng-click="onActiveTab('SEC2')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC1" ng-click="initLightGallery('lightgallery' )">
                                <h2>
                                  CASE  DETAIL
                                </h2>
                              </div>

                              <div id="SEC1" class="collapse " data-parent="#accordions">
                                <div class="card-body">
                                 
                               

                                  <div ng-if="dataView.Type == 'BUY' ">
                                    <?php $this->load->view('cases/_inc-view-case-detail.php'); ?>
                                  </div>

                                  <div ng-if="dataView.Type == 'SELL' ">
                                    <?php $this->load->view('cases/_inc-view-case-detail-sell.php'); ?>
                                  </div>
                                </div>
                              </div>
                            </div>


                       
                            <div class="card" ng-click="onActiveTab('SEC2')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC2" ng-class="{ active: isShowCase('SEC2_BODY') }">
                                <h2>
                                
                                  <div ng-if="dataView.Type == 'BUY'">
                                    Buy & Sell Agreement
                                  </div>
                                  <div ng-if="dataView.Type == 'SELL'">
                                    SALES AGREEMENT
                                  </div>
                                </h2>
                              </div>

                              <div id="SEC2" class="collapse" ng-class="{ show: isShowCase('SEC2_BODY') }" data-parent="#accordions">
                                <div class="card-body">
                                  <div class=""></div>
                                  <div ng-if="dataView.Type == 'BUY'">
                                    <?php $this->load->view('cases/_inc-view-buy-sell-agreement.php'); ?>
                                  </div>

                                  <div ng-if="dataView.Type == 'SELL'">
                                    <?php $this->load->view('cases/_inc-view-buy-sell-agreement-sell.php'); ?>
                                  </div>
                                </div>
                              </div>
                            </div>

                       
<!--                            <div class="card" ng-if="isShowCase('SEC3')">-->
<!--                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC3">-->
<!--                                <h2>-->
<!--                                  Key Hire Purchase-->
<!--                                </h2>-->
<!--                              </div>-->
<!---->
<!--                              <div id="SEC3" class="collapse" ng-class="{ show: isShowCase('SEC3_BODY') }" data-parent="#accordions">-->
<!--                                <div class="card-body">-->
<!--                                  --><?php //$this->load->view('cases/_inc-view-key-hire-purchase.php'); ?>
<!---->
<!--                                  -->
<!--                                  <div ng-if="CASE_STATUS_LOG_DATA.ST6 " class="text-center status-log ">-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST6.StatusText]]-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST6.INS | dateFormat]]-->
<!--                                  </div>-->
<!---->
<!--                                  <div ng-if="CASE_STATUS_LOG_DATA.ST7 " class="text-center status-log ">-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST7.StatusText]]-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST7.INS | dateFormat]]-->
<!--                                  </div>-->
<!---->
<!--                                  <div ng-if="CASE_STATUS_LOG_DATA.ST8 " class="text-center status-log red">-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST8.StatusText]]-->
<!--                                    [[CASE_STATUS_LOG_DATA.ST8.INS | dateFormat]]-->
<!--                                  </div>-->
<!---->
<!---->
<!--                                </div>-->
<!--                              </div>-->
<!--                            </div>-->

                           
                            <div class="card" ng-if="isShowCase('SEC4')" ng-click="onActiveTab('SEC4')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC4" ng-class="{ active: isShowCase('SEC4_BODY') }">
                                <h2>
                                ADVANCE AMOUNT to DEALER
                                </h2>
                              </div>

                              <div id="SEC4" class="collapse" ng-class="{ show: isShowCase('SEC4_BODY') }" data-parent="#accordions">
                                <div class="card-body">
                                  
  
                                  <?php $this->load->view('cases/_inc-view-amount-of-money.php'); ?>


                                  <div ng-if="CASE_STATUS_LOG_DATA.ST6 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST6.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST6.INS | dateFormat]]
                                  </div>

                                  <div ng-if="CASE_STATUS_LOG_DATA.ST7 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST7.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST7.INS | dateFormat]]
                                  </div>

                                  <div ng-if="CASE_STATUS_LOG_DATA.ST8 " class="text-center status-log">
                                    [[CASE_STATUS_LOG_DATA.ST8.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST8.INS | dateFormat]]
                                  </div>


                                </div>
                              </div>
                            </div>

                            <div class="card" ng-if="isShowCase('SEC41')" ng-click="onActiveTab('SEC41')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC41" ng-class="{ active: isShowCase('SEC41_BODY') }">
                                <h2>
                                  Undertaking and Important Instructions
                                </h2>
                              </div>

                              <div id="SEC41" class="collapse" ng-class="{ show: isShowCase('SEC41_BODY') }" data-parent="#accordions">
                                <div class="card-body">
        
        
                                  <?php $this->load->view('cases/_inc-view-amount-due.php'); ?>


                                  <div ng-if="CASE_STATUS_LOG_DATA.ST9 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST9.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST9.INS | dateFormat]]
                                  </div>

                                  <div ng-if="CASE_STATUS_LOG_DATA.ST10 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST10.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST10.INS | dateFormat]]
                                  </div>


                                  <div ng-if="CASE_STATUS_LOG_DATA.ST11 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST11.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST11.INS | dateFormat]]
                                  </div>


                                </div>
                              </div>
                            </div>


                            <div class="card" ng-if="isShowCase('SEC5')" ng-click="onActiveTab('SEC5')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC5" ng-class="{ active: isShowCase('SEC5_BODY') }">
                                <h2>
                                  APPOINTMENT
                                </h2>
                              </div>

                              <div id="SEC5" class="collapse" ng-class="{ show: isShowCase('SEC5_BODY') }" data-parent="#accordions">
                                <div class="card-body">
                                 
                                  <?php $this->load->view('cases/_inc-view-appointment.php'); ?>

                                  <div ng-if="auth.Type == 'SELLER' ">
                                    <div ng-if="dataView.StatusOri == '15' " class="view-action text-center">
                                      <button type="button" class="btn btn-danger btn-submit " ng-click="onCaseStaus('Accept')">Accept</button>
                                      <button type="button" class="btn btn-secondary btn-submit" ng-click="onCaseStaus('Reject') ">Reject</button>
                                      <div style="height: 40px;"></div>
                                    </div>

                                  </div>


                                  <div ng-if="CASE_STATUS_LOG_DATA.ST12 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST12.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST12.INS | dateFormat]]
                                  </div>
                                  <div ng-if="CASE_STATUS_LOG_DATA.ST13 " class="text-center status-log ">
                                    [[CASE_STATUS_LOG_DATA.ST13.StatusText]]
                                    [[CASE_STATUS_LOG_DATA.ST13.INS | dateFormat]]
                                  </div>
                                


                                </div>
                              </div>
                            </div>
                            

                            <div class="card" ng-if="isShowCase('SEC7')" ng-click="onActiveTab('SEC7')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC7" ng-class="{ active: isShowCase('SEC7_BODY') }">
                                <h2>
                                  MONEY TRANSFER
                                </h2>
                              </div>

                              <div id="SEC7" class="collapse" ng-class="{ show: isShowCase('SEC7_BODY') }" data-parent="#accordions">
                                <div class="card-body">
                                
<!--                                  <div ng-if="CASE_STATUS_LOG_DATA.ST16 ">-->
<!--                                    <a href="https://www.onemotoring.com.sg">-->
<!--                                      <span class="status-log"> https://www.onemotoring.com.sg </span>-->
<!--                                    </a>-->
<!--                                    <span class="status-log">: [[CASE_STATUS_LOG_DATA.ST16.INS | dateFormat]]</span>-->
<!--                                  </div>-->


                                  <div style="height: 30px;"></div>
                                    <?php  $this->load->view('cases/_inc-view-money-transferred.php'); ?>
                                    
<!--                                    <button ng-click="BTN_UPDATE_STATUS('--><?php //echo $this->session->scu_id; ?><!--')" type="button" class="btn btn-submit btn-danger btn-nor">Money transferred </button>-->
                                

                                  <div ng-if="dataView.StatusOri >= '23' ">
                                    <div style="height: 30px;"></div>
                                    
                                  <?php  $this->load->view('cases/_inc-view-handed-over.php'); ?>
    
                                  
                                  </div>

                                  <div style="height: 30px;"></div>
                                  <div class="text-center">
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST14 " class="text-center status-log ">
                                      [[CASE_STATUS_LOG_DATA.ST14.StatusText]]
                                      [[CASE_STATUS_LOG_DATA.ST14.INS | dateFormat]]
                                    </div>
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST15 " class="text-center status-log ">
                                      [[CASE_STATUS_LOG_DATA.ST15.StatusText]]
                                      [[CASE_STATUS_LOG_DATA.ST15.INS | dateFormat]]
                                    </div>
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST16 " class="text-center status-log ">
                                      [[CASE_STATUS_LOG_DATA.ST16.StatusText]]
                                      [[CASE_STATUS_LOG_DATA.ST16.INS | dateFormat]]
                                    </div>
                                    
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST17 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST17.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST17.INS | dateFormat]]
                                    </div>

                                    <div ng-if="CASE_STATUS_LOG_DATA.ST18 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST18.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST18.INS | dateFormat]]
                                    </div>

                                    <div ng-if="CASE_STATUS_LOG_DATA.ST19 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST19.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST19.INS | dateFormat]]
                                    </div>

                                    <div ng-if="CASE_STATUS_LOG_DATA.ST20 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST20.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST20.INS | dateFormat]]
                                    </div>

                                    <div ng-if="CASE_STATUS_LOG_DATA.ST21 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST21.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST21.INS | dateFormat]]
                                    </div>
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST22 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST22.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST22.INS | dateFormat]]
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                          

                            <div class="card" ng-if="isShowCase('SEC9')" ng-click="onActiveTab('SEC9')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC9" ng-class="{ active: isShowCase('SEC9_BODY') }">
                                <h2>
                                  HANDOVER ACKNOWLEDGEMENT
                                </h2>
                              </div>

                              <div id="SEC9" class="collapse" ng-class="{ show: isShowCase('SEC9_BODY') }" data-parent="#accordions">
                                <div class="card-body">

<!--                                  <div style="height: 30px;"></div>-->
<!--                                  <div ng-if="CASE_STATUS_LOG_DATA.ST16 ">-->
<!--                                    <a href="https://www.onemotoring.com.sg">-->
<!--                                      <span class="status-log"> https://www.onemotoring.com.sg </span>-->
<!--                                    </a>-->
<!--                                    <span class="status-log">: [[CASE_STATUS_LOG_DATA.ST16.INS | dateFormat]]</span>-->
<!--                                  </div>-->


                                  <div style="height: 30px;"></div>
    
    
                                    <?php  $this->load->view('cases/_inc-view-e-agreement-handover.php'); ?>

                                  <div style="height: 30px;"></div>
        
                                  
                                  <div style="height: 30px;"></div>

                                  <div class="text-center">
                                   

                                    <div ng-if="CASE_STATUS_LOG_DATA.ST21 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST21.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST21.INS | dateFormat]]
                                    </div>
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST22 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST22.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST22.INS | dateFormat]]
                                    </div>
                                    <div ng-if="CASE_STATUS_LOG_DATA.ST23 " class="status-log mt-2">
                                      [[CASE_STATUS_LOG_DATA.ST23.StatusText | caseStatus]]
                                      [[CASE_STATUS_LOG_DATA.ST23.INS | dateFormat]]
                                    </div>
                                    
                                  </div>
                                  

                                </div>
                              </div>
                            </div>

                          <div class="card" ng-if="isShowCase('SEC10')" ng-click="onActiveTab('SEC10')">
                            <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC10" ng-class="{ active: isShowCase('SEC10_BODY') }">
                              <h2>
                                DEALER SURVEY
                              </h2>
                            </div>
                            <div id="SEC10" class="collapse" ng-class="{ show: isShowCase('SEC10_BODY') }" data-parent="#accordions">
                              <div class="card-body">
                                  <?php  $this->load->view('cases/_inc-view-survey.php'); ?>
                                <div style="height: 30px;"></div>

                                <div class="text-center">
                                  <div ng-if="CASE_STATUS_LOG_DATA.ST24 " class="status-log mt-2">
                                    [[CASE_STATUS_LOG_DATA.ST24.StatusText | caseStatus]]
                                    [[CASE_STATUS_LOG_DATA.ST24.INS | dateFormat]]
                                  </div>
                                  <div ng-if="CASE_STATUS_LOG_DATA.ST25 " class="status-log mt-2">
                                    [[CASE_STATUS_LOG_DATA.ST25.StatusText | caseStatus]]
                                    [[CASE_STATUS_LOG_DATA.ST25.INS | dateFormat]]
                                  </div>

                                  <div ng-if="CASE_STATUS_LOG_DATA.ST26 " class="status-log mt-2">
                                    [[CASE_STATUS_LOG_DATA.ST26.StatusText | caseStatus]]
                                    [[CASE_STATUS_LOG_DATA.ST26.INS | dateFormat]]
                                  </div>

                                  
                                </div>
                                
                              </div>
                            </div>
                          </div>

                            <div class="card" ng-if="isShowCase('SEC11')" ng-click="onActiveTab('SEC11')">
                              <div class="card-header collapsed" data-toggle="collapse" data-target="#SEC11" ng-class="{ active: isShowCase('SEC11_BODY') }">
                                <h2>
                                  OTHER DOCUMENT
                                </h2>
                              </div>
                              <div id="SEC11" class="collapse" ng-class="{ show: isShowCase('SEC11_BODY') }" data-parent="#accordions">
                                <div class="card-body">
                                    <?php  $this->load->view('cases/_inc-view-document2.php'); ?>
                                  <div style="height: 30px;"></div>
                                </div>
                              </div>
                            </div>


                          </div>
                        
                        
                          
                          
                          <div class="mt-4 mb-2">
                            <a class="btn btn-secondary btn-submit btn-back-admin" href="<?php echo base_url($page_url ); ?>">
                              <i class="la la-angle-left"></i>
                              BACK
                            </a>
                          </div>
                        </div>
                      </div>


                      <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Body -->

