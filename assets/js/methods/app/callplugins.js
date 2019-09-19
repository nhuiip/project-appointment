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
  };

  methods.TouchSpin = function() {
    $(".touchspin").TouchSpin({
      buttondown_class: "btn btn-white",
      buttonup_class: "btn btn-white",
    });
  };

  return methods;
});
