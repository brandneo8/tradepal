//== Class MainJs
// JS Ajax Setup
jQuery.ajaxSetup({ cache: false });

var base_url = $("base").attr("href");

jQuery(document).ready(function() {
  $(".submit-realtime").on("click", function() {
    var url = $(this).data("url");
    var table = $(this).data("table");
    var field = $(this).data("field");
    var idfield = $(this).data("idfield");
    var id = $(this).data("id");
    var fvalue = $(this).data("fvalue");
    var value = $(fvalue).val();
    $.ajax({
      url: url + "/main/setupdatefield",
      type: "POST",
      dataType: "json",
      data: {
        table: table,
        field: field,
        idfield: idfield,
        id: id,
        value: value
      },
      success: function(data) {
        if (data.code === 0) {
          swal({
            title: "Saved",
            text: "You data has been updated",
            type: "success",
            showCloseButton: true,
            confirmButtonText: "OK"
          });
        } else {
          swal({
            title: "Save failed",
            text: "Can't updated data please check",
            type: "error",
            showCloseButton: true,
            confirmButtonText: "OK"
          });
        }
        //window.location.reload();
      }
    });
  });

  /* config for toast */
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
  };
  /* end toast */

  $("#submitForm").ajaxForm({
    type: "POST",
    target: ".bx-respone",
    dataType: "json",
    //data: $('#pu-register-sm').serialize(),
    cache: false,
    beforeSubmit: function() {
      $(".bx-respone.m--hides")
        .stop()
        .fadeIn();
      $('button[type="submit"]')
        .prop("disabled", true)
        .html('<i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>');
    },
    uploadProgress: function(event, position, total, percentComplete) {
      $(".bx-upload.m--hides").show();
      $(".progress-bar").width(percentComplete + "%");
      $(".progress-bar").text(percentComplete + "%");
      $(".progress-bar").attr("aria-valuenow", percentComplete);
    },
    success: function(rp) {
      // 'data' is the json object returned from the server
      var thisbaseurl = $("#submitForm").attr("data-url");
      //$('#submitForm')[0].reset();
      if (rp.code == 0) {
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .removeClass("alert-info");
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .removeClass("alert-danger");
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .addClass("alert-success");
        $(".bx-respone.m--hides")
          .stop()
          .fadeIn();
        $(".bx-respone.m--hides")
          .find(".m-alert__icon")
          .html('<i class="la la-check-circle"></i>');
        $(".bx-respone.m--hides")
          .find(".m-alert__text")
          .html(rp.text)
          .delay(1500);
        $(".bx-respone.m--hides").fadeOut(function() {
          swal({
            title: rp.text,
            text: "The system will redirect to modules page..",
            type: "success",
            showCloseButton: true,
            confirmButtonText: "OK"
          }).then(function(e) {
            window.parent.location.href = "" + thisbaseurl + "";
          });
          // swal({
          //     title: rp.text,
          //     text: "The system will redirect to modules page ?",
          //     type: "success",
          //     showCancelButton: !0,
          //     confirmButtonText: "Yes",
          //     cancelButtonText: "No"
          // }).then(function(e) {
          //     if (e.value) {
          //         //window.parent.location.href = '' + thisbaseurl + '';
          //         window.parent.location.href = '' + thisbaseurl + '/../';
          //         $('#submitForm')[0].reset();
          //     } else {
          //         window.parent.location.reload();
          //     }
          // });
        });
      } else {
        swal({
          title: rp.text,
          text: "Please check your information",
          type: "error",
          showCloseButton: true,
          confirmButtonText: "OK"
        });
        //toastr['error'](rp.text, 'Warning');
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .removeClass("alert-info");
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .removeClass("alert-success");
        $(".bx-respone.m--hides")
          .find(".m-alert")
          .addClass("alert-danger");
        $(".bx-respone.m--hides")
          .stop()
          .fadeIn();
        $(".bx-respone.m--hides")
          .find(".m-alert__icon")
          .html('<i class="la la-warning"></i>');
        $(".bx-respone.m--hides")
          .find(".m-alert__text")
          .html(rp.text)
          .delay(1500);
        $(".bx-respone.m--hides").fadeOut();
      }
      $(".bx-respone.m--hides").fadeOut("fast", function() {
        $(".bx-respone.m--hides")
          .stop()
          .fadeIn();
      });

      // Complete sending..
      $("body, html").animate({ scrollTop: $(".bx-respone").position().top });
      $('button[type="submit"]')
        .prop("disabled", false)
        .text("Save");
      $(".bx-upload.m--hides").hide();
    },
    complete: function() {
      $('button[type="submit"]')
        .prop("disabled", false)
        .text("Save");
    }
  });

  $(".setActive").click(function() {
    var sa_url = $(this).attr("data-url");
    var sa_id_field = $(this).attr("data-id-field");
    var sa_id = $(this).attr("data-id");
    var sa_table = $(this).attr("data-table");
    var sa_field_active = $(this).attr("data-field");
    var sa_value = $(this).val();

    if ($(this).prop("checked")) sa_value = 1;
    else sa_value = 0;

    $.ajax({
      url: sa_url + "main/setactive",
      type: "post",
      dataType: "json",
      data: {
        sa_url: sa_url,
        sa_id_field: sa_id_field,
        sa_id: sa_id,
        sa_table: sa_table,
        sa_field_active: sa_field_active,
        sa_value: sa_value
      },
      beforeSend: function() {},
      success: function(data) {
        if (data.code == 0) {
          toastr["success"]("Information has been updated.", "Active");
        } else {
          toastr["error"]("System can't updated.", "Active");
        }
      }
    });
  });

  $(".my-range").asRange({
    // namespace
    namespace: "asRange",
    // requires additional skin file
    skin: null,
    // max value
    max: 0,
    // min value
    min: 0,
    // initial value
    value: null,
    // moving step at a time
    step: 1,
    // limit the range of the pointer moving
    limit: true,
    // initial range
    range: true,
    // 'v' or 'h'
    direction: "h",
    // enable keyboard interactions
    keyboard: true,
    // false, 'inherit', {'inherit': 'default'}
    replaceFirst: false,
    // shows tips
    tip: true,
    // shows scales
    scale: true,
    // for formatting output
    format: function format(value) {
      return value;
    }
  });

  $(".m_datepicker").datepicker({
    todayHighlight: true,
    format: "yyyy-mm-dd",
    orientation: "bottom left",
    templates: {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>'
    }
  });

  $(".m_datepicker_month").datepicker({
    todayHighlight: false,
    defaultViewDate: "month",
    viewMode: "months",
    minViewMode: "months",
    format: "yyyy-mm",
    orientation: "bottom left",
    templates: {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>'
    }
  });

  $(".tum_editor").trumbowyg({
    autogrow: true,
    svgPath: base_url + "assets/css/ui/icons.svg",
    btnsDef: {
      // Create a new dropdown
      image: {
        dropdown: ["insertImage", "upload", "base64"],
        ico: "insertImage"
      }
    },
    btns: [
      ["viewHTML"],
      ["undo", "redo"], // Only supported in Blink browsers
      ["formatting"],
      ["strong", "em", "del"],
      ["superscript", "subscript"],
      ["link"],
      ["table"],
      ["noembed"],
      ["image"],
      ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
      ["unorderedList", "orderedList"],
      ["horizontalRule"],
      ["removeformat"],
      ["fullscreen"]
    ],
    plugins: {
      upload: {
        serverPath: base_url + "main/upload_tum"
      }
    }
  });

  $.each($(".ck-editor"), function() {
    // ckeditor
    var _myckeditor = $(this).attr("name");

    CKEDITOR.replace(_myckeditor, {
      width: "100%",
      height: "250",
      skin: "moonocolor",
      enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P,
      extraPlugins: "imageresize,table,tabletools,tableresize",
      filebrowserBrowseUrl: base_url + "assets/plugins/ckfinder/ckfinder.html",
      filebrowserUploadUrl:
        base_url +
        "assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files"
    });
  });
});

