requirejs.config({
  baseUrl: "http://localhost:9900/assets/js/lib",
  // baseUrl: 'http://min-yota.com/assets/inspinia/js/lib',
  paths: {
    jquery: "jquery-2.1.1",
    bootstrap: "bootstrap.min",
    metisMenu: "plugins/metisMenu/jquery.metisMenu",
    slimscroll: "plugins/slimscroll/jquery.slimscroll.min",
    pace: "plugins/pace/pace.min",
    codemirror: "plugins/codemirror/codemirror",
    codemirrorjs: "plugins/codemirror/mode/javascript/javascript",
    jqueryForm: "plugins/jqueryForm/jquery.form",
    validate: "plugins/validate/jquery.validate.min",
    toastr: "plugins/toastr/toastr.min",
    sweetalert: "plugins/sweetalert/sweetalert.min",
    clipboard: "plugins/clipboard/clipboard.min",
    moment: "plugins/fullcalendar/moment.min",
    // iCheck: "plugins/iCheck/icheck.min",
    fullcalendar: "plugins/fullcalendar/fullcalendar.min",
    datepicker: "plugins/datapicker/bootstrap-datepicker",
    daterange: "plugins/daterangepicker/daterangepicker",
    select2: "plugins/select2/select2.full.min",
    TouchSpin: "plugins/touchspin/jquery.bootstrap-touchspin.min",
    inspinia: "../methods/inspinia.min",
    function: "../methods/app/function",
    callvalidate: "../methods/callvalidate.min",
    callplugins: "../methods/callplugins.min"
  },
  shim: {
    bootstrap: {
      deps: ["jquery"]
    },
    codemirrorjs: {
      deps: ["codemirror"]
    },
    metisMenu: {
      deps: ["jquery"]
    },
    slimscroll: {
      deps: ["jquery"]
    },
    moment: {
      deps: ["jquery", "bootstrap"]
    },
    //  iCheck : {
    //     deps: ["jquery"]
    //   },
    fullcalendar: {
      deps: ["jquery", "bootstrap", "moment"]
    },
    datepicker: {
      deps: ["jquery", "bootstrap"]
    },
    daterange: {
      deps: ["jquery"]
    },
    select2: {
      deps: ["jquery"]
    },
    TouchSpin: {
      deps: ["jquery"]
    },
    jqueryForm: {
      deps: ["jquery"]
    },
    clipboard: {
      deps: ["jquery"]
    },
    inspinia: {
      deps: ["jquery", "metisMenu", "slimscroll"]
    }
  }
});

// Start the main app logic.
requirejs(
  [
    "jquery",
    "bootstrap",
    "codemirrorjs",
    "metisMenu",
    "slimscroll",
    "moment",
    // "iCheck",
    "fullcalendar",
    "pace",
    "codemirror",
    "jqueryForm",
    "validate",
    "clipboard",
    "inspinia"
  ],
  function($) {
    // @ts-ignore
    require(["function", "callplugins", "callvalidate", "clipboard"], function(
      fun,
      plug,
      vali,
      Clipboard
    ) {
      new Clipboard(".clipboard");
      vali.validate();
      plug.datepicker();
      plug.select2();
      plug.fullcalendar();
      plug.TouchSpin();
      plug.fullcalendar();
      $(".btn-reload").click(function() {
        location.reload();
      });
    });
  }
);

// sweetalert none
$(".btn-alert").click(function() {
  var url = $(this).attr("data-url");
  var title = $(this).attr("data-title");
  var text = $(this).attr("data-text");
  swal(
    {
      title: title,
      text: text,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#c0392b",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) {
        location.href = url;
      }
    }
  );
});

$(".timechecks").change(function() {
  var url = $(this).attr("data-url");
  swal(
    {
      title: "ยืนยันการเปลี่ยนแปลงช่วงเวลา",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#c0392b",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) {
        location.href = url;
      } else {
        location.reload();
      }
    }
  ); 
});

