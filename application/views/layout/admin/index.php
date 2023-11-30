<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/bootstrap-wysihtml5/wysihtml5.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/plugins/blockui/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/layout/blueone/assets/js/jquery.form.js"></script>

<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/js/jquery.Jcrop.js"></script>

<link href="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>themes/layout/blueone/plugins/crop-upload/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" /> 

<!-- watermaker -->
<link rel="StyleSheet" href="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/watermarker.css" type="text/css">
<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/watermarker.js"></script>
<script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/watermarker/script.js"></script>

<!-- End watermaker -->
<link href="https://fonts.googleapis.com/css?family=Battambang" rel="stylesheet">
<style>
        .radio-inline{}
        .error {color: red}
        .morefield {padding:5px 0 !important;}
        .morefield .form-group{padding: 0 0 0!important;}
        .morefield .input-group > .input-group-btn .btn,.ytid .btn{height: 32px}
        .removediv + .tooltip > .tooltip-inner {background-color: #f00;}
        .removediv + .tooltip > .tooltip-arrow { border-bottom-color:#f00;}
        .help-bloc{color:red;}
        #blockuis{padding:15%;position:fixed;z-index:99999999;background:rgba(0, 0, 0, 0.88) none repeat scroll 0% 0%;top:0;left: 0;right: 0;bottom: 0;}
        .fixed {position: fixed; right: 40px; width: 90%;bottom: 0;background: #fff}
        .wysihtml5-action-active{color: #1e88e5!important}
        .btn.wysihtml5-action-active {background-color:#fff!important;}
        .btn.disabled {color: #D1D1D1!important;}
        .wysihtml5-toolbar {margin-top: 3px!important}
        ul.wysihtml5-toolbar > li{margin:0px 5px -1px 0px!important}
        .khmer {font-family: 'Battambang';font-size: 14px!important;font-weight: 400!important;}
        .counts{color:#ff0000;}

        /*upload file*/
        .filecontainer{
    margin: 0;
}

#postimacros label{
    display: block;
    max-width: 200px;
    margin: 0 auto 15px;
    text-align: center;
    word-wrap: break-word;
    color: #1a4756;
}
#postimacros .addmorefield label{text-align: left;margin: -5px 0;}
#postimacros .hidden, #uploadImg:not(.hidden) + label{
    display: none;
}

#postimacros .file{
    display: none;
    margin: 0 auto;
}

#postimacros .upload{
    margin-left: 5px;
    width: 150px;
    display: block;
    padding: 2px 5px;
    border: 0;
    font-size: 15px;
    letter-spacing: 0.05em;
    cursor: pointer;
    background: #216e69;
    color: #fff;
    outline: none;
    transition: .3s ease-in-out;
    &:hover, &:focus{
        background: #1AA39A;
    }
    &:active{
        background: #13D4C8;
        transition: .1s ease-in-out;
    }

}

#postimacros img{
    display: block;
    margin:0;
}
        /*End upload file*/
/*watermark*/
.water-wrap {max-height: 350px;overflow-y: auto;}
/*End watermark*/
 /*updad with crop*/   
 .modal-dialog {
    z-index: 1050;
    width: auto!important;
    padding: 10px;
    margin-right: auto;
    margin-left: auto;
}
.ui-widget-overlay {
  opacity: 0.80;
  filter: alpha(opacity=70);
}
.jc-dialog {
  padding-top: 1em;
}
.ui-dialog p tt {
  color: yellow;
}
.jcrop-light .jcrop-selection {
  -moz-box-shadow: 0px 0px 15px #999;
  /* Firefox */

  -webkit-box-shadow: 0px 0px 15px #999;
  /* Safari, Chrome */

  box-shadow: 0px 0px 15px #999;
  /* CSS3 */

}
.jcrop-dark .jcrop-selection {
  -moz-box-shadow: 0px 0px 15px #000;
  /* Firefox */

  -webkit-box-shadow: 0px 0px 15px #000;
  /* Safari, Chrome */

  box-shadow: 0px 0px 15px #000;
  /* CSS3 */

}
.jcrop-fancy .jcrop-handle.ord-e {
  -webkit-border-top-left-radius: 0px;
  -webkit-border-bottom-left-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-w {
  -webkit-border-top-right-radius: 0px;
  -webkit-border-bottom-right-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-nw {
  -webkit-border-bottom-right-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-ne {
  -webkit-border-bottom-left-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-sw {
  -webkit-border-top-right-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-se {
  -webkit-border-top-left-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-s {
  -webkit-border-top-left-radius: 0px;
  -webkit-border-top-right-radius: 0px;
}
.jcrop-fancy .jcrop-handle.ord-n {
  -webkit-border-bottom-left-radius: 0px;
  -webkit-border-bottom-right-radius: 0px;
}
.description {
  margin: 16px 0;
}
.jcrop-droptarget canvas {
  background-color: #f0f0f0;
}  
.tooltip {font-family: 'Battambang';font-size: 14px!important;font-weight: 400!important;} 
 /*End updad with crop*/       
        .removediv{
            top: 0px;
            right: -30px;
            width: 32px;
        }
        .widgets-refresh {
            top: 37px;
            right: -61px;
            width: 32px;
        }
    .imgwrap{position: relative;}
    .imgwrap .btn{position: absolute;top:0;right: 0}

    /*watermark*/
    .watermarker-wrapper .watermarker-container .resizer{background-image: url("<?php echo base_url();?>uploads/image/watermark/watermark/resize.png");}
    .icon {width: 25px}
    .icon-choose {height: 50px;cursor: pointer;border: 1px solid white;float: left;padding: 5px;}
    .icon-choose:hover {border: 1px solid red}
    .water-wrap {margin: 10px 5px 5px 10px;border: 1px solid #eee;padding: 3px}
    fieldset {padding: 10px;border: 1px solid #ddd;}
    fieldset legend{font-size: 100%;border:none;margin-bottom: 0px;font-weight: bold;width: inherit;}
    /*End watermark*/

#image,#myCanvas{
  float:left;
}

#blur,#grayscale,#brightness,#contrast,#rotate,#invert,#opacity,#saturate,#sepia{
    width: 300px;
    margin: 15px;
   float:left;
   font-size: 11px;
 }
 
 div[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 2px 0;
}

div[type=range] {
  width: 100%;
  height: 1px;
  cursor: pointer;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
  background: rgba(191, 102, 192, 0.35);
  border-radius: 9.2px;
  border: 0.2px solid #010101;
}
.ui-slider .ui-slider-handle {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 5px;
  width: 22px;
  border-radius: 12px;
  background: rgba(255, 42, 109, 0.75);
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: 1.8px;
}

div[type=range] {
  width: 100%;
  height: 1px;
  cursor: pointer;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
  background: rgba(191, 102, 192, 0.35);
  border-radius: 9.2px;
  border: 0.2px solid #010101;
}

div[type=range] {
  background: rgba(164, 68, 165, 0.35);
  border: 0.2px solid #010101;
  border-radius: 18.4px;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
}
div[type=range] {
  background: rgba(191, 102, 192, 0.35);
  border: 0.2px solid #010101;
  border-radius: 18.4px;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
}
div[type=range] {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 5px;
  width: 22px;
  border-radius: 12px;
  cursor: pointer;
  height: 1px;
}
.loadding{border: red solid 1px !important}
    </style>
<script type="text/javascript">
    /**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

// convert bytes into friendly format
var changeImg = [];
$.globalEval("var jcrop_api;"); 
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val())) return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
};

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};
function initJcrop(oImage)
{
    console.log(oImage.naturalWidth);
    $('#preview').Jcrop({
        bgOpacity: 0.5,
        bgColor: 'white',
        addClass: 'jcrop-normal',
        minSize: [200, 104], // min crop size
        boxWidth: 800,
        boxHeight: 415,
        onChange: updateInfo,
        onSelect: updateInfo,
    }, function () {

        // use the Jcrop API to get the real image size
        var bounds = this.getBounds();

        // Store the Jcrop API in the jcrop_api variable
        jcrop_api = this;
        //jcrop_api.animateTo([oImage.naturalWidth, oImage.naturalHeight]);
        jcrop_api.setSelect([0, 0, oImage.naturalWidth, oImage.naturalHeight]);
        jcrop_api.setOptions({
            bgFade: true
        });
        jcrop_api.ui.selection.addClass('jcrop-selection');
    });
}
function fileSelectHandler() {
    // get selected file
    var oFile = $('#image_file')[0].files[0];
    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 1000 * 3000) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        changeImg.push(e.target.result);
        oImage.onload = function () { // onload event handler

            // display step 2
            $('.step2').fadeIn(500);

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // Create variables (in this scope) to hold the Jcrop API and image size
            var boundx, boundy;

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined')  {
                jcrop_api.destroy();
            }
            //jcrop_api.enable();

            // initialize Jcrop
            if(changeImg.length==1) {
                initJcrop(oImage);
            }
            if(changeImg.length>1) {
                //jcrop-normal
                //$('#uploadFile .jcrop-normal img').attr("src",e.target.result);
                // jcrop_api = this;
                // jcrop_api.animateTo([200, 104]);
                // jcrop_api.setSelect([0, 0, 400, 208]);
                // jcrop_api.setOptions({
                //     bgFade: true
                // });
                // jcrop_api.ui.selection.addClass('jcrop-selection');
                // $('#preview').Jcrop();
                jcrop_api.destroy();
                initJcrop(oImage);
            }
            // $('#preview').Jcrop({
            //     bgOpacity: 0.5,
            //     bgColor: 'white',
            //     addClass: 'jcrop-normal',
            //     minSize: [200, 104], // min crop size
            //     aspectRatio : 16 / 8.3, // keep aspect ratio 1:1
            //     boxWidth:800,
            //     boxHeight:415,
            //     onChange: updateInfo,
            //     onSelect: updateInfo,
            // }, function(){

            //     // use the Jcrop API to get the real image size
            //     var bounds = this.getBounds();


            //     // Store the Jcrop API in the jcrop_api variable
            //     jcrop_api = this;
            //     jcrop_api.setSelect([0,0,400,208]);
            //     jcrop_api.setOptions({ bgFade: true });
            //     jcrop_api.ui.selection.addClass('jcrop-selection');
            // });
        };
    }

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}
function ImageSelectHandler(img) {
    // get selected file
   $("#blockui").show();
    // hide all errors
    $('.error').hide();

    // preview element
    var oImage = document.getElementById('preview');
    oImage.src = img;
    changeImg.push(img);
    // display step 2
    $('.step2').fadeIn(500);

    // Create variables (in this scope) to hold the Jcrop API and image size
    var boundx, boundy;

    // destroy Jcrop if it is existed
    if (typeof jcrop_api != 'undefined')  {
        jcrop_api.destroy();
    }
    //jcrop_api.enable();

    // initialize Jcrop
    if(changeImg.length==1) {
        setTimeout(function(){ 
            $("#upload_form").append('<input value="'+img+'" name="imageurl" type="hidden"><input id="editimage" value="1" name="editimage" type="hidden">');
            initJcrop();
            $("#blockui").hide();
        }, 1500);
    }
    if(changeImg.length>1) {
        jcrop_api.destroy();
        setTimeout(function(){ 
            $("#upload_form").append('<input value="'+img+'" name="imageurl" type="hidden"><input id="editimage" value="1" name="editimage" type="hidden">');
            initJcrop();
            $("#blockui").hide();
        }, 1500);
    }
}

</script>
    <link rel="StyleSheet" href="<?php echo base_url(); ?>themes/layout/blueone/plugins/image-filter/jquery-ui.css" type="text/css">
    <script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/image-filter/caman.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>themes/layout/blueone/plugins/image-filter/jquery-ui.min.js" type="text/javascript"></script>
<?php
$fbUserId = $this->session->userdata('fb_user_id');
$log_id = $this->session->userdata ( 'user_id' );
$contents = '';
$titles = '';
$thumb = '';
$pid = '';
$sitePpost = array('https://jc24news.com/','https://www.bz24news.com/');
$k = array_rand($sitePpost);
$blogRand = $sitePpost[$k];
//$labels = [];
if(!empty($post)) {
    $pConent = json_decode($post[0]->p_conent);
    $content = html_entity_decode(html_entity_decode(stripslashes(trim($pConent->message))));
    $content = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $content); 
    $content = preg_replace("/<[\/]*div[^>]*>/i", "", $content); 
    $content = preg_replace('/<!--(.|\s)*?-->/', '', $content); 
    preg_match_all('/\[youtube id="(.*?)"\]/i', $content, $matches, PREG_SET_ORDER);
    if ( !empty( $matches ) && !empty( $matches[0] ) && !empty( $matches[0][1] ) ) {
      foreach( $matches as $k=>$v ) {
        $embeded_code = '[embedyt] https://www.youtube.com/watch?v='.$v[1].'[/embedyt]';
        $content = str_replace($v[0], $embeded_code, $content);
      }
    }

    $pSchedule = json_decode($post[0]->p_schedule);
    $titles = preg_replace('/\s+/', '<sp>', $post[0]->p_name);;
    $pid = $post[0]->p_id;
    $content = htmlentities($content);

    $content = str_replace('/\n/g', '<br>', $content);
    $content = trim(preg_replace('/\s+/', '<sp>', $content));
    $thumb = $pConent->picture;
    $labels = @$pSchedule->label;
    if(!empty($labels)) {
        switch ($labels) {
            case 'news':
                $labels = '1,3';
                break;
            case 'entertainment':
                $labels = '4';
                break;
            default:
                $labels = '1';
                break;
        }
    }
}
 if ($this->session->userdata('user_type') != 4) { ?>
    <style>
        .radio-inline{}
        .error {color: red}
        #defaultCountdown { width: 340px; height: 100px; font-size: 20pt;margin-bottom: 20px}
        .khmer {font-family: 'Koulen', cursive;font-size: 30px}
        .table tbody tr.trbackground,tr.trbackground {background:#0000ff!important;}
        .trbackground a,.trbackground {color:red;}
    </style>
    <div class="page-header">
    </div>
    <div style="display:none;text-align:center;font-size:20px;color:white" id="blockuis">
    <div id="loaderimg" class=""><img align="middle" valign="middle" src="http://2.bp.blogspot.com/-_nbwr74fDyA/VaECRPkJ9HI/AAAAAAAAKdI/LBRKIEwbVUM/s1600/splash-loader.gif"/>
    </div>
    Please wait...
</div>
<code id="codeB" style="width:300px;overflow:hidden;display:none"></code>
    <code id="examplecode5" style="width:300px;overflow:hidden;display:none">var codedefault2=&quot;SET !EXTRACT_TEST_POPUP NO\n SET !TIMEOUT_PAGE 300\n SET !ERRORIGNORE YES\n SET !TIMEOUT_STEP 0.1\n&quot;;var wm=Components.classes[&quot;@mozilla.org/appshell/window-mediator;1&quot;].getService(Components.interfaces.nsIWindowMediator);var window=wm.getMostRecentWindow(&quot;navigator:browser&quot;);const XMLHttpRequest = Components.Constructor(&quot;@mozilla.org/xmlextras/xmlhttprequest;1&quot;);var homeUrl = &quot;<?php echo base_url();?>&quot;,add_post_url = &quot;<?php echo @$blogRand;?>&quot;,titles = &quot;&quot;,contents = &quot;&quot;,thumb = &quot;&quot;,pid = &quot;<?php echo @$pid;?>&quot;,labels = [<?php echo @$labels;?>];</code>
    <script type="text/javascript">
        function runcode(codes) {
            var str = $("#examplecode5").text();
            var code = str + codes;
            if (/iimPlay/.test(code)) {
                code = "imacros://run/?code=" + btoa(code);
                location.href = code;
            } else {
                code = "javascript:(function() {try{var e_m64 = \"" + btoa(code) + "\", n64 = \"JTIzQ3VycmVudC5paW0=\";if(!/^(?:chrome|https?|file)/.test(location)){alert(\"iMacros: Open webpage to run a macro.\");return;}var macro = {};macro.source = atob(e_m64);macro.name = decodeURIComponent(atob(n64));var evt = document.createEvent(\"CustomEvent\");evt.initCustomEvent(\"iMacrosRunMacro\", true, true, macro);window.dispatchEvent(evt);}catch(e){alert(\"iMacros Bookmarklet error: \"+e.toString());}}) ();";
                location.href = code;
            }
        }
        function load_contents(url){
            var loading = false; 
            if(loading == false){
                loading = true;  //set loading flag on
                $.ajax({        
                    url : url + '?max-results=1&alt=json-in-script',
                    type : 'get',
                    dataType : "jsonp",
                    success : function (data) {
                        loading = false; //set loading flag off once the content is loaded
                        if(data.feed.openSearch$totalResults.$t == 0){
                            var message = "No more records!";
                            return message;
                        }
                        for (var i = 0; i < data.feed.entry.length; i++) {
                            var content = data.feed.entry[i].content.$t;
                            $("#codeB").html(content);
                            var str = $("#codeB").text();
                            runcode(str);
                        }
                    }
                })
            }
        }
    window.setTimeout( function(){
        <?php if(empty($link)):?>
        //load_contents('https://snfbpost.blogspot.com/feeds/posts/default/-/postToWordpress');
    <?php endif;?>
    }, 2000 );
    </script>
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
                        <input type="checkbox" value="1" id="isia" name="isia" />
                    </label>
                </div>
                <div class="widget-content">
                    <form method="post" id="validate" class="form-horizontal row-border" enctype="multipart/form-data">
                     
                    <div class="form-group">
                        <div class="col-md-2">
                            <input type="text" id="link" class="form-control post-option" name="link" placeholder="URL" />
                        </div>
                        <div class="col-md-5">
                            <input id="title" type="text" name="title"  class="form-control" placeholder="Title Site" />
                        </div>
                        <div class="col-md-5">
                            <input id="title" type="text" name="titleShare"  class="form-control" placeholder="Title Share" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <input id="image1" type="text" name="thumb[]"  class="form-control" placeholder="Image url array 0" />
                            <label class="checkbox" style="display: inline-block;"> 
                                <input value="1" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="1" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb1" name="asThumb[0]" value="set">
                        </div>
                        <div class="col-md-2">
                            <input id="image2" type="text" name="thumb[]"  class="form-control" placeholder="Set Image url array 1" />
                            <label class="checkbox"> 
                                <input value="2" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="2" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb2" name="asThumb[1]" value="set">
                        </div>
                        <div class="col-md-2">
                            <input id="image3" type="text" name="thumb[]"  class="form-control" placeholder="Image url array 2" />
                            <label class="checkbox"> 
                                <input value="3" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="3" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb3" name="asThumb[2]" value="set">
                        </div>
                        <div class="col-md-2">
                            <input id="image4" type="text" name="thumb[]"  class="form-control" placeholder="Image url array 3" />
                            <label class="checkbox"> 
                                <input value="4" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="4" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb4" name="asThumb[3]" value="set">
                        </div>
                        <div class="col-md-2">
                            <input id="image5" type="text" name="thumb[]"  class="form-control" placeholder="Image url array 4" />
                            <label class="checkbox"> 
                                <input value="5" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="5" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb5" name="asThumb[4]" value="set">
                        </div>
                        <div class="col-md-2">
                            <input id="image6" type="text" name="thumb[]"  class="form-control" placeholder="Image url array 5" />
                            <label class="checkbox"> 
                                <input value="6" onclick="changeid(this);" type="checkbox" checked="checked">
                                <b>Thumbs</b>
                            </label>
                            <span id="5" class="addfield btn btn-xs btn-primary pull-right bs-tooltip" data-original-title="Add more..." onclick="getEitImage(this);"><i class="icon-picture"></i></span>
                            <input type="hidden" id="asThumb6" name="asThumb[5]" value="set">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <textarea class="form-control" name="addvideo" placeholder="Add Video Embed code" style="height:30px"></textarea>
                        </div>
                        <div class="col-md-6">
                            <select name="label" class="select2" style="width: 100%">                       
                                <option value="lotto">Lotto</option>
                                <option value="news">News</option>
                                <option value="entertainment">Entertainment</option>
                                <option value="otherlotto">Other Lotto</option>
                            </select>             
                        </div>                                   
                    </div>
                    <div class="form-group">
                        <div class="col-md-10">
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="btnplayer">
                                <b>BTN Player</b>
                            </label>
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="imagetext">
                                <b>Random Image Text</b>
                            </label>
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="fewfeed">
                                <b class="khmer">as fewfeed</b>
                            </label>
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="edit">
                                <b class="khmer">add link (fewfeed)</b>
                            </label>
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="settitle">
                                <b class="khmer">set Title</b>
                            </label>
                            <label class="checkbox"> 
                                <input value="1" type="checkbox" name="copyfrom" checked>
                                <b class="khmer">ប្រភព</b>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input id="sumbmit" type="submit"class="btn pull-right" value="Post" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>
                        <i class="icon-reorder">
                        </i>
                        Add New Post
                    </h4>     
                    <div class="toolbar no-padding">
                        <div class="btn-group"> 
                            <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span> </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="col-md-12">
                        <a href="https://web.facebook.com/thainews/" class="btn btn-primary" target="_blank">Thainews 01</a>
                                <a href="https://web.facebook.com/KhaoYouLike/" class="btn btn-primary" target="_blank">Thainews 02</a>
                                <a href="https://web.facebook.com/khaosod/" class="btn btn-primary" target="_blank">Khaosod</a>
                                <a href="https://www.amarintv.com/news/latest" class="btn btn-primary" target="_blank">AMARINTVHD</a>
                                <a href="https://web.facebook.com/siamnews/" class="btn btn-primary" target="_blank">Siamnews</a>
                                <a href="https://web.facebook.com/teeneedotcom" class="btn btn-primary" target="_blank">Teenee</a>
                                <a href="https://web.facebook.com/linetodayth/" class="btn btn-primary" target="_blank">Linetoday</a>
                                <a href="https://web.facebook.com/onenews31/" class="btn btn-primary" target="_blank">Onenews31</a>
                                <a href="https://web.facebook.com/SanookEveryday/" class="btn btn-primary" target="_blank">Sanook</a>
                                <a href="https://web.facebook.com/SanookEveryday/" class="btn btn-primary" target="_blank">Sanook</a>
                                <a href="https://web.facebook.com/share2877/" class="btn btn-primary" target="_blank">share2877</a>
                                <a href="https://web.facebook.com/TnewsTV/" class="btn btn-primary" target="_blank">TnewsTV</a>
                                <a href="https://web.facebook.com/jarm/" class="btn btn-primary" target="_blank">Jarm</a>
                                <a href="https://web.facebook.com/fna69" class="btn btn-primary" target="_blank">fna69</a>
                                <a href="http://tdaily.us/" class="btn btn-primary" target="_blank">tdaily</a>
                                <a href="http://www.khreality.com/" class="btn btn-primary" target="_blank">Khreality</a>
                                <a href="www.postsod.com" class="btn btn-primary" target="_blank">www.postsod.com (សុខភាព)</a>
                                <a href="sharesod.com" class="btn btn-primary" target="_blank">sharesod.com (ទិកនិក)</a>
                                <a href="burmese.dvb.no" class="btn btn-primary" target="_blank">burmese.dvb.no (ភូមា)</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    </div>


<!-- crop Modal -->
<div class="modal fade khmer" id="loginModal" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginModalLabel">Please Login again</h4>
      </div>
      <div class="modal-body">
            <center><p class="khmer" style="color: red;font-size: 18px !important;">សូមមេត្តាចុចប៉ូតុង login ខាងក្រោម ចូលម្ដងទៀត មុននឹងធ្វើការប៉ុស្ដិ៍<br/>
ព្រោះផុតកំណត់ម៉ោងនៃការប្រើគណនីរបស់ google ហើយ</p>
<a href="<?php echo base_url();?>managecampaigns/account" target="_blank"><img src="<?php echo base_url();?>themes/layout/img/google.png"/></a><p class="khmer">ដើម្បីកុំឲ្យបាត់ទិន្នន័យដែលអ្នកបានបញ្ចូលហើយ<br/>
សូមចុច login រួចហើយ សឹមចុចបិទ</p></center>
      </div>
      <div class="modal-footer"><button onclick="myStopFunction()" data-dismiss="modal" class="btn btn-default" type="button">Close</button></div>
    </div>
  </div>
</div>

<!-- crop Modal -->
<div class="modal fade khmer" id="cropModal" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cropModalLabel">Upload</h4>
      </div>
      <div class="modal-body bbody" id="formgenerate">
      </div>
    </div>
  </div>
</div> 
<div style="display: none;">
<div id="imageeffect">
    <div class="row">
                <div class="col-md-8">
                    <div class="widget box"> <div class="widget-header"> <h4><i class="icon-reorder"></i> Preview</h4> </div> <div class="widget-content"> <div class="imagecontainer"><div class= "image" >
                        <img src="<?php echo base_url();?>uploads/image/watermark/watermark/picture.jpg" id="imagewater" style="width: 400px;"/>
                    </div></div>
        </div> </div>

                <!-- box 2 -->
                <div class="widget box"> <div class="widget-header"> <h4><i class="icon-reorder"></i> Image filter</h4> </div> <div class="widget-content align-center"> 
                            <div class="info form-horizontal row-border" style="margin: 0 5px;">
                                    <div id="blur" type="range">Blur</div> 
                                  <div id="grayscale" type="range">Grayscale</div> 
                                  <div id="brightness" type="range">brightness</div>
                                  <div id="contrast" type="range">contrast</div>
                                  <div id="rotate" type="range">huerotate</div>
                                  <div id="invert" type="range">invert</div>
                                  <div id="opacity" type="range">opacity</div>
                                  <div id="saturate" type="range">saturate</div>
                                  <div id="sepia" type="range">sepia</div>
                                  <div style="clear: both;"></div> 
                                  <div class="form-group" style="height: 0;opacity: 0;"> <div class="col-md-12"><textarea class="form-control" id="datavalu" name="dataImageEffect" readonly></textarea></div></div>    
                            </div>     
                </div> </div>
                <!-- End box 2 -->
                </div>
                <div class="col-md-4">
                    <div class="widget box"> <div class="widget-header"> <h4><i class="icon-reorder"></i> Watermark</h4> </div> <div class="widget-content"> 
                            <div class="info form-horizontal row-border" style="margin: 0 5px;">
                                <div class="form-group">
                                  <label class="radio-inline" style="margin-left: 5px">
                                      <input type="radio" value="text" name="watermarkchooser" class="required" />
                                      <img class="icon" src="<?php echo base_url();?>uploads/image/watermark/icon/text.png">
                                  </label> 
                                  <label class="radio-inline">
                                      <input type="radio" value="shape" name="watermarkchooser" class="required" />
                                      <img class="icon" src="<?php echo base_url();?>uploads/image/watermark/icon/shape.png">
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" value="sticker" name="watermarkchooser" class="required" />
                                      <img class="icon" src="<?php echo base_url();?>uploads/image/watermark/icon/heart-smiley-icon.png">
                                  </label>
                                  <div id="choosetext" class="water-wrap" style="display: none;">
                                    <img class="icon-choose bs-tooltip"  data-original-title="មកដល់ហើយ" src="<?php echo base_url();?>uploads/image/watermark/text/comeback.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ឆ្នោតមកក្ដៅៗ" src="<?php echo base_url();?>uploads/image/watermark/text/houy-ded.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ឆ្នោតល្បី" src="<?php echo base_url();?>uploads/image/watermark/text/houy-dung.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="លេខមកក្ដៅៗ" src="<?php echo base_url();?>uploads/image/watermark/text/lek-ded.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="លេខកំពុងល្បី" src="<?php echo base_url();?>uploads/image/watermark/text/lek-kamlang-dang.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ខ្ញុំបង្ហោះឲ្យហើយណា!" src="<?php echo base_url();?>uploads/image/watermark/text/post-now.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="សេវទុកទៅ" src="<?php echo base_url();?>uploads/image/watermark/text/save-it.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="អ្នកណាមានលេខនេះខ្លះ?" src="<?php echo base_url();?>uploads/image/watermark/text/who-have-this.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="អ្នកណាគេកំពុងរង់ចាំ" src="<?php echo base_url();?>uploads/image/watermark/text/who-wait-for.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="មិនបាច់ចាំទេ" src="<?php echo base_url();?>uploads/image/watermark/text/harry-up.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="លេខបែកធ្លាយ" src="<?php echo base_url();?>uploads/image/watermark/text/get-it.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="អ្នកជំពាក់ធនាគារច្រើន ហាមរំលង" src="<?php echo base_url();?>uploads/image/watermark/text/dont-giveup.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ត្រូវមកច្រើនដងហើយ" src="<?php echo base_url();?>uploads/image/watermark/text/all.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="លេខ២ខ្ទង់ត្រង់ៗ" src="<?php echo base_url();?>uploads/image/watermark/text/2-trong.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="លេខ៣ខ្ទង់ត្រង់ៗ" src="<?php echo base_url();?>uploads/image/watermark/text/3-rong.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="កុំអាលថយ" src="<?php echo base_url();?>uploads/image/watermark/text/back.png"/>
                                    <div style="clear: both;"></div>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ឆ្នោតវគ្គនេះ ប៉ុស្តិ៍ឲ្យហើយ" src="<?php echo base_url();?>uploads/image/watermark/text/posted.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="យកទៅ មានហើយ!" src="<?php echo base_url();?>uploads/image/watermark/text/rich.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចមើលទៅ!" src="<?php echo base_url();?>uploads/image/watermark/text/see.png"/>
                                    <div style="clear: both;"></div>
                                  </div>
                                  <div id="chooseshape" class="water-wrap" style="display: none;">
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសបែបជ្រុង" src="<?php echo base_url();?>uploads/image/watermark/shapes/sqare.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសបែបរង្វង់" src="<?php echo base_url();?>uploads/image/watermark/shapes/ellipse.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសរង្វង់បែបដៃ" src="<?php echo base_url();?>uploads/image/watermark/shapes/roundel.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសព្រួញ" src="<?php echo base_url();?>uploads/image/watermark/shapes/blue-point-l.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសព្រួញ" src="<?php echo base_url();?>uploads/image/watermark/shapes/blue-point-r.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសព្រួញ" src="<?php echo base_url();?>uploads/image/watermark/shapes/point-left.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសព្រួញ" src="<?php echo base_url();?>uploads/image/watermark/shapes/point-right.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសបិទអក្សរឬជ្រុង" src="<?php echo base_url();?>uploads/image/watermark/shapes/sqare-white.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="គូសបិទអក្សរឬជ្រុង" src="<?php echo base_url();?>uploads/image/watermark/shapes/blur.png"/>
                                    <div style="clear: both;"></div>
                                  </div>
                                  <div id="choosesticker" class="water-wrap" style="display: none;">
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/emj/pointing-finger-right.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/emj/pointing-finger-left.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/emj/folded-hand.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/emj/Tongue_Out_Emoji_with_Winking_Eye.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/1.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/Blushing.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/heart-smiley-heart.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/love-eyes.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/love-eyes-heart.png"/>
                                    <img class="icon-choose bs-tooltip"  data-original-title="ចុចលើវា ដើម្បីយក" src="<?php echo base_url();?>uploads/image/watermark/stickers/so-good.png"/>
                                    <img class="icon-choose" src="<?php echo base_url();?>uploads/image/watermark/emj/like.png"/>
                                    <img class="icon-choose" src="<?php echo base_url();?>uploads/image/watermark/emj/like-left.png"/>
                                    <img class="icon-choose" src="<?php echo base_url();?>uploads/image/watermark/emj/like-hand-right.png"/>
                                    <img class="icon-choose" src="<?php echo base_url();?>uploads/image/watermark/emj/like-hand-left.png"/>
                                    <div style="clear: both;"></div>
                                  </div>
                                </div>

                                <div class="form-group"> <label class="col-md-4 control-label">X:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="posx"></div> </div>

                                <div class="form-group"> <label class="col-md-4 control-label">Y:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="posy"></div> </div>

                                <div class="form-group"> <label class="col-md-4 control-label">Width:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="width"></div> </div>

                                <div class="form-group"> <label class="col-md-4 control-label">Height:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="height"></div> </div>

                                <div class="form-group"> <label class="col-md-4 control-label">Mouse X:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="mousex"></div> </div>

                                <div class="form-group"> <label class="col-md-4 control-label">Mouse Y:</label> <div class="col-md-8"><input type="text" name="regular" class="form-control" id="mousey"></div> </div>        
                            </div>     
                </div> </div>


                </div>
                <div style="clear: both;"></div>
                <div class="form-actions"> <input name="step3" value="Ok" class="btn btn-primary pull-right" type="submit"></div>
    </div>
</div>
</div>
<!-- image watermarker and effect -->
    <script>
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
         $(document).ready(function() {
            <?php if(!empty($link)):?>
            setTimeout(function () {
                //'success','information','error','warning','notification'
                var success = generateText('success','Post is ok','bottom');
            }, 1000);
            setTimeout(function () {
                $.noty.closeAll();
            }, 4000);
        <?php endif;?>
});
    function getLink(e) {
        if($("#link").val() !='') {
            var jqxhr = $.ajax( "<?php echo base_url();?>managecampaigns/insertLink/" + encodeURIComponent($("input[name=link]").val()) + "/" + encodeURIComponent($("input[name=title]").val()) + "/" + encodeURIComponent($("input[name=thumb]").val()))
            .done(function(data) {
            if ( data ) {
                 console.log(data);
            }
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {
            //alert( "complete" );
            });
        }
    } 

    function changeid(e) {
        if($(e).is(':checked')) {
            $("#asThumb"+$(e).val()).val('set');
        } else {
            $("#asThumb"+$(e).val()).val('no');
        }
    }
    function getEitImage(e) {
        num = [];
        $("#uploadFile #image_file").remove();
        var id = $(e).attr('id');
        setmodule(id);
        //ImageSelectHandler(img);
    }
    function setmodule(id) {
        var formhtml = '<div class="tabbable tabbable-custom tabs-below" id="tabbables"> <div class="tab-content"> <div class="tab-pane active" id="tab_2_1"><!--form--><form id="upload_form" method="post" data-formid="'+id+'" enctype="multipart/form-data" action="<?php echo base_url();?>managecampaigns/upload" class="form-horizontal row-border" > <input type="hidden" id="x1" name="x1"/> <input type="hidden" id="y1" name="y1"/> <input type="hidden" id="x2" name="x2"/> <input type="hidden" id="y2" name="y2"/> <div class="row" id="uploadFile"> <div class="col-md-12"> <fieldset> <div class="form-group"> <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" data-style="fileinput" accept="image/*"/> <div class="error"></div></div></fieldset> </div><div class="step2"> <h2>Step2: Please select a crop region</h2> <img id="preview"/> <div class="info"> <label>File size</label> <input type="text" id="filesize" name="filesize" class="form-control input-width-small" style="display: inline-block;"/> <label>Type</label> <input type="text" id="filetype" name="filetype" class="form-control input-width-small" style="display: inline-block;"/> <label>Image dimension</label> <input type="text" id="filedim" name="filedim" class="form-control input-width-small" style="display: inline-block;"/> <label>W</label> <input type="text" id="w" name="w" class="form-control input-width-small" style="display: inline-block;"/> <label>H</label> <input type="text" id="h" name="h" class="form-control input-width-small" style="display: inline-block;"/> </div><div class="form-group fixed"> <div class="col-md-12"> <input type="submit" value="Upload" class="btn btn-primary pull-right" name="upload"/> </div></div></div><div class="step3"></div></div><div class="row" id="wrap-loading"> <div class="col-md-12"> <div id="loading"></div></div></div></form><!--end form--></div><div class="tab-pane" id="tab_2_2"><div class="form-horizontal row-border"><div class="form-group" style="margin:0"> <label class="col-md-2 control-label">ដាក់លីងគ៍/URL:</label> <div class="col-md-10"><div class="input-group"> <input type="text" name="fromlink" id="fromlink" class="form-control"> <span class="input-group-btn"> <button class="btn btn-default" type="button" id="getfromlink" style="height:32px">Get!</button> </span> </div></div> </div></div></div></div><ul class="nav nav-tabs"> <li class="active"><a href="#tab_2_1" data-toggle="tab">ពីកុំព្យូទ័រ/Upload</a></li><li><a href="#tab_2_2" data-toggle="tab">ពីវេបសាយ / URL</a></li></ul> </div>';
        $('#formgenerate').html(formhtml);
        $('#cropModal').modal('show');
    }

                // pre-submit callback 
    function showRequest(formData, jqForm, options) { 
        $('#uploadFile').hide();
        $('#wrap-loading').show();
        $("#loading").html('<center><img src="<?php echo base_url(); ?>assets/img/upload_progress.gif" alt="Uploading...."/></center>');
        return true; 
    } 
     
    // post-submit callback 
    function showResponse(responseText, statusText, xhr, $form)  { 
        var obj = JSON.parse(responseText);
        if (!obj.error) {
            // $("#image-url").val(obj.image);
            // $("#image-preview").html('<img src="' + obj.image + '" alt="Success...."/>').show();
            // $("#photoCrop").attr("src",obj.image);
            // $('#cropModal').modal('hide');
            // $("#imagepost").val(obj.image);
            // $('#uploadFile').show();
            // $('#wrap-loading').hide();
        }
    }


        $(document).ready(function () {
        /*upload file*/
            var options = { 
                beforeSubmit:  showRequest,  // pre-submit callback 
                success:       showResponse  // post-submit callback 
                // other available options: 
                //url:       url         // override for form's 'action' attribute 
                //type:      type        // 'get' or 'post', override for form's 'method' attribute 
                //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
                //clearForm: true        // clear all form fields after successful submit 
                //resetForm: true        // reset the form after successful submit 
         
                // $.ajax options can be used here too, for example: 
                //timeout:   3000 
            }; 
         
            // bind to the form's submit event 
            $("body").on("submit", "#upload_form", function(e){
                e.preventDefault();
                var form = $(e.target);
                var id = $(e.target).data('formid');
                var data = new FormData(form[0]);
                if($("#image_file").length != 0) {
                    jQuery.each(jQuery('#image_file')[0].files, function(i, file) {
                        data.append('image_file', file);
                    });
                }
                $("#blockui").show();
                $.ajax({
                    url: form.attr("action"),
                    type: "POST",
                    data: data,
                    dataType: 'JSON',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    beforeSend: function (xhr) {
                        xhr.overrideMimeType("text/plain; charset=x-user-defined");
                    }
                }).done(function (data) {
                    $("#blockui").hide();
                    if(!data.error) {
                        if(data.image) {
                            var setbse = '<?php echo base_url();?>uploads/image/';
                            $("#uploadFile #image_file").remove();
                            $("#editimage").remove();
                            $("#image"+id).val(setbse+data.image);
                            //$("#show_link_"+id).attr("src",setbse+data.image);
                            $("#imagewater").attr("src",setbse+data.image);
                            $( "#imageeffect" ).clone().appendTo( ".step3" );
                            $(".step2").hide();
                            var image = $('#imagewater').attr('src');
                            num.push({"mainimage":image,"value":{}});
                            var pretty = JSON.stringify(num, undefined, 2);
                            $('#datavalu').val(pretty);
                            getslider();
                            $('.bs-tooltip').tooltip();
                        }
                        if(data.upload) {
                            $("#image"+id).val(data.upload);
                            //$("#show_link_"+id).attr("src",data.upload);
                            $('#cropModal').modal('hide');
                        }
                    }
                });
                // $(e.target).ajaxSubmit(options); 
                // return false; 
                // $.post( form.attr("action"), form.serialize(), function(res){
                //     console.log(res);
                // });
            });
            /*end upload file*/
        });
    </script>
<script>
        /*watermarker*/
        
        (function(){
          
            $(document).on("click","#getfromlink", function(){
                var id = $("#upload_form").data('formid');
                var img = $("#fromlink").val();
                if(img) {
                    $("#show_link_"+id).attr("src",img);
                    $("#image_link_"+id).val(img);
                    $('#cropModal').modal('hide');
                }
            });
            // $(document).on("mousemove",function(event){
            //     $("#mousex").val(event.pageX);
            //     $("#mousey").val(event.pageY);
            // });
            $(document).on("click","input[name=watermarkchooser]", function(){
                var value = $(this).val();
                switch (value) {
                  case 'text':
                    $("#chooseshape").slideUp();
                    $("#choosesticker").slideUp();
                    $("#choosetext").slideDown();
                    break;
                  case 'shape':
                    $("#choosesticker").hide();
                    $("#choosetext").hide();
                    $("#chooseshape").slideDown();
                    break;
                  case 'sticker':
                    $("#chooseshape").hide();
                    $("#choosetext").hide();
                    $("#choosesticker").slideDown();
                    break; 
                }
            });

            $(document).on("click",".icon-choose", function(){
                var value = $(this).attr('src');
                getwatermark(value);
            });


            $('select[name=watermark]').change(function () {
                var value = $(this).val();
                var setnum = make_id(10);
                if(value!='') {
                    num.push({"watermark":setnum, "value":{"image":value,"x1":0,"y1":0,"w":0,"h":0}});
                    setwatermarker(value,setnum);
                }
            });
        })();
        
function getattra(e) {
    $("#singerimageFist").val(e);
    $("#imageviewFist").html('<img style="width:100%;height:55px;" src="' + e + '"/>');
}
function getwatermark(value) {
  var setnum = make_id(10);
  if(value!='') {
      num.push({"watermark":setnum, "value":{"image":value,"x1":0,"y1":0,"w":0,"h":0}});
      setwatermarker(value,setnum);
  }
}
function setwatermarker(image,setval) {
    $("#imagewater").watermarker({
        imagePath: image,
        removeIconPath: "<?php echo base_url();?>uploads/image/watermark/watermark/close-icon.png",
        offsetLeft:30,
        offsetTop: 40,
        onChange: updateCoords,
        onInitialize: updateCoords,
        containerClass: "myContainer imagecontainer",
        watermarkImageClass: "myImage superImage",      
        watermarkerClass: "js-watermark-1 js-watermark",
        watermarkerDataId: setval,
        data: {id: setval, "class": "superclass", pepe: "pepe"},        
        onRemove: function(){
            for (var i = num.length - 1; i >= 0; --i) {
                if (num[i].watermark == setval) {
                    num.splice(i,1);
                }
            }
            if(typeof console !== "undefined" && typeof console.log !== "undefined"){
                console.log("Removing...");
            }
        },
        onDestroy: function(){
            if(typeof console !== "undefined" && typeof console.log !== "undefined"){
                console.log("Destroying...");   
            }
        }
    });
}
function updateCoords (coords){
    $("#posx").val(coords.x);
    $("#posy").val(coords.y);
    $("#width").val(coords.width);
    $("#height").val(coords.height);
    $("#opacity").val(coords.opacity);  
    for (var i = 0; i < num.length; i++) {
        if (num[i].watermark == coords.id) {
            num[i].value = {"image":coords.imagePath,"x1":coords.x,"y1":coords.y,"w":coords.width,"h":coords.height};
        }
    }

    // var image = $('#image').attr('src');
    //var obj={"watermark":{"image":coords.imagePath,"x1":coords.x,"y1":coords.y,"w":coords.width,"h":coords.height}}
    var pretty = JSON.stringify(num, undefined, 2);
    $('#datavalu').val(pretty);
}
function make_id(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
/*End watermarker*/
/*filter*/
function blur() {
  var blur = $("#blur").slider("value");
  var grayscale = $("#grayscale").slider("value");
  var brightness = $("#brightness").slider("value");
  var contrast = $("#contrast").slider("value");
  //var rotate = $("#rotate").slider("value");
  var invert = $("#invert").slider("value");
  //var opacity = $("#opacity").slider("value");
  //var saturate = $("#saturate").slider("value");
  //var sepia = $("#sepia").slider("value");
  $("#imagewater").css("-webkit-filter", "blur(" + blur + "px)" + "brightness(" + brightness + "%)" + "grayscale(" + grayscale + "%)" + "contrast(" + contrast + "%)" + "invert(" + invert + "%)");
  $("#imagewater").css("filter", "blur(" + blur + "px)" + "brightness(" + brightness + "%)" + "grayscale(" + grayscale + "%)" + "contrast(" + contrast + "%)" + "invert(" + invert + "%)");
  for (var i = 0; i < num.length; i++) {
      if (num[i].mainimage) {
          num[i].value = {"blur":blur,"grayscale":grayscale,"brightness":brightness,"contrast":contrast,"huerotate":rotate,"invert":invert,"opacity":opacity,"saturate":saturate,"sepia":sepia};
      }
  }
  var pretty = JSON.stringify(num, undefined, 2);
  $('#datavalu').val(pretty);
}
//***********SLIDERS*************//

function getslider() {
  $("#blur").slider({
    orientation: "horizontal",
    min: 0,
    max: 25,
    value: 0,
    slide: blur,
    change: blur
  });
  $("#grayscale").slider({
    orientation: "horizontal",
    min: 0,
    max: 100,
    value: 0,
    slide: blur,
    change: blur
  });
  $("#brightness").slider({
    orientation: "horizontal",
    min: 100,
    max: 1000,
    value: 100,
    slide: blur,
    change: blur
  });

  $("#contrast").slider({
    orientation: "horizontal",
    min: 0,
    max: 1000,
    value: 100,
    slide: blur,
    change: blur
  });
  // $("#rotate").slider({
  //   orientation: "horizontal",
  //   min: -180,
  //   max: 180,
  //   value: 0,
  //   slide: blur,
  //   change: blur
  // });

  // $("#saturate").slider({
  //   orientation: "horizontal",
  //   min: 0,
  //   max: 100,
  //   value: 1,
  //   slide: blur,
  //   change: blur
  // });

  // $("#sepia").slider({
  //   orientation: "horizontal",
  //   min: 0,
  //   max: 100,
  //   value: 0,
  //   slide: blur,
  //   change: blur
  // });

  // $("#opacity").slider({
  //   orientation: "horizontal",
  //   min: 0,
  //   max: 100,
  //   value: 100,
  //   slide: blur,
  //   change: blur
  // });

  $("#invert").slider({
    orientation: "horizontal",
    min: 0,
    max: 100,
    value: 0,
    slide: blur,
    change: blur
  });
}
    </script>
<style type="text/css">
    .addfield{margin-top: 7px}
</style>
<style>
        #image,#myCanvas{
  float:left;
}

#blur,#grayscale,#brightness,#contrast,#rotate,#invert,#opacity,#saturate,#sepia{
    width: 300px;
    margin: 15px;
   float:left;
   font-size: 11px;
 }
 
 div[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 2px 0;
}

div[type=range] {
  width: 100%;
  height: 1px;
  cursor: pointer;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
  background: rgba(191, 102, 192, 0.35);
  border-radius: 9.2px;
  border: 0.2px solid #010101;
}
.ui-slider .ui-slider-handle {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 5px;
  width: 22px;
  border-radius: 12px;
  background: rgba(255, 42, 109, 0.75);
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: 1.8px;
}

div[type=range] {
  width: 100%;
  height: 1px;
  cursor: pointer;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
  background: rgba(191, 102, 192, 0.35);
  border-radius: 9.2px;
  border: 0.2px solid #010101;
}

div[type=range] {
  background: rgba(164, 68, 165, 0.35);
  border: 0.2px solid #010101;
  border-radius: 18.4px;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
}
div[type=range] {
  background: rgba(191, 102, 192, 0.35);
  border: 0.2px solid #010101;
  border-radius: 18.4px;
  box-shadow: 1px 1px 0.7px #000000, 0px 0px 1px #0d0d0d;
}
div[type=range] {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 5px;
  width: 22px;
  border-radius: 12px;
  cursor: pointer;
  height: 1px;
}
.loadding{border: red solid 1px !important}
label {display:inline-block!important; }
</style>
    <?php

} else {
    echo '<div class="alert fade in alert-danger" >
                            <strong>You have no permission on this page!...</strong> .
                        </div>';
}
?>