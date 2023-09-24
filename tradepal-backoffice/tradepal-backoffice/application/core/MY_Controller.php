<?php



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
    var $module_config = array();
    var $required_field = array();
    var $api_master_key = 'API_KEY_SS';
    var $data;
    var $sql_details;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Singapore");
  
  
    
        # set database for dataTables
        $this->sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
            'charset' => 'utf8'
        );

        $this->benchmark->mark('api_start');
        $this->clear_cache();
        # set input data
        $this->raw_data = json_decode($this->input->raw_input_stream, true);
        $this->get_data = $this->input->get();
        $this->post_data = $this->input->post();

        # set default header
        $this->data->header = 200;
        $this->data->status = 1;
        $this->data->message = '';
        $this->data->data = [];

        /* HTTP Respone code
        * 
        * 200	OK
        * 201	Created
        * 304	Not Modified
        * 400	Bad Request
        * 401	Unauthorized
        * 403	Forbidden
        * 404	Not Found
        * 422	Unprocessable Entity
        * 500	Internal Server Error
        */
    }

    public function checkPermission($activate = 1)
    {
        if (@$_REQUEST['api_key'] != $this->api_master_key) {
            $data['message'] = 'access_failed';
            $this->renderJson($data, 403);
            exit;
        }
    }

    public function checkPermissionJson($activate = 1, $rawdata = array())
    {
        if ($rawdata['api_key'] != $this->api_master_key && $activate == 1) {
            $data['message'] = 'access_failed';
            $this->renderJson($data, 403);
            exit;
        }
    }

    public function checkRequire($required_field, $request = 'post')
    {
        # Start loop check
        if (count($required_field) > 0) :
            $check_point = 0;
            $data['message'] .= $this->lang->line('field_required');
            foreach ($required_field as $row) :
                if ($this->input->{$request}($row) == "") :
                    $required_is[] = $row;
                    $check_point++;
                endif;
            endforeach;
            $data['message'] .= implode(',', $required_is);
            $data['message'] .= $this->lang->line('field_required_sub');
            $data['check_point'] = $check_point;

            return $data;
        endif;
    }

    public function checkRequireData($required_field, $data = array())
    {
        # Start loop check
        if (count($required_field) > 0) :
            $check_point = 0;
            $data['message'] .= $this->lang->line('field_required');
            foreach ($required_field as $row) :
                if ($data[$row] == "") :
                    $required_is[] = $row;
                    $check_point++;
                endif;
            endforeach;
            $data['message'] .= implode(',', $required_is);
            $data['message'] .= $this->lang->line('field_required_sub');
            $data['check_point'] = $check_point;

            return $data;
        endif;
    }

    public function accept_method($method = 'post')
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) == $method) {
            return true;
        } else {
            $data['error'] = 400;
            $data['code'] = 1;
            $data['message'] = 'Method not allow.';
            echo json_encode($data);
            die;
        }
    }

    function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function crop_upload($upload, $folder = '/../uploads')
    {
        # Slim Upload
        $this->load->library('Slimcrop');
        $images = Slim::getImages($upload);

        # crop img
        foreach ($images as $image) {
            $files = array();
            // save output data if set
            if (isset($image['output']['data'])) {
                $name = $image['output']['name'];
                $data = $image['output']['data'];
                $data_information = Slim::saveFile($data, $name, dirname($_SERVER["SCRIPT_FILENAME"]) . $folder);
            }
        }
        return $data_information;
    }

    public function uploads($upload, $folder = '/uploads', $in_size = 1024, $in_width = 100, $in_height = 100, $img = false, $type = '', $encrypt = true)
    {
        /* Start Upload */
        $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]) . '/' . $folder;
        if ($type) :
            $config['allowed_types'] = $type;
        else :
            $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|mpg|doc|docx';
        endif;
        $config['max_size'] = $in_size;
        $config['encrypt_name'] = $encrypt;
        $config['overwrite'] = true;
        if ($img == true) :
            $config['max_width'] = $in_width;
            $config['max_height'] = $in_height;
        endif;
        # load lib upload
        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($upload)) :
            $data = array('upload_code' => 1, 'upload_data' => $this->upload->display_errors());
            return $data;
        else :
            $data = array('upload_code' => 0, 'upload_data' => $this->upload->data());
            return $data;
        endif;
    }

    public function renderJson($data = array(), $http = 200)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        # check data
        (is_object($data) ? $data = (array) $data : '');
        # End API Response time
        $this->benchmark->mark('api_end');
        $data['response_time'] = $this->benchmark->elapsed_time('api_start', 'api_end');
        $data['message'] = @strip_tags($data['message']);
        $data['data_request'] = array_merge(@$_REQUEST, json_decode($this->input->raw_input_stream, true));
//        unset($data['data_request']['Password']);
//        unset($data['data_request']['VerifyToken']);

        $data = $this->replace_null_with_empty_string($data);

        $this->output->set_status_header($http)
            ->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT')
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
            ->set_header('Cache-Control: post-check=0, pre-check=0')
            ->set_header('Pragma: no-cache')
            ->set_content_type('application/json', 'UTF-8')
            ->set_output(json_encode($data));
    }

    public function get_now()
    {
        return date('Y-m-d H:i:s');
    }

    function replace_null_with_empty_string($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = $this->replace_null_with_empty_string($value);
            else {
                if (is_null($value))
                    $array[$key] = "";
            }
        }
        return $array;
    }
}
