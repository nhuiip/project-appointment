<html>
  <head>
    <title>Success Page</title>
    <style>
      @import url("https://fonts.googleapis.com/css?family=PT+Serif");
      body {
        overflow: hidden;
        background-color: #55efc4;
        padding: 18% 20%;
        text-align: center;
      }
      h1 a {
        color: #ffffff;
        font-size: 2em;
        text-decoration: none;
        display: inline-block;
        position: relative;
        font-family: "PT Serif", serif;
      }
      a.effect-underline:after {
        content: "";
        position: absolute;
        left: 0;
        display: inline-block;
        height: 1em;
        width: 100%;
        border-bottom: 3px solid;
        margin-top: 10px;
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
      <h1>
        <a href="#" class="effect-underline"> ยืนยันอีเมลเรียบร้อย !!</a>
      </h1>
      <center><a href="<?=site_url()?>" class="btn btn-5">กลับหน้าแรก</a></center>
    </div>
  </body>
</html>
