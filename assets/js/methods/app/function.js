define(["jquery", "jqueryForm", "toastr", "sweetalert"], function(
  $,
  jqueryForm,
  toastr,
  swal
) {
  var methods = {};

  methods.Testfunction = function(element, animation) {
    console.log("Testfunction");
  };
  methods.animationHover = function(element, animation) {
    element = $(element);
    element.hover(
      function() {
        element.addClass("animated " + animation);
      },
      function() {
        //wait for animation to finish before removing classes
        window.setTimeout(function() {
          element.removeClass("animated " + animation);
        }, 2000);
      }
    );
  };

  // custom function
  // submit form
  methods.dataSubmit = function(form) {
    $(form).ajaxSubmit({
      dataType: "json",
      success: function(result) {
        toastr.options = {
          closeButton: true,
          progressBar: true,
          showMethod: "slideDown",
          timeOut: 4000
        };
        if (result.error === true) {
          toastr.error(result.title, result.msg);
        } else {
          toastr.success(result.title, result.msg);
          setTimeout(function() {
            location.href = result.url;
          }, 1000);
        }
      }
    });
  };

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

  return methods;
});
