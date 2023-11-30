<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller
{
    protected $mod_general;
    const Day = '86400';
    const Week = '604800';
    const Month = '2592000';
    const Year = '31536000';
    public function __construct() {
        parent::__construct ();
        $this->load->model ( 'Mod_general' );
        $this->load->library ( 'dbtable' );
        $this->load->theme ( 'layout' );
        $this->mod_general = new Mod_general ();
        TIME_ZONE;
        $this->load->library('Breadcrumbs');
    }
    public function index() {
        $data['title'] = 'Autopost';
        $this->load->view('admin/index', $data);
    }

    public function add()
    {
        $this->load->theme ( 'layout' );
        $data ['title'] = 'Admin Area :: Account';

        /*breadcrumb*/
        $this->breadcrumbs->add('<i class="icon-home"></i> Home', base_url());
        if($this->uri->segment(1)) {
            $this->breadcrumbs->add('blog post', base_url(). $this->uri->segment(1)); 
        }
        $this->breadcrumbs->add('Account', base_url().$this->uri->segment(1));
        $data['breadcrumb'] = $this->breadcrumbs->output();  
        /*End breadcrumb*/
        $this->load->view('admin/add', $data);
    }
    public function get()
     {
        $this->load->library ( 'html_dom' );
         $p = $this->input->get('p');
         $b = $this->input->get('b');
         if(!empty($b) && empty($p)) {
            $html = file_get_html ( 'http://m.ti-kh.org/books?book='.$b);
            $table = $html->find('table', 0);
            if(empty($table)) {
                echo 'no book found';
                die;
            }
            $rowData = array();
            $page = 0;
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $flight = array();
                $td = 1;
                //echo 'td = '. count($row->find('td')) .' - ';
                foreach($row->find('td') as $cell) {
                    // push the cell's text to the array

                    // if($td == 1) {
                    //     echo $cell->plaintext;
                    // }
                    // if($td == 2) {
                    //     echo ' page : '.$this->khNumber($cell->plaintext);
                    // }
                    // if(count($row->find('td')) == 1 && $page == 1) {
                    //     echo ' page : 1';
                    // } 
                    // if(count($row->find('td')) == 1 && $page != 1) {
                    //     echo ' page : 1';
                    // }
                    $flight[] = $cell->plaintext;
                    $td++;
                }
                //echo '<br/>';
                $rowData[] = $flight;
                $page++;
            }
            //var_dump($rowData);
            $metaval = array();
            //echo '<table>';

            for ($i=0; $i < count($rowData); $i++) {
                $smeta = array();
                //echo '<tr>'; 
                for ($t=0; $t < count($rowData[$i]); $t++) { 
                    if($t==0) {
                        //echo '<td>t0' . $rowData[$i][$t] .'</td>';
                        $val = $rowData[$i][$t];
                    } else {
                        //echo '<td>t1' . $rowData[$i][$t] .'</td>';
                        $key = $rowData[$i][$t];
                    }
                    
                    if(count($rowData[$i]) == 1) {
                        if(count($rowData[$i]) == 1 && $i == 1) {
                            //echo '<td>1</td>';
                            $key = '1';
                            $chapter = $this->session->userdata ( 'chapter' , $val);
                            if(!empty($chapter)) {
                                if($chapter!= $val) {
                                    $this->session->set_userdata('chapter', $val);
                                }
                            } else {
                                $this->session->set_userdata('chapter', $val);
                            }
                        } else if(count($rowData[$i]) == 1 && $i != 1) {
                            //echo '<td>' . $rowData[((int) $i + 1)][((int) $t + 1)] .'+++</td>';
                            $key = $rowData[((int) $i + 1)][((int) $t + 1)];
                            $chapter = $this->session->userdata ( 'chapter' , $val);
                            if(!empty($chapter)) {
                                if($chapter!= $val) {
                                    $this->session->set_userdata('chapter', $val);
                                }
                            } else {
                                $this->session->set_userdata('chapter', $val);
                            }
                        }
                    } 
                    $chapter = $this->session->userdata ( 'chapter' );
                    if(!empty($chapter)) {
                        $smeta['mname'] = $chapter;
                    }

                    if(!empty($val)) {
                        $smeta['name'] = $val;
                        $smeta['page'] = $this->khNumber($key);
                    }
                    
                    // if(count($rowData[$i]) == 1 && $i != 1) {
                    //     echo '<td>' . $rowData[((int) $i + 1)][((int) $t + 1)] .'+++</td>';
                    // }


                }
                //echo '</tr>';
                if(!empty($key)) {
                    $metaval[$this->khNumber($key)] = $smeta;
                }
            }
            // echo '</table>';
            // echo '<pre>';
            // print_r($metaval);
            // echo '</pre>';
            $tmp_path = FCPATH . 'uploads/data/';
            if (!file_exists($tmp_path)) {
                mkdir($tmp_path, 0777, true);
            }
            $file_tmp_name = 'mateka_'.$b.'.json';
            $this->json($tmp_path,$file_tmp_name, $metaval);

            echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'admin/get?b='.$b.'&p=1";}, 100 );</script>';
         }
         if(!empty($p)) {
            $page = '<div id="page_'.$p.'" class="bodypage"></div>';
            $html = file_get_html ( 'http://m.ti-kh.org/books?book='.$b.'&page='.$p );
            if(empty($html)) {
                echo '<meta http-equiv="refresh" content="3">';
                die;
            }

            /*set name*/
            $tmp_path = FCPATH . 'uploads/data/';
            $file_tmp_name = 'mateka_'.$b.'.json';
            $tmp_path = $tmp_path . $file_tmp_name;
            $string = file_get_contents($tmp_path);
            $json_a = json_decode($string,true);
            if(!empty($json_a[$p])) {
                $mname = $this->session->userdata ( 'mname' );
                if(!empty($mname)) {
                    if($mname!=$json_a[$p]['mname']) {
                        $this->session->set_userdata('mname', $json_a[$p]['mname']);
                    }
                } else {
                    $this->session->set_userdata('mname', $json_a[$p]['mname']);
                }

                $sname = $this->session->userdata ( 'sname' );
                if(!empty($sname)) {
                    if($sname!=$json_a[$p]['name']) {
                        $this->session->set_userdata('sname', $json_a[$p]['name']);
                    }
                } else {
                    $this->session->set_userdata('sname', $json_a[$p]['name']);
                }
            }

            /*End set name*/

            $found = [];
            $labels =[];
            $header =[];


            $mname = $this->session->userdata ( 'mname' );
            if(!empty($mname)) {
                array_push($labels, $mname);
            }
            $sname = $this->session->userdata ( 'sname' );
            if(!empty($sname)) {
                //array_push($labels, $sname);
            }

            $text = @$html->find( '#maincontent_divDetails div', 0);
            $texts = @$text->find( 'div', 1)->innertext;

            preg_match_all("/\\[(.*?)\\]/", $texts, $matches);
            $section='';
            if(!empty($matches)) {
                if(!empty($matches[0])) {
                    if(!empty($matches[1])) {
                        $num = preg_replace('/\D/', '', $this->khNumber($matches[1][0]));
                        //array_push($labels, 'section_'.$num);
                        $section = $this->session->userdata ( 'section' );
                        if(!empty($section)) {
                           if($section != $num) {
                                array_push($labels, 'book_'.$b.'_section_'.$section);
                                $this->session->set_userdata('section', $num);
                           } 
                        }  else {
                            $this->session->set_userdata('section', $num);
                        }

                        array_push($labels, 'book_'.$b.'_section_'.$num);                        
                        $section = '<div id="section_'.$num.'"></div>['.$matches[1][0].']';
                        $texts = str_replace('['.$matches[1][0].']', $section, $texts);
                        //$section = '<div id="section_'.khNumber($matches[1][0]).'"></div>';
                    }
                }
            }
            $section = $this->session->userdata ( 'section' );
            if(!empty($section)) {
                array_push($labels, 'book_'.$b.'_section_'.$section);
            }

            if(preg_match('/BCenter/', $texts)) {           
                $head = 'head.txt';
                if (is_writable($head)) {
                    // Open the file to get existing content
                    $current = file_get_contents($head);
                    $hcount = (int) $current;
                    $curr = $hcount + 1;
                    // Write the contents back to the file
                    array_push($labels, 'book_'.$b.'_head');
                    array_push($labels, 'book_'.$b.'_head_'.$curr);
                    $texts = str_replace('BCenter', 'header_section" id="'.$curr, $texts);
                    file_put_contents($head, $curr);
                } else {
                    $headerNum = 1;
                    $myh = fopen($head, "w") or die("Unable to open file!");
                    fwrite($myh, $headerNum);
                    fclose($myh);
                    $texts = str_replace('BCenter', 'header_section" id="'.$headerNum, $texts);
                    array_push($labels, 'book_'.$b.'_head');
                    array_push($labels, 'book_'.$b.'_head_'.$headerNum);
                }
            }
            //book_1_page_1
            array_push($labels, 'book_'.$b.'_page_'.$p);
            array_push($labels, 'book_'.$b);
            $label = '';
            foreach ($labels as $cate) {
                $label .= "<category scheme='http://www.blogger.com/atom/ns#' term='".$cate."'/>";
            }
            //array_push($labels, 'book_'.$b);
            $post_time = date( 'H:i:s');
            $post_date = date('Y-m-d');
            //$post_date = date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));
            //$post_time = date('H:i:s', strtotime('-1 days', strtotime(date('H:i:s'))));
            //2021-09-15T16:05:01.022+07:00
            //$pub = $d->format('c');
            $pub = $post_date."T".$post_time."Z";
            $pid = rand(100000,100);
            $newtext = '<span class="is_page_'.$p.' body_page">'.$page.$texts.'<span class="end_of_page"></span></span>';
            if($mname != $sname) {
                $addonTitle = $mname . ' | '.$sname;
            } else {
                $addonTitle = $mname;
            }
            
            $setTitle = "បិដក ភាគ ".$b." | page ".$p . ' | '.$addonTitle;
            $title = $this->ew2bc_esc_html($setTitle);
            $bodyText = $this->ew2bc_esc_html($newtext);
            $bodyText = str_replace( array( "\r\n", "\r", "\n" ), "", $bodyText );
            $bodyText = str_replace(PHP_EOL, "", $bodyText);
            //$bodyText = str_replace('&nbsp;', ' ', $bodyText);
            foreach($html->find('a') as $a) {
            if(preg_match('/បន្ទាប់/', $a->innertext)) {
                    array_push($found, $a->innertext);
                }
            }
            if($p==1) {
                $setHead = "<?xml version='1.0' encoding='utf-8'?><?xml-stylesheet href='https://www.blogger.com/styles/atom.css' type='text/css'?><feed xmlns='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' xmlns:gd='http://schemas.google.com/g/2005' xmlns:thr='http://purl.org/syndication/thread/1.0' xmlns:georss='http://www.georss.org/georss'><id>tag:blogger.com,1999:blog-4539092250549041002.archive</id><updated>2023-03-16T02:26:42.044+07:00</updated><title type='text'>ព្រះត្រៃបិដក</title><link rel='http://schemas.google.com/g/2005#feed' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='http://schemas.google.com/g/2005#post' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='alternate' type='text/html' href='http://xn--i2et3a4k.blogspot.com/'/><author><name>Chhuorn</name><uri>https://www.blogger.com/profile/14666010157633334330</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='35' height='35' src='//www.blogger.com/img/blogger_logo_round_35.png'/></author><generator version='7.00' uri='https://www.blogger.com'>Blogger</generator>";
            } else {
                $setHead = '';
            }
            if(empty($found)) {
                $endTxt = '</feed>';
            } else {
                $endTxt = '';
            }
            $xml = $setHead."<entry><id>tag:blogger.com,1999:blog-4539092250549041002.post-87".strtotime("now").$pid."</id><published>".$pub."</published><updated>".$pub."</updated><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/blogger/2008/kind#post'/>".$label."<title type='text'>".$title."</title><content type='html'>".$bodyText."</content><link rel='replies' type='application/atom+xml' href='https://bedok110.blogspot.com/feeds/87".strtotime("now").$pid."/comments/default' title='Post Comments'/><link rel='replies' type='text/html' href='https://bedok110.blogspot.com/2021/09/book-".$b."-page-".$p.".html#comment-form' title='0 Comments'/><link rel='edit' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/posts/default/87".strtotime("now").$pid."'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/posts/default/87".strtotime("now").$pid."'/><link rel='alternate' type='text/html' href='https://bedok110.blogspot.com/2021/09/book-".$b."-page-".$p.".html' title='".$title."'/><author><name>Chhuorn</name><uri>https://www.blogger.com/profile/14666010157633334330</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='35' height='35' src='//www.blogger.com/img/blogger_logo_round_35.png'/></author><thr:total>0</thr:total></entry>".$endTxt;
            $txtArr = array(
                'page'=>$p,
                'book'=>$b,
                'title'=>$title,
                'label'=>$labels,
                'content'=>$bodyText
            );
            $text_array = json_encode($txtArr);
            $book_path = FCPATH . 'uploads/data/';
            $bname = $book_path.'book_'.$b.'.xml';
            $bnameArr = 'book_'.$b.'_array.txt';

            if (is_writable($bname)) {
                $current = file_get_contents($bname);
                $current .= $xml;
                file_put_contents($bname, $current);

                //array file
                // $currentArr = file_get_contents($bnameArr);
                // $currentArr .= $text_array;
                // file_put_contents($bnameArr, $currentArr);
            } else {
                $myfile = fopen($bname, "w") or die("Unable to open file!");
                $txt = $xml;
                fwrite($myfile, $txt);
                fclose($myfile);
                //array file
                // $arrfile = fopen($bnameArr, "w") or die("Unable to open file!");
                // $txt = $xml;
                // fwrite($arrfile, $text_array);
                // fclose($arrfile);
            }

            //$bname = 'book_5.txt';
            // echo $bname;
            // echo '<br/>';
            // echo '<pre>';
            // print_r(array_unique($labels));
            // //print_r($labels);
            // echo '</pre>';
            /*
            Add to  database
            */
            $where_b = array('page' => $p,'book'=> $b);
            $CheckDupPage = $this->Mod_general->select('book', '*', $where_b);
            if(empty($CheckDupPage)) {
                $data_b = array(
                    'content'       => trim($texts),
                    'page'          => $p,
                    'book'          => $b,
                    'chapter'          => $mname,
                    'matika'          => $sname,
                    'section'          => $section,
                );
                //var_dump($data_b);
                $lastID = $this->Mod_general->insert('book', $data_b);
            }
            if(empty($found)) {
                echo '<h2 style="color:green;">Ok Finish!</h2>';
                $nextb = $b+1;
                echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'admin/get?b='.$nextb.'";}, 10 );</script>';
                die;
            } else {
                $next = $p+1;
                if(preg_match('/បន្ទាប់/', $a->innertext)) {
                    echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'admin/get?b='.$b.'&p='.$next.'";}, 10 );</script>';
                }
            }
         }
    }

    public function getdb()
    {
        $p = $this->input->get('p');
        $b = $this->input->get('b');
        $start = $this->input->get('start');
        $idstart = $this->input->get('idstart');
        $max = $this->input->get('max');
        $this->load->helper('cookie');
        $next = '';
        if(!empty($b)) {
            if(!empty($p)) {
                $where = array('book'=>$b,'page'=>$p);
            } else if(!empty($start)){
                $where = array('book'=>$b,'page >= '=>$start);
            } elseif($max) {
                if(!empty($idstart)) {
                    $where = array('id >='=>$idstart);
                } else {
                    $where = array('book >'=>$b);
                }
                
            } else if(!empty($idstart)){
                $where = array('id >='=>$idstart);
            } else {
                $where = array('book'=>$b);
            }
            if(!empty($max)) {
               $getB = $this->mod_general->select(
                    'book',
                    '*',
                    $where,
                    0, 
                    0, 
                    $max
                ); 
           } else {
                $getB = $this->mod_general->select(
                    'book',
                    '*',
                    $where
                );
           }
            echo count($getB).'<br/>';
            end($getB);
            $lastElementKey = key($getB);
            $bnum = $getB[0]->book.'-'.$getB[$lastElementKey]->book;
            $setName = 1;

            if(!empty($getB)) {
                $xml = '';
                foreach ($getB as $key => $bdata) {
                    $post_time = date( 'H:i:s');
                    $post_date = date('Y-m-d',strtotime("-2 days"));
                    $labels =[];
                    array_push($labels, 'book_'.$bdata->book.'_page_'.$bdata->page);
                    array_push($labels, 'book_'.$bdata->book);
                    //array_push($labels, 'book_'.$bdata->book.'_section_'.$bdata->section);
                    //array_push($labels, $bdata->chapter);


                    preg_match_all("/\[[^\]]*\]/", $bdata->content, $matches);
                    $lastTag = @$this->session->userdata('lastTag');
                    if(!empty($matches)) {
                        if(!empty($matches[0])) {
                            $cL = explode('[', $bdata->content);
                            echo mb_strlen($cL[0], "UTF-8").'<br/>';
                            if(mb_strlen($cL[0], "UTF-8")>150) {
                                array_push($labels, 'book_'.$bdata->book.'_section_'.$lastTag);
                            }
                            foreach ($matches[0] as $t) {
                                //$this->khNumber($i,'en')
                                $ta = str_replace('[','', $t);
                                $ta = str_replace(']','', $ta);
                                $ta = $this->khNumber($ta,'en');
                                array_push($labels, 'book_'.$bdata->book.'_section_'.$ta);
                            }
                            $lt = end($matches[0]);
                            $lt = str_replace('[','', $lt);
                            $lt = str_replace(']','', $lt);
                            $lt = $this->khNumber($lt,'en');
                            $this->session->set_userdata('lastTag', $lt);
                        } else {
                            if($lastTag) {
                                array_push($labels, 'book_'.$bdata->book.'_section_'.$lastTag);
                            }
                        }
                    } 

                    $label = '';
                    foreach ($labels as $cate) {
                        $label .= "<category scheme='http://www.blogger.com/atom/ns#' term='".$cate."'/>";
                    }
                    $pub = $post_date."T".$post_time."Z";
                    $pid = rand(100000,100);
                    if(!empty($bdata->chapter)) {
                        $tgs = $this->ew2bc_esc_html($bdata->chapter);
                        $tgs = str_replace( array( "\r\n", "\r", "\n" ), "", $tgs );
                        $this->session->set_userdata('schapter', $tgs);
                        $chapterT = ' | '.$bdata->chapter;
                    } else {
                        if($this->session->userdata('schapter')) {
                            $chapterT = ' | '.$this->session->userdata('schapter');
                        } else {
                            $chapterT = '';
                        }
                        
                    }
                    if(!empty($bdata->matika)) {
                       $cookie= array(
                           'name'   => 'matika',
                           'value'  => $bdata->matika,                            
                           'expire' => '300',           
                           'secure' => TRUE
                       );
                       $this->input->set_cookie($cookie);
                        $matikaT = ' | '.$bdata->matika;
                    } else {
                        if($this->input->cookie('matika',true)) {
                            $matikaT = ' | '.$this->input->cookie('matika',true);
                        } else {
                            $matikaT = '';
                        }
                        
                    }
                    $setTitle = "បិដកភាគ ".$bdata->book." | page ".$bdata->page . $chapterT . $matikaT;
                    $title = $this->ew2bc_esc_html($setTitle);
                    $bodyText = str_replace('section" id="', "section' id='", $bdata->content);
                    $bodyText = $this->ew2bc_esc_html($bodyText);
                    $bodyText = str_replace( array( "\r\n", "\r", "\n" ), "", $bodyText );
                    $bodyText = str_replace(PHP_EOL, "", $bodyText);

                    echo $bdata->id.'<br/>';
                    $indexs = $bdata->id;

                    echo $setTitle;
                    echo '<pre>';
                    print_r($labels);
                    echo '</pre>';
                    //echo $bodyText;
                    if($key % 500 == 0) {
                        //echo $key.'ssssssssss <br/>';
                        //$bnum = $bdata->id;
                        $indexs = 1;
                        $setName++;
                        $indexs++;
                    } 
                    if($lastElementKey == $key) {
                        $endTxt = '</feed>';
                    } else {
                        $endTxt = '';
                    }                 
                    //echo 'index '.$indexs.'<br/>';
                    if($key==0) {
                        $setHead = "<?xml version='1.0' encoding='utf-8'?><?xml-stylesheet href='https://www.blogger.com/styles/atom.css' type='text/css'?><feed xmlns='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' xmlns:gd='http://schemas.google.com/g/2005' xmlns:thr='http://purl.org/syndication/thread/1.0' xmlns:georss='http://www.georss.org/georss'><id>tag:blogger.com,1999:blog-4539092250549041002.archive</id><updated>2023-03-16T02:26:42.044+07:00</updated><title type='text'>ព្រះត្រៃបិដក</title><link rel='http://schemas.google.com/g/2005#feed' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='http://schemas.google.com/g/2005#post' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/archive'/><link rel='alternate' type='text/html' href='http://xn--i2et3a4k.blogspot.com/'/><author><name>Chhuorn</name><uri>https://www.blogger.com/profile/14666010157633334330</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='35' height='35' src='//www.blogger.com/img/blogger_logo_round_35.png'/></author><generator version='7.00' uri='https://www.blogger.com'>Blogger</generator>";
                    } else {
                        $setHead = '';
                    }
                    $xml .= $setHead."<entry><id>tag:blogger.com,1999:blog-4539092250549041002.post-87".strtotime("now").$pid."</id><published>".$pub."</published><updated>".$pub."</updated><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/blogger/2008/kind#post'/>".$label."<title type='text'>".$title."</title><content type='html'>".$bodyText."</content><link rel='replies' type='application/atom+xml' href='https://bedok110.blogspot.com/feeds/87".strtotime("now").$pid."/comments/default' title='Post Comments'/><link rel='replies' type='text/html' href='https://bedok110.blogspot.com/2021/09/book-".$bdata->book."-page-".$bdata->page.".html#comment-form' title='0 Comments'/><link rel='edit' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/posts/default/87".strtotime("now").$pid."'/><link rel='self' type='application/atom+xml' href='https://www.blogger.com/feeds/4539092250549041002/posts/default/87".strtotime("now").$pid."'/><link rel='alternate' type='text/html' href='https://bedok110.blogspot.com/2021/09/book-".$bdata->book."-page-".$bdata->page.".html' title='".$title."'/><author><name>Chhuorn</name><uri>https://www.blogger.com/profile/14666010157633334330</uri><email>noreply@blogger.com</email><gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='35' height='35' src='//www.blogger.com/img/blogger_logo_round_35.png'/></author><thr:total>0</thr:total></entry>".$endTxt;
                    if($indexs == 500) {
                        
                        echo $bdata->id .' - key '.$key .' - '.$bnum .' save to file<br/>';
                        
                        //
                    }
                    if($lastElementKey == $key) {
                        if(count($getB)>0) {
                            $next = base_url().'admin/getdb?idstart=' . ($bdata->id+1) .'&max='.$max.'&b=num';
                        }
                    }
                }
                $book_path = FCPATH . 'uploads/data/';
                
                $nextFile = $book_path.'next.txt';
                if (is_writable($nextFile)) {
                    $ncurrent = file_get_contents($nextFile);
                    $ncurrent .= $next;
                    file_put_contents($nextFile, $ncurrent);
                } else {
                    $mynfile = fopen($nextFile, "w") or die("Unable to open file!");
                    $ntxt = $next;
                    fwrite($mynfile, $ntxt);
                    fclose($mynfile);
                }

                $bname = $book_path.'book_'.$bnum.'.xml';
                if (is_writable($bname)) {
                    $current = file_get_contents($bname);
                    $current .= $xml;
                    file_put_contents($bname, $current);

                    //array file
                    // $currentArr = file_get_contents($bnameArr);
                    // $currentArr .= $text_array;
                    // file_put_contents($bnameArr, $currentArr);
                } else {
                    $myfile = fopen($bname, "w") or die("Unable to open file!");
                    $txt = $xml;
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    //array file
                    // $arrfile = fopen($bnameArr, "w") or die("Unable to open file!");
                    // $txt = $xml;
                    // fwrite($arrfile, $text_array);
                    // fclose($arrfile);
                }
                if(!empty($max)) {
                    if(!empty($next)) {
                        echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.$next.'";}, 10 );</script>';
                    }
                }
            }
        }
        
    }

    public function settime()
    {
        if(!empty($this->input->post('b'))) {
            $settime = $this->input->post('settime');
            $page = $this->input->post('p');
            $book = $this->input->post('b');
            $setPath = FCPATH . 'uploads/data/pages/';
            if (!file_exists($setPath)) {
                mkdir($setPath, 0700);
            }
            $upload_path = $setPath;
            $file_name = 'book'.$book.'.json';
            $str = file_get_contents($upload_path.$file_name);
            $json = json_decode($str);
            $b1_pages = array();
            $i = 1;
            foreach ($json->page as $value) {
                $b1_pages[$i] = array('t'=>$value->t);
                $i++;
            }
            $b1_pages[$page] = array('t'=>$settime);
            $b_page = array(
                'page'=> $b1_pages
            );
            $j = $b_page;
            // echo '<pre>';
            // print_r($j);
            // echo '</pre>';
            // die;
            // //var_dump($j);
            // //echo json_encode($j);
            $jsonPost = $this->json($upload_path,$file_name, $b_page);
            redirect(base_url().'admin/settime?b='.$book.'&p='.$page);
            exit();
            // if (!file_exists($setPath . '/book'.$book.'.json')) {
            //     mkdir(dirname(__FILE__) . '/uploads/data/pages/', 0700);
            // } else {
            //     $upload_path = $setPath;
            //     $file_name = 'book'.$book.'.json';
            //     $str = file_get_contents($upload_path.$file_name);
            //     $json = json_decode($str);
            //     $b1_pages = array();
            //     $i = 1;
            //     foreach ($json->page as $value) {
            //         $b1_pages[$i] = array('t'=>$value->t);
            //         $i++;
            //     }
            //     $b1_pages[$page] = array('t'=>$settime);
            //     $b_page = array(
            //         'page'=> $b1_pages
            //     );
            //     $j = $b_page;
            //     // echo '<pre>';
            //     // print_r($j);
            //     // echo '</pre>';
            //     // die;
            //     // //var_dump($j);
            //     // //echo json_encode($j);
            //     $jsonPost = $this->json($upload_path,$file_name, $b_page);
            //     redirect(base_url().'admin/settime?b='.$book.'&p='.$page);
            //     exit();
            // }
        }

        $p = $this->input->get('p');
        $b = $this->input->get('b');
        if(!empty($b)) {
            if(!empty($p)) {
                $where = array('book'=>$b,'page'=>$p);
            } else {
                $where = array('book'=>$b);
            }
            $getB = $this->mod_general->select(
                'book',
                '*',
                $where
            );
            echo count($getB).'<br/>';
            end($getB);
            $lastElementKey = key($getB);
            $bnum = $getB[0]->book.'-'.$getB[$lastElementKey]->book;
            $setName = 1;
            if(!empty($getB)) {
                foreach ($getB as $key => $bdata) {
                    $bodyText = $bdata->content;
                    $data['bodyText'] = $bodyText;
                }
                
            }

            if($b<10) {
                $bookmp3 = '00'.$b;
            } else if($b >= 10 && $b < 99) {
                $bookmp3 = '0'. $b;
            } else {
                $bookmp3 = $b;
            }
            $data['audiotrack'] = base_url() . 'uploads/mp3/audiobook_bedok_'.$bookmp3.'.mp3';

            // $upload_path = FCPATH . 'uploads/data/pages/';
            // $file_name = 'book'.$book.'.json';

            if (file_exists(FCPATH . 'uploads/data/pages/book'.$b.'.json')) {
                $upload_path = FCPATH . 'uploads/data/pages/';
                $file_name = 'book'.$b.'.json';
                $str = file_get_contents($upload_path.$file_name);
                $json = json_decode($str,true);
                $data['playtime'] = @$json['page'][$p]["t"];
            }
        }
        $data['title'] = 'Autopost';
        $this->load->view('admin/settime', $data);
    }

    public function getmatika()
    {
        $this->load->library ( 'html_dom' );
        $p = $this->input->get('p');
        $b = $this->input->get('b');
        $url = 'https://m.youtube.com/@SeihaTVOnline/search?query=Tipitaka%20Sutta%20Pitaka%20Ep'.$b;
        /*youtube*/
        $options = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: en\r\n" .
                      "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                      "User-Agent: Mozilla/5.0 (Linux; U; Android 2.2) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1\r\n" // i.e. An iPad 
          )
        );

        $context = stream_context_create($options);
        $file = file_get_contents($url, false, $context);
