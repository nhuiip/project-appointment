<?PHP if($position == 'นักศึกษา') { ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Basic form <small>Simple login form example</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" action="<?=base_url('profile/update');?>" method="post" enctype="multipart/form-data" name="formPagedetailTH" id="formPagedetailTH" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" id="IdLogin" name="IdLogin" value="<?=$loginid;?>">
                        <!-- <div id="grid-one-form" class="center">
                            <div class="picture-container">
                                <div class="picture">
                                    <div style="background: url('http://localhost:9900/assets/images/noimage.jpg');" id="std_imgpre"></div>
                                    <input type="file" id="std_img" name="" class="valid" aria-invalid="false" accept="image/*">
                                </div>
                                <h6 class="description">Choose Picture</h6>
                            </div>      
                        </div>
                        <br/> -->
                            <!-- <div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="">
                                    <label for="inlineRadio1"> นาย </label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                    <label for="inlineRadio2"> นางสาว </label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="inlineRadio3" value="option3" name="radioInline">
                                    <label for="inlineRadio3"> นาง </label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="inlineRadio4" value="option4" name="radioInline">
                                    <label for="inlineRadio4"> อื่นๆ </label>
                                </div>
                            </div>
                            <br/>
                            <div id="grid-two-form">
                                <div><label>ชื่อ</label> <input placeholder="ชื่อ" class="form-control"></div>
                                <div><label>นามสกุล</label> <input placeholder="นามสกุล" class="form-control"></div>
                            </div>
                            <div id="grid-one-form">
                                <div><label>รหัสนักศึกษา</label> <input placeholder="ชื่อ" class="form-control"></div>
                            </div>
                            <div id="grid-two-form">
                                <div><label>อีเมล์</label> <input type="email" placeholder="อีเมล์" class="form-control"></div>
                                <div><label>เบอร์โทรศัพท์</label> <input placeholder="เบอร์โทรศัพท์" class="form-control"></div>
                            </div> -->
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label class="col-lg-12">ชื่อ</label>
                                    <div class="col-lg-12">
                                        <input placeholder="ชื่อ" class="form-control"> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-lg-12">นามสกุล</label>
                                    <div class="col-lg-12">
                                        <input placeholder="นามสกุล"  class="form-control"> 
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="col-lg-12">รหัสนักศึกษา</label>
                                    <div class="col-lg-12"></div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Horizontal form</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <p>Sign in today for more expirience.</p>
                        <div class="form-group"><label class="col-lg-2 control-label">Email</label>

                            <div class="col-lg-10"><input type="email" placeholder="Email" class="form-control"> <span class="help-block m-b-none">Example block-level help text here.</span>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Password</label>

                            <div class="col-lg-10"><input type="password" placeholder="Password" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks"><label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div><i></i> Remember me </label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-white" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP } ?>