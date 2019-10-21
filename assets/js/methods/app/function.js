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
          // console.log(result.url);
          if(result.url == 'reload'){
            setTimeout(function() {
              location.reload();
            }, 1000);
          } else{
            setTimeout(function() {
              location.href = result.url;
            }, 1000);
          }
        }
      }
    });
  };

  // methods.dataReload = function(form) {
  //   $(form).ajaxSubmit({
  //     dataType: "json",
  //     success: function(result) {
  //       toastr.options = {
  //         closeButton: true,
  //         progressBar: true,
  //         showMethod: "slideDown",
  //         timeOut: 4000
  //       };
  //       if (result.error === true) {
  //         toastr.error(result.title, result.msg);
  //       } else {
  //         toastr.success(result.title, result.msg);
  //         setTimeout(function() {
  //           location.href = location.reload();
  //         }, 1000);
  //       }
  //     }
  //   });
  // };

  return methods;
});
