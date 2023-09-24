jQuery(document).ready(function() {

    $(".sl_select_add_employee").select2({
        placeholder: "เลือกคน",
        width: '200px'
    });
    $("#sl_select_add_position").select2({
        placeholder: "เลือกตำแหน่ง",
        width: '280px'
    });
    $("input[name^=txt_work_percent]").inputmask("decimal", {
        rightAlignNumerics: !1,
        placeholder: ""
    });

});



$(function() {


    // Add
    $(document).on("change", "input[name='rdo_rpt']", function(e) {
        $('#add_p_2').removeClass('d-none');
    });


    $(document).on("change", "select[name='department_id']", function(e) {
        var department_id = $(this).val();
        var rpt = $('input[name=rdo_rpt]').val();
        if (department_id != '') {
            $.ajax({
                url: base_url + 'projects/ajax_gen_project_code',
                type: 'post',
                dataType: 'json',
                data: { department_id: department_id, rpt: rpt },
                beforeSend: function() {

                },
                success: function(data) {
                    $('input[name="project_code"]').val(data.project_code);
                },
                complete: function() {

                }
            });
        }
    });


    $(document).on('click', "#btn_add_position", function(e) {
        var position_id = $('#sl_select_add_position').val();

        $.ajax({
            url: base_url + 'users_position/ajax_get_position_by_id',
            type: 'post',
            dataType: 'json',
            data: { position_id: position_id },
            success: function(data) {
                var html = "";
                html += "<tr data-id='" + data.id + "' data-cost='" + data.salary + "'> ";
                html += "<td><input type='hidden' name='project_position_id[]' value='" + data.id + "'><input type='hidden' name='project_position_name[]' value='" + data.position_name + "'><a href='javascript:;' class='text-danger btn_delete_project_position'><i class='fa fa-close'></i></a>&nbsp;&nbsp;&nbsp;" + data.position_name + "</td>";
                html += "<td class='text-right'>" + numeral(data.salary).format('0,00.00') + "</td>";
                html += "<td><input type='number' min='1' name='project_position_amount[]' class='form-control' value='1'></td>";
                html += "<td class='text-right work-cost-sum'>" + numeral(data.salary).format('0,00.00') + "</td>";
                html += "</tr>";

                $('#tbl_add_position tbody').append(html);
            }
        });
    });

    $(document).on('click', ".btn_delete_project_position", function(evt) {
        $(this).closest("tr").remove();
    });

    $(document).on('change', "input[name^='project_position_amount']", function(evt) {
        var cost = $(this).closest("tr").data("cost");
        var id = $(this).closest("tr").data("id");
        var amount = $(this).val();
        var sumCost = cost * amount;

        $(this).parent("td").next(".work-cost-sum").text(numeral(sumCost).format('0,00.00'));
        // $(this).parents("tr").find('.' + workInputId).val(sumCost);
    });

    $('#submitFormAddProject').ajaxForm({
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
            // 'data' is the json object returned from the server 
            var thisbaseurl = $('#submitFormAddProject').attr('data-url');
            //$('#submitForm')[0].reset();
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
                        title: "สร้างโครงการสำเร็จ",
                        text: "ต้องการจัดทำ Project Value (Quotation) หรือไม่?",
                        type: "success",
                        showCancelButton: !0,
                        confirmButtonText: "ใช่",
                        cancelButtonText: "ไม่ต้องการ"
                    }).then(function(e) {
                        if (e.value) {
                            window.parent.location.href = '' + thisbaseurl + '/project_value/' + rp.project_id;
                        } else {
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



    // Budget
    $(document).on('select2:select', ".sl_select_add_employee", function(e) {
        var target = $(e.target);
        var user_id = e.params.data.id;
        $.ajax({
            url: base_url + 'users/ajax_get_user_by_id',
            type: 'post',
            dataType: 'json',
            data: { user_id: user_id },
            success: function(data) {
                var salary = parseInt(data.salary);
                target.closest('td').attr('data-salary', salary).next('td').find('div').empty().text(numeral(salary).format('0,00.00'));
                target.closest('td').attr('data-salary', salary).next('td').find('input[name^=emp_salary]').val(salary);
            }
        });

    });

    $(document).on('change', "td.work-percent input[name^=txt_work_percent]", function(e) {
        var target = $(e.target);
        var inputValue = target.val();
        var salary = target.closest('tr').find('td:first').attr('data-salary');
        var sumCost = 0;

        if (salary && inputValue.length > 0) {
            target.closest('tr').find('td.work-percent').each(function(index, e) {
                var percentValue = $(this).find('select[name^=txt_work_percent]').val();

                if (percentValue !== '0' && percentValue.length > 0) {
                    var workSalary = parseFloat(salary * percentValue / 100);
                    sumCost = parseFloat(sumCost + workSalary);
                }

                $(this).closest('tr').next('tr').find('td.work-salary:eq(' + index + ')').text(numeral(workSalary).format('0,00.00'));
            });
            $(this).closest('tr').next('tr').find('td.td-summary div').html('<b>' + numeral(sumCost).format('0,00.00') + '</b>')
            $(this).closest('tr').next('tr').find('td.td-summary input[name^=total_salary]').val(sumCost);
        }

    });



    // ********************************************************************

    var inputWorkMonth = 'input-work-month';
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
        $.each($("." + inputWorkMonth), function() {
            var id = $(this).closest("tr").data("id");
            var month = $(this).val();
            var cost = $(this).closest("tr").data("cost");

            departments.push({ 'id': id, 'month': month, 'cost': parseInt(cost) });
        });
        return departments;
    }

    var getTotalCost = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.month !== '0') {
                total += parseInt(value.month * value.cost);
            }
        });
        return number_format(total, 2, '.', ',');
    }

    var getTotalCostnoNum = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.month !== '0') {
                total += parseInt(value.month * value.cost);
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
            if (value.month !== '0') {
                total += parseInt(value.month * value.cost);
            }
        });

        if ($('#' + inputCostDiscount).val()) {
            var discount = parseInt($('#' + inputCostDiscount).val());
            total = parseInt(total - discount);
        }

        return number_format(total, 2, '.', ',');
    }

    var getNetTotalval = function() {
        var products = getAllDepartment();
        var total = 0;
        $.each(products, function(index, value) {
            if (value.month !== '0') {
                total += parseInt(value.month * value.cost);
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
            if (value.month !== '0') {
                total += parseInt(value.month * value.cost);
            }
        });
        var discount = parseInt($('#' + inputCostDiscount).val());
        var percent = (discount * 100) / total;
        $("#" + discountPercent).text(parseFloat(percent).toFixed(0));
        $("#" + discountPercentval).val(parseFloat(percent).toFixed(0));
    }

    $(document).on("change", "." + inputWorkMonth, function() {
        var cost = $(this).closest("tr").data("cost");
        var id = $(this).closest("tr").data("id");
        var month = $(this).val();
        var sumCost = cost * month;

        $(this).parent("td").next().next("." + workCostSum).text(number_format(sumCost, 1, '.', ','));
        $(this).parents("tr").find('.' + workInputId).val(sumCost);
        showCostGranTotal();
        showNetTotal();
    });

    $(document).on('keypress', "." + inputWorkMonth, function(evt) {
        if (evt.keyCode == 38 || evt.keyCode == 40) {
            return;
        }
        evt.preventDefault();
    });

    $(document).on("input", "#" + inputCostDiscount, function() {
        showNetTotal();
        showDiscountPercent();
    });



});