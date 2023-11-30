<?php
$b = @$_GET['b'];
$p = @$_GET['p'];
//var audiotrack = 'https://5000-years-zip.org/5000tripitakaaudio/audiobook_bedok_'+bookmp3+'.mp3';
if(!empty($_POST['settime'])) {
	$settime = $_POST['settime'];
	$page = $_POST['page'];
	$book = $_POST['book'];



	if (!file_exists(dirname(__FILE__) . '/uploads/data/pages/')) {
        mkdir(dirname(__FILE__) . '/uploads/data/', 0700);
    }
    if (!file_exists(dirname(__FILE__) . '/uploads/data/pages/book'.$book.'.json')) {
        //mkdir(dirname(__FILE__) . '/uploads/data/pages/', 0700);
    } else {
    	$upload_path = dirname(__FILE__) . '/uploads/data/pages/';
        $file_name = 'book'.$book.'.json';
        $str = file_get_contents($upload_path.$file_name);
        $json = json_decode($str);
        $b1_pages = array();
        $i = 1;
        foreach ($json->page as $value) {
        	$b1_pages[$i] = array('t'=>$value->playtime);
        	$i++;
        }
        $b1_pages[$page] = array('t'=>$settime);
        $b_page = array(
			'page'=> $b1_pages
		);
		$j = $b_page;
		echo '<pre>';
		print_r($j);
		echo '</pre>';
		//var_dump($j);
		//echo json_encode($j);
        $jsonPost = json($upload_path,$file_name, $b_page);
    }



	//header("Location: http://localhost/beydokdb/book.php?b=".$book."&p=".($page + 1), true, 301);  
	exit();  
}
if(!empty($b)) {
	if($b<10) {
		$bookmp3 = '00'.$b;
	} else if($b >= 10 && $b < 99) {
		$bookmp3 = '0'. $b;
	} else {
		$bookmp3 = $b;
	}
	$audiotrack = 'https://5000-years-zip.org/5000tripitakaaudio/audiobook_bedok_'.$bookmp3.'.mp3';
	if (!file_exists(dirname(__FILE__) . '/uploads/data/pages/book'.$b.'.json')) {
        //mkdir(dirname(__FILE__) . '/uploads/data/pages/', 0700);
    } else {
    	$upload_path = dirname(__FILE__) . '/uploads/data/pages/';
        $file_name = 'book'.$b.'.json';
        $str = file_get_contents($upload_path.$file_name);
        $json = json_decode($str,true);
    }
}

function json($upload_path,$file_name, $list = array(),$do='update') {
    if (!file_exists($upload_path)) {
        mkdir($upload_path, 0700);
    }
    if (!file_exists($upload_path.$file_name)) {
        $f = fopen($upload_path.$file_name, 'w');
        $fwrite = fwrite($f, json_encode($list));
        fclose($f);
    } else {
        $f = fopen($upload_path.$file_name, 'w');
        $fwrite = fwrite($f, json_encode($list));
        fclose($f);
    }
    if ($do == 'update') {
        $f = fopen($upload_path.$file_name, 'w');
        $fwrite = fwrite($f, json_encode($list));
        fclose($f);
    } else if ($do == 'delete') {
        unlink($upload_path.$file_name);
        $f = fopen($upload_path.$file_name, 'w');
        $fwrite = fwrite($f, json_encode($list));
        fclose($f);
    }
    if ($fwrite === false) {
        $written = false;
    } else {
        $written = $fwrite;
    }
    return $written;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BeyDok Book page Generator</title>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'></script>
</head>

<body>
	<br/>
	<audio controls id="booktrack" style="width:100%;">
	  <source src="<?php echo @$audiotrack;?>" type="audio/mpeg">
	Your browser does not support the audio element.
	</audio>
	<br/>
	<form method="post">
		Book: <input type="number" name="book" id="getbook" value="<?php echo $b;?>" style='width: 80px;'/> Page: <input type="number" name="page" id="getpage" value="<?php echo ($p+1);?>" style='width: 80px;'/> : <input type="text" name="settime" id="settime"/>

		<input type="submit" name="savetime" id="savetime" value="Save" />
	</form>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var audios = jQuery('#booktrack');
			let vid = document.getElementById("booktrack");
			//vid.currentTime=(92*60)+52;
			vid.currentTime=<?php echo $json['page'][$p]["playtime"];?>;
			vid.ontimeupdate = function() {myFunction()};

			function myFunction() {
			    //document.getElementById("settime").innerHTML = vid.currentTime;
			    jQuery('#settime').val(vid.currentTime);
			}
		});
	
	</script>
</body>
</html>
