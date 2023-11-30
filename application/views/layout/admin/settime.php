<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/bootstrap-wysihtml5/wysihtml5.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/blockui/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/assets/js/jquery.form.js"></script>

<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/js/jquery.Jcrop.js"></script>
<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/js/script.js"></script>
<link href="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" /> 

<!-- watermaker -->
<link rel="StyleSheet" href="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/watermarker.css" type="text/css">
<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/watermarker.js"></script>
<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/script.js"></script>

<!-- End watermaker -->
<!-- <link href="https://fonts.googleapis.com/css?family=Battambang" rel="stylesheet"> -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Chenla&family=Hanuman&family=Khmer&family=Moul&family=Siemreap&display=swap');
</style>
<?php
$fbUserId = $this->session->userdata('fb_user_id');
$log_id = $this->session->userdata ( 'user_id' );
$p = $this->input->get('p');
$b = $this->input->get('b');
 if ($this->session->userdata('user_type') != 4) { ?>
    <style>
        .radio-inline{}
        .error {color: red}
        #defaultCountdown { width: 340px; height: 100px; font-size: 20pt;margin-bottom: 20px}
        .khmers {font-family: 'Khmer', serif!important;font-size: 25px;line-height: 45px;}
        .table tbody tr.trbackground,tr.trbackground {background:#0000ff!important;}
        .trbackground a,.trbackground {color:red;}
    </style>
    <div class="page-header">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>
                        <i class="icon-reorder">
                        </i>
                        Add New Post
                    </h4>     
                    <label class="pull-right">Instant Article 
                    </label>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12 khmers">
                            <?php echo @$bodyText;?>
                        </div>
                    </div>
                    <!-- https://5000-years-zip.org/5000tripitakaaudio/audiobook_bedok_003.mp3 -->
                    <div class="clearfix"></div>
                    <audio controls id="booktrack" style="width:100%;">
                      <source src="<?php echo @$audiotrack;?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>

    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>
                        <i class="icon-reorder">
                        </i>
                        Add New Post
                    </h4>     
                    <label class="pull-right">Instant Article 
                    </label>
                </div>
                <div class="widget-content">
                    <form method="post" id="validate" class="form-horizontal row-border">
                    <div class="form-group"> 
                        <div class="col-md-4 clearfix">
                            <label class="col-md-3 control-label">Book <span class="required">*</span>
                            </label> 
                            <div class="col-md-9"> 
                                <input type="number" name="b" class="form-control required" value="<?php echo $b;?>"> 
                            </div> 
                        </div>
                        <div class="col-md-4 clearfix">
                            <label class="col-md-3 control-label">Pages <span class="required">*</span>
                            </label> 
                            <div class="col-md-9"> 
                                <input type="number" name="p" class="form-control required" value="<?php echo ($p+1);?>"> 
                            </div> 
                        </div>
                        <div class="col-md-4 clearfix">
                            <label class="col-md-3 control-label">Set Time <span class="required">*</span>
                            </label> 
                            <div class="col-md-9"> 
                                <input type="text" id="settime" name="settime" class="form-control required"> 
                            </div> 
                        </div>
                    </div>
                    <div class="form-actions"><input type="button" id="addtime5" value="+50" class="btn btn-lg btn-inverse"><input type="button" id="addtime6" value="+60" class="btn btn-lg btn-inverse"><input type="button" id="addtime7" value="+70" class="bbtn btn-lg btn-danger"> <input type="button" id="addtime" value="+80" class="btn btn-lg btn-success">​<input type="submit" value="Submit" class="btn btn-primary pull-right"> </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>

    </div>
    <script>
        jQuery(document).ready(function(){
            var audios = jQuery('#booktrack');
            let vid = document.getElementById("booktrack");
            //vid.currentTime=(92*60)+52;
            vid.currentTime=<?php echo !empty($playtime)?$playtime:'0';?>;
            vid.ontimeupdate = function() {myFunction()};

            function myFunction() {
                //document.getElementById("settime").innerHTML = vid.currentTime;
                jQuery('#settime').val(vid.currentTime);
            }
            $('#addtime5').click(function(){
                vid.currentTime = vid.currentTime + 40;
                vid.play();
            });
            $('#addtime6').click(function(){
                vid.currentTime = vid.currentTime + 60;
                vid.play();
            });
            $('#addtime7').click(function(){
                vid.currentTime = vid.currentTime + 60;
                vid.play();
            });
            $('#addtime').click(function(){
                vid.currentTime = vid.currentTime + 76;
                vid.play();
            });
        });
        var num = [];
        var Apps = function () {
            return {
                init: function () {
                    v();
                    t();
                    u();
                    f();
                    d();
                    h();
                    e();
                    i();
                    k();
                    j();
                    a();
                    p()
                },
                getLayoutColorCode: function (x) {
                    if (m[x]) {
                        return m[x]
                    } else {
                        return ""
                    }
                },
                blockUI: function (x, y) {
                    var x = $(x);
                    x.block({
                        message: '<img src="<?php echo base_url(); ?>themes/layout/blueone/assets/img/ajax-loading.gif" alt="">',
                        centerY: y != undefined ? y : true,
                        css: {
                            top: "10%",
                            border: "none",
                            padding: "2px",
                            backgroundColor: "none"
                        },
                        overlayCSS: {
                            backgroundColor: "#000",
                            opacity: 0.05,
                            cursor: "wait"
                        }
                    })
                },
                unblockUI: function (x) {
                    $(x).unblock({
                        onUnblock: function () {
                            $(x).removeAttr("style")
                        }
                    })
                }
            }
        }();   
    function escapeHtml(str) {
      var map =
        {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#039;': "'"
        };
        return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
    }
        

        function getattra(e) {
            $("#singerimageFist").val(e);
            $("#imageviewFist").html('<img style="width:100%;height:55px;" src="' + e + '"/>');
        }
        //getgroup();
    </script>

    <?php

} else {
    echo '<div class="alert fade in alert-danger" >
                            <strong>You have no permission on this page!...</strong> .
                        </div>';
}
?>