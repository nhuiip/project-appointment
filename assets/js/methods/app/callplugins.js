define([
  "jquery",
  "bootstrap",
  "bootstrap_colorpicker",
  "datepicker",
  "daterange",
  "select2",
  "TouchSpin",
  // "iCheck",
  "fullcalendar"
], function($) {
  var methods = {};

  methods.datepicker = function() {
    var date = new Date();
    $(".datepicker").datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: true,
      autoclose: true,
      format: "yyyy-mm-dd"
    });
    $(".yearpicker").datepicker({
      startView: 1,
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years"
    });
  };

  methods.daterange = function() {
    $("#data_5 .input-daterange").datepicker({
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      format: "dd-mm-yyyy"
    });
  };

  methods.select2 = function() {
    $(".select2").select2({
      placeholder: "กรุณาเลือก",
      allowClear: true
    });

    $(".select2_demo_2").select2({
      tags: true,
      placeholder: "ค้นหารหัสนักศึกษา"
    });
  };

  methods.TouchSpin = function() {
    $(".touchspin").TouchSpin({
      buttondown_class: "btn btn-white",
      buttonup_class: "btn btn-white"
    });
  };

  methods.fullcalendar = function() {
    var burl = $('#calendar').attr('data-url');
		$('#calendar').fullCalendar({
			eventLimit: true, // allow "more" link when too many events
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: new Date(),
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: burl
      },
      // eventColor: '#378006',
		});
    // console.log(url);
  };

  // methods.iCheck = function() {
  //   $(".i-checks").iCheck({
  //     checkboxClass: "icheckbox_square-green",
  //     radioClass: "iradio_square-green"
  //   });
  // };

  return methods;
});
