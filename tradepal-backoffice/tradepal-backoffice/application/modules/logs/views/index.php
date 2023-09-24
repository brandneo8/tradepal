<div ng-controller="AppController" ng-cloak>
  <div class="loading-wrap" ng-show="loading">
    <div class="loading"></div>
  </div>
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
        <div class="m-portlet m-portlet--mobile">

          <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-bottom-30">

              <div class="row ">
                
                <div class="col-sm-3">
                  <div class="form-group ">
                    <div class="m-input-icon m-input-icon--left">
                      <input type="text" class="form-control m-input" placeholder="Search" id="generalSearch">
                      <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-search"></i></span></span>
                    </div>

                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group ">
                    <select class="form-control m-input m-input--square" name="StatusID" id="StatusID">
                      <option value="">Please select Status</option>
<!--                      <option value="1">Initiated</option>-->
                      <option value="2">Car owner - Accept Terms & Conditions</option>
<!--                      <option value="3"> Buy & Sell agreement rejected</option>-->
                      <option value="5">Dealer - Accept Terms & Conditions</option>
<!--                      <option value="6">Advance requested</option>-->
<!--                      <option value="7">Not request advance</option>-->
<!--                      <option value="8">HP updated (unuse)</option>-->
<!--                      <option value="9">HP accepted (unuse)</option>-->
<!--                      <option value="10">HP rejected (unuse)</option>-->
<!--                      <option value="11">Advance amount updated</option>-->
<!--                      <option value="12">Advance amount accepted</option>-->
<!--                      <option value="14">Advance amount rejected</option>-->
<!--                      <option value="15">Appointment created</option>-->
<!--                      <option value="16">Document uploaded</option>-->
<!--                      <option value="17">Appointment accepted</option>-->
<!--                      <option value="18">Appointment rejected</option>-->
<!--                      <option value="19">Initiate car ownership</option>-->
<!--                      <option value="20">Car title transferred</option>-->
<!--                      <option value="21">Money transferred to car owner</option>-->
<!--                      <option value="22">Amount received</option>-->
<!--                      <option value="23">Handover</option>-->
<!--                      <option value="24">Dealer accept handover acknowledgement</option>-->
<!--                      <option value="25">Seller accept handover acknowledgement</option>-->
<!--                      <option value="26">Complete</option>-->
<!--                      <option value="27">Other documents</option>-->
<!--                      <option value="101">Initiated Sell</option>-->
<!--                      <option value="102">Buy & Sell agreement accepted</option>-->
<!--                      <option value="103">Buy & Sell agreement rejected</option>-->
                    </select>
                  </div>
                </div>

                
                <div class="col-sm-3">
                  <div class="form-group ">
                    <button type="button" id="btn-search" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Search</button>
                  </div>
                </div>

              </div>

              
            
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->

            <div class="m_datatable table-case" id="ajax_data"></div>


            <!--end: Datatable -->
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- end:: Body -->
</div>


<script>
  //== Class definition
  jQuery(document).ready(function () {
    //== Private functions
    // basic demo
    var base_url = '<?php echo base_url($page_url); ?>';
    var datatable = $('.m_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: base_url + '/loadContent',
            method: 'POST',
            params: <?php echo json_encode($_POST); ?>,
            map: function (raw) {
              // sample data mapping
              var dataSet = raw;
              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
        saveState: {
          cookie: true,
          webstorage: false
        }
      },

      // layout definition
      layout: {
        scroll: false,
        footer: false,
        spinner: {
          message: 'Processing..',
        }
      },

      sort: {
        sort: 'desc',
        field: 'id',
      },

      // column sorting
      sortable: true,
      pagination: true,
      toolbar: {
        // toolbar items
        items: {
          // pagination
          pagination: {
            // page size select
            pageSizeSelect: [10, 20, 30, 50, 100],
          },
        },
      },

      search: {
        input: $('#generalSearch'),
      },

      // columns definition
      columns: [{
        field: '',
        title: 'Date',
        width: 120,
        filterable: true,
        sortable: true,
        template: function (row, index, datatable) {
          return row.INS;
        }
      }, {
        field: 'IP',
        title: 'Ip',
        width: 100,
        filterable: true,
        sortable: true,
        template: function (row, index, datatable) {
          return row.IP ? row.IP : '- ';
        }
      }, {
        field: 'StatusID',
        title: 'Details',
        width: 700,
        filterable: true,
        sortable: false,
        template: function (row, index, datatable) {
          var status = Number(row.StatusID);
          var html = '';
          var DealerName = row.DealerName != null ? 'Dealer (' + row.DealerCode + ')'  : 'Dealer (-) ';
          var SellerName = row.SellerFullname != null ? 'Car Owner (' + row.SellerCode  + ')' : 'Car Owner (-) ';
          var AdminName = row.AdminName != null ?  'Tradepal (' + row.AdminName + ')' : 'Tradepal (-) ';
          
          
          if (status == 2) {
            html += '<b>' +  SellerName + '</b> ';
            html += 'Accept Terms & Conditions  ';
          }
          if (status == 5) {
            html +=  '<b>' + DealerName  + '</b> ';
            html += 'Accept Terms & Conditions  ';
          }

          html += '<b>';
          if ([1, 7, 17, 18, 23, 24, 101].indexOf(status) >= 0) {
            html += DealerName;
          }
          if ([3, 15, 19, 20, 22, 25, 26, 102, 103].indexOf(status) >= 0) {
            html += SellerName;
          }
          if ([11, 12, 14, 16, 21, 27].indexOf(status) >= 0) {
            html += AdminName;
          }
          html += '</b> ';

       
          // html += ' ' + row.StatusID + ' ';
          // html += ' ' + row.StatusName + ' ';

          html += ' CaseID <a href="/cases/view/' + row.CaseID + '"> ' + row.CaseID + '</a>';
          
          return html;
        }
      }
      ],

    
  });


  //
  // $('.m_datatable').on('click', 'tbody #btn-advancequantum', function () {
  //
  //   var data =  datatable.row($(this).closest("tr")).data() ;
  //   console.log(data)
  // });

    $('#btn-search').on('click', function () {

      var query = {
        generalSearch: $('#generalSearch').val(),
        StatusID: Number($('#StatusID').val()),
      };
      datatable.setDataSourceQuery(query);
      datatable.search();
    });


  });


</script>