// ekeditor
function CKupdate() {
  for (instance in CKEDITOR.instances)
    CKEDITOR.instances[instance].updateElement();
}

function genURL(ele, target) {
  var str = ele.value;
  var a =
    "àáäâãåăæąçćčđďèéěėëêęǵḧìíïîįłḿǹńňñòóöôœøṕŕřßśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;";
  var b =
    "aaaaaaaaacccddeeeeeeeghiiiiilmnnnnooooooprrssssttuuuuuuuuuwxyyzzz------";
  var p = new RegExp(a.split("").join("|"), "g");

  var res = str
    .toString()
    .toLowerCase()
    .replace(/\s+/g, "-") // Replace spaces with -
    .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
    .replace(/&/g, "-and-") // Replace & with 'and'
    .replace(/[^\w\-]+/g, "") // Remove all non-word characters
    .replace(/\-\-+/g, "-") // Replace multiple - with single -
    .replace(/^-+/, "") // Trim - from start of text
    .replace(/-+$/, ""); // Trim - from end of text
  $(target).val(res);
}

$(document).on("click", ".crm-delete", function(e) {
  e.preventDefault();
  var deleteUrl = $(this).attr("href");
  swal({
    title: "Delete",
    text: "You want to delete this row ?",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes",
    cancelButtonText: "No"
  }).then(function(e) {
    if (e.value) {
      window.parent.location.href = "" + deleteUrl + "";
    } else {
      return false;
    }
  });
});

