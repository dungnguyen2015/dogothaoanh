<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'app_controller.php';

class Ajax_admin extends App_controller
{

    public function upload_image()
    {
        if(!isset($_POST) || empty($_POST)) exit;
        
        $folder = $_POST['folder'];
        $fileName = $this->toURI($_POST['name']).'-'.rand(100,900);

        $output_file = "public/img/{$folder}/".$fileName.".jpg";

        $data = explode(',', $_POST['file']);

        if(file_put_contents($output_file, base64_decode($data[1])))
          echo base_url().$output_file;
        else
            echo "";
        exit;
    }
    public function get_child_menu()
    {
        if(!isset($_POST) || empty($_POST)) exit;

        $data = [];
        if ($_POST['name'] == 'pror_id') {

            $this->load->model('type_product_model');
            $data = $this->type_product_model->get (['pror_id' => (int)$_POST['value']]);
        }

        if ($_POST['name'] == 'parent_id') {

            $this->load->model('producer_model');
            $data = $this->producer_model->get (['parent_id' => (int)$_POST['value']]);
        }

        if (count($data) < 1 ){

            echo json_encode(['status' => 'err', 'name' =>$_POST['name']]);
            exit;
        }

        echo json_encode(['status' => 'ok', 'data' => $data, 'name' =>$_POST['name'] ]);
        exit;
    }
    public function get_street()
    {
        if(!isset($_POST) || empty($_POST)) exit;

        $this->load->model('street_model');
        $data_district = $this->street_model->get_list (['district_id' => (int)$_POST['district_id'], 'w_id' => $_POST['w_id']]);

        echo json_encode($this->build_responses($data_district['result']));
        exit;
    }
    
    public function form_search(){

        if(!isset($_POST) || empty($_POST)) {

            echo "";
            exit;
        }

        $this->load->model('menu_model');
        $this->load->model('district_model');
        $this->load->model('street_model');
        $this->load->model('ward_model');

        $tmp_url = "";
        foreach ($_POST as $k => $v) {

            if ($k != 'menu' && $k != 'district' && $k != 'street' && $k != 'ward') {

                $tmp_url .="/".$v;
            }
        }

        $url = "nha-dat";
        if ((int) $_POST['menu']) {

            $data_menu = $this->menu_model->get_item (['id' => (int) $_POST['menu']]);

            if (!empty($data_menu)) {

                $url = $data_menu[0]->m_short_url;

            }
        }


        if (isset($_POST['street']) && (int) $_POST['street']) {

            $data_street = $this->street_model->get_item (['id' => (int) $_POST['street']]);
            if (!empty($data_street)) {

                $url .= "-duong-".$data_street[0]->st_short_url;

            }
        }


        if (isset($_POST['ward']) && (int) $_POST['ward']){

            $data_ward = $this->ward_model->get_item (['id' => (int) $_POST['ward']]);
            if (!empty($data_ward)) {

                $url .= "-phuong-".$data_ward[0]->w_short_url;

            }
        }

        if ((int) $_POST['district']) {

            $data_district = $this->district_model->get_item (['id' => (int) $_POST['district']]);
            if (!empty($data_district)) {

                $url .= "-".$data_district[0]->dt_short_url;

            }
        }

        $url .= $tmp_url;
        echo base_url().$url;
        exit;
    }
    public function update_user_active() {

        if(!isset($_POST) || empty($_POST)) exit;

        $this->load->model('user_model');
        $this->load->model('user_verify_model');

        if (isset($_POST['token']) && !empty($_POST['token'])) {

            $token = trim($_POST['token']);
            $user_id = (int) $this->user_verify_model->get_user_id($token)->user_id;

            $active = 0;
            if (isset($_POST['type']) && $_POST['type'] == "accept") {

                $active = 1;
                echo $this->user_model->update_active ($active, $user_id);
                exit;

            } else {

                echo $this->user_verify_model->destroy ($token);
                exit;
            }
        }
        echo "0";
        exit;
    }

    public function user_login()
    {
        if(!isset($_POST) || empty($_POST)) exit;

        $this->load->model('user_model');
        $data_user = $this->user_model->get_for_login ($_POST);

        $error = "0";
        if (empty($data_user)) {

            $error = "Email hoặc tên đăng nhập không tồn tại";
            echo $error;
            exit;
        }

        $data_user = $this->build_responses($data_user[0]);
        if ($data_user['password'] != md5(trim($_POST['password']))) {

            $error = "Password đăng nhập bị sai";
            echo $error;
            exit;
        }
        $this->session->set_userdata(['user_data' => $data_user]);
        echo $error;
        exit;

    }

    public function user_logout()
    {
        if(!isset($_POST) || empty($_POST)) exit;

        $this->session->unset_userdata('user_data');
        echo "1";
        exit;

    }

    public function build_response ($params = [], $options = [])
    {
        // Check data
        if (empty($params)) {
            return [];
        }

        return get_object_vars($params);
    }

    public function changeStateOrder()
    {
        if(!isset($_POST) || empty($_POST)) exit;

        $this->load->model('orders_model');
        $data_district = $this->orders_model->update (['state' => $_POST['state']],$_POST['order_id'] );

        if ($data_district)
        echo json_encode(['status' => 'ok', 'data' => $data_district]);
        exit;
    }

}