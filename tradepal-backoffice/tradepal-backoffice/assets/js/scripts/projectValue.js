jQuery(document).ready(function($) {

    $("#sl_select_add_position").select2({
        placeholder: "เพิ่มตำแหน่ง"
    });

});

$(function() {

    var listWorkPercent = [
        { key: '1', value: '100' },
        { key: '0.9', value: '90' },
        { key: '0.8', value: '80' },
        { key: '0.7', value: '70' },
        { key: '0.6', value: '60' },
        { key: '0.5', value: '50' },
        { key: '0.4', value: '40' },
        { key: '0.3', value: '30' },
        { key: '0.2', value: '20' },
        { key: '0.1', value: '10' }
    ]

    $(document).on('click', "#btn_add_position", function(e) {
        $('#btn_add_position').prop('disabled', true).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var position_id = $('#sl_select_add_position').val();
        var project_period = $('input[name=value_period]').val();
        var i;

        $.ajax({
            url: base_url + 'users_position/ajax_get_quotation_position_by_id',
            type: 'post',
            dataType: 'json',
            data: { position_id: position_id },
            success: function(data) {
                $('#btn_add_position').prop('disabled', false).html('<i class="fa fa fa-plus"></i>');

                var html = "";
                html += "<tr data-id='" + data.id + "' data-cost='" + data.salary + "'> ";
                html += "<td><input type='hidden' name='project_position_salary[]' value='" + data.salary + "'><input type='hidden' name='project_position_id[]' value='" + data.id + "'><input type='hidden' name='project_position_name[]' value='" + data.position_name + "'><a href='javascript:;' class='text-danger btn_delete_project_position'><i class='fa fa-close'></i></a>&nbsp;&nbsp;&nbsp;" + data.position_name + "</td>";
                html += "<td class='text-right'>" + numeral(data.salary).format('0,00.00') + "</td>";
                html += "<td><div style='width: 100px'><input type='number' min='1' readonly='readonly' name='project_position_amount[]' class='form-control' value='1'></div></td>";
                for (i = 0; i < parseInt(project_period); i++) {
                    html += "<td class='text-center work-percent'>";
                    html += "<div style='width: 100px'>";
                    html += "<p class='text-center mb-0'><small>เดือนที่ " + parseInt(i + 1) + "</small></p>";
                    html += "<select class='form-control input-work-percent' style='width: 90%; margin: 0 auto;' name='input_work_percent[" + i + "][]'>";
                    html += "<option value=''>%</option>";
                    $.each(listWorkPercent, function(key, item) {
                        // console.log(item);
                        html += "<option value='" + item.value + "'>" + item.key + "</option>";
                    });
                    html += "</select>";
                    html += "</div>";
                    html += "</td>";
                }
                html += "</tr>";
                html += "<tr style='background-color: #f4ffff; border-bottom: 2px solid #333;'>";
                html += "<td class='text-right'>รวม:</td>";
                html += "<td class='text-right td-summary'><div style='width: 150px;'></div><input type='hidden' name='total_salary[]'></td>";
                html += "<td>&nbsp;</td>";
                for (i = 0; i < parseInt(project_period); i++) {
                    html += "<td class='text-right work-salary'><div style='width: 100px'></div></td>";
                }
                html += "</tr>";

                $('#tbl_add_position tbody').append(html);
            }
        });
    });

    $(document).on('click', ".btn_delete_project_position", function(evt) {
        $(this).closest("tr").next("tr").remove();
        $(this).closest("tr").remove();

        showCostGranTotal();
        showNetTotal();
        clearDiscount();
    });




    $('#submitFormProjectValue').ajaxForm({
        type: 'POST',
        target: '.bx-respone',
        dataType: 'json',
        //data: $('#pu-register-sm').serialize(),
        cache: false,
        beforeSubmit: function() {
            $('.bx-respone.m--hides').stop().fadeIn();
            $('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>');
        },
        success: function(rp) {
            var thisbaseurl = $('#submitFormProjectValue').attr('data-url');
            if (rp.code == 0) {
                $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-danger');
                $('.bx-respone.m--hides').find('.m-alert').addClass('alert-success');
                $('.bx-respone.m--hides').stop().fadeIn();
                $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-check-circle"></i>');
                $('.bx-respone.m--hides').find('.m-alert__text').html(rp.text).delay(1500);
                $('.bx-respone.m--hides').fadeOut(function() {
                    // window.parent.location.href = '' + thisbaseurl + '';
                    swal({
                        title: "บันทึกข้อมูลสำหรับ",
                        text: "กรุณารอการอนุมัติ จากผู้มีอำนาจ เพื่อออกใบเสนอราคา",
                        type: "success",
                        onClose: function() {
                            window.parent.location.href = '' + thisbaseurl + '';
                        }
                    });
                });

            } else {
                toastr['error'](rp.text, 'Warning');
                $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-success');
                $('.bx-respone.m--hides').find('.m-alert').addClass('alert-danger');
                $('.bx-respone.m--hides').stop().fadeIn();
                $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-warning"></i>');
                $('.bx-respone.m--hides').find('.m-alert__text').html(rp.text).delay(1500);
                $('.bx-respone.m--hides').fadeOut();
            }
            $('.bx-respone.m--hides').fadeOut('fast', function() {
                $('.bx-respone.m--hides').stop().fadeIn();
            });

            // Complete sending..
            $("body, html").animate({ scrollTop: $(".bx-respone").position().top });
            $('button[type="submit"]').prop('disabled', false).text('บันทึกข้อมูล');
            $(".bx-upload.m--hides").hide();
        },
        complete: function() {
            $('button[type="submit"]').prop('disabled', false).text('บันทึกข้อมูล');
        }
    });



    // ********************************************************************
    var inputWorkPercent = 'input-work-percent';
    var inputCostDiscount = 'input-cost-discount';
    var workCostSum = 'work-cost-sum';
    var workInputId = 'work-cost-sumval';
    var costGrandTotal = 'cost-grand-total';
    var costGrandTotalval = 'cost-grand-totalval';
    var costNetTotal = 'cost-net-total';
    var costNetTotalval = 'cost-net-totalval';
    var discountPercent = 'discount-persent';
    var discountPercentval = 'discount-persentval';

    // function
    var number_format = function(number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }


    var getAllDepartment = function() {
        var departments = new Array();
        $.each($("." + inputWorkPercent), function() {
            var id = $(this).closest("tr").data("id");
            var percent = $(this).val();
            var cost = $(this).closest("tr").data("cost");

            departments.push({ 'id': id, 'percent': percent, 'cost': parseInt(cost) });
        });
        console.log(departments);
        return departments;
    }

    var getTotalCost = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.percent !== '0') {
                total += parseFloat((value.percent * value.cost) / 100);
            }
        });
        return number_format(total, 2, '.', ',');
    }

    var getTotalCostnoNum = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.percent !== '0') {
                total += parseInt((value.percent * value.cost) / 100);
            }
        });
        return total;
    }

    var showCostGranTotal = function() {
        $("#" + costGrandTotal).text(getTotalCost());
        $("#" + costGrandTotalval).val(getTotalCostnoNum());
    }

    var getNetTotal = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.percent !== '0') {
                total += parseFloat((value.percent * value.cost) / 100);
            }
        });

        if ($('#' + inputCostDiscount).val()) {
            var discount = parseFloat($('#' + inputCostDiscount).val());
            total = parseFloat(total - discount);
        }

        return number_format(total, 2, '.', ',');
    }

    var getNetTotalval = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.percent !== '0') {
                total += parseFloat((value.percent * value.cost) / 100);
            }
        });

        if ($('#' + inputCostDiscount).val()) {
            var discount = parseInt($('#' + inputCostDiscount).val());
            total = parseInt(total - discount);
        }

        return total;
    }

    var showNetTotal = function() {
        $("#" + costNetTotal).text(getNetTotal());
        $("#" + costNetTotalval).val(getNetTotalval());
    }

    var showDiscountPercent = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.percent !== '0') {
                total += parseFloat((value.percent * value.cost) / 100);
            }
        });


        var discount = parseFloat($('#' + inputCostDiscount).val());
        var percent = (discount * 100) / total;
        $("#" + discountPercent).text(parseFloat(percent).toFixed(2));
        $("#" + discountPercentval).val(parseFloat(percent).toFixed(2));
    }

    var clearDiscount = function() {
        $('#' + inputCostDiscount).val(0);
        showDiscountPercent();
    }


    $(document).on('change', "." + inputWorkPercent, function(e) {
        var target = $(e.target);
        var value = target.val();
        var cost = target.closest('tr').attr('data-cost');
        var sumCost = 0;

        if (value) {
            target.closest('tr').find('td.work-percent').each(function(index, e) {
                var percentValue = $(this).find('select[name^=input_work_percent]').val();
                console.log(percentValue);
                if (percentValue !== '0' && percentValue.length > 0) {
                    var workSalary = parseFloat(cost * percentValue / 100);
                    sumCost = parseFloat(sumCost + workSalary);
                }

                $(this).closest('tr').next('tr').find('td.work-salary:eq(' + index + ')').text(numeral(workSalary).format('0,00.00'));
            });
            $(this).closest('tr').next('tr').find('td.td-summary div').html('<b>' + numeral(sumCost).format('0,00.00') + '</b>')
            $(this).closest('tr').next('tr').find('td.td-summary input[name^=total_salary]').val(sumCost);

            showCostGranTotal();
            showNetTotal();
        }
    });


    $(document).on('keypress', "." + inputWorkPercent, function(event) {
        if (event.which != 46 && (event.which < 47 || event.which > 59)) {
            event.preventDefault();
            if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
                event.preventDefault();
            }
        }
    });

    $(document).on("input", "#" + inputCostDiscount, function() {
        showNetTotal();
        showDiscountPercent();
    });

});