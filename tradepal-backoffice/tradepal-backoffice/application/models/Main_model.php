<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    private $_lang = NULL;
    var $can_access;
    var $can_add;
    var $can_edit;
    var $can_delete;

    function gencss() {
        $css = array(
            css('asRange.css'),
            css('bootstrap-tagsinput.css'),
            css('ion.range/ion.rangeSlider.css'),
            css('ion.range/ion.rangeSlider.skinModern.css'),
            css('slim.min.css'),
            css('flag-icon.css'),
            css('main.css')
        );
        return $css;
    }

    function genjs() {
        $js = array(
            js('form.min.js'),
            js('numeral.min.js'),
            js('locales.min.js'),
            js('jscolor.js'),
            js('jquery-asrange.min.js'),
            js('ion.rangeSlider.min.js'),
            js('slim.kickstart.min.js'),
            js('bootstrap-tagsinput.min.js'),
            js('functions.js'),
            js('main.js')
        );
        return $js;
    }

    public function set_lang() {
        $this->_lang = $this->session->userdata('lang');
    }

    public function get_lang() {
        return $this->_lang;
    }

    public function check_can_permission($class = 'main', $method = 'access') {
        /* first get user group permission */
        $this->db->trans_start();
        $this->db->select('permission_data');
        $this->db->from('admin_permission');
        $this->db->where('group_id', $this->session->userdata('scu_group_id'));
        $query = $this->db->get();
        $this->db->trans_complete();
        $result = $query->row();

        /* defined permission */
        $defined_permission = json_decode($result->permission_data, true);
        $view = explode(',', $defined_permission['view']);
        $add = explode(',', $defined_permission['add']);
        $edit = explode(',', $defined_permission['edit']);
        $delete = explode(',', $defined_permission['delete']);

        /* get permission class */
        $this->db->trans_start();
        $this->db->select('sm_id,sm_name,sm_controller');
        $this->db->from('admin_system');
        $this->db->where('sm_controller', $class);
        $query_class = $this->db->get();
        $this->db->trans_complete();
        $result_sys = $query_class->row();


        switch ($method) {
            case 'access':
                if (!in_array($result_sys->sm_id, $view)):
                    redirect(base_url('errors/permission'));
                    return false;
                else:
                    return true;
                endif;
                break;

            case 'add':
                if (!in_array($result_sys->sm_id, $add)):
                    redirect(base_url('errors/permission'));
                    return false;
                else:
                    return true;
                endif;
                break;

            case 'edit':
                if (!in_array($result_sys->sm_id, $edit)):
                    redirect(base_url('errors/permission'));
                    return false;
                else:
                    return true;
                endif;
                break;

            case 'delete':
                if (!in_array($result_sys->sm_id, $delete)):
                    redirect(base_url('errors/permission'));
                    return false;
                else:
                    return true;
                endif;
                break;

            default :
                return false;
                break;
        }
    }

    public function re_validate($required_field, $input) {
        $required_is = array();
        if (count($required_field) > 0):
            $check_point = 0;
            $data['message'] .= 'The field \'';
            foreach ($required_field as $row):
                if ($input[$row] == ''):
                    $required_is[] = $row;
                    $check_point++;
                endif;
            endforeach;
            $data['check_point'] = $check_point;
            $data['message'] .= implode(',', $required_is);
            $data['message'] .= '\' is required.';
            return $data;
        endif;
    }

    public function re_validate_files($required_field, $input) {
        $required_is = array();
        if (count($required_field) > 0):
            $check_point = 0;
            $data['message'] .= 'The files \'';
            foreach ($required_field as $row):
                if ($input[$row]['tmp_name'] == ''):
                    $required_is[] = $row;
                    $check_point++;
                endif;
            endforeach;
            $data['check_point'] = $check_point;
            $data['message'] .= implode(',', $required_is);
            $data['message'] .= '\' is required.';
            return $data;
        endif;
    }

    public function count_result($table = '', $data = '') {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($data)):
            if (is_array($data)):
                foreach ($data as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function check_recaptcha($respon = '') {
        # Google Check
        $secretKey = "6LezjSQTAAAAAGQJ8A6Klgv8h6yEC9QsDrZ6oB0r";
        $ip = $this->input->ip_address();
        $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $respon . "&remoteip=" . $ip);
        $responseKeys = @json_decode($response, true);
        return intval($responseKeys["success"]);
    }

    public function gen_forurl($name = '') {
        if ($name != ""):
            $search = array(' ', '/', '-', '_', '>', '<', '&', ';', '[', ']');
            $comp_subdomain = str_replace($search, '-', $name);
            return strtolower(mb_substr($comp_subdomain, 0, 35, 'UTF-8'));
        endif;
    }

    public function genUrl($url = '') {
        $repls = array(' ', '_', '\'', '#');
        $ret_url = trim(str_replace($repls, '-', strtolower($url)));
        return urldecode($ret_url);
    }

    public function get_allsystem($parent = '') {
        $this->db->select('*');
        $this->db->from('admin_system');
        if ($parent != "" || $parent == 0) {
            $this->db->where('sm_parent_id', $parent);
        }
        $this->db->where('sm_active', 1);
        $this->db->order_by('sm_seq', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_allsystems() {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_active', 1);
        $this->db->order_by('sm_seq', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_systeminfo($id = '') {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sumdataRepeat($table = '', $data = array()) {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($data)):
            if (is_array($data)):
                foreach ($data as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    public function getCountdata($table = '', $data = array()) {
        $this->db->select('*');
        $this->db->from($table);
        if (!empty($data)):
            if (is_array($data)):
                foreach ($data as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return $query->num_rows();
        else:
            return 0;
        endif;
    }

    public function timeago($timestamp){
  
        date_default_timezone_set("Asia/Singapore");
        $time_ago        = strtotime($timestamp);
        $current_time    = time();
        $time_difference = $current_time - $time_ago;
        $seconds         = $time_difference;
        
        $minutes = round($seconds / 60); // value 60 is seconds  
        $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
        $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
        $weeks   = round($seconds / 604800); // 7*24*60*60;  
        $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
        $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                      
        if ($seconds <= 60){
          return "เมื่อสักครู่";
        } else if ($minutes <= 60){
          if ($minutes == 1){
            return "1 นาทีที่แล้ว";
          } else {
            return "$minutes นาทีที่แล้ว";
          }
      
        } else if ($hours <= 24){
          if ($hours == 1){
            return "ชั่วโมงที่แล้ว";
          } else {
            return "$hours ชั่วโมงที่แล้ว";
          }
      
        } else if ($days <= 7){
          if ($days == 1){
            return "เมื่อวานนี้";
          } else {
            return "$days วันที่แล้ว";
          }
      
        } else if ($weeks <= 4.3){
          if ($weeks == 1){
            return "อาทิตย์ที่แล้ว";
          } else {
            return "$weeks อาทิตย์ที่แล้ว";
          }
      
        } else if ($months <= 12){
          if ($months == 1){
            return "เดือนที่แล้ว";
          } else {
            return "$months เดือนที่แล้ว";
          }
      
        } else {
          
          if ($years == 1){
            return "ปีที่แล้ว";
          } else {
            return "$years ปีที่แล้ว";
          }
        }
      }

    public function loadAjaxData($data = array()) {
        /* load lib */
        $this->load->library('List_Util', 'listutil');

        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

        // search filter by keywords
        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
        if ( ! empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (boolean)preg_grep("/$filter/i", (array)$a);
            });
            unset($datatable['query']['generalSearch']);
    
        }

        // filter by field query
        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
      
        if (is_array($query)) {
            $query = array_filter($query);
            foreach ($query as $key => $val) {
                $data = list_filter($data, [$key => $val]);
            }
        }

        $sort  = ! empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = ! empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'user_id';

        $meta    = [];
        $page    = ! empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = ! empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data); // total items in array

        // // sort
        // usort($data, function ($a, $b) use ($sort, $field) {
        //     if ( ! isset($a->$field) || ! isset($b->$field)) {
        //         return false;
        //     }

        //     if ($sort === 'asc') {
        //         return $a->$field > $b->$field ? true : false;
        //     }

        //     return $a->$field < $b->$field ? true : false;
        // });

        // $perpage 0; get all data
        if ($perpage > 0) {
            $pages  = ceil($total / $perpage); // calculate total pages
            $page   = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page   = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];


        // if selected all records enabled, provide all the ids
        if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                    'sort'  => $sort,
                    'field' => $field,
                ],
            'data' => $data,
        ];

        return json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function loadAjaxFilterData($data = array()) {
        /* load lib */
        $this->load->library('List_Util', 'listutil');
        
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);
        
        // search filter by keywords
        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
        if ( ! empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (boolean)preg_grep("/$filter/i", (array)$a);
            });
            unset($datatable['query']['generalSearch']);
            
        }
        
        $sort  = ! empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = ! empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'user_id';
        
        $meta    = [];
        $page    = ! empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = ! empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;
        
        $pages = 1;
        $total = count($data); // total items in array
        
        
        // $perpage 0; get all data
        if ($perpage > 0) {
            $pages  = ceil($total / $perpage); // calculate total pages
            $page   = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page   = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            
            $data = array_slice($data, $offset, $perpage, true);
        }
        
        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];
        
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        
        $result = [
            'meta' => $meta + [
                    'sort'  => $sort,
                    'field' => $field,
                ],
            'data' => $data,
        ];
        
        return json_encode($result, JSON_PRETTY_PRINT);
    }

   

    public function setActive($table = '', $field = '', $field_id = '', $id = '', $value = 1) {
        $data = array(
            $field => $value
        );

        $this->db->where($field_id, $id);
        $this->db->update($table, $data);
    }

    public function getMax($table = '', $field = '', $field_id = '', $id = '', $option = '') {
        $this->db->select('MAX(CAST(' . $field . ' as unsigned)) as ' . $field);
        $this->db->from($table);
        if (!empty($field_id) && !empty($id)):
            $this->db->where($field_id, $id);
        endif;
        if (!empty($option)):
            if (is_array($option)):
                foreach ($option as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        $dbs = $query->row_array();
        return $dbs;
    }

    public function getBy($table = '', $field = '', $field_id = '', $id = '', $option = '') {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where($field_id, $id);
        if (!empty($option)):
            if (is_array($option)):
                foreach ($option as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        $dbs = $query->row_array();
        return $dbs;
    }
    
    public function getByAll($table = '', $field = '', $option = '') {
        $this->db->select($field);
        $this->db->from($table);
        if (!empty($option)):
            if (is_array($option)):
                foreach ($option as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        $dbs = $query->result_array();
        return $dbs;
    }

    public function getSeq($table = '', $field = '', $field_id = '', $id = '') {
        $this->db->select_max($field);
        $this->db->from($table);
        if (!empty($field_id)):
            if (is_array($field_id)):
                foreach ($field_id as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            else:
                $this->db->where($field_id, $id);
            endif;
        endif;
        $query = $this->db->get();
        $dbs = $query->row_array();
        return $dbs;
    }

    public function getSeqinfo($table = '', $field = '', $field_id = '', $id = '', $option = '') {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where($field_id, $id);
        if (!empty($option)):
            if (is_array($option)):
                foreach ($option as $key => $rows):
                    $this->db->where($key, $rows);
                endforeach;
            endif;
        endif;
        $query = $this->db->get();
        $dbs = $query->row_array();
        return $dbs;
    }

    public function setSeq($table = '', $field = '', $direct = '', $field_id = '', $id = '', $option = '') {
        # Get Max Row
        $maxRowInt = @$this->getSeq($table, $field, $option, $id);
        $maxRow = (int) @$maxRowInt[$field];
        # Get Current Row
        $nowIDInt = @$this->getSeqinfo($table, $field, $field_id, $id, $option);
        $nowID = (int) @$nowIDInt[$field];
        # Get before Row
        $before = (int) ($nowID - 1);
        $getIDBeforeInt = @$this->getBy($table, $field_id, $field, $before, $option);
        # Set before var
        $getIDBefore = @$getIDBeforeInt[$field_id];

        # Get behind Row
        $behind = (int) ($nowID + 1);
        $getIDBehideInt = @$this->getBy($table, $field_id, $field, $behind, $option);
        # Set behide var
        $getIDBehide = @$getIDBehideInt[$field_id];

        # Make Array to text
        $arrayUpdate = '';

        # make array key for update
        if (@count($option) > 0):
            $arrayUpdate .= " AND ";
            foreach ($option as $key => $vals):
                $arrayUpdate .= "`" . $key . "` = '" . $vals . "'";
            endforeach;
        endif;

        switch ($direct) {
            case 'up':
                if (!empty($id)):
                    $this->db->query("UPDATE `" . $table . "` SET `" . $field . "` = '" . $before . "' WHERE `" . $field_id . "` = '" . $id . "'" . $arrayUpdate);
                endif;
                if (!empty($getIDBefore)):
                    $this->db->query("UPDATE `" . $table . "` SET `" . $field . "` = '" . $nowID . "' WHERE `" . $field_id . "` = '" . $getIDBefore . "'" . $arrayUpdate);
                endif;
                return true;
                break;
            case 'down':
                if (!empty($id)):
                    $this->db->query("UPDATE `" . $table . "` SET `" . $field . "` = '" . $behind . "' WHERE `" . $field_id . "` = '" . $id . "'" . $arrayUpdate);
                endif;
                if (!empty($getIDBehide)):
                    $this->db->query("UPDATE `" . $table . "` SET `" . $field . "` = '" . $nowID . "' WHERE `" . $field_id . "` = '" . $getIDBehide . "'" . $arrayUpdate);
                endif;
                return true;
                break;
            default :
                return false;
                break;
        }
    }

    public function ajaxdelete($table = '', $field = '', $id = '') {
        if ($id != '' && $table != "" && $field != ""):
            $this->db->delete($table, array($field => $id));
            return true;
        else:
            return false;
        endif;
    }

    public function getMonth($short = false) {
        date_default_timezone_set('Asia/Singapore');
        $start = 1;
        $arrays = array();
        $month = strtotime('2011-01-01');
        while ($start <= 12) {
            $months['code'] = date('m', $month);
            $months['name'] = date(($short ? "F" : "M"), $month);
            array_push($arrays, $months);
            $month = strtotime('+1 month', $month);
            $start++;
        }
        return $arrays;
    }

    public function getYears($start, $end) {
        return range($start, $end);
    }

    public function remove_dir($dir)
    {
        if(is_dir($dir))
        {
            $dir = (substr($dir, -1) != "/")? $dir."/":$dir;
            $openDir = opendir($dir);
            while($file = readdir($openDir))
            {
            if(!in_array($file, array(".", "..")))
            {
                if(!is_dir($dir.$file))
                {
                @unlink($dir.$file);
                }
                else
                {
                remove_dir($dir.$file);
                }
            }
            }
            closedir($openDir);
            @rmdir($dir);
        }
    } 

    function ks_datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
        /*
          $interval can be:
          yyyy - Number of full years
          q - Number of full quarters
          m - Number of full months
          y - Difference between day numbers
          (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
          d - Number of full days
          w - Number of full weekdays
          ww - Number of full weeks
          h - Number of full hours
          n - Number of full minutes
          s - Number of full seconds (default)
         */

        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto = strtotime($dateto, 0);
        }
        $difference = $dateto - $datefrom; // Difference in seconds

        switch ($interval) {

            case 'yyyy': // Number of full years

                $years_difference = floor($difference / 31536000);
                if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
                    $years_difference--;
                }
                if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
                    $years_difference++;
                }
                $datediff = $years_difference;
                break;

            case "q": // Number of full quarters

                $quarters_difference = floor($difference / 8035200);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }
                $quarters_difference--;
                $datediff = $quarters_difference;
                break;

            case "m": // Number of full months

                $months_difference = floor($difference / 2678400);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }
                $months_difference--;
                $datediff = $months_difference;
                break;

            case 'y': // Difference between day numbers

                $datediff = date("z", $dateto) - date("z", $datefrom);
                break;

            case "d": // Number of full days

                $datediff = floor($difference / 86400);
                break;

            case "w": // Number of full weekdays

                $days_difference = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day = date("w", $datefrom);
                $days_remainder = floor($days_difference % 7);
                $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
                if ($odd_days > 7) { // Sunday
                    $days_remainder--;
                }
                if ($odd_days > 6) { // Saturday
                    $days_remainder--;
                }
                $datediff = ($weeks_difference * 5) + $days_remainder;
                break;

            case "ww": // Number of full weeks

                $datediff = floor($difference / 604800);
                break;

            case "h": // Number of full hours

                $datediff = floor($difference / 3600);
                break;

            case "n": // Number of full minutes

                $datediff = floor($difference / 60);
                break;

            default: // Number of full seconds (default)

                $datediff = $difference;
                break;
        }

        return $datediff;
    }

    function min_datediff($strDate1, $strDate2) {
        return ceil(strtotime($strDate2) - strtotime($strDate1)) / ( 60 * 60 * 24 );  // 1 day = 60*60*24
    }

    function min_timediff($strTime1, $strTime2) {
        return ceil(strtotime($strTime2) - strtotime($strTime1)) / ( 60 * 60 ); // 1 Hour =  60*60
    }

    function min_datetimediff($strDateTime1, $strDateTime2) {
        return ceil(strtotime($strDateTime2) - strtotime($strDateTime1)) / ( 60 * 60 ); // 1 Hour =  60*60
    }

    function ezdatediff($d1, $d2) {
        return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
    }

    public function mailer($arr_email, $subject, $body, $cc = '') {
        $this->load->library('Mailer');

        # set time zone
        $timezone = "Asia/Singapore";
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set($timezone);

        $arr_email = (array) $arr_email;
        $arr_subject = $subject;
        $arr_body = $body;

        # Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        # Enable SMTP debugging
        # 0 = off (for production use)
        # 1 = client messages
        # 2 = client and server messages
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        #$mail->Host = 'smtp.gmail.com';
        #$mail->Port = 25;
        #$mail->SMTPSecure = 'tls';
        #$mail->SMTPAuth = true;
        #$mail->Username = "sittha.roj@gmail.com";
        #$mail->Password = "xxxxxxx";
        #$mail->setFrom('sittha.roj@gmail.com', 'Test');
        #$mail->addReplyTo('sittha.roj@gmail.com', 'Test');

        foreach ($arr_email as $email) {
            $mail->addAddress($email);
        }
        if ($cc != "")
            $mail->addCC($cc);
        $mail->Subject = $arr_subject;
        $mail->msgHTML($arr_body);
        #$mail->AltBody = '';
        if (!$mail->send()) {
            $resp['code'] = 1;
            $resp['text'] = $mail->ErrorInfo;
            $resp['status'] = false;
        } else {
            $resp['code'] = 0;
            $resp['text'] = 'success';
            $resp['status'] = true;
        }
        return json_encode($resp);
    }

    public function get_user_info($user_id = '') {
        $this->db->select('*');
        $this->db->from('admin_users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['fullname'];
    }

    public function get_one($table,$whereArray) {
        $obj = $this->db->where($whereArray)
            ->limit(1)
            ->get($table)
            ->row();
        return $obj;
    }

    public function get_many($table,$whereArray) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($whereArray);
        $query = $this->db->get();
        return $query->result_array();
    }

    function reverseDate($date){
        $space_array = explode(" ",$date);
        $date_array = explode("-",$space_array[0]);
        $var_year = $date_array[0]; 
        $var_month = $date_array[1]; 
        $var_day = $date_array[2]; 
        $new_date_format = "$var_day/$var_month/$var_year"; 
        return $new_date_format;
    }

    function convertDate($date){
        $date_array = explode("/",$date);
        $var_day = $date_array[0]; 
        $var_month = $date_array[1]; 
        $var_year = $date_array[2]; 
        $new_date_format = "$var_year-$var_month-$var_day"; 
        return $new_date_format;
    }

    public function get_datatable($table = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_datatablew($table = '', $where = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        ($where) ? $this->db->where($where) : '';
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable($table = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable_byid($table = '', $key = '', $id = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($key, $id);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path)) ? $path : false;
    }

    public function update_by_field($table = '', $field = '', $idfield = '', $id = '', $value = '') {
        foreach ($field as $row) {
            $arraySet[$row] = $value;
        }
        $this->db->where($idfield, $id);
        $this->db->update($table, $arraySet);
        return true;
    }
}

/* End of file home_model.php */
/* Location: ./application/models/home_model.php */