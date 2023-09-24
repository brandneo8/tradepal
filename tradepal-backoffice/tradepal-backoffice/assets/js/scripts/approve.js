$(function() {
    var approveId = $('#approve_id').val();
    var projectType = $('#project_type').val();

    $('#btn-approve').on('click', function() {
        Swal({
            title: 'ยืนยันการอนุมัติ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: base_url + 'approve/ajax_approve_status',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'approve_id': approveId,
                        'project_type': projectType,
                        'approve_status': 1,
                    },
                    beforeSubmit: function() {
                        $('.bx-respone.m--hides').stop().fadeIn();
                        $(this).prop('disabled', true);
                    },
                    success: function(res) {
                        var thisbaseurl = $(this).attr('data-url');
                        if (res.status) {
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-danger');
                            $('.bx-respone.m--hides').find('.m-alert').addClass('alert-success');
                            $('.bx-respone.m--hides').stop().fadeIn();
                            $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-check-circle"></i>');
                            $('.bx-respone.m--hides').find('.m-alert__text').html(rp.text).delay(1500);
                            $('.bx-respone.m--hides').fadeOut(function() {
                                window.parent.location.href = '' + thisbaseurl + '';
                            });
                        } else {
                            toastr['error'](rp.text, 'Warning');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-success');
                            $('.bx-respone.m--hides').find('.m-alert').addClass('alert-danger');
                            $('.bx-respone.m--hides').stop().fadeIn();
                            $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-warning"></i>');
                            $('.bx-respone.m--hides').find('.m-alert__text').html(res.text).delay(1500);
                            $('.bx-respone.m--hides').fadeOut();
                        }

                        // Complete sending..
                        $("body, html").animate({ scrollTop: $(".bx-respone").position().top });
                        $(this).prop('disabled', false);
                        $(".bx-upload.m--hides").hide();
                    },
                    complete: function() {
                        $(this).prop('disabled', false);
                    }
                });
            }
        })
    });

    $('#btn-reject').on('click', function() {
        swal({
            title: '<strong>กรุณาใส่เหตุผล</strong>',
            type: 'error',
            html: '<textarea class="form-control" name="txt_remark" id="txt_remark"></textarea> ',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                var txtRemark = $('#txt_remark').val();
                $.ajax({
                    url: base_url + 'approve/ajax_approve_status',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'approve_id': approveId,
                        'project_type': projectType,
                        'txt_remark': txtRemark,
                        'approve_status': 0,
                    },
                    beforeSubmit: function() {
                        $('.bx-respone.m--hides').stop().fadeIn();
                        $(this).prop('disabled', true);
                    },
                    success: function(res) {
                        var thisbaseurl = $(this).attr('data-url');
                        if (res.status) {
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-danger');
                            $('.bx-respone.m--hides').find('.m-alert').addClass('alert-success');
                            $('.bx-respone.m--hides').stop().fadeIn();
                            $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-check-circle"></i>');
                            $('.bx-respone.m--hides').find('.m-alert__text').html(rp.text).delay(1500);
                            $('.bx-respone.m--hides').fadeOut(function() {
                                window.parent.location.href = '' + thisbaseurl + '';
                            });
                        } else {
                            toastr['error'](rp.text, 'Warning');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-info');
                            $('.bx-respone.m--hides').find('.m-alert').removeClass('alert-success');
                            $('.bx-respone.m--hides').find('.m-alert').addClass('alert-danger');
                            $('.bx-respone.m--hides').stop().fadeIn();
                            $('.bx-respone.m--hides').find('.m-alert__icon').html('<i class="la la-warning"></i>');
                            $('.bx-respone.m--hides').find('.m-alert__text').html(res.text).delay(1500);
                            $('.bx-respone.m--hides').fadeOut();
                        }

                        // Complete sending..
                        $("body, html").animate({ scrollTop: $(".bx-respone").position().top });
                        $(this).prop('disabled', false);
                        $(".bx-upload.m--hides").hide();
                    },
                    complete: function() {
                        $(this).prop('disabled', false);
                    }
                });
            }
        });
    });

});