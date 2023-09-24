/* js function */
var errMsg = 'Error please check';
var sucMsg = 'Processing completed';

Date.isLeapYear = function(year) {
    return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
};

Date.getDaysInMonth = function(year, month) {
    return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function() {
    return Date.isLeapYear(this.getFullYear());
};

Date.prototype.getDaysInMonth = function() {
    return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function(value) {
    var n = this.getDate();
    console.log(this.getMonth());
    this.setDate(1);
    this.setMonth(this.getMonth() + value);
    this.setDate(Math.min(n, this.getDaysInMonth()));
    return this;
};

var _updateNextEle = function(ele, target, url) {
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: { id: (ele.value ? ele.value : '-1') },
        beforeSend: function() {
            $(target).html('');
        },
        success: function(data) {
            if (data.code == 0) {
                $(target).html(data.html);
            } else {
                toastr['error'](data.respone, errMsg);
            }
        },
        complete: function() {

        }
    });
}

var genProjectCode = function(url, department_id) {
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: { department_id: department_id },
        beforeSend: function() {

        },
        success: function(data) {
            $('input[name="project_code"]').val(data.project_code);
        },
        complete: function() {

        }
    });
}