$(document).on("click", ".setActive", function() {
  var sa_url = $(this).attr("data-url");
  var sa_id_field = $(this).attr("data-id-field");
  var sa_id = $(this).attr("data-id");
  var sa_table = $(this).attr("data-table");
  var sa_field_active = $(this).attr("data-field");
  var sa_value = $(this).val();

  if ($(this).prop("checked")) sa_value = 1;
  else sa_value = 0;

  $.ajax({
    url: sa_url + "main/setactive",
    type: "post",
    dataType: "json",
    data: {
      sa_url: sa_url,
      sa_id_field: sa_id_field,
      sa_id: sa_id,
      sa_table: sa_table,
      sa_field_active: sa_field_active,
      sa_value: sa_value
    },
    beforeSend: function() {},
    success: function(data) {
      if (data.code == 0) {
        toastr["success"]("Information has been updated.", "Active");
      } else {
        toastr["error"]("System can't updated.", "Active");
      }
    }
  });
});

var updateSEQ = function(direct, table, field, field_id, id, options) {
  var getDirect = direct;
  var getTable = table;
  var getField = field;
  var getFieldID = field_id;
  var getID = id;
  //var getOption = $.parseJSON(options);
  var getOption = options;

  $.ajax({
    url: base_url + "main/setseq",
    type: "POST",
    dataType: "json",
    data: {
      getDirect: getDirect,
      getTable: getTable,
      getField: getField,
      getFieldID: getFieldID,
      getID: getID,
      getOption: getOption
    },
    beforeSend: function() {},
    success: function(data) {
      if (data.code == 0) {
        toastr["success"]("Sequence has been updated.", "Congraturation!");
        window.location.reload();
      } else {
        toastr["error"]("Sequence update failed.", "System error!");
      }
    },
    complete: function() {}
  });
};

var schShowhide = function(hele, sele, shele, speed) {
  shele = typeof shele !== "undefined" ? shele : null;

  if (speed == "") {
    speed = "fast";
  }
  if (sele !== "") {
    $(sele)
      .fadeIn("fast")
      .show();
    if (shele !== null) {
      var Setreset = $(shele).attr("data-hide");

      if (Setreset) {
        $(shele)
          .fadeIn("fast")
          .show();
      }
    }
  }
  if (hele !== "") {
    $(hele)
      .fadeOut("fast")
      .hide();
    if (shele !== null) {
      var Setreset = $(shele).attr("data-hide");

      if (Setreset) {
        $(shele)
          .fadeOut("fast")
          .hide();
      }
    }
  }
};

var schShowtg = function(ele, speed) {
  if (speed == "") {
    speed = "fast";
  }
  $(ele).fadeToggle(speed);
};

var ajaxdel = function(table, field, id) {
  $.ajax({
    url: base_url + "main/ajaxdel",
    type: "POST",
    dataType: "json",
    data: { table: table, field: field, id: id },
    beforeSend: function() {},
    success: function(data) {
      if (data.code == 0) {
        toastr["success"]("This record has been deleted.", "Respone");
        //window.location.reload();
      } else {
        toastr["error"]("System can't delete this record.", "Respone");
      }
    },
    complete: function() {}
  });

  $(".m-select2").select2();
};

var updateMultiselect = function(target, ele) {
  if ($(ele).attr("checked")) {
    $(target).multiSelect("select_all");
  } else {
    $(target).multiSelect("deselect_all");
  }
};

var genSeourl = function(vals, target) {
  $.ajax({
    url: base_url + "main/genseourl",
    type: "POST",
    dataType: "json",
    data: { vals: vals },
    beforeSend: function() {},
    success: function(data) {
      $(target).val(data.data);
    },
    complete: function() {}
  });
};
