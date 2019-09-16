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
    if ($("#formAdministrators").length) {
      $("#formAdministrators").validate({
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
            required: "กรุณากรอกข้อมูล."
          },
          position_id: {
            required: "กรุณาเลือกระดับผู้ใช้."
          },
          use_email: {
            required: "กรุณากรอกข้อมูล.",
            email: "รูปแบบ E-mail ผิดพลาด.",
            remote: "E-mail นี้มีในระบบอยุ่แล้ว !"
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
            number: true,
          },
          set_term: {
            required: true,
          },
          set_open: {
            required: true,
          },
          set_close: {
            required: true,
          },
        },
        messages: {
          set_year: {
            required: "กรุณากรอกปีการศึกษา.",
            number: "กรอกเฉพาะตัวเลขเท่านั้น",
          },
          set_term: {
            required: "กรุณาเลือกเทอม.",
          },
          set_open: {
            required: "กรุณาระบุวันเปิดนัด.",
          },
          set_close: {
            required: "กรุณาระบุวันปิดนัด.",
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
            required: true,
          },
          hol_date: {
            required: true,
          },
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล.",
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด.",
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
            required: true,
          },
          hol_date: {
            required: true,
          },
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล.",
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด.",
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
  };
  return methods;
});
