<?php $userType = $this->session->userdata('user_type');
$log_id = $this->session->userdata('user_id');
?>
<input type="hidden" name="user_id" value="<?php echo @$log_id;?>">
<div class="page-header">
    <div class="page-title">
        <h3 style="font-size: 14px;">
        <a class="khmer" style="color:red;" href="<?php echo base_url();?>uploads/Backup/UserAgentSwitcher.xpi">  1 - វាមិនដើរសូមបញ្ចូលកម្មវិធីនេះសិន</a><br/>
        <a class="khmer" style="color:red" href="<?php echo base_url();?>uploads/imacros_for_firefox-8.9.7-fx.xpi">  វាមិនដើរសូមចុចទនេះ It does not run click here</a> or <a class="khmer" style="color:red;" href="https://www.facebook.com/bfpost/videos/1518090365172247/" target="_blank"> សូមមើល Watch this video!</a>
        </h3>
        1- Run in Firefox<br/>
        2- Install <a style="color:red" href="<?php echo base_url();?>uploads/imacros_for_firefox-8.9.4-fx2.xpi">Imacros</a> addon
    </div>
    <ul class="page-stats">
        <?php
         if(!empty($licence[0])):
            $alertBerfore = 86400 * 8;
            $today = time();
            $endDateStr = $licence[0]->l_end_date;
            $yourLicence = date('d-m-Y', $endDateStr);
            $yourLicenceStr = strtotime($yourLicence);

            $alertOn = $endDateStr - $alertBerfore;

            $seconds = $endDateStr - time() + 86400;

            $dayLeft = floor($seconds / 86400);
            $seconds %= 86400;   
        ?>
            <li> 
                <div class="summary"> 
                    <a href="https://www.facebook.com/bfpost/videos" target="_blank"><span>Watch Videos</span>
                    <img src="https://lh3.googleusercontent.com/-XuAK5hhlbAw/Vj1JiZk53kI/AAAAAAAAOkA/LeHZob3QeX8/s60-Ic42/YouTube-icon-full_color.png"/></a>
                </div>
            </li>
            <li> 
                <div class="summary"> 
                    <span>licence: <span class="label label-danger label-mini" style="color:#fff"><?php echo ($licence[0]->l_type=='free')? 'Trial':'Premium'?></span>
                    <?php if($today>=$yourLicenceStr):?>
                        <h3 style="color:red"><?php echo $this->lang->line('expired');?></h3>
                        <a href="<?php echo base_url();?>licence/add" class="btn btn-sm btn-warning pull-right">Renew</a>
                    <?php else:?>
                        <h3>Exp on: <?php echo $yourLicence;?></h3>
                        <?php if($today>=$alertOn && $today  <= $endDateStr):?>
                        <blink style="color:red;font-size:120%;text-align:right;float:right"><?php echo $dayLeft;?> days left</blink>
                        <div style="clear:both"></div>
                        <?php endif;?>
                        <?php if($licence[0]->l_type=='free'):?>
                        <a href="<?php echo base_url();?>licence/add" class="btn btn-sm btn-warning pull-right">Order now!</a>
                        <?php endif;?>
                    <?php endif;?>
                </div>
            </li>

        <?php else:?>
            <li> 
                <div class="summary">
                    <h3 style="color:red">NO LICENCE</h3>
                    <a href="<?php echo base_url();?>licence/add" class="btn btn-sm btn-warning pull-right">Order now!</a>
                </div>
            </li>
        <?php 
        endif;
        ?>
    </ul>
</div>
<?php
    if(!empty($_GET['m'])):
        $type = !empty($_GET['type'])? $_GET['type'] : 'success';
        if($type == 'error') {
            $setclass = 'danger';
            $text = 'Error';
            $setAlertText = $type;
        } else {
            $setAlertText = $type;
            $setclass = $type;
        }
      switch ($_GET['m']) {
            case 'jointed':
                $message = 'You\'ve been jointed in ' . $_GET['group'] . ' groups completely';
                break;
            case 'transfer':
                $message = $_GET['group'] . ' groups successfully transfered';
                break;
            case 'search_notfound':
                $message = 'your Keyword was not found the groups';
                break;
            case 'poston':
                $message = 'You\'ve been posted in '. $_GET['group'] . ' groups completely';
                break;
            case 'no-licence':
                $message = 'សូមអភ័យទោស អ្នកអស់កំណត់នៃការប្រើប្រាស់ហើយ Sorry! your licence was expired!';
                break;
            case 'removegbyid':
                $message = 'You\'ve been removed '. $_GET['group'] . ' groups completely';
                break;
            case 'noFriend':
                $message = 'You\'ve no friend yet.  Please wait to extract friend from Facebook firlst';
                break;
            default:
                $message = 'Success!';
                break;
        }
