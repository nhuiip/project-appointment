define([
  "jquery",
  "bootstrap",
  "bootstrap_colorpicker",
  "datepicker",
  "daterange",
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

  return methods;
});
