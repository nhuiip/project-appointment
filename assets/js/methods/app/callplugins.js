define([
  "jquery",
  "bootstrap",
  "bootstrap_colorpicker",
  "datepicker",
  "colorpicker",
  "daterange",
  "select2",
  "TouchSpin",
  "chosen",
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

  methods.colorpicker = function(){
    $('.colorpicker').colorpicker();
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
    var placeholder = $('.select2').attr('data-placeholder');
    $(".select2").select2({
      placeholder: placeholder,
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
				right: 'month'
			},
			defaultDate: new Date(),
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: burl
      },
		});
  };

  methods.chosen = function(e) {
    var config = {
      ".chosen-select": {},
      ".chosen-select-deselect": { allow_single_deselect: true },
      ".chosen-select-no-single": { disable_search_threshold: 10 },
      ".chosen-select-no-results": { no_results_text: "Oops, nothing found!" },
      ".chosen-select-width": { width: "100%" }
    };
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  };

  return methods;
});
