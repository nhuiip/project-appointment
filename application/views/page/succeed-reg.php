<html>
  <head>
    <title>Success Page</title>
    <style>
      @import url("https://fonts.googleapis.com/css?family=PT+Serif");
      body {
        overflow: hidden;
        background-color: #16a085;
        padding: 0;
        text-align: center;
      }
      h1 {
        margin-bottom: 0 !important;
      }
      h1 a {
        color: #ffffff;
        font-size: 3em;
        text-decoration: none;
        display: inline-block;
        position: relative;
        font-family: "PT Serif", serif;
      }
      a.effect-underline:after {
        content: "";
        position: absolute;
        left: -10%;
        display: inline-block;
        height: 1em;
        width: 120%;
        border-bottom: 3px solid;
        margin-top: 25px;
        opacity: 0;
        -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
        transition: opacity 0.35s, transform 0.35s;
        -webkit-transform: scale(0, 1);
        transform: scale(0, 1);
      }
      a.effect-underline:hover:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
      }
      .boxcontent {
        overflow: hidden;
        width: 100%;
        color: #ffffff;
        text-align: center;
        height: 276.44px;
        margin-top: 20%;
      }

      .btn {
        color: #fff;
        cursor: pointer;
        display: block;
        font-size: 16px;
        font-weight: bold;
        line-height: 45px;
        margin: 0 0 2em;
        max-width: 250px;
        position: relative;
        text-decoration: none;
        text-transform: uppercase;
        width: 100%;
      }
      .btn-5 {
        border: 0 solid;
        box-shadow: inset 0 0 20px rgba(255, 255, 255, 0);
        outline: 2px solid;
        outline-color: rgba(255, 255, 255, 0.5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
      }

      .btn-5:hover {
        border: 1px solid;
        box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.5),
          0 0 20px rgba(255, 255, 255, 0.2);
        outline-color: rgba(255, 255, 255, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #427388;
      }
    </style>
  </head>
  <body>
    <div class="boxcontent">
      <h1 style="margin-bottom: 0;">
        <a href="#" class="effect-underline">การลงทะเบียนสำเร็จ</a>
      </h1>
      <h3 style="margin:0 0 20px">
        กรุณาตรวจสอบและยืนยันอีเมลของคุณก่อนเข้าใช้งานระบบ
      </h3>
      <center>
        <a href="<?=site_url()?>" class="btn btn-5">กลับหน้าแรก</a>
      </center>
    </div>
  </body>
</html>
