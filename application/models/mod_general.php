<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mod_general extends CI_Model
{
    
    function __construct() {
        parent::__construct();
        $this->load->library('dbtable');
    }
    
    function count($tableName, $where = array()) {
        $this->load->database('default', true);
        if (!empty($where)) {
            $this->db->like($where);
        }
        $count = $this->db->count_all_results($tableName);
        return $count;
    }
    
    public function select($table, $field = '*', $where = array(), $order = 0, $group = 0, $limit = 0, $offset = 0) {
        $this->load->database('default', true);
        $this->db->select($field);
        $this->db->from($table);
        if (!empty($where)) {
            if (!empty($where['where_in'])) {
                foreach ($where['where_in'] as $key_w => $value_w) {
                    $this->db->where_in($key_w, $value_w);
                }
            } 
            else if (!empty($where['where_not_in'])) {
                foreach ($where['where_not_in'] as $key_w => $value_w) {
                    $this->db->where_not_in($key_w, $value_w);
                }
            } 
            else {
                $this->db->where($where);
            }
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        }
        if (!empty($group)) {
            $this->db->group_by($group);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    function like($table, $field = '*', $search = array(), $where = array()) {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->like($search);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function fql($table, $search = '*') {
        $this->db->select($search);      
        $query = $this->db->get();
        return $query->result();
    }
    function sql($sql) { 
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function insert($table, $data = array()) {
        $this->load->database('default', true);
        $this->db->simple_query('SET NAMES \'utf-8\'');
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    function update($table, $data = array(), $where = array()) {
        $this->load->database('default', true);
        $this->db->where($where);
        $this->db->simple_query('SET NAMES \'utf-8\'');
        $ok = $this->db->update($table, $data);
        return (($ok) ? true : false);
    }
    
    function delete($table, $where = array()) {
        $this->load->database('default', true);
        $ok = $this->db->delete($table, $where);
        return (($ok) ? true : false);
    }
    
    public function record_count($table, $where = '') {
        if (!empty($where)) {
        } 
        else {
            return $this->db->count_all($table);
        }
    }
    
    /**
     *
     * @param undefined $table
     * @param undefined $tablejoin
     * @param undefined $fields
     * @param undefined $where
     * @param undefined $order
     * @param undefined $group
     * @param undefined $limit
     *
     */
    function join($table, $tablejoin, $fields = '*', $where = null, $order = 0, $group = 0, $limit = 0, $offset = 0) {
        $this->db->select($fields);
        $this->db->from($table);
        if (is_array($tablejoin)) {
            foreach ($tablejoin as $key => $value) {
                $this->db->join($key, $value);
                //$this->db->join('comments', 'comments.id = blogs.id');
                //$this->db->join($value['table'], $value['field1'] . '=' . $value['field2']);
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        }
        if (!empty($group)) {
            $this->db->group_by($group);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function jointable($table, $tablejoin, $fields = '*', $where = null, $order = 0, $group = 0, $limit = 0, $offset = 0) {
        $this->db->select($fields);
        $this->db->from($table);
        if (is_array($tablejoin)) {
            foreach ($tablejoin as $value) {
                
                //$this->db->join('comments', 'comments.id = blogs.id');
                $this->db->join($value['table'], $value['field1'] . '=' . $value['field2']);
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        }
        if (!empty($group)) {
            $this->db->group_by($group);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function checkUser() {
        if (!$this->session->userdata('user_id')) {
            $ci = get_instance();
            $account_url = $ci->config->item('account_url');
            redirect($account_url . '?continue=' . urlencode(current_url()));
        }
    }

    function checkUserLogin()
    {
        $sid = $this->session->userdata ( 'sid' );
        $log_id = $this->session->userdata ( 'user_id' );
        $isWait = $isLogin = false;

        /*check for clear*/
        $whereLg = array(
            'meta_name'     => $log_id . 'user_login',
            'status'     => 0,
        );
        $queryLg = $this->select('meta', '*', $whereLg);
        $notClose = [];
        $Closed = [];
        if(!empty($queryLg[0])) {
            foreach ($queryLg as $key => $ch) {
                if($ch->status == 0) {
                    array_push($Closed, $ch->status);
                } else {
                    array_push($notClose, $ch->status);
                }
            }
        }
        if(count($notClose)== 0 && count($Closed) > 3) {
            $isLogin = true;
            $this->delete ( 'meta', array (
                'meta_name'     => $log_id . 'user_login',
                'object_id !='      => $sid,
            ));
        }
        if(count($notClose)!= 0 && count($Closed) > 3) {
            $isWait = true;
        }
        // if(count($queryLg)>3) {
        //     //
        //     $this->delete ( 'meta', array (
        //         'meta_name'     => $log_id . 'user_login'
        //     ) );
        // }
        /*End check for clear*/
        if(empty($isWait)) {
           $whereMeLg = array(
                'meta_name'     => $log_id . 'user_login',
                'object_id' => $sid,
            );
            $queryMeLg = $this->select('meta', '*', $whereMeLg);
            if(empty($queryMeLg[0])) {
                /*add new*/
                $data_blog = array(
                    'meta_key'      => date('Y-m-d'),
                    'object_id'      => $sid,
                    'meta_name'     => $log_id . 'user_login',
                    'status'     => 1,
                );
                $this->insert('meta', $data_blog);
                /*End add new*/
            } 
        }
        
        $data = new stdClass();
        $data->reboot = $isLogin;
        $data->waiting = $isWait;

        /*check time for login*/
        $chUser = $this->select ('users','*', array('user_id' => $log_id, 'u_id'=> $sid));

        $oneDaysAgo = date('Y-m-d', strtotime('-120 minutes', strtotime(date('Y-m-d'))));
        $where_online = array('user_id' => $log_id, 'u_dmodify <= '=> $oneDaysAgo, 'u_id'=> $sid);
        $PostShare_pg = $this->select ('users','*', $where_online);
        if(!empty($chUser[0]->u_dmodify)) {
            if(!empty($PostShare_pg[0])) {
                $dataAllO = array(
                    'u_dmodify' => date('Y-m-d H:i:s')
                );
                $whereAllO = array(
                    'u_id' => $sid,
                );
                $dataid = $this->update('users', $dataAllO, $whereAllO);
                $data->waitPosting = false;
            } else {
                $data->waitPosting = true;
            }
        } else {
            $dataAllO = array(
                'u_dmodify' => date('Y-m-d H:i:s')
            );
            $whereAllO = array(
                'u_id' => $sid,
            );
            $dataid = $this->update('users', $dataAllO, $whereAllO);
            $data->waitPosting = false;
        }

        /*check max do action for a day*/
        $whereShowAuto = array(
            'c_name'      => 'autopost',
            'c_key'     => $log_id,
        );
        $autoData = $this->select('au_config', '*', $whereShowAuto);
        if(!empty($autoData[0])) {
            $autopost = json_decode($autoData[0]->c_value);
            if(!empty($autopost->max_do_aday)) {
                $date = new DateTime("now");
                $curr_date = $date->format('Y-m-d ');

                $wSare = array('sid'=>$sid,'uid' => $log_id,'DATE(shp_date)'=>$curr_date);
                $maxDo = $this->select ( 'share_history', '*', $wSare );
                $data->waitPosting = false;
                if(count($maxDo)>= $autopost->max_do_aday) {
                    $data->waitPosting = true;
                    /*clean history for a day ago*/
                    $oneDay = date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));
                    $where_a_day = array('uid' => $log_id, 'shp_date <= '=> $oneDay);
                    $cleanArr = $this->select ( 'share_history', '*', $where_a_day );
                    foreach ($cleanArr as $c) {
                        @$this->delete ( 'share_history', array (
                            'shp_id' => $c->shp_id,
                        ));
                    }
                    /*End clean history for a day ago*/
                }
            }
        }
        /*End check max do action for a day*/
        /*End check time for login*/
        return $data;
    }

    function getUserFun()
    {
        $log_id = $this->session->userdata ( 'user_id' );
        if ($log_id == 2 || $log_id == 3 || $log_id == 4 || $log_id == 527 || $log_id == 511) {
            define('is_admin', true);
        } else {
            define('is_admin', false);
        }
    }

    /*
    * check link to sahre
    */
    public function chceckLink($pid)
    {
        $sid = $this->session->userdata ( 'sid' );
        $where_Pshare = array (
            'p_id' => $pid,
            'u_id' => $sid,
            'p_status' => 1,
        );
        $dataPost = $this->Mod_general->select ('post','*', $where_Pshare);
        $datareturn = new ArrayObject();
        $pConent = json_decode($dataPost[0]->p_conent);
        $pOption = json_decode($dataPost[0]->p_schedule);
        $imgUrl = @$pConent->picture;
        if (preg_match("/http/", $imgUrl) && preg_match('/ytimg.com/', $imgUrl)) {
            $datareturn->needToPost = true;
            $datareturn->share = false;
            $datareturn->dataPost = $dataPost[0];
            $datareturn->pConent = $pConent;
            $datareturn->pOption = $pOption;
            //echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'managecampaigns/yturl?pid='.$dataPost[0]->p_id.'&action=postblog&autopost=1";},0 );</script>';
        }
        if (date('H') <= 23 && date('H') > 4 && date('H') !='00') {
            if(preg_match('/youtu/', $pConent->link) || $dataPost[0]->p_post_to ==1 || ($dataPost[0]->p_post_to == 1 && $pOption->main_post_style =='tnews')) {
                $datareturn->needToPost = true;
                $datareturn->share = false;
                $datareturn->dataPost = $dataPost[0];
                $datareturn->pConent = $pConent;
                $datareturn->pOption = $pOption;
                //echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'managecampaigns/yturl?pid='.$dataPost[0]->p_id.'&action=postblog&autopost=1";},0 );</script>';
            } else {
                $datareturn->needToPost = false;
                $datareturn->share = true;
                $datareturn->dataPost = $dataPost[0];
                $datareturn->pConent = $pConent;
                $datareturn->pOption = $pOption;
            }
        } else {
            echo '<script language="javascript" type="text/javascript">window.setTimeout( function(){window.location = "'.base_url().'managecampaigns/waiting";}, 30 );</script>';
            exit();
        }
        return $datareturn;
    }

    public function userrole($type='')
    {
        $log_id = $this->session->userdata('user_id');
        $userrole = false;
        switch ($type) {
            case 'uid':
                if ($log_id == 2 || $log_id == 3 || $log_id == 4  || $log_id == 24 || $log_id == 527 || $log_id == 511 || $log_id == 533 || $log_id == 534) {
                    $userrole = true;
                }
                break;
            default:
                $userrole = false;
                break;
        }
        return $userrole;
    }
    
    function getMenuUser() {
        $action = $this->uri->segment(1);
        $id = $this->uri->segment(2);
        if (!empty($id)) {
            $id = '/' . $id;
        } 
        else {
            $id = '';
        }
        $page = $action . $id;
        $user = $this->session->userdata('username');
        $log_id = $this->session->userdata('log_id');
        $user_type = $this->session->userdata('user_type');
        $data_field = array('per_value',);
        $data_sel = array('per_user_id' => $log_id, 'per_status' => 1,);
        $dataPagePer = $this->Mod_general->select('permission', $data_field, $data_sel);
        $data = array();
        $user_type = $this->session->userdata('user_type');
        if ($user_type != 1 && !empty($dataPagePer)) {
            $dataPage = array();
            $i = 0;
            foreach ($dataPagePer as $value) {
                $where_sel = array(Tbl_title::type => 'nav_menu_item', Tbl_title::status => 1, Tbl_title::id => $value->per_value,);
                $dataPage = $this->select(Tbl_title::tblname, '*', $where_sel);
                foreach ($dataPage as $value_a) {
                    $data[$i][Tbl_title::value] = $value_a->{Tbl_title::value};
                    $data[$i][Tbl_title::title] = $value_a->{Tbl_title::title};
                    $i++;
                }
            }
        }
        return $data;
    }
    
    public function getuser($field = '*', $where = '') {
        $log_id = $this->session->userdata ( 'user_id' );
        $this->load->database('default', true);
        if (!empty($field) && $field == 'me') {
            $log_id = $this->session->userdata ( 'user_id' );
            $this->db->select('*');
        } else if (!empty($field) && $field != 'me') {
            $this->db->select($field);
        } else {
            $this->db->select('username');
        }
        $this->db->from('users');
        if (!empty($where)) {
            $this->db->where($where);
        }
        if($field == 'me') {
            $this->db->where(array('user_id' => $log_id));
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    function labelAlert($class, $text) {
        if (!empty($class) && !empty($text)) {
            echo '<span class="label label-' . $class . '">' . $text . '</span>';
        }
    }

    function checkSiteLinkStatus()
    {
        $siteUrl = array(
            'www.bz24news.com',
            'news17times.com',
            'www.jc24news.com',
            'newzset.com',
            'ournewsl.com',
            'updatecamp.com',
            'aq24news.com',
            'web.facebook.com',
            'www.facebook.com',
            'm.facebook.com',
            'mobile.facebook.com',
            'mbasic.facebook.com',
        );
        return $siteUrl;
    }
    
    function build_tree_edit($parent_id = 0, $level = 0) {
        $has_childs = false;
        $result = mysql_query("SELECT * FROM (`title`) JOIN `cat_term_relationships` ON title.`id` = cat_term_relationships.`object_id` WHERE title.`mo_parent`='" . $parent_id . "' and title.`mo_type`='nav_menu_item' group by title.id");
        
        //display each child row
        $i = 0;
        $menu = '';
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                if ($has_childs === false) {
                    $has_childs = true;
                    $menu.= '<ol class="dd-list">';
                }
                $menu.= "<li class='dd-item' data-id='" . $row['id'] . "'><div class='dd-handle'>" . $row['mo_title'] . '<span class="pull-right" style="margin-right:35px;">' . $row[Tbl_title::value] . "</span></div>";
                $menu.= $this->build_tree_edit($row['id'], $level + 1);
                $menu.= "<a class='btn btn-sm pull-right removelist' data='" . $row['id'] . "'><i class='icol-cross'></i></a></li>";
            }
            if ($has_childs === true) $menu.= '</ol>';
            return $menu;
        }
    }
    
    function getvdo($continue, $vdo_title_d) {
        $this->load->library('html_dom');
        $log_id = $this->session->userdata('log_id');
        $data_post_sel = array(Tbl_meta::id => $continue,);
        $order = Tbl_meta::id . ' DESC';
        $get_data_link = $this->select(Tbl_meta::tblname, '', $data_post_sel, $order, '', 1);
        try {
            foreach ($get_data_link as $value_link) {
                $getlink = $value_link->{Tbl_meta::value};
                $getID = $value_link->{Tbl_meta::id};
                $html1 = file_get_html($getlink);
                $i = 0;
                foreach ($html1->find('.blog-content .play-inner') as $article) {
                    $i++;
                    if (preg_match('/dailymotion.com/', $article)) {
                        $files = trim($article->find('#Playerholder iframe', 0)->src);
                        preg_match('#http://www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $files, $matches);
                        if (!empty($matches[1])) {
                            $dailyM = $matches[1];
                        } 
                        else {
                            $dailyM = $files;
                        }
                        $title = trim(@$article->find('.blog .blog-title h2 span', 0)->innertext);
                        $dataLogin = $this->add_meta($dailyM, '', $title, 'dailymotion', $vdo_title_d);
                    } 
                    else if (preg_match('/docs.google/', $article)) {
                        $files = trim($article->find('#Playerholder iframe', 0)->src);
                        $g_array = explode('/', $files);
                        if (!empty($g_array[5])) {
                            $Gid = $g_array[5];
                        } 
                        else {
                            $Gid = $files;
                        }
                        $title = trim($html1->find('.blog .blog-title span', 0)->innertext);
                        $dataLogin = $this->add_meta($Gid, '', $title, 'docs.google', $vdo_title_d);
                    } 
                    else if (preg_match('/vimeo.com/', $article)) {
                        $files = trim($article->find('#Playerholder iframe', 0)->src);
                        preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $files, $matches);
                        if (!empty($matches[5])) {
                            $files = $matches[5];
                        } 
                        else {
                            $files = $files;
                        }
                        
                        //$files = str_replace("?start=1", "?start=0", $code);
                        $title = trim(@$article->find('.blog .blog-title h2 span', 0)->innertext);
                        $dataLogin = $this->add_meta($files, '', $title, 'vimeo', $vdo_title_d);
                    } 
                    else if (preg_match('/youtube.com/', $article)) {
                        $code = trim($article->find('script', 1)->innertext);
                        preg_match("/v=([^&]+)/i", $code, $code_link);
                        $title = trim(@$article->find('.blog .blog-title h2 span', 0)->innertext);
                        $files = substr($code_link[1], 0, 11);
                        $dataLogin = $this->add_meta($files, '', $title, 'yt', $vdo_title_d);
                    } 
                    else if (preg_match('/vid.me/', $article)) {
                        $files = trim($article->find('#Playerholder iframe', 0)->src);
                        $title = trim(@$article->find('.blog .blog-title h2 span', 0)->innertext);
                        $dataLogin = $this->add_meta($files, '', $title, 'iframe', $vdo_title_d);
                    }
                }
            }
            $delete = $this->delete(Tbl_meta::tblname, array(Tbl_meta::id => $getID));
            if ($delete) {
                $data_post_sel = array(Tbl_meta::type => 'not_in_use', Tbl_meta::user_id => $log_id,);
                $get_data_next = $this->select(Tbl_meta::tblname, '', $data_post_sel, $order, '', 1);
                if (!empty($get_data_next)) {
                    foreach ($get_data_next as $value_next) {
                        return $value_next->{Tbl_meta::id};
                    }
                } 
                else {
                    return false;
                }
            }
        }
        catch(exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

public function get_video_id($param, $videotype = '')
    {
        $v_type = $this->check_v_type($param);
        switch ($v_type) {
            case 'yt':
                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $param, $matches);
                if (!empty($matches[1])) {
                    $content = (!empty($matches[1]) ? $matches[1] : '');
                    if (!empty($videotype)) {
                        $v_id   = 'https://www.youtube.com/embed/' . $content;
                        $v_type = 'iframe';
                    } else {
                        $v_id = $content;
                    }
                }
                break;
            case 'vimeo':
                preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $param, $matches);
                if (!empty($matches[5])) {
                    if (!empty($videotype)) {
                        if ($videotype != 'vimeoDomain') {
                            $v_id   = 'http://player.vimeo.com/video/' . $matches[5];
                            $v_type = 'iframe';
                        } else {
                            $v_id = $matches[5];
                        }
                    } else {
                        $v_id = $matches[5];
                    }
                }
                break;
            case 'docs.google':
                $g_array = explode('/', $param);
                if (!empty($g_array[5])) {
                    $v_ids = $g_array[5];
                } else {
                    $v_ids = $param;
                }
                if (!empty($videotype)) {
                    $v_id   = 'https://docs.google.com/file/d/' . $v_ids . '/preview';
                    $v_type = 'iframe';
                } else {
                    $v_id = $v_ids;
                }
                break;
            case 'dailymotion':
                preg_match('#dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $param, $matches);
                if (!empty($matches[1])) {
                    $v_ids = $matches[1];
                } else {
                    $v_ids = $param;
                }
                if (!empty($videotype)) {
                    $v_id   = 'http://www.dailymotion.com/embed/video/' . $v_ids . '?autoPlay=0&hideInfos=0';
                    $v_type = 'iframe';
                } else {
                    $v_id = $v_ids;
                }
                break;
            case 'fbvid':
                if (preg_match('/photo/', $param)) {
                    preg_match("/v=([^&]+)/i", $param, $code);
                    $v_id = $code[1];
                } elseif (preg_match('/embed/', $param)) {
                    preg_match("/video_id=([^&]+)/i", $param, $code);
                    $v_id = $code[1];
                } elseif (preg_match('/video.php/', $param)) {
                    preg_match("/v=([^&]+)/i", $param, $code);
                    $v_id = $code[1];
                } else {
                    $v_id = $valCode;
                }
                if (!empty($videotype)) {
                    $v_id   = 'https://www.facebook.com/video/embed?video_id=' . $v_id;
                    $v_type = 'iframe';
                }
                break;
                case 'ok':
                    if (!empty($videotype)) {
                        $v_id = $param;
                    } else {
                        preg_match("/videoembed\/([^&]+)/i", $param, $code);
                        $v_id = $code[1];
                    }
                    break;
            default:
                $v_id   = $param;
                $v_type = 'iframe';
                break;
        }
        $data = array(
            'vid'   => $v_id,
            'vtype' => $v_type,
        );
        return $data;
    }   
    
    public function check_v_type($param)
    {
        if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $param)) {
            $v_type = 'yt';
        } elseif (preg_match('/vimeo/', $param)) {
            $v_type = 'vimeo';
        } elseif (preg_match('/docs.google/', $param)) {
            $v_type = 'docs.google';
        } elseif (preg_match('/drive.google.com/', $param)) {
            $v_type = 'docs.google';
        } elseif (preg_match('/dailymotion/', $param)) {
            $v_type = 'dailymotion';
        } elseif (preg_match('/facebook.com/', $param) || preg_match('/fb.com/', $param)) {
            $v_type = 'fbvid';
        } elseif (preg_match('/ok.ru/', $param)) {
            $v_type = 'ok';
        } else {
            $v_type = '';
        }
        return $v_type;
    }
    
    function getkhdrama($continue, $vdo_title_d, $update) {
        $this->load->library('html_dom');
        $log_id = $this->session->userdata('log_id');
        $data_post_sel = array(Tbl_meta::id => $continue,);
        $order = Tbl_meta::id . ' DESC';
        $get_data_link = $this->select(Tbl_meta::tblname, '', $data_post_sel, $order, '', 1);
        try {
            foreach ($get_data_link as $value_link) {
                $getlink = $value_link->{Tbl_meta::value};
                $getID = $value_link->{Tbl_meta::id};
                $html1 = file_get_html($getlink);
                $code_id = @$html1->find('.content .main center iframe', 0)->src;
                if (!empty($code_id)) {
                    $title = trim(@$html1->find('.content .main h3', 0)->innertext);
                    if (preg_match('/dailymotion.com/', $code_id)) {
                        preg_match('#http://www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $code_id, $matches);
                        if (!empty($matches[1])) {
                            $dailyM = $matches[1];
                        } 
                        else {
                            $dailyM = $files;
                        }
                        $dataLogin = $this->add_meta($dailyM, '', $title, 'dailymotion', $vdo_title_d);
                    } 
                    else if (preg_match('/docs.google/', $code_id)) {
                        $g_array = explode('/', $code_id);
                        if (!empty($g_array[5])) {
                            $Gid = $g_array[5];
                        } 
                        else {
                            $Gid = $files;
                        }
                        $dataLogin = $this->add_meta($Gid, '', $title, 'docs.google', $vdo_title_d);
                    } 
                    else if (preg_match('/vimeo.com/', $code_id)) {
                        preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $code_id, $matches);
                        if (!empty($matches[5])) {
                            $files = $matches[5];
                        } 
                        else {
                            $files = $files;
                        }
                        $dataLogin = $this->add_meta($files, '', $title, 'vimeo', $vdo_title_d);
                    } 
                    else if (preg_match('/youtube.com/', $code_id)) {
                        preg_match("/v=([^&]+)/i", $code_id, $code_link);
                        $files = substr($code_link[1], 0, 11);
                        $dataLogin = $this->add_meta($files, '', $title, 'yt', $vdo_title_d);
                    } 
                    else {
                        $dataLogin = $this->add_meta($code_id, '', $title, 'iframe', $vdo_title_d);
                    }
                    if ($update == 1) {
                        $title_arr = explode(' - part', $title);
                        if (!empty($title_arr[0])) {
                            $titl = $title_arr[0];
                        } 
                        else {
                            $titl = $title;
                        }
                        $where_title = array(Tbl_title::type => 'vdolist', Tbl_title::id => $vdo_title_d,);
                        $data_title = array(Tbl_title::title => trim($titl),);
                        $query_blog = $this->update(Tbl_title::tblname, $data_title, $where_title);
                    }
                }
            }
            $delete = $this->delete(Tbl_meta::tblname, array(Tbl_meta::id => $getID));
            if ($delete) {
                $data_post_sel = array(Tbl_meta::type => 'not_in_use', Tbl_meta::user_id => $log_id,);
                $get_data_next = $this->select(Tbl_meta::tblname, '', $data_post_sel, $order, '', 1);
                if (!empty($get_data_next)) {
                    foreach ($get_data_next as $value_next) {
                        return $value_next->{Tbl_meta::id};
                    }
                } 
                else {
                    return false;
                }
            }
        }
        catch(exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getconfig($param)
    {
        $log_id = $this->session->userdata ('user_id');
        $whereShowAuto = array(
            'c_name'      => 'autopost',
            'c_key'     => $log_id,
        );
        $autoData = $this->select('au_config', '*', $whereShowAuto);
        if(!empty($autoData[0])) {
            $autopost = json_decode($autoData[0]->c_value);
            if(!empty($autopost->{$param})) {
                return $autopost->{$param};
            }
        } else {
            return false;
        }
    }
    
    function getuserPage($parent_id = 0, $level = 0) {
        $has_childs = false;
        $result = mysql_query("SELECT * FROM (`title`) JOIN `cat_term_relationships` ON title.`id` = cat_term_relationships.`object_id` WHERE title.`mo_type`='nav_menu_item' group by title.id");
        
        //display each child row
        $i = 0;
        $menu = '';
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                if ($has_childs === false) {
                    $has_childs = true;
                    $menu.= '<ul class="">';
                }
                $menu.= "<li class='listpage' data-id='" . $row['id'] . "'><input name='pageid[]' class='checkforuser' type='checkbox' value='" . $row['mo_value'] . "'/> " . str_repeat('--', $level) . $row['mo_title'];
                $menu.= $this->getuserPage($row['id'], $level + 1);
                $menu.= "</li>";
            }
            if ($has_childs === true) {
                $menu.= '</ul>';
            }
            return $menu;
        }
    }
    
    function generate_menu($parent) {
        $has_childs = false;
        global $menu_array;
        foreach ($menu_array as $key => $value) {
            if ($value['parent'] == $parent) {
                if ($has_childs === false) {
                    $has_childs = true;
                    echo '<ul>';
                }
                echo '<li><a href="#">' . $value['name'] . '</a>';
                generate_menu($key);
                echo '</li>';
            }
        }
        if ($has_childs === true) echo '</ul>';
    }
    
    function add_meta($value, $key, $title, $type = 'yt', $continue = '') {
        $log_id = $this->session->userdata('log_id');
        $vdo_type = 'vdolist';
        $data_sub = array(Tbl_meta::object_id => $continue, Tbl_meta::type => $vdo_type, Tbl_meta::key => trim($title) . ' - Part ' . $key, Tbl_meta::value => $value, Tbl_meta::name => $type, Tbl_meta::user_id => $log_id,);
        $dataLogin = $this->insert(Tbl_meta::tblname, $data_sub);
    }
    
    /* menu user */
    
    function menuuser($param) {
        $user = $this->session->userdata('username');
        $log_id = $this->session->userdata('log_id');
        $user_type = $this->session->userdata('user_type');
        $data_sel = array('per_user_id' => $log_id, 'per_status' => 1, 'per_value' => $page,);
        $dataPage = $this->select('permission', '*', $data_sel);
        
        $this->db->select('*');
        $this->db->from('permission');
        $this->db->join(Tbl_title::tblname, 'title.id = blogs.id');
    }
    
    /* end menu user */
    
    /* url convert */
    
    function flash_encode($string) {
        $string = rawurlencode(utf8_encode($string));
        $string = str_replace("%C2%96", "-", $string);
        $string = str_replace("%C2%91", "%27", $string);
        $string = str_replace("%C2%92", "%27", $string);
        $string = str_replace("%C2%82", "%27", $string);
        $string = str_replace("%C2%93", "%22", $string);
        $string = str_replace("%C2%94", "%22", $string);
        $string = str_replace("%C2%84", "%22", $string);
        $string = str_replace("%C2%8B", "%C2%AB", $string);
        $string = str_replace("%C2%9B", "%C2%BB", $string);
        
        return $string;
    }

    function remove_emoji($text){
         $clean_text = "";

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        // Match Flags
        $regexDingbats = '/[\x{1F1E6}-\x{1F1FF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        // Others
        $regexDingbats = '/[\x{1F910}-\x{1F95E}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        $regexDingbats = '/[\x{1F980}-\x{1F991}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        $regexDingbats = '/[\x{1F9C0}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        $regexDingbats = '/[\x{1F9F9}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }
    
    /* end url convert */
    
    function blogcheck($current, $backto) {
        $Current_url = explode('?', $current);
        $Current_url = !empty($Current_url[1]) ? @$Current_url[1] : @$Current_url[0];
        $blogpassword = $this->session->userdata('user_id');
        if (empty($blogpassword)) {
            redirect($backto . '?backto=' . $Current_url);
        }
    }
    
    public function blogger_post($client,$data)
    {
        date_default_timezone_set('Asia/Phnom_Penh');
        try {
            $service = new Google_Service_Blogger($client);
            $posts   = new Google_Service_Blogger_Post();
            $posts->setTitle($data->title);
            $str = stripslashes($data->bodytext);
            $str = str_replace("<br />", "\n", $str);
            $posts->setContent($str);
            //$label = array('khmer1','test1');
            $posts->setLabels(array($data->label));

            /*set date*/
            if (empty($data->setdate)) {
                $date = date("c");
                $posts->setUpdated($date);
                $posts->setPublished($date);
            } else if ($data->setdate) {
                $dateset = $data->setdate;
                $date    = $dateset . 'T';
                $date .= date("H:i:s");
                $posts->setUpdated($date);
                $posts->getPublished($date);
            }
            /*end set date*/

            /*set customcode*/
            if (!empty($data->customcode)) {
                $Location = new Google_Service_Blogger_PostLocation();
                $Location->setName($data->customcode);
                $Location->setLat('37.16031654673677');
                $Location->setLng('-108.984375');
                $Location->setSpan('51.044069,82.617188');
                $posts->setLocation($Location);
            }
            /*end set customcode*/

            /*add post*/
            if (empty($data->editpost)) {
                $getpost = $service->posts->insert($data->bid, $posts);
                //$pid     = $getpost->id;
            } else {
                $getpost = $service->posts->update($data->bid, $data->pid, $posts);
                //$pid                = $data->pid;
            }
            return $getpost;
            die;
        } catch (Exception $exc) {
            $data = array(
                'error'=> true,
                'message'=> $exc->getTraceAsString(),
            );
            return $data;
            //echo $exc->getTraceAsString();
        }
    }

    function paginations($config) {
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        return $config;
    }
    
    public function select2($table, $field = '*', $where = array(), $order = 0, $group = 0, $limit = 0, $offset = 0) {
        $db2 = $this->load->database('second', true);
        $db2->select($field);
        $db2->from($table);
        if (!empty($where)) {
            $db2->where($where);
        }
        if (!empty($order)) {
            $db2->order_by($order);
        }
        if (!empty($group)) {
            $db2->group_by($group);
        }
        if (!empty($limit)) {
            $db2->limit($limit, $offset);
        }
        $query = $db2->get();
        return $query->result();
    }
    
    function insert2($table, $data = array()) {
        $db2 = $this->load->database('second', true);
        $db2->simple_query('SET NAMES \'utf-8\'');
        $db2->insert($table, $data);
        return $db2->insert_id();
    }
    
    function update2($table, $data = array(), $where = array()) {
        $db2 = $this->load->database('second', true);
        $db2->where($where);
        $db2->simple_query('SET NAMES \'utf-8\'');
        $ok = $db2->update($table, $data);
        return (($ok) ? true : false);
    }
    
    function delete2($table, $where = array()) {
        $db2 = $this->load->database('second', true);
        $ok = $db2->delete($table, $where);
        return (($ok) ? true : false);
    }
    
    function join2($table, $tablejoin, $fields = '*', $where = null, $order = null, $group = null, $limit = null) {
        $db2 = $this->load->database('second', true);
        $db2->select($fields);
        $db2->from($table);
        if (is_array($tablejoin)) {
            foreach ($tablejoin as $value) {
                
                //$this->db->join('comments', 'comments.id = blogs.id');
                $db2->join($value['table'], $value['field1'] . '=' . $value['field2']);
            }
        }
        if (!empty($where)) {
            $db2->where($where);
        }
        if (!empty($order)) {
            $db2->order_by($order, "desc");
        }
        if (!empty($group)) {
            $db2->group_by($group);
        }
        if (!empty($limit)) {
            $db2->limit($limit);
        }
        $query = $db2->get();
        return $query->result();
    }
    
    function like2($table, $field = '*', $search = array(), $where = array()) {
        $db2 = $this->load->database('second', true);
        $db2->select($field);
        $db2->from($table);
        $db2->like($search);
        if (!empty($where)) {
            $db2->where($where);
        }
        $query = $db2->get();
        return $query->result();
    }
    
    /* DB for Movies */
    
    public function select3($table, $field = '*', $where = array(), $order = 0, $group = 0, $limit = 0, $offset = 0) {
        $db3 = $this->load->database('movies', true);
        $db3->select($field);
        $db3->from($table);
        if (!empty($where)) {
            $db3->where($where);
        }
        if (!empty($order)) {
            $db3->order_by($order);
        }
        if (!empty($group)) {
            $db3->group_by($group);
        }
        if (!empty($limit)) {
            $db3->limit($limit, $offset);
        }
        $query = $db3->get();
        return $query->result();
    }
    
    function insert3($table, $data = array()) {
        $db3 = $this->load->database('movies', true);
        $db3->simple_query('SET NAMES \'utf-8\'');
        $db3->insert($table, $data);
        return $db3->insert_id();
    }
    
    function update3($table, $data = array(), $where = array()) {
        $db3 = $this->load->database('movies', true);
        $db3->where($where);
        $db3->simple_query('SET NAMES \'utf-8\'');
        $ok = $db3->update($table, $data);
        return (($ok) ? true : false);
    }
    
    function delete3($table, $where = array()) {
        $db3 = $this->load->database('movies', true);
        $ok = $db3->delete($table, $where);
        return (($ok) ? true : false);
    }
    
    function join3($table, $tablejoin, $fields = '*', $where = null, $order = null, $group = null, $limit = null) {
        $db3 = $this->load->database('movies', true);
        $db3->select($fields);
        $db3->from($table);
        if (is_array($tablejoin)) {
            foreach ($tablejoin as $value) {
                
                //$this->db->join('comments', 'comments.id = blogs.id');
                $db3->join($value['table'], $value['field1'] . '=' . $value['field2']);
            }
        }
        if (!empty($where)) {
            $db3->where($where);
        }
        if (!empty($order)) {
            $db3->order_by($order, "desc");
        }
        if (!empty($group)) {
            $db3->group_by($group);
        }
        if (!empty($limit)) {
            $db3->limit($limit);
        }
        $query = $db3->get();
        return $query->result();
    }
    
    function like3($table, $field = '*', $search = array(), $where = array()) {
        $db3 = $this->load->database('movies', true);
        $db3->select($field);
        $db3->from($table);
        $db3->like($search);
        if (!empty($where)) {
            $db3->where($where);
        }
        $query = $db3->get();
        return $query->result();
    }
    
    /* end DB for Movies */
    
    //LABEL IN DROP STYLE
    
    function get_all_sub_caseTypeId($parent_id) {
        $table = Tbl_cat_term::TBL;
        $order = Tbl_cat_term::id;
        if (!empty($parent_id)) {
            $getJoin = $this->select2($table, '', array(Tbl_cat_term::id => $parent_id), $order);
        } 
        else {
            $getJoin = $this->select2($table, '', array(), $order);
        }
        
        foreach ($getJoin as $rows) {
            $child_ids[$rows->{Tbl_cat_term::id}] = ($rows->{Tbl_cat_term::id});
            if ($this->has_child($rows->{Tbl_cat_term::id})) {
                $child_ids[$rows->{Tbl_cat_term::id}] = $this->get_all_sub_caseTypeId($rows->{Tbl_cat_term::id});
            }
        }
        
        return $child_ids;
    }
    
    function has_child($parent_id) {
        $getJoin = $this->select2(Tbl_cat_term_taxonomy::TBL, '', array(Tbl_cat_term_taxonomy::parent => $parent_id));
        if (empty($getJoin)) {
            return false;
        }
        return true;
    }
    
    function build_tree_drop($parent_id = 0, $level = 0) {
        
        //run our query. by default starts at top of
        //the tree (with zero depth)
        $table = Tbl_cat_term_taxonomy::TBL;
        $tablejoin = array('0' => array('table' => Tbl_cat_term::TBL, 'field1' => Tbl_cat_term::TBL . '.' . Tbl_cat_term::id, 'field2' => $table . '.' . Tbl_cat_term_taxonomy::term_id,));
        $where_cat = array(Tbl_cat_term_taxonomy::TBL . '.' . Tbl_cat_term_taxonomy::parent => $parent_id);
        
        //$order = $table . '.' . Tbl_cat_term::id;
        $getJoin = $this->join($table, $tablejoin, '', $where_cat);
        
        //$result = mysql_query("SELECT * FROM cat_term_taxonomy INNER JOIN cat_term ON cat_term_taxonomy.term_id=cat_term.term_id WHERE parent='" . $parent_id . "'");
        $getcate = '';
        
        foreach ($getJoin as $row) {
            
            //indent as necessary and print name
            $getcate.= '<option value="' . $row->term_id . '" class="level-' . $row->parent . '">';
            $getcate.= str_repeat('&nbsp;&nbsp;&nbsp;', $level) . $row->name . "\n";
            $getcate.= '</option>';
            
            //we want to see all the children that belong to this
            //node… so we need to call *this* function again
            $getcate.= $this->build_tree_drop($row->term_id, $level + 1);
        }
        return $getcate;
    }
    function build_menu($parent_id = 0, $level = 0, $show_parent = 0, $selected = 0) {
        
        //run our query. by default starts at top of
        //the tree (with zero depth)
        $table = Tbl_cat_term_taxonomy::TBL;
        $tablejoin = array('0' => array('table' => Tbl_cat_term::TBL, 'field1' => Tbl_cat_term::TBL . '.' . Tbl_cat_term::id, 'field2' => $table . '.' . Tbl_cat_term_taxonomy::term_id,));
        if (!empty($show_parent)) {
            $where_cat = array(Tbl_cat_term::TBL . '.' . Tbl_cat_term::slug => $show_parent, Tbl_cat_term::TBL . '.' . Tbl_cat_term::term_group => 'category');
        } 
        else {
            $where_cat = array(Tbl_cat_term_taxonomy::TBL . '.' . Tbl_cat_term_taxonomy::parent => $parent_id, Tbl_cat_term::TBL . '.' . Tbl_cat_term::term_group => 'category');
        }
        
        //$order = $table . '.' . Tbl_cat_term::id;
        $getJoin = $this->join($table, $tablejoin, '', $where_cat, 'cat_term.name ASC');
        
        //$result = mysql_query("SELECT * FROM cat_term_taxonomy INNER JOIN cat_term ON cat_term_taxonomy.term_id=cat_term.term_id WHERE parent='" . $parent_id . "'");
        $getcate = '';
        $has_childs = false;
        $i = 0;
        foreach ($getJoin as $row) {
            $i++;
            if ($row->parent == $parent_id) {
                if ($has_childs === false) {
                    $has_childs = true;
                    if ($level != 0) {
                        $getcate.= '<ul style="display:none" class="displaysubcat">';
                    }
                }
                if (!empty($selected) && $selected == $row->slug) {
                    $active = 'active';
                } 
                else {
                    $active = '';
                }
                if ($level != 0) {
                    $getCurSlug = $this->select(Tbl_cat_term::TBL, '*', array(Tbl_cat_term::id => $row->parent));
                    if (!empty($getCurSlug)) {
                        $GetCSlug = $getCurSlug[0]->{Tbl_cat_term::slug};
                        $getLink = base_url() . $GetCSlug . '/index/' . $row->slug;
                        if ($level + $i == 2) {
                            $getcate.= '<li><a href="' . $getCurSlug[0]->{Tbl_cat_term::slug} . '" class="' . $row->parent . ' level-' . $level . '">All ' . $getCurSlug[0]->{Tbl_cat_term::name} . '</a></li>';
                        }
                    } 
                    else {
                        $getLink = base_url() . $row->slug;
                    }
                } 
                else {
                    $getLink = base_url() . $row->slug;
                }
                
                //indent as necessary and print name
                //$getcate .= $MainCat;
                $getcate.= '<li class="' . $active . ' in-cat-' . $row->slug . '"><a href="' . $getLink . '" class="' . $row->parent . ' level-' . $level . '">' . $row->name . '</a>';
                $getcate.= $this->build_menu($row->term_id, $level + 1);
                $getcate.= '</li>';
                
                //we want to see all the children that belong to this
                //node… so we need to call *this* function again
                
            }
        }
        if ($has_childs === true) {
            if ($level != 0) {
                $getcate.= '</ul>';
            }
        }
        return $getcate;
    }
    
    //end LABEL IN DROP STYLE
    //LABEL IN LIST STYLE for edit
    function build_tree_cat($parent_id = 0, $level = 0, $per_page = 0, $page = 0) {
        
        //run our query. by default starts at top of
        //the tree (with zero depth)
        $table = Tbl_cat_term_taxonomy::TBL;
        $tablejoin = array('0' => array('table' => Tbl_cat_term::TBL, 'field1' => Tbl_cat_term::TBL . '.' . Tbl_cat_term::id, 'field2' => $table . '.' . Tbl_cat_term_taxonomy::term_id,));
        $where_cat = array(Tbl_cat_term_taxonomy::TBL . '.' . Tbl_cat_term_taxonomy::parent => $parent_id);
        
        //$order = $table . '.' . Tbl_cat_term::id;
        $getJoin = $this->join($table, $tablejoin, '', $where_cat, "cat_term.term_id DESC", '', $per_page, $page);
        
        //display each child row
        //"img_id DESC", '', $config['per_page'], $page
        $i = 0;
        $getcate = '';
        foreach ($getJoin as $row) {
            $i++;
            
            //indent as necessary and print name
            $getcate.= '<tr>';
            $getcate.= '<td align="center"><input type="checkbox" value="' . $row->{Tbl_cat_term::id} . '"  id="itemid" name="itemid[]"></td>';
            $getcate.= '<td class="popular-category" id="category-' . $row->{Tbl_cat_term_taxonomy::parent} . '">';
            $getcate.= str_repeat('&#8212; ', $level) . $row->{Tbl_cat_term::name} . "\n";
            $getcate.= '</td>';
            $getcate.= '<td><div class="btn-group"><button class="btn btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-cog"></i>
                                                    <span class="caret"></span>
                                                </button><ul class="dropdown-menu">
                                                    <li>
                                                        <a href="' . base_url() . 'upload/category?edit=' . $row->{Tbl_cat_term::id} . '"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a data-modal="true" data-text="Do you want to delete this TV?" data-type="confirm" data-class="error" data-layout="top" data-action="tv/category?delete=' . $row->{Tbl_cat_term::id} . '" class="btn-notification"><i class="fa fa-times"></i> Remove</a>
                                                    </li>
                                                </ul></div></td>';
            $getcate.= '</tr>';
            
            //we want to see all the children that belong to this
            //node… so we need to call *this* function again
            $getcate.= $this->build_tree_cat($row->{Tbl_cat_term::id}, $level + 1);
        }
        
        //echo '<ul class="categories">';
        //build_tree($parent_id=0,$level=0);
        //echo '</ul>';
        return $getcate;
    }
    
    function addHistory($vdo_id, $bloginCat = 'editaction') {
        $log_id = $this->session->userdata('log_id');
        $curdate = date('Y-m-d', time());
        $data_his_ch = array(Tbl_history::object_id => $vdo_id, Tbl_history::user_id => $log_id, Tbl_history::date . ' =' => $curdate,);
        $movie_post = $this->Mod_general->select(Tbl_history::Table, '', $data_his_ch);
        if (empty($movie_post)) {
            $Data_his = array(Tbl_history::object_id => $vdo_id, Tbl_history::type => $bloginCat, Tbl_history::user_id => $log_id, Tbl_history::date => date('Y-m-d', time()),);
            $hist_rec = $this->Mod_general->insert(Tbl_history::Table, $Data_his);
        }
    }
    
    function get_image() {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $DataImage = array('img_object_id' => $user_id, 'img_obj_type' => 'user');
            $GetImage = $this->select('image', '*', $DataImage, 'img_id DESC');
            foreach ($GetImage as $image) {
                echo '<div class="photos_item" id="ITM' . $image->img_id . '">';
                echo '<span class="pointer" onclick="choosePhotoClick(' . $image->img_id . ',\'' . $image->img_path . '\',\'' . $image->img_w . 'x' . $image->img_h . '\');">';
                echo '<img src="' . $image->img_path . '">';
                echo '</span>';
                echo '<div class="delPhoto" style="background:URL(\'' . base_url() . 'img/img/delete16.png\') top left no-repeat" onclick=\'choosePhotoDel("' . $image->img_id . '","' . $image->img_path . '","' . $user_id . '");\'></div>';
                echo '</div>';
            }
        }
    }

    //$thumbs=array(),$asThumb=array(),$label,$btnplayer='',$imagetext='',$setTitle=''
    public function imageMerge($thumbs=array(),$asThumb=array(),$label='',$btnplayer='',$imagetext='',$setTitle='')
    {
        $setArr = array();
        if(!empty($thumbs[0])) {
            // for ($i=0; $i < count($thumbs); $i++) { 
            //     if(!empty($thumbs[$i])) {
            //         if($asThumb[$i] == 'set') {
            //             array_push($setArr, $thumbs[$i]);
            //         }
            //     }
            // }
            $count = count($thumbs);
            $setWeight = 1200;
            $setHeight = 635;
            $path    = FCPATH . 'uploads/photos/';
            for ($j=0; $j < count($thumbs); $j++) {
                if(!empty($thumbs[$j])) {
                    if (!preg_match('/fbpost\\\uploads/', $thumbs[$j])) {
                        $imgSrc = $thumbs[$j];
                        echo $imgSrc.'<br/>';
                        $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
                        if (preg_match('/fna.fbcdn/', $imgSrc)) {
                            $ext = 'jpg';
                        }
                        $file_title = strtotime(date('Y-m-d H:i:s'));
                        $file_title = $file_title.(rand(100,10000)).'.'.$ext;
                        $fileName = $path.$file_title;
                        $arrContextOptions=array(
                            "ssl"=>array(
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ),
                        );
                        if(file_get_contents($imgSrc, false, stream_context_create($arrContextOptions))) {
                            $fp = fopen($fileName, "w");
                            fwrite($fp, $thumbs[$j]);
                            fclose($fp);
                        } else {
                            continue;
                        }
                    } 
                    switch ($count) {
                        case 1:
                            $thumb = $this->mergeImages('',$this->crop_image($thumbs[$j],$setWeight,($setHeight)),'lt');
                            $textPosition = 45;
                            $bgPosition = 'cb';
                            break;
                        case 2:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($thumbs[$j],($setWeight/2)-1,$setHeight),'lt');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],($setWeight/2)-1,$setHeight),'rb');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 3:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($thumbs[$j],($setWeight/3)-1,$setHeight),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],($setWeight/3)-1,$setHeight),'cc');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],($setWeight/3)-1,$setHeight),'rt');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 4:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-1)),"rt");
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'lb');
                            }  else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'rb');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 5:
                            $padding = 1;
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'ct');
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rt');
                            }  else if($j==3) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-$padding)),'lb');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-$padding)),'rb');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 6:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'ct');
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'rt');
                            } else if($j==3) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'lb');
                            } else if($j==4) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'cb');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($thumbs[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'rb');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        default:
                            # code...
                            break;
                    }
                    if(!empty($thumb)) {
                        @unlink($thumbs[$j]);
                    }
                }
            }
            if(!empty($thumb)) {
                if($label == 'lotto') {
                    $thumb = $this->watermarktextAndLogo($thumb,$bgPosition,$textPosition,$btnplayer,$imagetext,'',$setTitle);
                }
            }
            // if(!empty($setLogo)) {
            //     $thumb = $this->watermarktextAndLogo($thumb,$bgPosition,$textPosition);
            // }
        }
        return @$thumb;
    }
    function watermark($photo_id) {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $DataImage = array('img_id' => $photo_id);
            $GetImage = $this->select('image', '*', $DataImage);
            foreach ($GetImage as $image) {
            }
        }
    }
    
    function do_upload() {
        $user_id = $this->session->userdata('user_id');
        $this->load->helper('path');
        $directory = FCPATH;
        $base_path = set_realpath($directory);
        $config['upload_path'] = $ImagePath;
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $config['max_size'] = '2048';
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            $this->load->view('upload_form', $error);
        }
    }
    
    //end LABEL IN LIST STYLE for edit
    
    function deletePhoto($client, $user, $albumId, $photoId) {
        $photos = new Zend_Gdata_Photos($client);
        
        $photoQuery = new Zend_Gdata_Photos_PhotoQuery;
        $photoQuery->setUser($user);
        $photoQuery->setAlbumId($albumId);
        $photoQuery->setPhotoId($photoId);
        $photoQuery->setType('entry');
        
        $entry = $photos->getPhotoEntry($photoQuery);
        
        $photos->deletePhotoEntry($entry, true);
        return true;
        
        //outputAlbumFeed($client, $user, $albumId);
        
    }
    function addPhoto($client, $user, $albumId, $photo) {
        $photos = new Zend_Gdata_Photos($client);
        
        $fd = $photos->newMediaFileSource($photo["tmp_name"]);
        $fd->setContentType($photo["type"]);
        
        $entry = new Zend_Gdata_Photos_PhotoEntry();
        $entry->setMediaSource($fd);
        $entry->setTitle($photos->newTitle($photo["name"]));
        
        $albumQuery = new Zend_Gdata_Photos_AlbumQuery;
        $albumQuery->setUser($user);
        $albumQuery->setAlbumId($albumId);
        $albumEntry = $photos->getAlbumEntry($albumQuery);
        $result = $photos->insertPhotoEntry($entry, $albumEntry);
        if ($result) {
            $image = $result->getMediaGroup()->GetThumbnail();
            $getUrl = $image[0]->getUrl();
            $getGphotoId = $result->getGphotoId()->getText();
            $getTitle = $result->getTitle()->getText();
            $imgName = explode('.', $photo["name"]);
            $imgName = str_replace('_', ' ', $imgName[0]);
            $imgName = str_replace('-', ' ', $imgName);
            $data_result = array('image' => $getUrl, 'imageId' => $getGphotoId, 'imageTitle' => $imgName,);
        } 
        else {
            $data_result = array();
        }
        return $data_result;
    }
    public function crop_image($imgSrc,$thumbW=300,$thumbH=300)
    {
        echo ' set w: '.$thumbW.' h: '.$thumbH .'<br/>';
        $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
        if (preg_match('/fna.fbcdn/', $imgSrc)) {
            $ext = 'jpg';
        }
        
        //$fileName = FCPATH . 'uploads/image/'.$file_title;
        if (preg_match('/fbpost\\\uploads/', $imgSrc)) {
            //@copy($imgSrc, $fileName);
            $file_titles = basename($imgSrc);
            $file_titles = explode('.', $file_titles);
            $file_title = $file_titles[0];
            $fileName = $imgSrc;
        } else {
            $file_title = strtotime(date('Y-m-d H:i:s'));
            $file_title = $file_title.(rand(100,10000)).'.'.$ext;
            $fileName = FCPATH . 'uploads/image/'.$file_title;
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );
            $content = file_get_contents($imgSrc, false, stream_context_create($arrContextOptions));
            $fp = fopen($fileName, "w");
            fwrite($fp, $content);
            fclose($fp);
        }
        if(!file_exists($fileName)) {
            if (preg_match('/fbpost\\\uploads/', $imgSrc)) {
                //@copy($imgSrc, $fileName);
                $file_titles = basename($imgSrc);
                $file_titles = explode('.', $file_titles);
                $file_title = $file_titles[0];
                $fileName = $imgSrc;
            } else {
                $file_title = strtotime(date('Y-m-d H:i:s'));
                $file_title = $file_title.(rand(100,10000)).'.'.$ext;
                $fileName = FCPATH . 'uploads/image/'.$file_title;
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $content = file_get_contents($imgSrc, false, stream_context_create($arrContextOptions));
                $fp = fopen($fileName, "w");
                fwrite($fp, $content);
                fclose($fp);
            }
        }
        $maxDim = $thumbW;
        list($width, $height, $type, $attr) = getimagesize( $fileName );
        echo ' ori '.$width .'x' .$height;
        $target_filename = $fileName;
        $ratio = $width/$height;
        echo ' ratio '.$ratio.' src: ' . $imgSrc .'<br/>';
        if($width<$height && $thumbW<$thumbH && $width<$thumbW) {
            $new_width = $width;
            $new_height = $height*$ratio / 1.7;
            echo '<br>CASE: [1] - ';
            echo $new_width .'x'. $new_height . ' vs ori '.$width .'x' .$height;
            $src = imagecreatefromstring( file_get_contents( $fileName ) );
            $dst = imagecreatetruecolor( $new_width, $new_height );
            //$bg = imagecolorallocate($dst, 255, 255, 255);
            //imagefill($dst, 0, 0, $bg); 
            imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $new_width, $new_height );
            imagedestroy( $src );
            imagejpeg( $dst, $fileName ); // adjust format as needed
            imagedestroy( $dst );
            list($width, $height, $type, $attr) = getimagesize( $fileName );
            $new_width = $thumbW;
            $new_height = $thumbH;
            $vImg = imagecreatefromstring( file_get_contents( $fileName ) );
            $vDstImg = @imagecreatetruecolor( $thumbW, $thumbH );
            //$bg = imagecolorallocate($vDstImg, 255, 255, 255);
            //imagefill($vDstImg, 0, 0, $bg);
            imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, $thumbW, $thumbH, $width, $height);
            imagedestroy( $vImg );
            imagejpeg( $vDstImg, $fileName ); // adjust format as needed
            imagedestroy( $vDstImg );
        } else if($width<$height && $thumbW<$thumbH && $thumbW<$width) {
            $new_width = $width;
            $new_height = $height*$ratio / 1.7;
            echo '<br>CASE: [2] - ';
            echo $new_width .'x'. $new_height . ' vs ori '.$width .'x' .$height;
            $src = imagecreatefromstring( file_get_contents( $fileName ) );
            $dst = imagecreatetruecolor( $new_width, $new_height );
            //$bg = imagecolorallocate($dst, 255, 255, 255);
            //imagefill($dst, 0, 0, $bg); 
            imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $new_width, $new_height );
            imagedestroy( $src );
            imagejpeg( $dst, $fileName ); // adjust format as needed
            imagedestroy( $dst );
            list($width, $height, $type, $attr) = getimagesize( $fileName );
            $new_width = $thumbW;
            $new_height = $thumbH;
            $vImg = imagecreatefromstring( file_get_contents( $fileName ) );
            $vDstImg = @imagecreatetruecolor( $thumbW, $thumbH );
            //$bg = imagecolorallocate($vDstImg, 255, 255, 255);
            //imagefill($vDstImg, 0, 0, $bg);
            imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, $thumbW, $thumbH, $width, $height);
            imagedestroy( $vImg );
            imagejpeg( $vDstImg, $fileName ); // adjust format as needed
            imagedestroy( $vDstImg );
        } else if($width>$height && $thumbW<$thumbH && $width>$thumbW) {
            $new_width = $thumbW;
            $new_height = $thumbH;
            $vImg = imagecreatefromstring( file_get_contents( $fileName ) );
            $vDstImg = @imagecreatetruecolor( $thumbW, $thumbH );
            //$bg = imagecolorallocate($vDstImg, 255, 255, 255);
            //imagefill($vDstImg, 0, 0, $bg);
            imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, $thumbW, $thumbH, $width, $height/$ratio);
            imagedestroy( $vImg );
            imagejpeg( $vDstImg, $fileName ); // adjust format as needed
            imagedestroy( $vDstImg );
            echo '<br>CASE: [3] - ';
            echo $new_width .' h: '. $new_height . ' vs ori '.$width .'x' .$height;

        } else if($width<$height && $thumbW>$thumbH) {
            $new_width = $thumbW;
            $new_height = $maxDim/$ratio;
            $src = imagecreatefromstring( file_get_contents( $fileName ) );
            $dst = imagecreatetruecolor( $new_width, $new_height );
            //$bg = imagecolorallocate($dst, 255, 255, 255);
            //imagefill($dst, 0, 0, $bg);
            imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
            imagedestroy( $src );
            imagejpeg( $dst, $fileName ); // adjust format as needed
            imagedestroy( $dst );


            $vImg = imagecreatefromstring( file_get_contents( $fileName ) );
            $vDstImg = @imagecreatetruecolor( $thumbW, $thumbH );
            //$bg = imagecolorallocate($vDstImg, 255, 255, 255);
            //imagefill($vDstImg, 0, 0, $bg);
            imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, $thumbW, $thumbH, $thumbW, $thumbH);
            imagedestroy( $vImg );
            imagejpeg( $vDstImg, $fileName ); // adjust format as needed
            imagedestroy( $vDstImg );
            echo '<br>CASE: [4] - ';
            echo $new_width .' h: '. $new_height . ' vs ori '.$width .'x' .$height;
        } else if($width>$height) {
            $new_width = $thumbW;
            $new_height = $thumbH;
            $vImg = imagecreatefromstring( file_get_contents( $fileName ) );
            $vDstImg = @imagecreatetruecolor( $thumbW, $thumbH );
            //$bg = imagecolorallocate($vDstImg, 255, 255, 255);
            //imagefill($vDstImg, 0, 0, $bg);
            imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, $thumbW, $thumbH, $width, $height/$ratio);
            imagedestroy( $vImg );
            imagejpeg( $vDstImg, $fileName ); // adjust format as needed
            imagedestroy( $vDstImg );
            echo '<br>CASE: [5] - ';
            echo $new_width .' h: '. $new_height . ' vs ori '.$width .'x' .$height;
        }
        echo $fileName;
        return $fileName;
    }

    public function gridGen($thumbs=array())
    {
        $setArr = array();
        if(!empty($thumbs[0])) {
            for ($i=0; $i < count($thumbs); $i++) { 
                $file_path = $thumbs[$i];
                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                $headers = @get_headers($file_path);
                if(strpos($headers[0],'404') === false)
                {
                    if (preg_match('/fbpost\\\uploads/', $file_path)) {
                        //@copy($file_path, $fileName);
                        $file_titles = basename($file_path);
                        $file_titles = explode('.', $file_titles);
                        $file_title = $file_titles[0];
                        $fileName = $file_path;
                    } else {
                        $file_title = strtotime(date('Y-m-d H:i:s'));
                        $file_title = $file_title.(rand(100,10000)).'.'.$ext;
                        $fileName = FCPATH . 'uploads/image/'.$file_title;
                        $arrContextOptions=array(
                            "ssl"=>array(
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ),
                        );
                        $content = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
                        $fp = fopen($fileName, "w");
                        fwrite($fp, $content);
                        fclose($fp);




                        if($ext!='webp') {
                            $im = imagecreatefromstring( file_get_contents( $fileName ) );
                        } else {
                            $im = imagecreatefromwebp($fileName);
                        }
                        $old = $fileName;
                        $file_title = strtotime(date('Y-m-d H:i:s'));
                        $file_title = $file_title.(rand(100,10000)).'.jpg';
                        $fileName = FCPATH . 'uploads/image/'.$file_title;
                        imagejpeg($im, $fileName, 100);
                        imagedestroy($im);
                        @unlink($old);
                
                    }
                    echo 'file before web. '.$fileName.'<br/>';
                    array_push($setArr, $fileName);
                } else {
                    continue;
                }





                // if($ext!='webp') {
                //     if(!empty($thumbs[$i])) {
                //         if (preg_match('/fna.fbcdn/', $thumbs[$i])) {
                //             array_push($setArr, $thumbs[$i]);
                //         } else {
                //             $imgSrc = strtok($thumbs[$i], '?');
                //             preg_match("/-((\w+)x(\w+))/", $imgSrc, $results);
                //             if(!empty($results[0])) {
                //                 $imgSrc = str_replace($results[0], '', $imgSrc);
                //             }
                //             array_push($setArr, $imgSrc);
                //         }
                //     }
                // } else {
                //     if (preg_match('/fbpost\\\uploads/', $file_path)) {
                //         //@copy($file_path, $fileName);
                //         $file_titles = basename($file_path);
                //         $file_titles = explode('.', $file_titles);
                //         $file_title = $file_titles[0];
                //         $fileName = $file_path;
                //     } else {
                //         $arrContextOptions=array(
                //             "ssl"=>array(
                //                 "verify_peer"=>false,
                //                 "verify_peer_name"=>false,
                //             ),
                //         );
                //         $content = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
                //         $fp = fopen($fileName, "w");
                //         fwrite($fp, $content);
                //         fclose($fp);
                
                //     }
                //     echo 'file before web. '.$fileName.'<br/>';
                //     $im = imagecreatefromwebp($fileName);
                //     $old = $fileName;
                //     $file_title = strtotime(date('Y-m-d H:i:s'));
                //     $file_title = $file_title.(rand(100,10000)).'.jpg';
                //     $fileName = FCPATH . 'uploads/image/'.$file_title;
                //     imagejpeg($im, $fileName, 100);
                //     imagedestroy($im);
                //     @unlink($old);
                //     array_push($setArr, $fileName);
                // }
            }
            $count = count($setArr);
            $setWeight = 1974;
            $setHeight = 1980;
            $thumb = '';
            switch ($count) {
                case 2:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
                case 3:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
                case 4:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
                case 5:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
                case 6:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
                default:
                    $mode = array(1,2);
                    $k = array_rand($mode);
                    $grid = $mode[$k];
                    break;
            }
            //$grid = 2;
            list($width, $height, $type, $attr) = @getimagesize( $setArr[0] );
            if($width<$height) {
                //$grid = 1;
            }
            $this->load->library('ChipVNl');
            \ChipVN\Loader::registerAutoLoad();

            for ($j=0; $j < count($setArr); $j++) {
                if(!empty($setArr[$j])) {
                    switch ($count) {
                        case 1:
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            $param = array(
                                'btnplayer'=>0,
                                'playerstyle'=>0,
                                'imgcolor'=>0,
                                'txtadd'=>'',
                                'filter_brightness'=>0,
                                'filter_contrast'=>0,
                                'img_rotate'=>'',
                                'no_need_upload'=>1,
                            );
                            \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/1.5));
                            $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-3-2.jpg';
                            $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 1980);
                            $setArr[$j];
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 2:
                            if($j==0) {
                                echo 'case 2: <br/>';
                            }
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-2-1.jpg';
                                if($j==0) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,($width/2),$height);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], ($setWeight/2)-6, $setHeight);
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                } else {
                                    \ChipVN\Image::crop($setArr[$j],0,0,($width/2),$height);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], ($setWeight/2)-6, $setHeight);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);
                                }
                            }
                            if($grid==2) {
                                $watermar = FCPATH . 'uploads/image/watermark/bg_lotto-2-2.jpg';
                                if($j==0) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $img = $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 987);
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,1980,1971,$watermar);
                                } else {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 987);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                }
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 3:
                            if($j==0) {
                                echo 'case 3<br/>';
                            }
                            /**
                            ct = center top
                            cc = center center
                            lt = left top
                            rt = right top
                            lb = left bottom
                            rb = right bottom
                            rc = right center
                            cb = center bottom
                            resize($imagePath, $width, $height, $resize_mod = 'basic')
                            cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
                            crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
                            */
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-3-1.jpg';
                                if($j==0) {
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 982, 1980);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 982,986);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);

                                } else if($j==2) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 986,986);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                } 
                            }
                            if($grid==2) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-3-2.jpg';
                                if($j==0) {
                                    if($width<$height) {
                                        \ChipVN\Image::crop($setArr[$j],0,0,1971,($height/2));
                                        $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 987);
                                    } else {
                                        $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 987);
                                    }
                                    
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,1971,1980,$watermarks);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 982,987);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'lb',0,$setWeight,$setHeight);

                                } else if($j==2) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 982,987);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                }
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 4:
                            if($j==0) {
                                echo 'case 4<br/>';
                            }
                        
                            /**
                            ct = center top
                            cc = center center
                            lt = left top
                            rt = right top
                            lb = left bottom
                            rb = right bottom
                            rc = right center
                            cb = center bottom
                            resize($imagePath, $width, $height, $resize_mod = 'basic')
                            cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
                            crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
                            */
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-2.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1315, 1980);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);

                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rc',0,$setWeight,$setHeight);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                } 
                            }
                            if($grid==2) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-1.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 1314);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'lb',0,$setWeight,$setHeight);

                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'cb',0,$setWeight,$setHeight);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $thumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                }
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 5:
                            if($j==0) {
                                echo 'case 5<br/>';
                            }
                            $padding = 1;
                            // $w = array();
                            // $l = array_rand($RanChoose);
                            // $getChoose = $RanChoose[$l];
                            /**
                            ct = center top
                            cc = center center
                            lt = left top
                            rt = right top
                            lb = left bottom
                            rb = right bottom
                            rc = right center
                            cb = center bottom
                            resize($imagePath, $width, $height, $resize_mod = 'basic')
                            cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
                            crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
                            */
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            echo ' $grid '.$grid.'<br/>';
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-2.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1315, 1980);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rc',0,$setWeight,$setHeight);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    sleep(1);
                                }
                            }
                            if($grid==2) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-1.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 1314);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'lb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'cb',0,$setWeight,$setHeight);
                                    sleep(1);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    //$this->crop_and_resize_image_gd($setThumb, $setArr[$j], $setArr[$j],651,654)
                                    sleep(1);
                                }
                            }                            
                            $textPosition = 38;
                            $bgPosition = 'cb';
                            break;
                        case 6:
                            if($j==0) {
                                echo 'case 6<br/>';
                            }
                            /**
                            ct = center top
                            cc = center center
                            lt = left top
                            rt = right top
                            lb = left bottom
                            rb = right bottom
                            rc = right center
                            cb = center bottom
                            resize($imagePath, $width, $height, $resize_mod = 'basic')
                            cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
                            crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
                            */
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-2.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1315, 1980);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rc',0,$setWeight,$setHeight);
                                    sleep(1);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==4) {
                                    $setThumb = $setThumb;
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    sleep(1);
                                }
                            }
                            if($grid==2) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-1.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 1314);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'lb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'cb',0,$setWeight,$setHeight);
                                    sleep(1);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==4) {
                                    $setThumb = $setThumb;
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    sleep(1);
                                }
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        default:
                            if($j==0) {
                                echo 'default case<br/>';
                            }
                            /**
                            ct = center top
                            cc = center center
                            lt = left top
                            rt = right top
                            lb = left bottom
                            rb = right bottom
                            rc = right center
                            cb = center bottom
                            resize($imagePath, $width, $height, $resize_mod = 'basic')
                            cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
                            crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
                            */
                            list($width, $height, $type, $attr) = @getimagesize( $setArr[$j] );
                            if($grid==1) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-2.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1315, 1980);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rt',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rc',0,$setWeight,$setHeight);
                                    sleep(1);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 651,656);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==4) {
                                    $setThumb = $setThumb;
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    sleep(1);
                                }
                            }
                            if($grid==2) {
                                $watermarks = FCPATH . 'uploads/image/watermark/bg_lotto-5-1.jpg';
                                if($j==0) {
                                    //$this->crop_image($setArr[$j],1315,1980);
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 1971, 1314);
                                    //die;
                                    $setThumb = $this->mergeImages('',$setArr[$j],'lt',0,$setWeight,$setHeight,$watermarks);
                                    sleep(1);
                                } else if($j==1) {
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'lb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==2) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rc',0,$setWeight,$setHeight,$watermarks);

                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'cb',0,$setWeight,$setHeight);
                                    sleep(1);
                                }  else if($j==3) {
                                    //$setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb',0,$setWeight,$setHeight,$watermarks);
                                    \ChipVN\Image::crop($setArr[$j],0,0,$width,($height/2));
                                    //\ChipVN\Image::resize($setArr[$j],651,654,'adaptive');
                                    $this->crop_and_resize_image_gd($setArr[$j], $setArr[$j], 653,662);
                                    $setThumb = $this->mergeImages($setThumb,$setArr[$j],'rb',0,$setWeight,$setHeight);
                                    sleep(1);
                                } else if($j==4) {
                                    $setThumb = $setThumb;
                                } else {
                                    //$thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb',0,$setWeight,$setHeight,$watermarks);
                                    $nums=array(2,3,4,5);
                                    $t = array_rand($nums);
                                    $numsR = $nums[$t];
                                    $numwater = FCPATH . 'uploads/image/watermark/number'.$numsR.'.png';
                                    \ChipVN\Image::watermark($setThumb,$numwater,'rb');
                                    $thumb = $setThumb;
                                    sleep(1);
                                }
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                        break;
                    }
                }
            }
        }
        if($thumb) {
            return @$thumb;
        } else {
            sleep(10);
            return @$thumb;
        }
        
        
        //return @$thumb;
    }

    function crop_and_resize_image_gd($orig_path, $new_path, $new_width, $new_height){
        $image_data  = @getimagesize($orig_path);                       // Get image data
        $orig_width  = $image_data[0];                                 // Image width
        $orig_height = $image_data[1];                                 // Image height
        $media_type  = $image_data['mime'];                            // Media type
        $orig_ratio  = $orig_width / $orig_height;                     // Ratio of original
        $new_ratio   = $new_width / $new_height;                       // Ratio of crop
        // Calculate new size
        if ($new_ratio < $orig_ratio) {                                // If new ratio < orig
            $select_width  = $orig_height * $new_ratio;                // Calculate width
            $select_height = $orig_height;                             // Height stays same
            $x_offset      = ($orig_width - $select_width) / 2;        // Calculate X Offset
            $y_offset      = 0;                                        // Y offset = 0 (top)
        } else {                                                       // Otherwise
            $select_width  = $orig_width;                              // Width stays same
            $select_height = $orig_width * $new_ratio;                 // Calculate height
            $x_offset      = 0;                                        // X-offset = 0 (left)
            $y_offset      = ($orig_height - $select_height) / 2;      // Calculate Y Offset
        }
        switch($media_type) {                                           // If media type is
            case 'image/gif' :                                          // GIF
                $orig = imagecreatefromgif($orig_path);                 // Open GIF
                break;                                                  // End of switch
            case 'image/jpeg' :                                         // JPEG
                $orig = imagecreatefromjpeg($orig_path);                // Open JPEG
                break;                                                  // End of switch
            case 'image/png' :                                          // PNG
                $orig = imagecreatefrompng($orig_path);                 // Open PNG
                break;                                                  // End of switch
        }

        $new = imagecreatetruecolor($new_width, $new_height);           // New blank image
        imagecopyresampled($new, $orig, 0, 0, $x_offset, $y_offset, $new_width, 
                           $new_height, $select_width, $select_height); // Crop and resize

        // Save the image in the correct format
        switch($media_type) {                                           // If media type is
            case 'image/gif' :                                          // GIF 
              $result = imagegif($new, $new_path);                      // Save GIF  
              break;                                                    // End of switch
            case 'image/jpeg':                                          // JPEG
              $result = imagejpeg($new, $new_path);                     // Open JPEG 
              break;                                                    // End of switch
            case 'image/png' :                                          // PNG 
              $result = imagepng($new, $new_path);                      // Open PNG  
              break;                                                    // End of switch
        }
        return $new_path; 
    }
    function decToFraction($float) {
        // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
        // 9/16, 11/16, 13/16, 15/16
        $whole = floor ( $float );
        $decimal = $float - $whole;
        $leastCommonDenom = 48; // 16 * 3;
        $denominators = array (2, 3, 4, 8, 16, 24, 48 );
        $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
        if ($roundedDecimal == 0)
            return $whole;
        if ($roundedDecimal == 1)
            return $whole + 1;
        foreach ( $denominators as $d ) {
            if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
                $denom = $d;
                break;
            }
        }
        return ($whole == 0 ? '' : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;
    }
    function resize_image($url, $imgsize, $height = '') {
        if (preg_match('/blogspot/', $url)) {
            
            //inital value
            $newsize = "w" . $imgsize;
            $newurl = "";
            
            //Get Segments
            $path = parse_url($url, PHP_URL_PATH);
            $segments = explode('/', rtrim($path, '/'));
            
            //Get URL Protocol and Domain
            $parsed_url = parse_url($url);
            $domain = $parsed_url['scheme'] . "://" . $parsed_url['host'];
            $newurl_segments = array($domain . "/", $segments[1] . "/", $segments[2] . "/", $segments[3] . "/", $segments[4] . "/", $newsize . $height . "/",
             //change this value
            $segments[6]);
            $newurl_segments_count = count($newurl_segments);
            for ($i = 0; $i < $newurl_segments_count; $i++) {
                $newurl = $newurl . $newurl_segments[$i];
            }
            return $newurl;
        } 
        else if (preg_match('/googleusercontent/', $url)) {
            
            //inital value
            $newsize = "w" . $imgsize;
            $newurl = "";
            
            //Get Segments
            $path = parse_url($url, PHP_URL_PATH);
            $segments = explode('/', rtrim($path, '/'));
            
            //Get URL Protocol and Domain
            $parsed_url = parse_url($url);
            $domain = $parsed_url['scheme'] . "://" . $parsed_url['host'];
            $newurl_segments = array($domain . "/", $segments[1] . "/", $segments[2] . "/", $segments[3] . "/", $segments[4] . "/", $newsize . $height . "/",
             //change this value
            $segments[6]);
            $newurl_segments_count = count($newurl_segments);
            for ($i = 0; $i < $newurl_segments_count; $i++) {
                $newurl = $newurl . $newurl_segments[$i];
            }
            return $newurl;
        } 
        else {
            return $url;
        }
    }
    function p_resize_image($url, $imgsize) {
        if (preg_match('/googleusercontent/', $url)) {
            
            //inital value
            $newsize = "s" . $imgsize;
            $newurl = "";
            
            //Get Segments
            $path = parse_url($url, PHP_URL_PATH);
            $segments = explode('/', rtrim($path, '/'));
            
            //Get URL Protocol and Domain
            $parsed_url = parse_url($url);
            $domain = $parsed_url['scheme'] . "://" . $parsed_url['host'];
            $newurl_segments = array($domain . "/", $segments[1] . "/", $segments[2] . "/", $segments[3] . "/", $segments[4] . "/", $newsize . "/",
             //change this value
            $segments[6]);
            $newurl_segments_count = count($newurl_segments);
            for ($i = 0; $i < $newurl_segments_count; $i++) {
                $newurl = $newurl . $newurl_segments[$i];
            }
            return $newurl;
        } 
        else {
            return $url;
        }
    }
    function text_only($str) {
        $text = preg_match('/[a-z]+/i', $str);
        if ($text == true) {
            return $str;
        } 
        else {
            return false;
        }
    }
    
    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";
        
        // First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } 
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } 
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        
        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } 
        elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } 
        elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } 
        elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } 
        elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } 
        elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } 
        elseif (preg_match('/Mozilla/i', $u_agent)) {
            $bname = 'Mozilla';
            $ub = "Mozilla";
        } 
        else {
            $bname = $u_agent;
            $ub = $u_agent;
        }
        
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            
            // we have no matching number just continue
            
            
        }
        
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            
            // we will have two since we are not using 'other' argument yet
            // see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } 
            else {
                $version = $matches['version'][1];
            }
        } 
        else {
            $version = $matches['version'][0];
        }
        
        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        
        return array('userAgent' => $u_agent, 'name' => $bname, 'version' => $version, 'platform' => $platform, 'pattern' => $pattern);
    }

    public function upload($file_path='', $param=array(),$rezie=1)
    {
        $maxDim = 1200;
        $file_name = $file_path;
        list($width, $height, $type, $attr) = @getimagesize( $file_path );
        if($width < $maxDim) {
            $structure = FCPATH . 'uploads/image/';
            if (!file_exists($structure)) {
                mkdir($structure, 0777, true);
            }
            $file_title = basename($file_path);
            $fileName = FCPATH . 'uploads/image/'.$file_title;
            @copy($file_path, $fileName);

                    $target_filename = $file_name;
                    $ratio = $width/$height;
                    if( $ratio > 1) {
                        $new_width = $maxDim;
                        $new_height = $maxDim/$ratio;
                    } else {
                        $new_width = $maxDim*$ratio;
                        $new_height = $maxDim;
                    }

                    $src = imagecreatefromstring( file_get_contents( $file_name ) );
                    $dst = imagecreatetruecolor( $new_width, 635 );
                    imagecopyresampled( $dst, $src, 0, 0, 0, 50, $new_width, $new_height, $width, $height );
                    imagedestroy( $src );
                    imagejpeg( $dst, $fileName ); // adjust format as needed
                    imagedestroy( $dst );

            $image = $this->uploadtoImgur($fileName);
            return $image;
        } else {
            return $file_path;
        }
    }

    public function uploadMedia($file_path='', $param=array(),$rezie=1)
       {

        if(!empty($file_path)) {
            $structure = FCPATH . 'uploads/image/';
            if (!file_exists($structure)) {
                mkdir($structure, 0777, true);
            }
            
            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
            if (preg_match('/fna.fbcdn/', $file_path)) {
                $ext = 'jpg';
            }
            if(empty($ext)) {
                $ext = 'jpg';
            }
            $file_title = strtotime(date('Y-m-d H:i:s'));
            $file_title = $file_title.(rand(100,10000)).'.'.$ext;
            $fileName = FCPATH . 'uploads/image/'.$file_title;
            $fileName = strtok($fileName, '?');
            //$fileName = FCPATH . 'uploads/image/'.$file_title;
            if (preg_match('/fbpost\\\uploads/', $file_path)) {
                //@copy($file_path, $fileName);
                $file_titles = basename($file_path);
                $file_titles = explode('.', $file_titles);
                $file_title = $file_titles[0];
                $fileName = $file_path;
            } else {
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $content = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
                $fp = fopen($fileName, "w");
                fwrite($fp, $content);
                fclose($fp);
        
            }
            if($ext=='webp') {
                $im = imagecreatefromwebp($fileName);
                $old = $fileName;
                $file_title = strtotime(date('Y-m-d H:i:s'));
                $file_title = $file_title.(rand(100,10000)).'.jpg';
                $fileName = FCPATH . 'uploads/image/'.$file_title;
                imagejpeg($im, $fileName, 100);
                imagedestroy($im);
                @unlink($old);
            }
            sleep(1);
            $file_path = $fileName;
            $file_name = $imgName = $fileName;
            $uploads = 1;
            $file_name = $file_path;
            if (file_exists($fileName)) {
                $this->load->library('ChipVNl');
                \ChipVN\Loader::registerAutoLoad();


                $client_id = '51d22a7e4b628e4';

                $filetype = mime_content_type($fileName);
                /*resize image*/
                if(!empty($rezie)) {
                    $maxDim = 1200;
                    list($width, $height, $type, $attr) = @getimagesize( $file_name );
                    if($width < $maxDim || $width < $height) {
                        if(empty($uploads)) {
                            $structure = FCPATH . 'uploads/image/';
                            if (!file_exists($structure)) {
                                mkdir($structure, 0777, true);
                            }
                            $file_title = basename($file_path);
                            $fileName = FCPATH . 'uploads/image/'.$file_title;
                            @copy($file_path, $fileName);
                            $file_path = $fileName;
                            $file_name = $imgName = $fileName;
                        }
                        if ( $width < $maxDim || $height < $maxDim ) {
                            $target_filename = $file_name;
                            $ratio = $width/$height;
                            if( $ratio > 1) {
                                $new_width = $maxDim;
                                $new_height = $maxDim/$ratio;
                            } else if ( $width < $maxDim && $height > $width) {

                            } else {
                                $new_width = $maxDim*$ratio;
                                $new_height = $maxDim;
                            }
                            $new_width = 1200;
                            $new_height = 635;
                            $src = imagecreatefromstring( file_get_contents( $file_name ) );
                            $dst = imagecreatetruecolor( $new_width, 635 );
                            imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                            imagedestroy( $src );
                            imagejpeg( $dst, $imgName ); // adjust format as needed
                            imagedestroy( $dst );
                        }
                    } 
                }
                // $fileSName = FCPATH . 'uploads/image/'.strtotime("now").basename($imgName);
                // @copy($file_path, $fileSName);
                // List($sWidth, $sHeight) = getimagesize($fileSName);
                // $Sw = 440;
                // $Sh = $sHeight * ($Sw / $sWidth);
                // $src = imagecreatefromstring( file_get_contents( $fileSName ) );
                // $NewImageBase = imagecreatetruecolor($Sw, $Sh);
                // imagecopyresampled($NewImageBase, $src, 0, 0, 0, 0, $Sw, $Sh, $sWidth, $sHeight);
                // imagedestroy( $src );
                // imagejpeg( $NewImageBase, $fileSName ); // adjust format as needed
                // imagedestroy( $NewImageBase );
                
                // $border=10;
                // $img_adj_width=$Sw+(2*$border);
                // $img_adj_height=$Sh+(2*$border);
                // $src = imagecreatefromstring( file_get_contents( $fileSName ) );
                // $newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
                // $border_color = imagecolorallocate($newimage, 255, 255, 255);
                // imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
                // imageCopyResized($newimage,$src,$border,$border,0,0,$Sw,$Sh,$Sw,$Sh);
                // imagedestroy( $src );
                // imagejpeg($newimage,$fileSName);
                // imagedestroy( $newimage );
                // $imagePositionArr = array(
                //     'cc',
                //     'ct',
                //     'cb',
                // );
                // $imagePosition = mt_rand(0, count($imagePositionArr) - 1);
                // \ChipVN\Image::watermark($file_path, $fileSName, $imagePositionArr[$imagePosition]);
                // @unlink($fileSName);
                /*End for big and small image*/


                if(!empty($param['filter_brightness'])) {
                    $im = imagecreatefromstring( file_get_contents( $file_name ) );
                    if($im && imagefilter($im, IMG_FILTER_BRIGHTNESS, rand(10,100)))
                    {
                        imagejpeg($im, $file_path);
                        imagedestroy($im);
                    }
                }

                if(!empty($param['filter_contrast'])) {
                    $im = imagecreatefromstring( file_get_contents( $file_name ) );
                    if($im && imagefilter($im, IMG_FILTER_CONTRAST, rand(10,30)))
                    {
                        imagejpeg($im, $file_path);
                        imagedestroy($im);
                    }
                }

                if(!empty($param['imgcolor'])) {
                    $rgbColor = array();
                    foreach(array('r', 'g', 'b') as $color){
                        $rgbColor[$color] = mt_rand(0, 255);
                    }
                    $im = imagecreatefromstring( file_get_contents( $file_name ) );
                    if($im && imagefilter($im, IMG_FILTER_COLORIZE, $rgbColor['r'], $rgbColor['g'], $rgbColor['b']))
                    {
                        imagejpeg($im, $file_path);
                        imagedestroy($im);
                    }
                }


                /*end resize image*/
                
                if(!empty($param['img_rotate'])) {
                    \ChipVN\Image::rotate($file_path, rand(-4,4));
                }
                if(empty($param['playerstyle'])) {
                    if(!empty($param['txtadd'])) {
                        $logoPosition = 'lt';
                        $logoPath = FCPATH . '/uploads/image/watermark/web-logo.png';
                        \ChipVN\Image::watermark($file_path, $logoPath, $logoPosition);
                    }
                }

                if(!empty($param['playerstyle'])) {
                    $btnPosition = 'cc';
                    $btnPath = FCPATH . '/uploads/image/watermark/btn/btn-'.rand(1,15).'.png';
                    \ChipVN\Image::watermark($file_path, $btnPath, $btnPosition);     

                    $setWidth = 800;
                    $setHeight = 450;
                    list($width, $height, $type, $attr) = getimagesize( $file_name );
                    if ( $width < $setWidth || $height < $setWidth ) {
                        $target_filename = $file_name;
                        $ratio = $width/$height;
                        if( $ratio > 1) {
                            $new_width = $setWidth;
                            $new_height = $setWidth/$ratio;
                        } else {
                            $new_width = $setWidth*$ratio;
                            $new_height = $setWidth;
                        }

                        $src = imagecreatefromstring( file_get_contents( $file_name ) );
                        $dst = imagecreatetruecolor( $new_width, 520 );
                        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        imagedestroy( $src );
                        imagejpeg( $dst, $target_filename ); // adjust format as needed
                        imagedestroy( $dst );
                    }
                    /*btn player bottom style*/
                    $btncPosition = 'lb';
                    $btnPc = FCPATH . '/uploads/image/watermark/player/btn-c.png';
                    \ChipVN\Image::watermark($file_path, $btnPc, $btncPosition);

                    $btnlPosition = 'lb';
                    $btnPl = FCPATH . '/uploads/image/watermark/player/btn-l.png';
                    \ChipVN\Image::watermark($file_path, $btnPl, $btnlPosition);
                    $btnrPosition = 'rb';
                    $btnPr = FCPATH . '/uploads/image/watermark/player/btn-r.png';
                    \ChipVN\Image::watermark($file_path, $btnPr, $btnrPosition);
                    /*End btn player bottom*/
                }

                if(!empty($param['btnplayer'])) {
                    $btnPosition = 'cc';
                    $btnPath = FCPATH . '/uploads/image/watermark/btn/btn-'.rand(1,15).'.png';
                    \ChipVN\Image::watermark($file_path, $btnPath, $btnPosition);                    
                }  
                $image = $file_path;     
                /*upload to picasa*/
                // $service  = 'Picasa';
                // $uploader = \ChipVN\Image_Uploader::factory($service);
                // $uploader->login($this->session->userdata('guid'), '0689989@Sn',$this->session->userdata('access_token'));
                // $image = $uploader->upload($imgName);
                // if(!empty($image)) {
                //     return $image;
                // } else {
                //     return false;
                // }
                /*End upload to picasa*/
                if(empty($param['no_need_upload'])) {
                    /*upload to imgur.com*/
                    return $this->uploadtoImgur($imgName);
                    // $image = file_get_contents($imgName);
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                    // curl_setopt($ch, CURLOPT_POST, TRUE);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Authorization: Client-ID $client_id" ));
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // $reply = curl_exec($ch);
                    // curl_close($ch);
                    // $reply = json_decode($reply);
                    // if($reply->success) {
                    //     return $reply->data->link;
                    // } else {
                    //     return false;
                    // }
                } else {
                    return $file_path;
                }
                /*End upload*/
            } else {
                return $file_path;
            }
        } else {
            return false;
        }
    }
    public function uploadtoImgur($imgName)
    {
        $client_id = '51d22a7e4b628e4';
        $image = @file_get_contents($imgName);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Authorization: Client-ID $client_id" ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $reply = curl_exec($ch);
        curl_close($ch);
        $reply = json_decode($reply);
        if(!empty($reply->success)) {
            @unlink($imgName);
            return $reply->data->link;
        } else {
            return false;
        }
    }
    public function uploadToImgbb($image, $apiKey)
    {
        if(!empty($image)) {
            if (!file_exists($image)) {
                return false;
            }
            /*upload to Imgbb.com*/
            $image = @file_get_contents($image);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key='.$apiKey);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $reply = curl_exec($ch);
            curl_close($ch);
            $reply = json_decode($reply);
            if(!empty($reply->success)) {
                @unlink($imgName);
                return $reply->data->image->url;
            } else {
                return false;
            }
        }
    }
    public function uploadMediaWithText($file_path='')
       {
        $imgName = $file_path;
        $client_id = '51d22a7e4b628e4';

        $filetype = mime_content_type($file_path);
        /*resize image*/
        $maxDim = 800;
        $file_name = $imgName;
        list($width, $height, $type, $attr) = getimagesize( $file_name );
        if ( $width < $maxDim || $height < $maxDim ) {
            $target_filename = $file_name;
            $ratio = $width/$height;
            if( $ratio > 1) {
                $new_width = $maxDim;
                $new_height = $maxDim/$ratio;
            } else {
                $new_width = $maxDim*$ratio;
                $new_height = $maxDim;
            }

            $src = imagecreatefromstring( file_get_contents( $file_name ) );
            $dst = imagecreatetruecolor( $new_width, 415 );
            imagecopyresampled( $dst, $src, 0, 0, 0, 50, $new_width, $new_height, $width, $height );
            imagedestroy( $src );
            imagejpeg( $dst, $target_filename ); // adjust format as needed
            imagedestroy( $dst );
        }
        /*end resize image*/
        $this->load->library('ChipVNl');
        \ChipVN\Loader::registerAutoLoad();
        $logoPosition = 'lt';
        $logoPath = FCPATH . '/uploads/image/watermark/web-logo.png';
        \ChipVN\Image::watermark($file_path, $logoPath, $logoPosition);
        /*upload to imgur.com*/
        // $image = file_get_contents($imgName);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        // curl_setopt($ch, CURLOPT_POST, TRUE);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Authorization: Client-ID $client_id" ));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $reply = curl_exec($ch);
        // curl_close($ch);
        // $reply = json_decode($reply);
        // if(!empty($reply->data->link)) {
        //     return $reply->data->link;
        // } else {
        //     return false;
        // }
        /*End upload*/
    }

    /*
    imageMerge
    for Image Template 1-6 column
    */
    public function btnplayer($file_path)
    {
        $this->load->library('ChipVNl');
        \ChipVN\Loader::registerAutoLoad();
        $btnPosition = 'cc';
        $btnPath = FCPATH . '/uploads/image/watermark/btn/btn-'.rand(1,15).'.png';
        \ChipVN\Image::watermark($file_path, $btnPath, $btnPosition);
        return $file_path;                    
    }
    public function imageMultiThumbs($thumbs=array(),$asThumb=array(),$label,$btnplayer='',$imagetext='')
    {
        $setArr = array();
        if(!empty($thumbs[0])) {
            for ($i=0; $i < count($thumbs); $i++) { 
                if(!empty($thumbs[$i])) {
                    if($asThumb[$i] == 'set') {
                        if (preg_match('/fna.fbcdn/', $thumbs[$i])) {
                            array_push($setArr, $thumbs[$i]);
                        } else {
                            array_push($setArr, strtok($thumbs[$i], '?'));
                        }
                    }
                }
            }
            $count = count($setArr);
            $setWeight = 1200;
            $setHeight = 635;
            $thumb = '';
            for ($j=0; $j < count($setArr); $j++) {
                if(!empty($setArr[$j])) {
                    switch ($count) {
                        case 1:
                            //$thumb = $this->mergeImages('',$this->crop_image($setArr[$j],$setWeight,($setHeight-95)),'lt');
                            $param = array(
                                'btnplayer'=>0,
                                'playerstyle'=>0,
                                'imgcolor'=>0,
                                'txtadd'=>'',
                                'filter_brightness'=>0,
                                'filter_contrast'=>0,
                                'img_rotate'=>'',
                                'no_need_upload'=>1,
                            );
                            $thumb = $this->uploadMedia($setArr[$j],$param);
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 2:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($setArr[$j],($setWeight/2)-1,$setHeight),'lt');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],($setWeight/2)-1,$setHeight),'rb');
                            }
                            $textPosition = 30;
                            $bgPosition = 'cb';
                            break;
                        case 3:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($setArr[$j],($setWeight/3)-1,$setHeight),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],($setWeight/3)-1,$setHeight),'cc');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],($setWeight/3)-1,$setHeight),'rt');
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 4:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-1)),"rt");
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'lb');
                            }  else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-1)),'rb');
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        case 5:
                            $padding = 1;
                            // $w = array();
                            // $l = array_rand($RanChoose);
                            // $getChoose = $RanChoose[$l];
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-$padding)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/2)-1),(($setHeight/2)-$padding)),'rt');
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'lb');
                            }  else if($j==3) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'cb');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-$padding)),'rb');
                            }
                            $textPosition = 38;
                            $bgPosition = 'cb';
                            break;
                        case 6:
                            if($j==0) {
                                $setThumb = $this->mergeImages('',$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'lt');
                            } else if($j==1) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'ct');
                            } else if($j==2) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'rt');
                            } else if($j==3) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'lb');
                            } else if($j==4) {
                                $setThumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'cb');
                            } else {
                                $thumb = $this->mergeImages($setThumb,$this->crop_image($setArr[$j],(($setWeight/3)-1),(($setHeight/2)-1)),'rb');
                            }
                            $textPosition = 40;
                            $bgPosition = 'cb';
                            break;
                        default:
                            # code...
                            break;
                    }
                    
                }
            }
            if(!empty($thumb)) {
                if($label == 'lotto') {
                    $thumb = $this->watermarktextAndLogo($thumb,$bgPosition,$textPosition,$btnplayer,$imagetext);
                }
            }
        }
        return @$thumb;
    }

    /**
    ct = center top
    cc = center center
    lt = left top
    rt = right top
    lb = left bottom
    rb = right bottom
    cb = center bottom
    */
    public function mergeImages($file_a='',$file_b,$position,$padding=0,$width = 1200,$height = 635,$watermarks='')
    {
        if(empty($file_a)) {
            $file_title = strtotime('now');
            $file_title = $file_title.(rand(100,10000)).'.jpg';
            $file_a = FCPATH . 'uploads/image/'.$file_title;
            if(!empty($watermarks)) {
                $im = imagecreatefromstring( file_get_contents($watermarks) );
            } else {
                $im = imagecreatefromstring( file_get_contents( FCPATH . 'uploads/image/watermark/bg_lotto.jpg' ) );
            }
            
            imagejpeg( $im, $file_a); // adjust format as needed
            imagedestroy( $im );
        }
        $this->load->library('ChipVNl');
        \ChipVN\Loader::registerAutoLoad();
        \ChipVN\Image::watermark($file_a, $file_b, $position,$padding);
        @unlink($file_b);
        return $file_a;
    }

    public function watermarktextAndLogo($file_path='',$position,$textPosition,$btnplayer='',$imagetext='',$setdate='',$setTitle='')
    {
        $this->load->library('ChipVNl');
        \ChipVN\Loader::registerAutoLoad();
        if(!empty($imagetext)) {
            $mydir = FCPATH . 'uploads/image/watermark/randtext'; 
            $myfiles = array_diff(scandir($mydir), array('.', '..')); 
            $k = array_rand($myfiles);
            $textImage = $myfiles[$k];
            $setTextImage= $mydir.'/'.$textImage;
            \ChipVN\Image::watermark($file_path, $setTextImage, 'lt'); 
        }
        
        list($width, $height, $type, $attr) = getimagesize( $file_path );


        $day = date('d');
        $m = date('m');
        $y = date('Y');
        $timestamp = time();
        $date = '';
        if($day>=1 && $day<16) {
            $date = '16'.'/'.$m .'/'.(date('Y', $timestamp)+543);
        } else if($day>16 && $day<=31) {
            $date = '1/'.date('m',strtotime('first day of +1 month')) .'/'.(date('Y', $timestamp)+543);
        }

        $textColors = array(
            'y'=>array(255,255,0),
            //'yb'=>array(255,255,0),
            //'r'=>array(255,0,0),
            //'w'=>array(255,255,255),
            
        );
        $c = array_rand($textColors);
        $cArr = $textColors[$c];
        if($c == 'y') {
            $backColor = array(255,0,0);
        }
        if($c == 'r') {
            $backColor = array(255,255,0);
        }
        if($c == 'w') {
            $backColor = array(0,0,0);
        }
        if($c == 'yb') {
            $backColor = array(0,0,0);
        }
        if(!empty($date) && !empty($setdate)) {
            $bg= FCPATH . 'uploads/image/watermark/bg_black2.png';
            \ChipVN\Image::watermark($file_path, $bg, $position);
            // $bg= FCPATH . 'uploads/image/watermark/bg_a.png';
            $imagetobewatermark= imagecreatefromstring( file_get_contents( $file_path ) );

            $watermarktext="แนวทาง " .$date;
            $font= FCPATH . 'uploads/image/watermark/font/thai_c.ttf';
            $fontsize="70";
            $bbox = imagettfbbox($fontsize, 0, $font, $watermarktext);
            if($c == 'y' || $c == 'r') {
                $x = $bbox[0] + (imagesx($imagetobewatermark) / 2) - ($bbox[4] / 2) + 10;
                $y = $bbox[1] + (imagesy($imagetobewatermark) - $textPosition) - ($bbox[5] / 2) - 5;
                $white = imagecolorallocate($imagetobewatermark, $backColor[0], $backColor[1], $backColor[2]);
                imagettftext($imagetobewatermark, $fontsize, 0, $x, $y, $white, $font, $watermarktext);
                imagejpeg( $imagetobewatermark, $file_path);
                imagedestroy($imagetobewatermark);
            }
            $imagetobewatermark= imagecreatefromstring( file_get_contents( $file_path ) );
            $x = $bbox[0] + (imagesx($imagetobewatermark) / 2) - ($bbox[4] / 2) + 10 - 3;
            $y = $bbox[1] + (imagesy($imagetobewatermark) - $textPosition) - ($bbox[5] / 2) - 5 - 2;
            $white = imagecolorallocate($imagetobewatermark, $cArr[0], $cArr[1], $cArr[2]);
            imagettftext($imagetobewatermark, $fontsize, 0, $x, $y, $white, $font, $watermarktext);
            imagejpeg( $imagetobewatermark, $file_path);
            imagedestroy($imagetobewatermark);
        }
        if(!empty($setTitle)) {
            $countTitle = $this->utf8_strlen($setTitle);
            $setTitle = str_replace('​', '', $setTitle);
            $setTitle = trim($setTitle);
            echo '<br/>count text ='.$countTitle.'<br/>';
            $line_height = 90;
            if($countTitle>10) {
                echo 'set Title Case:1<br/>';
                $fontsize="50";
                if($countTitle<50) {
                    $text = wordwrap($setTitle, ($width/18));
                }
                if($countTitle>50) {
                    $text = wordwrap($setTitle, ($width/13));
                }
                if($countTitle>69) {
                    $text = wordwrap($setTitle, ($width/11));
                }
                $lines = explode("\n", $text);
                $textPosition = 500;
                if(count($lines)==2) {
                    $bg= FCPATH . 'uploads/image/watermark/bg_black1.png';
                    $fontsize="50";
                    $line_height = 90;
                    $textPosition = 420;
                } else if(count($lines)==3) {
                    $bg= FCPATH . 'uploads/image/watermark/bg_black.png';
                    $line_height = 80;
                    $textPosition = 320;
                } else if(count($lines)==4) {
                    $bg= FCPATH . 'uploads/image/watermark/bg_black.png';
                    $line_height = 90;
                    $textPosition = 200;
                }

                $bg= FCPATH . 'uploads/image/watermark/bg_black.png';
                \ChipVN\Image::watermark($file_path, $bg, $position);
                //$imagetobewatermark= imagecreatefromstring( file_get_contents( $file_path ) );
                $watermarktext=$setTitle;
                $font= FCPATH . 'uploads/image/watermark/font/thai_d.ttf';
                $imagetobewatermark= imagecreatefromstring( file_get_contents( $file_path ) );
                $color1 = imagecolorallocate($imagetobewatermark, 255, 255, 0);
                $color2 = imagecolorallocate($imagetobewatermark, 255, 0, 0);
                $i = $line_height;
                $c=0;
                foreach($lines as $line){
                    $c++;
                    if(count($lines)==3) {
                        $fontsize="45";
                        $bg= FCPATH . 'uploads/image/watermark/bg_black.png';
                    }
                    if(count($lines)==2) {
                        $bg= FCPATH . 'uploads/image/watermark/bg_black1.png';
                        if($countTitle>69) {
                            if($c==1) {
                                $fontsize="40";
                            }
                            if($c==2) {
                                $fontsize="50";
                            }
                        } else if($countTitle>50) {
                            if($c==1) {
                                $fontsize="60";
                            }
                            if($c==2) {
                                $fontsize="50";
                            }
                        } else if($countTitle>25) {
                            if($c==1) {
                                $fontsize="70";
                            }
                            if($c==2) {
                                $fontsize="50";
                            }
                        }
                    }
                    echo $fontsize.' font size<br/>';
                    $bbox = imagettfbbox($fontsize, 0, $font, trim($line));
                    $x = $bbox[0] + (imagesx($imagetobewatermark) / 2) - ($bbox[4] / 2) + 10 - 3;
                    $y = $bbox[1] + (imagesy($imagetobewatermark) - $textPosition) - ($bbox[5] / 2) - 5 - 2;
                    if(count($lines)==1) {
                        imagettftext($imagetobewatermark, $fontsize, 0, $x, ($textPosition+$i), $color1, $font, trim($line));
                    }  else {
                        if($c != count($lines)) {
                            imagettftext($imagetobewatermark, $fontsize, 0, $x, ($textPosition+$i), $color1, $font, trim($line));
                        } else {
                            imagettftext($imagetobewatermark, $fontsize, 0, $x, ($textPosition+$i), $color2, $font, trim($line));
                        }
                    }
                    $i += $line_height;
                }
                imagejpeg( $imagetobewatermark, $file_path);
                imagedestroy($imagetobewatermark);
            } else {
                echo 'set Title Case:2<br/>';
                $textPosition = 200;
                $fontsize="50";
                $bg= FCPATH . 'uploads/image/watermark/bg_black1.png';
                \ChipVN\Image::watermark($file_path, $bg, 'cb');
                $watermarktext=$setTitle;
                $font= FCPATH . 'uploads/image/watermark/font/thai_d.ttf';
                $bbox = imagettfbbox($fontsize, 0, $font, $watermarktext);
                $imagetobewatermark= imagecreatefromstring( file_get_contents( $file_path ) );
                $x = $bbox[0] + (imagesx($imagetobewatermark) / 2) - ($bbox[4] / 2) + 10 - 3;
                $y = $bbox[1] + (imagesy($imagetobewatermark) - $textPosition) - ($bbox[5] / 2) - 5 - 2;
                $white = imagecolorallocate($imagetobewatermark, $cArr[0], $cArr[1], $cArr[2]);
                imagettftext($imagetobewatermark, $fontsize, 0, $x, $y, $white, $font, $watermarktext);
                imagejpeg( $imagetobewatermark, $file_path);
                imagedestroy($imagetobewatermark);
            } 
        }
        return $file_path;
    }
    /*
    Download Youtube Video from y2mate
    */
    public function youtube_download($url='')
    {
        //@$this->load->library('html_dom');
        // $datas = array(
        //     'url' => $url,
        //     'q_auto' => 1,
        //     'ajax' => 1,
        // );
        // $options = array(
        //     'http' => array(
        //         'header' => "User-Agent:MyAgent/1.0\r\n", 
        //         'method' => 'POST', 
        //         'content' => http_build_query($datas),
        //     ),
        // );
        // $context = stream_context_create($options);
        // return @file_get_html('https://www.y2mate.com/mates/analyze/ajax', false, $context);
        $url = 'https://8downloader.com/download?v='.urlencode($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }    
    /* returns the shortened url */
    function get_bitly_short_url($url, $login, $appkey, $format = 'txt') {
        $connectURL = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode ( $url ) . '&format=' . $format;
        return $this->curl_get_result ( $connectURL );
    }

    /* returns a result form url */
    function curl_get_result($url) {
        $ch = curl_init ();
        $timeout = 5;
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        $data = curl_exec ( $ch );
        curl_close ( $ch );
        return $data;
    }
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    function url_file_exists($url){
       $headers=get_headers($url);
       return stripos($headers[0],"200 OK")?true:false;
    }
    public function downloadFileFromUrl($url='',$saveTo)
    {
        $url = strtok($url, "?");
        $saveTo = strtok($saveTo, "?");
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $content = @file_get_contents($url, false, stream_context_create($arrContextOptions));
        if(!empty($content)) {
            $fp = fopen($saveTo, "w");
            fwrite($fp, $content);
            fclose($fp);
            return $saveTo;
        } else {
            return false;
        }
    }
    function get_remote_file_info($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        $data = curl_exec($ch);
        $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'fileExists' => (int) $httpResponseCode == 200,
            'fileSize' => (int) $fileSize
        ];
    }    
    function getActionPost($callback = false)
    {
        $log_id = $this->session->userdata ( 'user_id' );
        $sid = $this->session->userdata ( 'sid' );
        $whereShowAuto = array(
            'c_name'      => 'autopost',
            'c_key'     => $log_id,
        );
        $autoData = $this->Mod_general->select('au_config', '*', $whereShowAuto);
        if(!empty($autoData[0])) {
            return json_decode($autoData[0]->c_value);
        } else {
            return false;
        }
    }
    function utf8_strlen($s) {
        $c = strlen($s); $l = 0;
        for ($i = 0; $i < $c; ++$i)
        if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
        return $l;
    } 
    function getMBStrSplit($string, $split_length = 1){
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8'); 
        
        $split_length = ($split_length <= 0) ? 1 : $split_length;
        $mb_strlen = mb_strlen($string, 'utf-8');
        $array = array();
        $i = 0; 
        
        while($i < $mb_strlen)
        {
            $array[] = mb_substr($string, $i, $split_length);
            $i = $i+$split_length;
        }
        
        return $array;
    }
    function thai_date_short_number($time){   // 19-12-56 
        $thai_date_return = date("d",$time);   
        $thai_date_return.="/".date("m",$time);   
        $thai_date_return.= "/".substr((date("Y",$time)+543),-2);   
        return $thai_date_return;   
    }
}
