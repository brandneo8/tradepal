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
            Dealer Detail
          </h3>
            <?php $this->load->view('inc-bread.php', ['dealer_name' => ' Dealer Detail']); ?>
        </div>
      </div>
     
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
      <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
          <!--begin: Search Form -->
          
          <?php // print_r($info_data); ?>
          <div class="mb-4">
            <h2><?php echo $info_data['CompanyName'] ?></h2>
            <p><b>Address : </b>
                <?php echo $info_data['BlockHouseNo'] ?>
                <?php echo $info_data['Street'] ?>
                <?php echo $info_data['Unit'] ?>
                <?php echo $info_data['BuildingName'] ?>
                <?php echo $info_data['Poscode'] ?>
                Tel <?php echo $info_data['TelHome'] ?>
            
            </p>
          </div>

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
            url: base_url + '/dealerDetail/' + <?php echo $edit_id; ?> ,
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

      // search: {
      //   input: $('#generalSearch'),
      // },

      // columns definition
      columns: [
        {
          field: 'ID',
          title: 'No',
          width: 60,
          sortable: true,
        },
        {
          field: 'VehicleNo',
          title: 'Case code',
          filterable: true,
          sortable: true,
        },
        {
          field: 'StaffName',
          title: 'Staff',
          filterable: true,
          sortable: true,
        },
        {
          field: 'Model',
          title: 'Make/Model',
          filterable: true,
          sortable: true,
          template: function (row, index, datatable) {
            return row.VehicleMake + ' / ' + row.VehicleModel;
          }
        },
        {
          field: '',
          title: 'Advance request amount',
          filterable: true,
          sortable: true,
          textAlign: 'center',
         
        },
        {
          field: 'Request_date',
          title: 'Request date',
          filterable: true,
          sortable: true,
          textAlign: 'center',
          template: function (row, index, datatable) {
            var date =  moment(row.Request_date).format('DD MMM YYYY HH:mm')
            return date == 'Invalid date' ? '-' : date ;
          }
        },
        {
          field: 'Amount_to_dealer',
          title: 'Amount to dealer',
          filterable: true,
          sortable: true,
          textAlign: 'center',
        }, {
          field: 'Accept_Amount',
          title: 'Approve date',
          filterable: true,
          sortable: true,
          textAlign: 'center',
          template: function (row, index, datatable) {
            var date =  moment(row.Accept_Amount).format('DD MMM YYYY HH:mm')
            return date == 'Invalid date' ? '-' : date ;
          }
        },{
          field: 'Start_Date_of_Advance',
          title: 'Start Date of Advance',
          filterable: true,
          sortable: true,
          textAlign: 'center',
          template: function (row, index, datatable) {
            var date =  moment(row.Start_Date_of_Advance).format('DD MMM YYYY HH:mm');
            return date == 'Invalid date' ? '-' : date ;
          }
        },
        {
          field: 'Aging_Clock',
          title: 'Aging Clock',
          filterable: true,
          sortable: true,
          textAlign: 'center',
          template: function (row, index, datatable) {
            if (row.Start_Date_of_Advance == null) {
              return '-';
            }
            
            var a =  moment(row.Start_Date_of_Advance).format();
            var b =  moment(row.Complete).format();
            var c =  moment().format();
            
            try {
              
              if (row.Status != '26') {
                return moment.utc(c).diff(moment.utc(a), "days");
              }

              if (!moment(b).isValid()) {
                return '-';
              }
              
              return moment.utc(b).diff(moment.utc(a), "days");
              
            } catch (e) {
              console.log(e, a , b, c);
              
              return '-';
    
            }
            
           
          }
        },  {
          field: 'Handover_Status',
          title: 'Handover',
          filterable: true,
          sortable: true,
          textAlign: 'center',
        }, {
          field: 'Sold_date',
          title: 'Sold',
          filterable: true,
          sortable: true,
          textAlign: 'center',
        },
        {
          field: 'StatusTradepal',
          title: 'Status',
          filterable: true,
          sortable: true,
          textAlign: 'center',
        }
      ],
    });

    // $('#m_form_status').on('change', function () {
    //   datatable.search($(this).val(), 'Status');
    // });
    //
    // $('#m_form_type').on('change', function () {
    //   datatable.search($(this).val(), 'Type');
    // });
  });
</script>