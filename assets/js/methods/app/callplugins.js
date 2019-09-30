define([
  "jquery",
  "bootstrap",
  "bootstrap_colorpicker",
  "datepicker",
  "daterange",
  "select2",
  "TouchSpin",
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
      placeholder: 'ค้นหารหัสนักศึกษา'
    });
  };

  methods.fullcalendar = function() {
    /* initialize the calendar  -----------------------------------------------------------------*/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1)
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d-5),
                end: new Date(y, m, d-2)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d-3, 16, 0),
                allDay: false
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d+4, 16, 0),
                allDay: false
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d+1, 19, 0),
                end: new Date(y, m, d+1, 22, 30),
                allDay: false
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }
        ]
});


  };

  methods.TouchSpin = function() {
    $(".touchspin").TouchSpin({
      buttondown_class: "btn btn-white",
      buttonup_class: "btn btn-white",
    });
  };

  return methods;
});
