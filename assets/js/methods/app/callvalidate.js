define(["jquery", "function", "bootstrap", "validate"], function($, fun) {
  var methods = {};
  jQuery.validator.addMethod(
    "engonly",
    function(value, element) {
      return this.optional(element) || /^[a-z," "]+$/i.test(value);
    },
    ""
  );
  jQuery.validator.addMethod(
    "thaionly",
    function(value, element) {
      return this.optional(element) || /^[u0E01-u0E5B]+$/i.test(value);
    },
    ""
  );
  methods.validate = function(e) {
    // formAdministrators
    if ($("#formAdministrators_C").length) {
      $("#formAdministrators_C").validate({
        rules: {
          use_name: { required: true },
          position_id: { required: true },
          use_email: {
            required: true,
            email: true,
            remote: {
              url: $("#use_email").attr("data-url"),
              type: "post",
              data: {
                use_email: function() {
                  return $("#use_email").val();
                }
              }
            }
          },
          use_pass: {
            required: true,
            required: true,
            minlength: 6
          },
          use_confirmPassword: {
            required: true,
            minlength: 6,
            equalTo: "#use_pass"
          }
        },
        messages: {
          use_name: {
            required: "กรุณากรอกชื่อเต็ม."
          },
          position_id: {
            required: "กรุณาเลือกระดับผู้ใช้."
          },
          use_email: {
            required: "กรุณากรอกอีเมล.",
            email: "รูปแบบอีเมลผิดพลาด.",
            remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
          },
          use_pass: {
            required: "กรุณากรอกรหัสผ่าน.",
            minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร."
          },
          use_confirmPassword: {
            required: "กรุณากรอกรหัสผ่านอีกครั้ง.",
            minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร.",
            equalTo: "รหัสผ่านไม่ถูกต้อง"
          }
        },
        errorPlacement: function(error, element) {
          if (element.is(":radio") || element.is(":checkbox")) {
            error.appendTo(element.parent());
          } else {
            error.insertAfter(element);
          }
        },
        showErrors: function(errorMap, errorList) {
          submitted = true;
          if (submitted) {
            var summary =
              '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
            $.each(errorList, function() {
              summary +=
                ' <font color="#FF0000">*</font> ' + this.message + "<br/>";
            });
            $("#formError").html(summary);
            $("#formError").slideDown();
            $("#formError").removeClass("hide");
            submitted = false;
          }
          this.defaultShowErrors();
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formAdministrators_Up").length) {
      $("#formAdministrators_Up").validate({
        rules: {
          use_name: { required: true },
          position_id: { required: true },
          use_email: {
            required: true,
            email: true
          }
        },
        messages: {
          use_name: {
            required: "กรุณากรอกชื่อเต็ม."
          },
          position_id: {
            required: "กรุณาเลือกระดับผู้ใช้."
          },
          use_email: {
            required: "กรุณากรอกข้อมูล.",
            email: "รูปแบบ E-mail ผิดพลาด."
          }
        },
        errorPlacement: function(error, element) {
          if (element.is(":radio") || element.is(":checkbox")) {
            error.appendTo(element.parent());
          } else {
            error.insertAfter(element);
          }
        },
        showErrors: function(errorMap, errorList) {
          submitted = true;
          if (submitted) {
            var summary =
              '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
            $.each(errorList, function() {
              summary +=
                ' <font color="#FF0000">*</font> ' + this.message + "<br/>";
            });
            $("#formError").html(summary);
            $("#formError").slideDown();
            $("#formError").removeClass("hide");
            submitted = false;
          }

          this.defaultShowErrors();
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formRepass").length) {
      $("#formRepass").validate({
        rules: {
          use_pass: {
            required: true,
            required: true,
            minlength: 6
          },
          use_confirmPassword: {
            required: true,
            minlength: 6,
            equalTo: "#use_pass"
          }
        },
        messages: {
          use_pass: {
            required: "กรุณากรอกรหัสผ่าน.",
            minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร."
          },
          use_confirmPassword: {
            required: "กรุณากรอกรหัสผ่านอีกครั้ง.",
            minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร.",
            equalTo: "รหัสผ่านไม่ถูกต้อง"
          }
        }, 
        errorPlacement: function(error, element) {
          if (element.is(":radio") || element.is(":checkbox")) {
            error.appendTo(element.parent());
          } else {
            error.insertAfter(element);
          }
        },
        showErrors: function(errorMap, errorList) {
          submitted = true;
          if (submitted) {
            var summary =
              '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
            $.each(errorList, function() {
              summary +=
                ' <font color="#FF0000">*</font> ' + this.message + "<br/>";
            });
            $("#formError").html(summary);
            $("#formError").slideDown();
            $("#formError").removeClass("hide");
            submitted = false;
          }
          this.defaultShowErrors();
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formSetting").length) {
      $("#formSetting").validate({
        rules: {
          set_year: {
            required: true,
            number: true
          },
          set_term: {
            required: true
          },
          set_open: {
            required: true
          },
          set_close: {
            required: true
          }
        },
        messages: {
          set_year: {
            required: "กรุณากรอกปีการศึกษา.",
            number: "กรอกเฉพาะตัวเลขเท่านั้น"
          },
          set_term: {
            required: "กรุณาเลือกเทอม."
          },
          set_open: {
            required: "กรุณาระบุวันเปิดนัด."
          },
          set_close: {
            required: "กรุณาระบุวันปิดนัด."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formCHoliday").length) {
      $("#formCHoliday").validate({
        rules: {
          hol_name: {
            required: true
          },
          hol_date: {
            required: true
          }
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล."
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formEHoliday").length) {
      $("#formEHoliday").validate({
        rules: {
          hol_name: {
            required: true
          },
          hol_date: {
            required: true
          }
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล."
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formSubject").length) {
      $("#formSubject").validate({
        rules: {
          sub_name: {
            required: true
          },
          sub_code: {
            required: true
          },
          use_id: {
            required: true
          },
          sub_setuse: {
            required: true
          },
          sub_setless: {
            required: true
          },
          sub_type: {
            required: true
          }
        },
        errorPlacement: function() {
          $("#formError").slideDown();
          $("#formError").removeClass("hide");
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    // if ($("#formSubject").length) {
    //   $("#formSubject").validate({
    //     rules: {
    //       sub_name: {
    //         required: true
    //       },
    //       sub_code: {
    //         required: true
    //       },
    //       use_id: {
    //         required: true
    //       },
    //       sub_setuse: {
    //         required: true
    //       },
    //       sub_setless: {
    //         required: true
    //       },
    //       sub_type: {
    //         required: true
    //       }
    //     },
    //     messages: {
    //       sub_name: {
    //         required: "กรุณากรอกชื่อวิชา."
    //       },
    //       sub_code: {
    //         required: "กรุณากรอกรหัสวิชา."
    //       },
    //       use_id: {
    //         required: "กรุณาเลือกรอาจารย์ผู้สอน."
    //       },
    //       sub_setuse: {
    //         required: "กรุณากรอกจำนวนอาจารย์ขึ้นสอบ."
    //       },
    //       sub_setless: {
    //         required: "กรุณากรอกอาจารย์ขึ้นสอบอย่างน้อย."
    //       },
    //       sub_type: {
    //         required: "กรุณาเลือกประเภทวิชา."
    //       }
    //     },
    //     errorPlacement: function(error, element) {
    //       if( element.is(':radio') || element.is(':checkbox')) {
    //           error.appendTo(element.parent());
    //       } else {
    //           error.insertAfter(element);
    //       }
    //   },//end errorPlacement
    //   showErrors: function(errorMap, errorList) {
    //     submitted = true;
    //     if (submitted) {
    //           var summary = '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
    //           $.each(errorList, function() { summary += " * " + this.message + "<br/>"; });
    //           $("#formAlert").html(summary);
    //           submitted = false;
    //       }

    //       this.defaultShowErrors();
    //   },
    //     submitHandler: function(form) {
    //       fun.dataSubmit(form);
    //       return false;
    //     }
    //   });
    // }

    //################################################################## yui
    if ($("#formStudentProfile").length) {
      $("#formStudentProfile").validate({
        rules: {
          text_name: {
            required: true
          },
          text_lastname: {
            required: true
          },
          text_email: {
            required: true,email: true
          },
          text_tel: {
            required: true
          },
          text_password: {
            required: true
          },
        },
        messages: {
          text_email: {
            required: "กรุณากรอกข้อมูล.",
            email: "รูปแบบ E-mail ผิดพลาด."
          }
        },
        errorPlacement: function() {
          $("#formError").slideDown();
          $("#formError").removeClass("hide");
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }

    if ($("#formChangemail").length) {
      $("#formChangemail").validate({
        rules: {
          text_email: {
            required: true,email: true
          },
        },
        messages: {
          text_email: {
            required: "กรุณากรอกข้อมูล.",
            email: "รูปแบบ E-mail ผิดพลาด."
          }
        },
        errorPlacement: function() {
          $("#formErrorchangemail").slideDown();
          $("#formErrorchangemail").removeClass("hide");
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
  };
  if ($("#formAddsubject").length) {
    $("#formAddsubject").validate({
      rules: {
        txt_projectname: {required: true},
        select_subject: {required: true},
      },
      errorPlacement: function() {
        $("#formErroraddsubject").slideDown();
        $("#formErroraddsubject").removeClass("hide");
      },
      submitHandler: function(form) {
        fun.dataSubmit(form);
        return false;
      }
    });
  }


  return methods;
});
