<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'app_controller.php';

class Admin extends App_controller {

    // POST PRODUCT
    public function post_product() {

        try {

            $this->load->library('form_validation');
            $this->load->model("producer_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");

            $this->form_validation->set_rules('name', 'Tên', 'required|max_length[200]');
            $this->form_validation->set_rules('xuat_xu', 'Xuất xứ', 'required');
            $this->form_validation->set_rules('kg_ml', 'Dung tích', 'required');
            $this->form_validation->set_rules('price', 'Giá sp', 'required|number');
            $this->form_validation->set_rules('s_content', 'Nội dung ngắn', 'required');
            $this->form_validation->set_rules('content', 'Nội dung dài', 'required');
            $this->form_validation->set_rules('pror_id', 'Danh mục cha', 'required');
            $this->form_validation->set_rules('tp_id', 'Danh mục con', 'required');

            // EDIT
            if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                $params = ['id' => $this->uri->segment(3)];
                $data_pro = $this->product_model->get($params)[0];

                // GET IMG
                $params = ['product_id' =>$this->uri->segment(3)];
                $data_img_product = $this->img_product_model->get($params);
                $data_pro->img_product = $data_img_product;

                $data['data_pro'] = $data_pro;
            }

            $data['success'] = FALSE;
            // Validation for description and image
            if (isset($_POST) && !empty($_POST) && !($this->uri->segment(3) && is_numeric($this->uri->segment(3)))) {

                $ck_img = 0;
                $data_img = [];
                if (isset($_FILES['fileupload']['tmp_name'])) {

                    foreach ($_FILES['fileupload']['tmp_name'] as $k => $v) {

                        if (!empty($v)) {
                            ++$ck_img;
                            $data_img['tmp_name'][$k] = $v;
                            continue;
                        }
                    }
                    unset($_POST['img_des']);
                    //Check img
                    if (isset($data_img['tmp_name'])) {
                        foreach ($data_img['tmp_name'] as $k => $v) {

                            switch ($_FILES['fileupload']['type'][$k]) {

                                case 'image/jpeg';
                                    break;
                                case 'image/gif';
                                    break;
                                case 'image/png';
                                    break;
                                default:
                                    $data['error'][] = "Định dạnh file ảnh bị lỗi";
                                    break;
                            }
                        }
                    }
                }

                if($ck_img < 1){

                    $data['error'][] = 'Ảnh không được bỏ trống, ảnh được tải lên tối thiểu là 1';
                }
            }

            if ($this->form_validation->run() == FALSE || (isset($data['error']) && $data['error'] )) {

            } else {

                $_POST['url'] = $this->toURI(trim($_POST['name']));

                $_data = [
                    'name' => $_POST['name'],
                    'pror_id' => $_POST['pror_id'],
                    'tp_id' => $_POST['tp_id'],
                    'url' => $_POST['url'],
                    'price' => $_POST['price'],
                    'content' => ($_POST['content']),
                    's_content' => ($_POST['s_content']),
                    'xuat_xu' => ($_POST['xuat_xu']),
                    'kg_ml' => $_POST['kg_ml'],
                    'code' => 'CO-'.date("d").$_POST['tp_id'].$_POST['pror_id'].rand(10,100)
                ];

                if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                    $product_id = intval($this->uri->segment(3));
                    $this->product_model->update($_data, $product_id);
                    $params = ['product_id' => $product_id];
                    $this->img_product_model->delete ($params);

                } else {

                    $product_id = $this->product_model->save($_data);
                }

                foreach ($_POST['img_url'] as $k => $v) {

                    if ($v != "") {

                        $_data_img = [
                            'url' => str_replace(base_url().'public/img/product/' , '' ,$v),
                            'product_id' => (int) $product_id,

                        ];
                        $this->img_product_model->save ($_data_img);
                    }
                }

                $_POST = [];
                unset($_POST);
                $data['success'] = true;
            }

            $data['parent_menu'] = $this->producer_model->get();
            
            $this->load->view('admin/header');
            $this->load->view('admin/post_product', $data);
            $this->load->view('admin/footer');

        } catch (Exception  $err) {


        }
    }

    // LIST PRODUCT
    public function list_product() {

        try {

            $this->load->library('form_validation');
            $this->load->model("producer_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");

            $data = [];
            $this->load->view('admin/header');
            $this->load->view('admin/list_product', $data);
            $this->load->view('admin/footer');

        }catch (Exception  $err) {

        }

    }

}

