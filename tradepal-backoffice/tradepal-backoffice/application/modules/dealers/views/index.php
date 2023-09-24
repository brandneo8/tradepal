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
              <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                  <div class="form-group m-form__group row align-items-center">
                    <div class="col-md-4">
                      <div class="m-input-icon m-input-icon--left">
                        <input type="text" class="form-control m-input" placeholder="Search" id="generalSearch">
                        <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-search"></i></span></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                  <form method="post" action="<?php echo base_url($page_url . '/export'); ?>">
										<?php foreach ($_POST as $key => $row) : ?>
                      <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $row; ?>"/>
										<?php endforeach; ?>
                    <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                      <span>
                        <i class="flaticon-download"></i>
                        <span>
                          Export to .csv
                        </span>
                      </span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->

            <div class="m_datatable table-case" id="ajax_data"></div>

            <div class="modal modal-signin  fade" id="modalAdvanceQuantum" tabindex="-1" role="dialog" aria-labelledby="signIn" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="signin">
                    <div class="signin-title">
                      <div class="text"><span class="red"> Edit </span> Advance Quantum%</div>
                    </div>
                    <div style="height: 40px;"></div>

                    <form class="form" name="ngf" novalidate ng-submit="CASE_FORM_ADVANCE_QUANTUM(ngf)">

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label"> Amount <span class="red">*</span></label>
                        <div class="col-md-9">
                          <input numbers-only placeholder="Advance Quantum" maxlength="3" ng-model="dataForm.AdvanceQuantum" name="AdvanceQuantum" type="text" class="form-control " required>
                          <div class="error text-danger" ng-show="ngf.AdvanceQuantum.$dirty && ngf.AdvanceQuantum.$invalid ">Please fill in information</div>
                        </div>
                      </div>
                      <div style="height: 10px;"></div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-9">
                          <div class="form-action">
                            <button class="btn btn-r btn-danger btn-submit " type="submit">
                              SAVE
                            </button>
                          </div>
                          <div style="height: 40px;"></div>
                        </div>
                      </div>
                    </form>


                  </div>

                </div>
              </div>
            </div>

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
        field: 'ID',
        title: 'No',
        width: 60,
        sortable: true,
      }, {
        field: 'CompanyRegistertionNo',
        title: 'Dealer code',
        width: 120,
        filterable: true,
        sortable: true,
      },
        {
          field: 'CompanyName',
          title: 'Dealer name',
          filterable: true,
          sortable: true,
        },
        {
          field: 'AdvanceQuantum',
          title: 'Advance Quantum%',
          filterable: true,
          sortable: true,
          template: function (row, index, datatable) {
            var data = JSON.stringify(row);
            var html = '<a onclick=\'angular.element(this).scope().ON_ADVANCE_QUANTUM(' + data + ')\' class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill">\n  <i class="la la-edit"></i>\n</a>';
            var AdvanceQuantum = row.AdvanceQuantum ? row.AdvanceQuantum : '100';
            return '<span style="padding-right: 20px;"> ' + AdvanceQuantum + '%</span>' + html;
          },

        },
        {
          field: 'cnt_wait_accept',
          title: 'Agreement signed',
          width: 100,
          filterable: true,
          sortable: true,
          textAlign: 'center',
        }, {
          field: 'cnt_accept',
          title: 'Advance accept',
          width: 100,
          filterable: true,
          sortable: true,
          textAlign: 'center',
        },
        {
          field: 'cnt_reject',
          title: 'Advance reject',
          width: 100,
          filterable: true,
          sortable: true,
          textAlign: 'center',
        },
        {
          field: 'cnt_handover',
          title: 'Handed over',
          width: 100,
          filterable: true,
          sortable: true,
          textAlign: 'center',
        },
        {
          field: 'Status',
          title: 'Status',
          width: 100,
          filterable: true,
          sortable: true,
          textAlign: 'center',
        },
        {
          field: 'action',
          width: 150,
          title: '',
          sortable: false,
          overflow: 'visible',
          template: function (row, index, datatable) {
            var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
            return '<a href="' + base_url + '/view/' + row.ID + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Detail">\
                            <i class="la la-file-text"></i>\
                        </a><a href="' + base_url + '/detail/' + row.ID + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View">\
                            <i class="la la-eye"></i>\
                        </a>\
                        <a href="' + base_url  + '/edit/' + row.ID + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">\
                              <i class="la la-edit"></i>\
                          </a>\
                        <a href="' + base_url  + '/delete/' + row.ID + '" class="crm-delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
                              <i class="la la-trash"></i>\
                          </a>';
          },
        }],
    });


    //
    // $('.m_datatable').on('click', 'tbody #btn-advancequantum', function () {
    //
    //   var data =  datatable.row($(this).closest("tr")).data() ;
    //   console.log(data)
    // });

    $('#m_form_status').on('change', function () {
      datatable.search($(this).val(), 'Status');
    });

    $('#m_form_type').on('change', function () {
      datatable.search($(this).val(), 'Type');
    });


  });


</script>