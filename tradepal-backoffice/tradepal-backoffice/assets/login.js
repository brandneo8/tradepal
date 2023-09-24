// Allow submit by enter
$('form').on('keypress', function (e) {
    if (e.which == 13) {
        $(this).submit();
        return false;
    }
});

// login process
$("#loginProcess").on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        beforeSend: function () {
            $('.note').fadeIn(function () {
                $(this).removeClass('note-warning');
                $(this).removeClass('note-danger');
                $(this).find('span').text('Checking..');
            });
        },
        success: function (data) {
            if (data.code == 1 || data.code == 2 || data.code == 3) {
                $('.note').fadeIn(function () {
                    $(this).removeClass('note-warning');
                    $(this).addClass('note-danger');
                    $(this).find('span').text(data.text);
                });
            } else {
                $('.note').removeClass('note-danger');
                $('.note').removeClass('note-warning');
                $('.note').addClass('note-success');
                $('.note').find('span').text(data.text);
                window.location.href = $("#loginProcess").attr('data-baseurl');
            }
        }
    });
});