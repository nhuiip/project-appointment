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
      plug.TouchSpin();
      // reload
      $(".btn-reload").click(function() {
        location.reload();
      });
    });
  }
);

// sweetalert none
$(".btn-alert").click(function() {
  var url = $(this).attr("data-url");
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
        location.href = url;
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
      extend: "copy"
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


function ShowHidePassword() {
  var x = document.getElementById("text_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}