requirejs.config({
  baseUrl: "http://localhost:9900/assets/js/lib",
  // baseUrl: 'http://ift.idt.rmutr.ac.th/examschedule/assets/js/lib',
  paths: {
    jquery: "jquery-2.1.1",
    jqueryui: "plugins/jquery-ui/jquery-ui.min",
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
    fullcalendar: "plugins/fullcalendar/fullcalendar.min",
    datepicker: "plugins/datapicker/bootstrap-datepicker",
    colorpicker: "plugins/colorpicker/bootstrap-colorpicker.min",
    daterange: "plugins/daterangepicker/daterangepicker",
    select2: "plugins/select2/select2.full.min",
    TouchSpin: "plugins/touchspin/jquery.bootstrap-touchspin.min",
    inspinia: "../methods/inspinia.min",
    function: "../methods/app/function",
    callvalidate: "../methods/callvalidate.min",
    callplugins: "../methods/callplugins.min",
    chosen: 'plugins/chosen/chosen.jquery',
  },
  shim: {
    bootstrap: {
      deps: ["jquery"]
    },
    jqueryui: {
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
    fullcalendar: {
      deps: ["jquery", "bootstrap", "moment"]
    },
    datepicker: {
      deps: ["jquery", "bootstrap"]
    },
    colorpicker: {
      deps: ["jquery", "bootstrap"]
    },
    daterange: {
      deps: ["jquery"]
    },
    select2: {
      deps: ["jquery"]
    },
    chosen: {
      deps: ['jquery'],
      exports: "chosen"
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
  function ($) {
    // @ts-ignore
    require(["function", "callplugins", "callvalidate", "clipboard"], function (
      fun,
      plug,
      vali,
      Clipboard
    ) {
      new Clipboard(".clipboard");
      vali.validate();
      plug.datepicker();
      plug.colorpicker();
      plug.select2();
      plug.fullcalendar();
      plug.TouchSpin();
      plug.fullcalendar();
      plug.chosen();
      $(".btn-reload").click(function () {
        location.reload();
      });
      $('#text_type').change(function () {
				fun.jsontimes(this);
			});
    });
  }
);
$('.collapse-link').click(function () {
  var ibox = $(this).closest('div.ibox');
  var button = $(this).find('i');
  var content = ibox.find('div.ibox-content');
  content.slideToggle(200);
  button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
  ibox.toggleClass('').toggleClass('border-bottom');
  setTimeout(function () {
      ibox.resize();
      ibox.find('[id^=map-]').resize();
  }, 50);
});
// sweetalert none
$(".btn-alert").click(function () {
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
    function (isConfirm) {
      if (isConfirm) {
        location.href = url;
      }
    }
  );
});

// sweetalert trace
$(".btn-trace").click(function () {
  var url = $(this).attr("data-url");
  var geturl = $(this).attr("data-geturl");
  var title = $(this).attr("data-title");
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
    function (isConfirm) {
      if (isConfirm) {

        // location.href = url;

        $.ajax({
          method: "POST",
          dataType: "json",
          url: url,
          success: function (result) {
            if (result.error === true) {
              swal(result.title, result.msg, "error");
            } else {
              // location.href = geturl;
              window.open(geturl, '_blank', '');
              location.reload();
            }
          }
        });

      }
    }
  );
});

$(".btn-reloadmeet").click(function () {

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
    function (isConfirm) {
      if (isConfirm) {
        swal.close();
        $(".loading").show();
        location.href = url;
      }
    }
  );
});


$(".timechecks").change(function () {
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
    function (isConfirm) {
      if (isConfirm) {
        location.href = url;
      } else {
        location.reload();
      }
    }
  );
});

// sweetalert ckeck
$(".btn-check").click(function () {
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
    function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          method: "POST",
          dataType: "json",
          url: urlCheck,
          success: function (result) {
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


$(".btn-checkuserHead").click(function () {
  var url = $(this).attr("data-url");
  var title = $(this).attr("data-title");
  var text = $(this).attr("data-text");
  var id = $(this).attr("data-id");
  var meetId = $(this).attr("data-meetId");

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
    function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          method: "POST",
          dataType: "json",
          url: url,
          data: {
            id: id,
            meetId: meetId
          },
          success: function (result) {

            $meetId = result.meet_id;
            location.href = '/calendar/showcalendar/' + $meetId + '';

          }
        });
      }
    },

  );
});

//DataTable -----------------------------------------------------------------------------------------------//
// datatable-export tfoot search
$(".dataTables-export tfoot th").each(function () {
  var title = $(this).text();
  if ($(this).hasClass("ftinput")) {
    $(this).html(
      '<input type="text" class= "form-control ftsearch" placeholder="ค้นหา ' +
      title +
      '" />'
    );
  }
});
// datatable-export
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
  dom: 'Brtip',
  buttons: [
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
table.columns().every(function () {
  var that = this;
  $("input", this.footer()).on("keyup change", function () {
    if (that.search() !== this.value) {
      that.search(this.value).draw();
    }
  });
});
$(".dt-buttons").hide();
$(".dataTables_filter").hide();
// search .dataTables
$("#search-btn").click(function () {
  // $('#search-btn').on( 'click', function () {
  var val = $("#search-input").val();
  table.search( val ).draw();
});
// export excel
$("#btnexport").click(function () {
// $('#btnexport').on('click', function () { 
  table.button( '.buttons-excel' ).trigger();
});
// DataTable end --------------------------------------------------------------------------------------------//

$(".btnajax").click(function () {

  // window.localStorage.removeItem('productCompare');

  var date = $(this).attr("data-date");
  var time = $(this).attr("data-time");
  var sub = $(this).attr("data-sub");
  var subid = $(this).attr("data-subid");
  var url = $(this).attr("data-url");

  $.ajax({
    method: "POST",
    dataType: "json",
    url: url,
    data: {
      date: date,
      time: time,
      sub: sub,
      subid: subid,
    },
    success: function (result) {

      console.log(result);

      $("#listtt").empty();
      $("#listtts").empty();

      $("#listttbutton").append('<div class="alert alert-warning alert-dismissable hide" id="formError" style="color:#333"> กรุณาเลือกประธานสำหรับการขอขึ้นสอบ <a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a> </div>');

      $.each(result, function (index, item) {
        $('#txt_time').val(item.time);

        $("#listtt").append(
          $('<li><span class="m-l-xs"><div class="checkbox checkbox-primary checkbox-inline"> <input onclick="toggle_visibility(' + item.id + ')"  type="checkbox" name="checkUser[]" class="charr" id="checkUser' + item.id + '" value="' + item.id + ' " ' + item.subjectUserId + '  > <label for="checkUser' + item.id + ' "> ' + item.name + ' ' + item.subjectUserstatus + ' '+item.subjectPositionstatus+'</label> </div></span>' + item.checkuserHidden + ' ' + item.rediouserHidden + '</li> ').append()
        );
      });
      
    },
  });
});

function toggle_visibility(id) {
  // var arr = this.toArray();
  var num = $('#checkuse').val();
  var arr = Array();
  // $(".charr").each(function () {
  $("input:checkbox[class=charr]:checked").each(function () {
    arr.push($(this).val());
  });
  if(arr.length == num ){
    $("#listtts").append('<button type="submit" class="btn btn-block btn-w-m btn-info" id="btnsubsmit">ส่งคำขอขึ้นสอบปริญญานิพนธ์</button>');
  } else{
    $("#listtts").empty();

  }
  // console.log(arr);
  var e = document.getElementById(id);
  if (e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}