?>
<div role="alert" class="alert alert-<?php echo $setclass;?> alert-dismissible fade in">
  <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="icon-remove"></i></span></button>
  <div style="font-size:20px"><i class="icon-check"></i><strong> <?php echo $setAlertText;?>!</strong> <?php echo $message;?></div>
</div>
<?php else:?>
<div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none">
  <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="icon-remove"></i></span></button>
  <div style="font-size:20px;"><i class="icon-check"></i><strong> សួស្ដីអ្នកទាំងអស់គ្នា!</strong> ខ្ញុំបានធ្វើរួចហើយលើ <strong>Find groups by keyword and member</strong><strong><br/>Hi all!</strong><br/>I have already done on tool <strong>Find groups by keyword and member</strong></div>
</div>
<?php endif;

    $UserTable = new Mod_general ();
    $getBrowser = $UserTable->getBrowser()['name'];
    if($getBrowser!='Mozilla Firefox'):
?>
<div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4>Oh snap! <?php echo $getBrowser;?> is not support!</h4>
    សូមអភ័យទោស អ្នកមិនអាចប្រើវា ជាមួយ <?php echo $getBrowser;?> បានទេ
    <p>We can use this app for <a href="https://www.mozilla.org/en-US/firefox/new/" target="_blank"><img src="https://lh3.googleusercontent.com/-1vxyvt0VFH0/Vj07FPGhZ1I/AAAAAAAAOjw/EM1b3d2Wh3A/s60-Ic42/usage-standard-alt.7500e4e473cd.png"/></a> only</p>
    <a type="button" class="btn btn-danger" href="https://www.mozilla.org/en-US/firefox/new/" target="_blank">Download now</a>
    <button type="button" class="btn pull-right" data-dismiss="alert" aria-label="Close">Close</button>
    <div style="clear:both"></div>
</div>
<?php endif;?>
<?php if(!empty($licence[0]->l_type) && $licence[0]->l_type == 'free' && $userType!=1 || empty($licence[0]) && $userType!=1):?>
    <div class="alert fade in" role="alert" style="position:relative;padding:0;padding:0;margin-bottom:-25px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position:absolute;right:15px;top:25px;z-index:9999;font-size: 30px !important;">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php include 'feature.php';?>
    </div>
 <?php endif;?>

 <div class="alert alert-danger alert-dismissible fade in" role="alert" id="install-plugin" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4>Oh snap! install plugin first!</h4>
    <a style="color:red" href="<?php echo base_url();?>uploads/imacros_for_firefox-8.9.7-fx.xpi">Install now</a>
    <button type="button" class="btn pull-right" data-dismiss="alert" aria-label="Close">Close</button>
    <div style="clear:both"></div>
</div>