$str = <<< HTML
'.$file.'
HTML;
        $html = str_get_html($str);
        $html = explode("var ytInitialData = '", $html);
        $html = explode("';", $html[1]);
        // $jsons = $html[0];
        // echo '<script>';
        // echo 'const myJSON = JSON.parse("'.$jsons.'");console.log(myJSON);';
        // echo '</script>';        
        $html = str_replace('\\x22:\\', '', $html[0]);
        $vids = explode("videoId", $html);
        $i = 0;
        $vidarr = [];
        $ytid = '';
        foreach($vids as $vidss) {
            //var_dump($vidss);
                //echo '<span style="color: #FF0000">'.$i.'  <===</span> ';
                $ytl = explode('\\', $vidss);
                $vid = str_replace('x22', '', $ytl[0]);
                //echo $vid.'  ';
                $title = str_replace('x22titlex7b\x22runsx5b\x7b\x22textx22', 'titleee', $vidss);
                $title = str_replace('\x22\x7d\x5d,\x22accessibilityx7b\x22accessibility', 'emdtile', $title);
                $title = explode('titleee', $title);
                $title = explode('emdtile',  @ $title[1]);
                $get = 0;

                $title =  @ $title[0];
                $checkt = 'បិដកភាគ'.$this->khNumber($b,'kh');
                if (preg_match('/'.$checkt.'/', $title)) {
                    $ytid = $vid;
                    break;
                } else {
                    continue;
                }
        }
        /*End youtube*/
        if(!empty($b) && empty($p)) {
            $html = file_get_html ( 'http://m.ti-kh.org/books?book='.$b);
            $table = $html->find('table', 0);
            if(empty($table)) {
                echo 'no book found';
                die;
            }
            $rowData = array();
            $page = 0;
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $flight = array();
                $td = 1;
                //echo 'td = '. count($row->find('td')) .' - ';
                foreach($row->find('td') as $cell) {
                    $flight[] = $cell->plaintext;
                    $td++;
                }
                //echo '<br/>';
                $rowData[] = $flight;
                $page++;
            }
            //var_dump($rowData);
            $metaval = array();
            //echo '<table>';

            for ($i=0; $i < count($rowData); $i++) {
                $smeta = array();
                //echo '<tr>'; 
                for ($t=0; $t < count($rowData[$i]); $t++) { 
                    if($t==0) {
                        //echo '<td>t0' . $rowData[$i][$t] .'</td>';
                        $val = $rowData[$i][$t];
                    } else {
                        //echo '<td>t1' . $rowData[$i][$t] .'</td>';
                        $key = $rowData[$i][$t];
                    }
                    
                    if(count($rowData[$i]) == 1) {
                        if(count($rowData[$i]) == 1 && $i == 1) {
                            //echo '<td>1</td>';
                            $key = '1';
                            $chapter = $this->session->userdata ( 'chapter' , $val);
                            if(!empty($chapter)) {
                                if($chapter!= $val) {
                                    $this->session->set_userdata('chapter', $val);
                                }
                            } else {
                                $this->session->set_userdata('chapter', $val);
                            }
                        } else if(count($rowData[$i]) == 1 && $i != 1) {
                            //echo '<td>' . $rowData[((int) $i + 1)][((int) $t + 1)] .'+++</td>';
                            $key = $rowData[((int) $i + 1)][((int) $t + 1)];
                            $chapter = $this->session->userdata ( 'chapter' , $val);
                            if(!empty($chapter)) {
                                if($chapter!= $val) {
                                    $this->session->set_userdata('chapter', $val);
                                }
                            } else {
                                $this->session->set_userdata('chapter', $val);
                            }
                        }
                    } 
                    $chapter = $this->session->userdata ( 'chapter' );
                    if(!empty($chapter)) {
                        $smeta['chapter'] = $chapter;
                    }

                    if(!empty($val)) {
                        $smeta['matika'] = $val;
                        $smeta['page'] = $this->khNumber($key);
                    }
                    
                    // if(count($rowData[$i]) == 1 && $i != 1) {
                    //     echo '<td>' . $rowData[((int) $i + 1)][((int) $t + 1)] .'+++</td>';
                    // }


                }
                //echo '</tr>';
                if(!empty($key)) {
                    $metaval[$this->khNumber($key)] = $smeta;
                }
            }
            //echo '</table>';
            $where = array('book'=>$b);
            $getB = $this->mod_general->select(
                'book',
                '*',
                $where
            );
            $dataBook = array(
                'matika'=> $metaval,
                'book'=> $b,
                'videoID'=> $ytid,
                'total'=>count($getB)
            );
            // echo '<pre>';
            // print_r($dataBook);
            // echo '</pre>';
            $tmp_path = FCPATH . 'uploads/data/';
            if (!file_exists($tmp_path)) {
                mkdir($tmp_path, 0777, true);
            }
            $file_tmp_name = 'mateka_'.$b.'.json';
            $this->json($tmp_path,$file_tmp_name, $dataBook);
        }
        // $p = $this->input->get('p');
        // $b = $this->input->get('b');
        // $start = $this->input->get('start');
        // $idstart = $this->input->get('idstart');
        // $max = $this->input->get('max');
        // if(!empty($b)) {
        //     if(!empty($p)) {
        //         $where = array('book'=>$b,'page'=>$p);
        //     } else if(!empty($start)){
        //         $where = array('book'=>$b,'page >= '=>$start);
        //     } elseif($max) {
        //         if(!empty($idstart)) {
        //             $where = array('id >='=>$idstart);
        //         } else {
        //             $where = array('book >'=>$b);
        //         }
                
        //     } else if(!empty($idstart)){
        //         $where = array('id >='=>$idstart);
        //     } else {
        //         $where = array('book'=>$b);
        //     }
        //     $getB = $this->mod_general->select(
        //         'book',
        //         '*',
        //         $where,
        //         0, 
        //         0, 
        //         $max
        //     );
        //     echo count($getB).'<br/>';
        //     end($getB);
        //     $lastElementKey = key($getB);
        //     foreach ($getB as $key => $bdata) {
        //         $data_b = array(
        //             'page'          => $bdata->page,
        //             'book'          => $bdata->book,
        //             'chapter'          => $bdata->chapter,
        //             'matika'          => $bdata->matika,
        //             'section'          => $bdata->section,
        //         );
        //     }
        // }
        // if (is_writable($bname)) {
        //     array file
        //     $currentArr = file_get_contents($bnameArr);
        //     $currentArr .= $text_array;
        //     file_put_contents($bnameArr, $currentArr);
        // } else {
        //     array file
        //     $arrfile = fopen($bnameArr, "w") or die("Unable to open file!");
        //     $txt = $xml;
        //     fwrite($arrfile, $text_array);
        //     fclose($arrfile);
        // }

    }
    function khNumber($input,$t = 'en')
    {
        if($t == 'en') {
            $input = strval($input);
            $arabic_number = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $kh_number = array('០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩');    
            return str_replace($kh_number, $arabic_number, $input);
        } else if($t == 'kh') {
            $arabic_number = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $kh_number = array('០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩');    
            return str_replace($arabic_number, $kh_number, $input);
        }
    }
    function ew2bc_esc_html( $text ) {
        //encode & in named entities and numbered entities
        $text = str_replace('&', '&amp;', $text);
        //encode & <> ' "
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        return $text;
    }
    function ew2bc_esc_html_label( $text ) {
        //blogger doesn't recognize named entities and numbered entities in labels so decode them
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        //encode & <> ' "
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        return $text;
    }
    public function json($upload_path,$file_name, $list = array(),$do='update')
    {
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
            return TRUE;
        } else {
            return false;
        }
    }

    public function menu()
    {
        $menu = array();

        /*Vinaya*/
        $vineysub = array();
        $subv_v = array();
        $subv_k = array();
        $subv_m = array();
        $subv_j = array();
        $subv_b = array();
        for ($i=1; $i < 14; $i++) {
            if($i<10) {
                $e = '0';
                $k = '០';
            } else {
                $e = '';
                $k = '';
            }
            if($i<= 4) {
                $subv_v[] = array(
                    'name'=>'បិដកភាគ '.$k.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$e.$this->khNumber($i,'en'),
                ); 
            } else if($i == 5) {
                $subv_k[] = array(
                    'name'=>'បិដកភាគ '.$k.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$e.$this->khNumber($i,'en'),
                );
            } else if($i >= 6 && $i <= 8) {
                $subv_m[] = array(
                    'name'=>'បិដកភាគ '.$k.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$e.$this->khNumber($i,'en'),
                );
            } else if($i >= 9 && $i <= 11) {
                $subv_j[] = array(
                    'name'=>'បិដកភាគ '.$k.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$e.$this->khNumber($i,'en'),
                );
            } else if($i >= 12 && $i <= 13) {
                $subv_b[] = array(
                    'name'=>'បិដកភាគ '.$k.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$e.$this->khNumber($i,'en'),
                );
            }
             
        }
        $vineysub[] = array(
            'name' => 'មហាវិភង្គ',
            'link'=>'#',
            'sub'=> $subv_v,
        );
        $vineysub[] = array(
            'name' => 'ភិក្ខុនីវិភង្គ',
            'link'=>'#',
            'sub'=> $subv_k,
        );
        $vineysub[] = array(
            'name' => 'មហាវគ្គ',
            'link'=>'#',
            'sub'=> $subv_m,
        );
        $vineysub[] = array(
            'name' => 'ចុល្លវគ្គ',
            'link'=>'#',
            'sub'=> $subv_j,
        );
        $vineysub[] = array(
            'name' => 'បរិវារៈ',
            'link'=>'#',
            'sub'=> $subv_b,
        );
        /*End Vinaya*/

        /*suttonta*/
        $suttonta = $subs_t = $subs_m = $subs_s = $subs_a = $subs_k = array();
        for ($i=14; $i < 78; $i++) {
            if($i >= 14 && $i <= 19) {
                $subs_t[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 20 && $i <= 28) {
                $subs_m[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 29 && $i <= 39) {
                $subs_s[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 40 && $i <= 51) {
                $subs_a[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else {
                $subs_k[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            }
        }
        $suttonta[] = array(
            'name' => 'ទីឃនិកាយ',
            'link'=>'#',
            'sub'=> $subs_t,
        );
        $suttonta[] = array(
            'name' => 'មជ្ឈិមនិកាយ',
            'link'=>'#',
            'sub'=> $subs_m,
        );
        $suttonta[] = array(
            'name' => 'សំយុត្តនិកាយ',
            'link'=>'#',
            'sub'=> $subs_s,
        );
        $suttonta[] = array(
            'name' => 'អង្គុត្តរនិកាយ',
            'link'=>'#',
            'sub'=> $subs_a,
        );
        $suttonta[] = array(
            'name' => 'ខុទ្ទកនិកាយ',
            'link'=>'#',
            'sub'=> $subs_k,
        );
        /*End suttonta*/

        /*Aphithama*/
        $Aphithama = $suba_t = $suba_v = $suba_th = $suba_b = $suba_k = $suba_y = $suba_mb = array();
        for ($i=78; $i < 111; $i++) { 
            if($i >= 78 && $i <= 79) {
                $suba_t[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 80 && $i <= 82) {
                $suba_v[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i == 83) {
                $suba_th[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
                $suba_b[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 84 && $i <= 86) {
                $suba_k[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else if($i >= 87 && $i <= 93) {
                $suba_y[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            } else {
                $suba_mb[] = array(
                    'name'=>'បិដកភាគ '.$this->khNumber($i,'kh'),
                    'link'=>'book_'.$this->khNumber($i,'en'),
                );
            }
        }
        $Aphithama[] = array(
            'name' => 'ធម្មសង្គណី',
            'link'=>'#',
            'sub'=> $suba_t,
        );
        $Aphithama[] = array(
            'name' => 'វិភង្គ',
            'link'=>'#',
            'sub'=> $suba_v,
        );
        $Aphithama[] = array(
            'name' => 'ធាតុកថា',
            'link'=>'#',
            'sub'=> $suba_th,
        );
        $Aphithama[] = array(
            'name' => 'បុគ្គលបញ្ញត្តិ',
            'link'=>'#',
            'sub'=> $suba_b,
        );
        $Aphithama[] = array(
            'name' => 'កថាវត្ថុ',
            'link'=>'#',
            'sub'=> $suba_k,
        );
        $Aphithama[] = array(
            'name' => 'យមក',
            'link'=>'#',
            'sub'=> $suba_y,
        );
        $Aphithama[] = array(
            'name' => 'បដ្ឋាន',
            'link'=>'#',
            'sub'=> $suba_mb,
        );
        /*End Aphithama*/

        $menu[] = array(
            'name'=>'ព្រះវិន័យបិដក',
            'link'=>'#',
            'sub'=> $vineysub,
        );
        $menu[] = array(
            'name'=>'ព្រះសុត្តន្តបិដក',
            'link'=>'#',
            'sub'=> $suttonta,
        );
        $menu[] = array(
            'name'=>'ព្រះអភិធម្មបិដក',
            'link'=>'#',
            'sub'=> $Aphithama,
        );
        echo '<pre>';
        print_r($menu);
        echo '</pre>';
        $tmp_path = FCPATH . 'uploads/data/';
        $file_tmp_name = 'menu.json';
        $this->json($tmp_path,$file_tmp_name, $menu);
    }
}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */
