//== Class definition
var modules_path = 'users';
var DatatableRemoteAjax = function() {
    //== Private functions

    // basic demo
    var started = function() {
        var base_url = $('base').attr('href');
        var datatable = $('.m_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: base_url + modules_path + '/loadContent',
                        map: function(raw) {
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
                field: 'user_id',
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
                field: 'user_id',
                title: '#',
                sortable: true, // disable sort for this column
                width: 40,
                selector: false,
                textAlign: 'center',
            }, {
                field: 'block',
                title: 'Status',
                width: 80,
                sortable: true,
                template: function(row) {
                    if (row.block === '1') {
                        return '<span class="m-badge m-badge--warning m-badge--wide">Block</span>';
                    } else {
                        return '<span class="m-badge m-badge--success m-badge--wide">Normal</span>';
                    }
                }
            }, {
                field: 'user_name',
                title: 'Username',
                sortable: true,
            }, {
                field: 'full_name',
                title: 'Full Name',
                // sortable: 'asc', // default sort
                filterable: false, // disable or enable filtering
                sortable: true,
                // basic templating support for column rendering,
                //template: '{{OrderID}} - {{ShipCountry}}',
            }, {
                //     field: 'ShipCountry',
                //     title: 'Ship Country',
                //     attr: {nowrap: 'nowrap'},
                //     width: 150,
                //     template: function(row) {
                //       // callback function support for column rendering
                //       return row.ShipCountry + ' - ' + row.ShipCity;
                //     },
                //   }, {
                field: 'email',
                title: 'Email',
                sortable: true,
            }, {
                field: 'group_name',
                title: 'Group',
                sortable: true,
            }, {
                field: 'Action',
                width: 110,
                title: 'Action',
                sortable: false,
                overflow: 'visible',
                template: function(row, index, datatable) {
                    var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                    return '\
                          <a href="' + base_url + modules_path + '/unblock/' + row.user_id + '" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Unlock Account">\
                              <i class="la la-lock"></i>\
                          </a>\
                          <a href="' + base_url + modules_path + '/edit/' + row.user_id + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">\
                              <i class="la la-edit"></i>\
                          </a>\
                          <a href="' + base_url + modules_path + '/delete/' + row.user_id + '" class="crm-delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
                              <i class="la la-trash"></i>\
                          </a>';
                },
            }],
        });

        $('#m_form_status').on('change', function() {
            datatable.search($(this).val(), 'Status');
        });

        $('#m_form_type').on('change', function() {
            datatable.search($(this).val(), 'Type');
        });

        $('#m_form_status, #m_form_type').selectpicker();

    };

    return {
        // public functions
        init: function() {
            started();
        },
    };
}();

jQuery(document).ready(function() {
    DatatableRemoteAjax.init();
});