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
    <div class="m-content" >
      <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
          <!--begin: Search Form -->
          <div class="m-form m-form--label-align-right m--margin-bottom-30">
            <div class="row ">
              <div class="col-sm-3">
                <div class="form-group ">
                  <select class="form-control m-input m-input--square" name="type" id="sType">
                    <option value="">Please select Type</option>
                    <option value="BUY">BUY</option>
                    <option value="SELL">SELL</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group ">
                  <input type="text" class="form-control m-input" placeholder="Dealer" id="dealer_name">

                </div>
                </div>
              <div class="col-sm-3">
                <div class="form-group ">
                  <input type="text" class="form-control m-input" placeholder="Vehicle No." id="VehicleNo">

                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group ">
                  <input type="text" class="form-control m-input" placeholder="Vehicle Make" id="VehicleMake">

                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group ">
                  <input type="text" class="form-control m-input" placeholder="Vehicle Model" id="VehicleModel">

                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group ">
                  <input type="text" class="form-control m-input" placeholder="Year of Manufacture" id="YearOfManufacture">

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
          cookie: false,
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
        field: 'MOD',
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
        width: 80,
        sortable: true,
      }, {
        field: 'VehicleNo',
        title: 'Vehicle registeration number',
        width: 180,
        filterable: true,
        sortable: true,
      }, {
        field: 'Type',
        title: 'Type',
        width: 60,
        filterable: true,
        sortable: true,
      },
        {
          field: 'dealer_name',
          title: 'Dealer',
          filterable: true,
          sortable: true,
        },
        {
          field: 'seller_name',
          title: 'Car Owner',
          filterable: true,
          sortable: true,
          template: function (row, index, datatable) {
            var name = row.seller_name ?  row.seller_name : row.SellerName;
            return name;
          }
        },
        

        {
          field: 'VehicleMake',
          title: 'Make/Model',
          filterable: true,
          sortable: true,
          template: function (row, index, datatable) {
            return row.VehicleMake + ' / ' + row.VehicleModel;
          }
        }, {
          field: 'MOD',
          title: 'Date',
          filterable: true,
          sortable: true,
          template: function (row, index, datatable) {
            return moment(row.MOD).format('DD MMM YYYY HH:mm');
          }
        }, {
          field: 'status_name',
          title: 'Status',
          filterable: false,
          sortable: false
        }, {
          field: 'action',
          width: 50,
          title: '',
          sortable: false,
          overflow: 'visible',
          template: function (row, index, datatable) {
            var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
            return '\
                        <a href="' + base_url + '/view/' + row.ID + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View">\
                            <i class="la la-file-text"></i>\
                        </a>';
          },
        }],
    });

    // $('#m_form_status').on('change', function () {
    //   datatable.search($(this).val(), 'Status');
    // });
    //
    // $('#m_form_type').on('change', function () {
    //   datatable.search($(this).val(), 'Type');
    // });


    $('#btn-search').on('click', function () {

      var query = {
        Type: $('#sType').val(),
        dealer_name: $('#dealer_name').val(),
        VehicleNo: $('#VehicleNo').val(),
        VehicleMake: $('#VehicleMake').val(),
        VehicleModel: $('#VehicleModel').val(),
        YearOfManufacture: $('#YearOfManufacture').val(),
      };
      datatable.setDataSourceQuery(query);
      datatable.search();
    });


  });
</script>