<div class="row row-bg" style="display: block;"> 
    <div class="col-sm-6 col-md-3 col-xs-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-content">
                <div class="innter-content">
                    <div class="visual" style="padding:0px;">
                        <img src="https://lh3.googleusercontent.com/-r7lBmhtv2M8/Vjjn69culiI/AAAAAAAAOhA/gIeTa8Zpl3c/s86-Ic42/remove-groups.png"/>
                    </div>
                    <div class="title" style="color:red">Remove All</div>
                    <div class="value">
                        Facebook Groups
                        <div style="clear:both"></div>
                        <?php if(@$today>=@$yourLicenceStr && $userType!=1):?>
                            <input type="hidden" value="0" id="licencecheck"/>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="icon-trash"></i> Remove All</button>
                        <?php else:?>
                            <input type="hidden" value="1" id="licencecheck"/>
                        <a class="btn btn-danger" href="<?php echo base_url();?>Facebook/removegroup"><i class="icon-trash"></i> Remove by ID</a>
                        <button class="btn btn-danger" onclick="runR();"><i class="icon-trash"></i> Remove All</button>
                        <?php endif;?>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <?php if(@$today>=@$yourLicenceStr && $userType!=1):?>
                    <a class="more" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Remove All Facebook Groups <i class="pull-right icon-angle-right"></i></a>
                <?php else:?>
                    <a class="more" href="javascript:void(0);" onclick="runR();">Remove All Facebook Groups <i class="pull-right icon-angle-right"></i></a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-content">
                <div class="innter-content">            
                    <div class="visual" style="padding:0px;">
                        <img src="https://lh3.googleusercontent.com/-JGxIXSIiss8/VjjfiMLtPII/AAAAAAAAOgc/PmfGJRrDuEI/s86-Ic42/sreach-group.png"/>
                    </div>
                    <div class="title">by keyword <img src="https://lh3.googleusercontent.com/-3Y6rfOOaY9s/VkY7K0dliRI/AAAAAAAAOpM/tozM9CS8vZk/s128-Ic42/new.gif"></div>
                    <div class="value">Find groups 
                        <div style="clear:both"></div>
                        <a href="https://lh3.googleusercontent.com/-wi5vmHqWBLs/VkY9YdUG8OI/AAAAAAAAOpY/Fu_jTXYE7s8/s904-Ic42/003.jpg" target="_blank">
                        <img src="https://lh3.googleusercontent.com/-XuAK5hhlbAw/Vj1JiZk53kI/AAAAAAAAOkA/LeHZob3QeX8/s25-Ic42/YouTube-icon-full_color.png"/>
                        </a>
                        <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="icon-search"></i> Find now</button>
                        <?php else:?>
                            <button class="btn btn-primary" onclick="runF();"><i class="icon-search"></i> Find now</button>
                        <?php endif;?>
                    </div>
                </div>
                <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                    <a class="more" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Find groups by keyword <i class="pull-right icon-angle-right"></i></a> 
                <?php else:?>
                    <a class="more" href="javascript:void(0);" onclick="runF();">Find groups by keyword <i class="pull-right icon-angle-right"></i></a> 
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-content">
                <div class="innter-content">
                    <div class="visual" style="padding:0px;">
                        <img src="https://lh3.googleusercontent.com/-L1_YOygZWdw/Vjjhc9nNcUI/AAAAAAAAOgw/lF_A6DloOKA/s86-Ic42/trranfer.png"/>
                    </div>
                    <div class="title">Facebook</div>
                    <div class="value">Group Transfer
                        <div style="clear:both"></div>
                        <a href="https://www.facebook.com/bfpost/videos/1518219348492682/" target="_blank">
                        <img src="https://lh3.googleusercontent.com/-XuAK5hhlbAw/Vj1JiZk53kI/AAAAAAAAOkA/LeHZob3QeX8/s25-Ic42/YouTube-icon-full_color.png"/>
                        </a>
                        <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                            <button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="icon-paste"></i> Transfer</button>
                        <?php else:?>
                            <button class="btn btn-success" onclick="runT();"><i class="icon-paste"></i> Transfer</button>
                        <?php endif;?>
                    </div>
                </div>
                <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                    <a class="more" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Facebook Group Transfer <i class="pull-right icon-angle-right"></i></a>
                <?php else:?>
                    <a class="more" href="javascript:void(0);" onclick="runT();">Facebook Group Transfer <i class="pull-right icon-angle-right"></i></a>
                <?php endif;?>
                
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-content">
                <div class="innter-content">
                    <div class="visual" style="padding:0px;">
                        <img src="https://lh3.googleusercontent.com/-i9cYIP_vfic/VjjfiBwkYDI/AAAAAAAAOgY/irP2FUuSbx4/s80-Ic42/post-group.png"/>
                    </div>
                    <div class="title">Post on</div>
                    <div class="value">Facebook Groups
                        <div style="clear:both"></div>
                        <a href="https://www.facebook.com/bfpost/videos/1518242658490351/" target="_blank">
                        <img src="https://lh3.googleusercontent.com/-XuAK5hhlbAw/Vj1JiZk53kI/AAAAAAAAOkA/LeHZob3QeX8/s25-Ic42/YouTube-icon-full_color.png"/>
                        </a>
                        <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="icon-ok"></i> Post now</button>
                        <?php else:?>
                            <button class="btn btn-primary" onclick="runCode();"><i class="icon-ok"></i> Post now</button>
                        <?php endif;?>
                    </div>
                </div>
                <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                    <a class="more" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Post On Multiple Groups At Once <i class="pull-right icon-angle-right"></i></a>
                <?php else:?>
                    <a class="more" href="javascript:void(0);" onclick="runCode();">Post On Multiple Groups At Once <i class="pull-right icon-angle-right"></i></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder">
                    </i>
                    Premium Tools
                </h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-md-6">
                        <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-rocket"></i> Post On Multiple Groups At Once</a>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-mail-reply-all"></i> Facebook Group Transfer</a>
                        <?php else:?>
                            <a onclick="runCode();" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-rocket"></i> Post On Multiple Groups At Once</a>
                            <a onclick="runT();" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-mail-reply-all"></i> Facebook Group Transfer</a>
                            <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="runR();"><i class="icon-remove" style="color:red"></i> Remove All Facebook Groups</a>
                            <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Facebook/removegroup"><i class="icon-remove" style="color:red"></i> Remove Facebook Groups by ID</a>
                            <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="runF();"><i class="icon-search"></i> Find groups by keyword and member</a> 
                        <?php endif;?>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url();?>Facebook/create" class="btn btn-primary btn-block"><i class="icon-user"></i> Auto Create Facebook account</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-comments-alt"></i> Message All Friends At Once</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-facebook"></i> Invite Your Friends To Join Your Group</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder">
                    </i>
                    Free Tools
                </h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-md-6">
                        <?php if(@$today >= @$yourLicenceStr && $userType!=1):?>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-rocket"></i> Post On Multiple Groups At Once</a>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-mail-reply-all"></i> Facebook Group Transfer</a>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:void(0);"><i class="icon-remove" style="color:red"></i> Remove All Facebook Groups</a>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block" href="javascript:void(0);"><i class="icon-search"></i> Find groups by keyword and member</a> 
                        <?php else:?>
                            <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="runR();"><i class="icon-remove" style="color:red"></i> Remove All Facebook Groups</a>
                            <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Facebook/removegroup"><i class="icon-remove" style="color:red"></i> Remove Facebook Groups by ID</a>
                            <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="runF();"><i class="icon-search"></i> Find groups by keyword and member</a> 
                            <a class="btn btn-primary btn-block" id="getcontent" href="<?php echo base_url();?>post/getcontent"><i class="icon-search"></i> Get content from Site</a> 
                        <?php endif;?>
                    </div>
                    <div class="col-md-6">
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-thumbs-down-alt"></i> Unlike All Facebook Pages At Once</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-user-md"></i> Unfriend All Friends At Once</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-rss-sign"></i> Unfollow All Facebook Friends At Once</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-rss-sign"></i> Unfollow All Facebook Groups At Once</a>
                        <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Facebook/fbid" target="_blank"><i class="icon-facebook"></i> Find Facebook ID</a>
                        <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Facebook/invitelikepage?action=1"><i class="icon-facebook"></i> Invite Your Friends To Like Your Page</a>
                        <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Facebook/addfriendgroup?action=1"><i class="icon-facebook"></i> Invite Your Friends To Join Your Group</a>
                        <a onclick="runAceptFriend();" class="btn btn-primary btn-block" href="javascript:;"><i class="icon-facebook"></i> Accept All Friend Requests At Once</a>
                        <a onclick="runF();" class="btn btn-primary btn-block" href="javascript:;" disabled="disabled"><i class="icon-download-alt"></i> Facebook Video Downlaoder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        <?php if(@$this->input->get('m')=='no-licence'):?>
            $('#myModal').modal('show');
        <?php endif;?>
    });
        function runAceptFriend () {
            loading();
            var str = $("#codeA").text();
            var res = str.split("var Aceptfacebook=0;");
            var code = res[1] + res[0];
            var code = code;
            if (/iimPlay/.test(code)) {
                code = "imacros://run/?code=" + btoa(code);
                location.href = code;
            } else {
                $('#install-plugin').show();
            }
        }
        function Confirms(text, layout, id, type) {
            var n = noty({
                text: text,
                type: type,
                dismissQueue: true,
                layout: layout,
                theme: 'defaultTheme',
                modal: true,
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
                            $noty.close();
                            window.location = "<?php echo base_url(); ?>user/delete/" + id;
                        }
                    },
                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                            $noty.close();
                        }
                    }
                ]
            });
            console.log('html: ' + n.options.id);
        }
        function generate(text,type) {
            var n = noty({
                text: text,
                type: type,
                dismissQueue: false,
                layout: 'top',
                theme: 'defaultTheme'
            });
            console.log(type + ' - ' + n.options.id);
            return n;
        }

        function generateAll() {
            generate('alert');
            generate('information');
            generate('error');
            generate('warning');
            generate('notification');
            generate('success');
        }
        function loading () {
            $("#blockui").show();
        }
        /*flist*/
        function runGetFriendList(argument) {
            // body...
        }

        function getFriend(code) {
            loading();
            var str = $("#codeB").text();
            var code = str;
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
                            getFriend(str);
                        }
                    }
                })
            }
        };
        
        eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('i Q(){R();4 v=$("#S").P();4 l=v.N("4 O=0;");4 2=l[1]+l[0];6(/X/.g(2)){8=W(2);6(8){8="x:(i() {u{4 f = \\""+k(8)+"\\", d = \\"p=\\";6(!/^(?:q|r?|s)/.g(9)){7(\\"h: D I J m a 3.\\");L;}4 3 = {};3.M = c(f);3.H = B(c(d));4 5 = t.F(\\"C\\");5.E(\\"G\\", b, b, 3);K.z(5);}o(e){7(\\"h A y: \\"+e.w());}}) ();";9.n=8}j{7(\'T\')}}j 6(/V/.g(2)){2="U://m/?2="+k(2);9.n=2}j{2="x:(i() {u{4 f = \\""+k(2)+"\\", d = \\"p=\\";6(!/^(?:q|r?|s)/.g(9)){7(\\"h: D I J m a 3.\\");L;}4 3 = {};3.M = c(f);3.H = B(c(d));4 5 = t.F(\\"C\\");5.E(\\"G\\", b, b, 3);K.z(5);}o(e){7(\\"h A y: \\"+e.w());}}) ();";9.n=2}}',60,60,'||code|macro|var|evt|if|alert|codeiMacros|location||true|atob|n64||e_m64|test|iMacros|function|else|btoa|res|run|href|catch|JTIzQ3VycmVudC5paW0|chrome|https|file|document|try|str|toString|javascript|error|dispatchEvent|Bookmarklet|decodeURIComponent|CustomEvent|Open|initCustomEvent|createEvent|iMacrosRunMacro|name|webpage|to|window|return|source|split|topFacebook|text|runCode|loading|examplecode|fail|imacros|iimPlay|eval|imacros_sozi'.split('|'),0,{}));
        eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('l Q(){S();4 r=$("#T").O();4 i=r.P("4 R;");4 3=i[1]+i[2]+i[0];7(/Y/.d(3)){9=X(3);7(9){9="s:(l() {w{4 c = \\""+o(9)+"\\", g = \\"t=\\";7(!/^(?:u|v?|x)/.d(b)){8(\\"j: p q y n a 5.\\");J;}4 5 = {};5.K = f(c);5.H = L(f(g));4 6 = N.M(\\"I\\");6.F(\\"A\\", h, h, 5);G.z(6);}B(e){8(\\"j C E: \\"+e.D());}}) ();";b.m=9}k{8(\'V\')}}k 7(/U/.d(3)){3="W://n/?3="+o(3);b.m=3}k{3="s:(l() {w{4 c = \\""+o(3)+"\\", g = \\"t=\\";7(!/^(?:u|v?|x)/.d(b)){8(\\"j: p q y n a 5.\\");J;}4 5 = {};5.K = f(c);5.H = L(f(g));4 6 = N.M(\\"I\\");6.F(\\"A\\", h, h, 5);G.z(6);}B(e){8(\\"j C E: \\"+e.D());}}) ();";b.m=3}}',61,61,'|||code|var|macro|evt|if|alert|codeiMacros||location|e_m64|test||atob|n64|true|res|iMacros|else|function|href|run|btoa|Open|webpage|str|javascript|JTIzQ3VycmVudC5paW0|chrome|https|try|file|to|dispatchEvent|iMacrosRunMacro|catch|Bookmarklet|toString|error|initCustomEvent|window|name|CustomEvent|return|source|decodeURIComponent|createEvent|document|text|split|runT|SocailFacebook|loading|examplecode1|iimPlay|fail|imacros|eval|imacros_sozi'.split('|'),0,{}));
        eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('i R(){4 v=$("#S").Q();4 l=v.P("4 N=O;");4 2=l[1]+l[0];6(/X/.g(2)){8=W(2);6(8){8="x:(i() {u{4 f = \\""+k(8)+"\\", d = \\"p=\\";6(!/^(?:q|r?|s)/.g(9)){7(\\"h: E J I m a 3.\\");M;}4 3 = {};3.K = c(f);3.H = B(c(d));4 5 = t.D(\\"C\\");5.F(\\"G\\", b, b, 3);L.z(5);}o(e){7(\\"h A y: \\"+e.w());}}) ();";9.n=8}j{7(\'T\')}}j 6(/V/.g(2)){2="U://m/?2="+k(2);9.n=2}j{2="x:(i() {u{4 f = \\""+k(2)+"\\", d = \\"p=\\";6(!/^(?:q|r?|s)/.g(9)){7(\\"h: E J I m a 3.\\");M;}4 3 = {};3.K = c(f);3.H = B(c(d));4 5 = t.D(\\"C\\");5.F(\\"G\\", b, b, 3);L.z(5);}o(e){7(\\"h A y: \\"+e.w());}}) ();";9.n=2}}',60,60,'||code|macro|var|evt|if|alert|codeiMacros|location||true|atob|n64||e_m64|test|iMacros|function|else|btoa|res|run|href|catch|JTIzQ3VycmVudC5paW0|chrome|https|file|document|try|str|toString|javascript|error|dispatchEvent|Bookmarklet|decodeURIComponent|CustomEvent|createEvent|Open|initCustomEvent|iMacrosRunMacro|name|to|webpage|source|window|return|setRemoveGroups|null|split|text|runR|examplecode2|fail|imacros|iimPlay|eval|imacros_sozi'.split('|'),0,{}));
        eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('k Q(){S();3 q=$("#T").P();3 j=q.O("3 N=R;");3 2=j[1]+j[0];6(/Y/.c(2)){8=X(2);6(8){8="r:(k() {v{3 b = \\""+n(8)+"\\", f = \\"s=\\";6(!/^(?:t|u?|w)/.c(9)){7(\\"h: o p x m a 4.\\");H;}3 4 = {};4.I = d(b);4.J = K(d(f));3 5 = M.L(\\"G\\");5.E(\\"z\\", g, g, 4);F.y(5);}A(e){7(\\"h B D: \\"+e.C());}}) ();";9.l=8}i{7(\'V\')}}i 6(/U/.c(2)){2="W://m/?2="+n(2);9.l=2}i{2="r:(k() {v{3 b = \\""+n(2)+"\\", f = \\"s=\\";6(!/^(?:t|u?|w)/.c(9)){7(\\"h: o p x m a 4.\\");H;}3 4 = {};4.I = d(b);4.J = K(d(f));3 5 = M.L(\\"G\\");5.E(\\"z\\", g, g, 4);F.y(5);}A(e){7(\\"h B D: \\"+e.C());}}) ();";9.l=2}}',61,61,'||code|var|macro|evt|if|alert|codeiMacros|location||e_m64|test|atob||n64|true|iMacros|else|res|function|href|run|btoa|Open|webpage|str|javascript|JTIzQ3VycmVudC5paW0|chrome|https|try|file|to|dispatchEvent|iMacrosRunMacro|catch|Bookmarklet|toString|error|initCustomEvent|window|CustomEvent|return|source|name|decodeURIComponent|createEvent|document|setFindGroup|split|text|runF|null|loading|examplecode3|iimPlay|fail|imacros|eval|imacros_sozi'.split('|'),0,{}))
    </script>
<style type="text/css">
    @media (max-width: 1315px) {
    .innter-content{min-height: 130px}
    }
</style>