// sweetalert ckeck
$(".btn-check").click(function() {
  var url = $(this).attr("data-url");
  var urlCheck = $(e).attr("data-urlCheck");
  var title = $(this).attr("data-text");
  swal(
    {
      title: title,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#c0392b",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          method: "POST",
          dataType: "json",
          url: urlCheck,
          success: function(result) {
            if (result.error === true) {
              swal(result.title, result.msg, "error");
            } else {
              location.href = url;
            }
          }
        });
      }
    }
  );
});

// datatable-export
$(".dataTables-export tfoot th").each(function() {
  var title = $(this).text();
  if ($(this).hasClass("ftinput")) {
    $(this).html(
      '<input type="text" class= "form-control ftsearch" placeholder="ค้นหา ' +
        title +
        '" />'
    );
  }
});
// DataTable
var exportcol = $(".dataTables-export").attr("data-colexport");
var filename = $(".dataTables-export").attr("data-filename");
var table = $(".dataTables-export").DataTable({
  responsive: true,
  ordering: false,
  language: {
    sSearch: "ค้นหา",
    zeroRecords: "ไม่พบข้อมูลที่คุณค้นหา",
    emptyTable: "ไม่มีข้อมูล",
    paginate: {
      next: "ถัดไป",
      previous: "ย้อนกลับ"
    },
    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
    infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
    lengthMenu: "แสดง _MENU_ รายการ"
  },
  dom: '<"html5buttons"B>lfrtip',
  buttons: [
    {
      extend: "copy",
      title: filename,
      exportOptions: {
        columns: [exportcol]
      }
    },
    {
      extend: "excel",
      title: filename,
      exportOptions: {
        columns: [exportcol]
      }
    }
  ]
});
// Apply the search
table.columns().every(function() {
  var that = this;
  $("input", this.footer()).on("keyup change", function() {
    if (that.search() !== this.value) {
      that.search(this.value).draw();
    }
  });
});

// datatable-basic
$(".dataTables tfoot th").each(function() {
  var titles = $(this).text();
  if ($(this).hasClass("ftinput")) {
    $(this).html(
      '<input type="text" class= "form-control ftsearch" placeholder="ค้นหา ' +
        titles +
        '" />'
    );
  }
});
// DataTable
var tables = $(".dataTables").DataTable({
  responsive: true,
  ordering: false,
  language: {
    sSearch: "ค้นหา",
    zeroRecords: "ไม่พบข้อมูลที่คุณค้นหา",
    emptyTable: "ไม่มีข้อมูล",
    paginate: {
      next: "ถัดไป",
      previous: "ย้อนกลับ"
    },
    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
    infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
    lengthMenu: "แสดง _MENU_ รายการ"
  },
  dom: "lfrtip"
});
// Apply the search
tables.columns().every(function() {
  var that = this;
  $("input", this.footer()).on("keyup change", function() {
    if (that.search() !== this.value) {
      that.search(this.value).draw();
    }
  });
});

$(".btnajax").click(function() {
  var date = $(this).attr("data-date");
  var time = $(this).attr("data-time");
  var url = $(this).attr("data-url");
  console.log(url);
  $.ajax({
    method: "POST",
    dataType: "json",
    url: url,
    data: {
      date: date,
      time: time
    },
    success: function(result) {
      console.log(result);
      $("#listtt").empty();
      $.each(result, function(index, item) {
        $("#listtt").append(
          $('<li><span class="m-l-xs">' + item.name + "</span></li>").append()
          // $('<option value="'+item.type_id+'">'+item.type_name_th+' | '+item.type_name_en+'</option>').append()
        );
      });
    },
    error: function(jqXHR, exception) {
      if (jqXHR.status === 0) {
        alert("Not connect.\n Verify Network.");
      } else if (jqXHR.status == 404) {
        alert("Requested page not found. [404]");
      } else if (jqXHR.status == 500) {
        alert("Internal Server Error [500].");
      } else if (exception === "parsererror") {
        alert("Requested JSON parse failed.");
      } else if (exception === "timeout") {
        alert("Time out error.");
      } else if (exception === "abort") {
        alert("Ajax request aborted.");
      } else {
        alert("Uncaught Error.\n" + jqXHR.responseText);
      }
    }
  });
});
