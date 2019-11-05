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
    //################################################################## NHUII
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
            email: true,
            remote: {
              url: $("#use_email_up").attr("data-url"),
              type: "post",
              data: {
                use_id: function() {
                  return $("#use_id").val();
                },
                use_email: function() {
                  return $("#use_email_up").val();
                }
              }
            }
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
            email: "รูปแบบ E-mail ผิดพลาด.",
            remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formExtra_C").length) {
      $("#formExtra_C").validate({
        rules: {
          use_name: { required: true },
          text_type: { required: true },
          sec_date: { required: true },
          text_time: { required: true }
        },
        messages: {
          use_name: {
            required: "กรุณากรอกชื่อเต็ม."
          },
          text_type: {
            required: "กรุณาเลือกระดับผู้ใช้."
          },
          sec_date: {
            required: "กรุณาเลือกวันที่ขึ้นสอบ."
          },
          text_time: {
            required: "กรุณาเลือกเวลาขึ้นสอบ"
          }
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
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formChangemail").length) {
      $("#formChangemail").validate({
        rules: {
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
          }
        },
        messages: {
          use_email: {
            required: "กรุณากรอกอีเมล.",
            email: "รูปแบบอีเมลผิดพลาด.",
            remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
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
    if ($("#formSetting_up").length) {
      $("#formSetting_up").validate({
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
            required: true,
            remote: {
              url: $("#hol_date").attr("data-url"),
              type: "post",
              data: {
                set_id: function() {
                  return $("#set_id").val();
                },
                hol_date: function() {
                  return $("#hol_date").val();
                }
              }
            }
          }
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล."
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด.",
            remote: "วันที่ผิดพลาด"
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
            required: true,
            remote: {
              url: $("#hol_date_up").attr("data-url"),
              type: "post",
              data: {
                set_id: function() {
                  return $("#set_id_up").val();
                },
                hol_date: function() {
                  return $("#hol_date_up").val();
                }
              }
            }
          }
        },
        messages: {
          hol_name: {
            required: "กรุณากรอกข้อมูล."
          },
          hol_date: {
            required: "กรุณาระบุวันหยุด.",
            remote: "วันที่ผิดพลาด"
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
        messages: {
          sub_name: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_code: {
            required: "กรุณากรอกข้อมูล."
          },
          use_id: {
            required: "กรุณาเลือกอาจารย์ผู้สอน."
          },
          sub_setuse: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_setless: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_type: {
            required: "กรุณาเลือกประเภทวิชา."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formSubject_Up").length) {
      $("#formSubject_Up").validate({
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
        messages: {
          sub_name: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_code: {
            required: "กรุณากรอกข้อมูล."
          },
          use_id: {
            required: "กรุณาเลือกอาจารย์ผู้สอน."
          },
          sub_setuse: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_setless: {
            required: "กรุณากรอกข้อมูล."
          },
          sub_type: {
            required: "กรุณาเลือกประเภทวิชา."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formAttached").length) {
      $("#formAttached").validate({
        rules: {
          att_name: {
            required: true
          },
          att_filename: {
            required: true
          }
        },
        messages: {
          att_name: {
            required: "กรุณากรอกข้อมูล."
          },
          att_filename: {
            required: "กรุณาเลือกไฟล์."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formProjectStd_Up").length) {
      $("#formProjectStd_Up").validate({
        rules: {
          project_name: {
            required: true
          },
          use_id: {
            required: true
          }
        },
        messages: {
          project_name: {
            required: "กรุณากรอกข้อมูล."
          },
          use_id: {
            required: "กรุณาเลือกอาจารย์ที่ปรึกษา."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formProjectStd_Add").length) {
      $("#formProjectStd_Add").validate({
        rules: {
          project_name: {
            required: true
          },
          use_id: {
            required: true
          },
          std_id: {
            required: true
          }
        },
        messages: {
          project_name: {
            required: "กรุณากรอกข้อมูล."
          },
          use_id: {
            required: "กรุณาเลือกอาจารย์ที่ปรึกษา."
          },
          std_id: {
            required: "กรุณาเลือกอาจารย์ที่ผู้จัดทำ."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formProjectfileStd_Add").length) {
      $("#formProjectfileStd_Add").validate({
        rules: {
          file_name: {
            required: true
          },
          proformat_name: {
            required: true
          }
        },
        messages: {
          file_name: {
            required: "กรุณาเลือกไฟล์เอกสาร."
          },
          proformat_name: {
            required: "กรุณาเลือกชื่อไฟล์."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formProjectfileStd_Up").length) {
      $("#formProjectfileStd_Up").validate({
        rules: {
          file_name: {
            required: true
          }
        },
        messages: {
          file_name: {
            required: "กรุณาเลือกไฟล์เอกสาร."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formProject_Up").length) {
      $("#formProject_Up").validate({
        rules: {
          project_status: {
            required: true
          }
        },
        messages: {
          project_status: {
            required: "กรุณาเลือกสถานะ."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formChooseType").length) {
      $("#formChooseType").validate({
        rules: {
          conftype_id: {
            required: true
          }
        },
        messages: {
          conftype_id: {
            required: "กรุณาเลือกประเภท Conference."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formUpdateType").length) {
      $("#formUpdateType").validate({
        rules: {
          conftype_id: {
            required: true
          }
        },
        messages: {
          conftype_id: {
            required: "กรุณาเลือกประเภท Conference."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formUpdateCon").length) {
      $("#formUpdateCon").validate({
        rules: {
          conf_year: { required: true },
          conf_title: { required: true },
          conf_subtitle: { required: true },
          conf_number: { required: true },
          conf_datepresent: { required: true },
          conf_nopage: { required: true },
          conf_weight: { required: true },
          conf_data: { required: true },
          conf_place: { required: true },
          conf_publisher: { required: true }
        },
        messages: {
          conf_year: { required: "กรุณากรอกข้อมูล." },
          conf_title: { required: "กรุณากรอกข้อมูล." },
          conf_subtitle: { required: "กรุณากรอกข้อมูล." },
          conf_number: { required: "กรุณากรอกข้อมูล." },
          conf_datepresent: { required: "กรุณากรอกข้อมูล." },
          conf_nopage: { required: "กรุณากรอกข้อมูล." },
          conf_weight: { required: "กรุณากรอกข้อมูล." },
          conf_data: { required: "กรุณากรอกข้อมูล." },
          conf_place: { required: "กรุณากรอกข้อมูล." },
          conf_publisher: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formAddPreson").length) {
      $("#formAddPreson").validate({
        rules: {
          confpos_name: { required: true },
          confpos_sort: { required: true }
        },
        messages: {
          confpos_name: { required: "กรุณากรอกข้อมูล." },
          confpos_sort: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formUpPreson").length) {
      $("#formUpPreson").validate({
        rules: {
          confpos_name: { required: true },
          confpos_sort: { required: true }
        },
        messages: {
          confpos_name: { required: "กรุณากรอกข้อมูล." },
          confpos_sort: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#FormEmailset").length) {
      $("#FormEmailset").validate({
        rules: {
          email_user: {
            required: true,
            remote: {
              url: $("#email_user").attr("data-url"),
              type: "post",
              data: {
                email_user: function() {
                  return $("#email_user").val();
                }
              }
            }
          },
          email_password: { required: true }
        },
        messages: {
          email_user: {
            required: "กรุณากรอกข้อมูล.",
            remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
          },
          email_password: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#FormEmailset_Up").length) {
      $("#FormEmailset_Up").validate({
        rules: {
          email_user: {
            required: true,
          },
          email_password: { required: true }
        },
        messages: {
          email_user: {
            required: "กรุณากรอกข้อมูล."
          },
          email_password: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#FormEmailset_T").length) {
      $("#FormEmailset_T").validate({
        rules: {
          email_test: {
            required: true,
          },
        },
        messages: {
          email_test: {
            required: "กรุณากรอก Email ปลายทาง."
          },
        },
        submitHandler: function(form) {
          $(".loading").show();
          fun.TestMail(form);
          return false;
        }
      });
    }

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
            required: true,
            email: true
          },
          text_tel: {
            required: true
          }
        },
        messages: {
          text_name: { required: "กรุณากรอกข้อมูล." },
          text_lastname: { required: "กรุณากรอกข้อมูล." },
          text_email: {
            required: "กรุณากรอกข้อมูล.",
            email: "รูปแบบ E-mail ผิดพลาด."
          },
          text_tel: { required: "กรุณากรอกข้อมูล." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formAddproject").length) {
      $("#formAddproject").validate({
        rules: {
          txt_projectname: {
            required: true,
            remote: {
              url: $("#txt_projectname").attr("data-url"),
              type: "post",
              data: {
                use_email: function() {
                  return $("#txt_projectname").val();
                }
              }
            }
          },
          txt_projectname: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formsearchStudent").length) {
      $("#formsearchStudent").validate({
        rules: {
          txt_search: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add01_cov").length) {
      $("#add01_cov").validate({
        rules: {
          txt_01_cov: { required: true }
        },
        messages: {
          txt_01_cov: {
            required: "กรุณาเลือกไฟล์."
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add02_cer").length) {
      $("#add02_cer").validate({
        rules: {
          txt_02_cer: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add03_abs").length) {
      $("#add03_abs").validate({
        rules: {
          txt_03_abs: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add04_ack").length) {
      $("#add04_ack").validate({
        rules: {
          txt_04_ack: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add05_tcb").length) {
      $("#add05_tcb").validate({
        rules: {
          txt_05_tcb: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add06_ch01").length) {
      $("#add06_ch01").validate({
        rules: {
          txt_06_ch01: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add06_ch02").length) {
      $("#add06_ch02").validate({
        rules: {
          txt_06_ch02: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add06_ch03").length) {
      $("#add06_ch03").validate({
        rules: {
          txt_06_ch03: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add06_ch04").length) {
      $("#add06_ch04").validate({
        rules: {
          txt_06_ch04: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add06_ch05").length) {
      $("#add06_ch05").validate({
        rules: {
          txt_06_ch05: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add07_ref").length) {
      $("#add07_ref").validate({
        rules: {
          txt_07_ref: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add08_app").length) {
      $("#add08_app").validate({
        rules: {
          txt_08_app: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#add09_bio").length) {
      $("#add09_bio").validate({
        rules: {
          txt_09_bio: { required: true }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formChangemailstd").length) {
      $("#formChangemailstd").validate({
        rules: {
          std_email: {
            required: true,
            email: true,
            remote: {
              url: $("#std_email").attr("data-url"),
              type: "post",
              data: {
                std_email: function() {
                  return $("#std_email").val();
                }
              }
            }
          }
        },
        messages: {
          std_email: {
            required: "กรุณากรอกอีเมล.",
            email: "รูปแบบอีเมลผิดพลาด.",
            remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formChangepasswordstd").length) {
      $("#formChangepasswordstd").validate({
        rules: {
          std_password: { required: true }
        },
        messages: {
          std_password: { required: "กรุณากรอกรหัสผ่าน." }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formStudentAddproject").length) {
      $("#formStudentAddproject").validate({
        rules: {
          txt_projectname: {
            required: true
          },
          std_number: {
            number: true
          },
          txt_std_id: {
            required: true
          },
          txt_teacher: {
            required: true
          }
        },
        messages: {
          txt_projectname: {
            required: "กรุณากรอกข้อมูล."
          },
          std_number: {
            number: "กรุณากรอกเฉพาะตัวเลข"
          },
          txt_std_id: {
            required: "กรุณาเลือกข้อมูล"
          },
          txt_teacher: {
            required: "กรุณาเลือกข้อมูล"
          }
        },
        submitHandler: function(form) {
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formCalendarrequest").length) {
      $("#formCalendarrequest").validate({
        rules: {
          radioHeadproject: {
            required: true
          }
        },
        messages: {
          radioHeadproject: {
            required: "กรุณาเลือกประธานการสอบ."
          }
        },
        errorPlacement: function() {
          $("#formError").slideDown();
          $("#formError").removeClass("hide");
        },
        submitHandler: function(form) {
          $(".loading").show();
          fun.dataSubmit(form);
          return false;
        }
      });
    }
    if ($("#formCancelmeet").length) {
      $("#formCancelmeet").validate({
        rules: {
          Idproject: {
            required: true
          },
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
  };
  return methods;
});
