<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'app_controller.php';

class Admin extends App_controller {

    // POST PRODUCT
    public function post_product() {

        try {

            $this->load->library('form_validation');
            $this->load->model("producer_model");
            $this->load->model("parent_menu_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");

            $this->form_validation->set_rules('name', 'Tên', 'required|max_length[200]');
            $this->form_validation->set_rules('xuat_xu', 'Xuất xứ', 'required');
            $this->form_validation->set_rules('price', 'Giá sp', 'required|number');
            $this->form_validation->set_rules('s_content', 'Nội dung ngắn', 'required');
            $this->form_validation->set_rules('content', 'Nội dung dài', 'required');
            $this->form_validation->set_rules('parent_id', 'Danh mục cha', 'required');

            // EDIT
            if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                $params = ['id' => $this->uri->segment(3)];
                $data_pro = $this->product_model->get($params)[0];

                if (count($data_pro) < 1) {

                    header('Location: '.base_url().'admin/list-product');
                }

                // GET IMG
                $params = ['product_id' =>$this->uri->segment(3)];
                $data_img_product = $this->img_product_model->get($params);
                $data_pro->img_product = $data_img_product;

                $data['data_pro'] = $data_pro;
                $data['producer_menu'] = $this->producer_model->get(['parent_id'=>$data_pro->parent_id]);
                $data['type_menu'] = $this->type_product_model->get(['pror_id'=>$data_pro->pror_id]);
            }


            $data['success'] = FALSE;

            // Validation for description and image
            if (isset($_POST) && !empty($_POST) && !($this->uri->segment(3) && is_numeric($this->uri->segment(3)))) {

                $data['error'] = $this->checkValidImg($_FILES);
            }

            if ($this->form_validation->run() == FALSE || (isset($data['error']) && $data['error'] )) {


            } else {

                $_POST['url'] = $this->toURI(trim($_POST['name']));

                $arrColor = [];
                if ($_POST['color'] != '') {

                    $arrColor = explode(',', $_POST['color']);

                }
                $arrSize = [];
                if ($_POST['size'] != '') {

                    $arrSize = explode(',', $_POST['size']);

                }

                $_data = [
                    'name' => $_POST['name'],
                    'pror_id' => isset($_POST['pror_id']) ? $_POST['pror_id'] : '',
                    'colorArr' => json_encode($arrColor),
                    'sizeArr' => json_encode($arrSize),
                    'qty_entered' => $_POST['qty_entered'],
                    'parent_id' => $_POST['parent_id'],
                    'tp_id' => isset($_POST['tp_id']) ? $_POST['tp_id']:'',
                    'url' => $_POST['url'],
                    'price' => $_POST['price'],
                    'content' => ($_POST['content']),
                    'sale_off' => ($_POST['sale_off']),
                    's_content' => ($_POST['s_content']),
                    'xuat_xu' => ($_POST['xuat_xu']),
                    'kg_ml' => $_POST['kg_ml']
                ];

                if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                    $product_id = intval($this->uri->segment(3));
                    $this->product_model->update($_data, $product_id);

                } else {

                    $_data['code'] = 'CO-'.date("d").$_POST['parent_id'].rand(10,100);
                    $product_id = $this->product_model->save($_data);
                }

                $dataImg = [];
                $incre = 0;
                if (isset($_FILES['fileupload'])) {

                    $tmpArr = [];
                    foreach ($_FILES['fileupload']['tmp_name'] as $k => $v) {


                        if ($k == 0 || $k == 5 || $k == 10 || $k == 15 || $k == 20) {
                            $i = $k/5;
                            $incre = 0;
                        }

                        $tmp = isset($arrColor[$i]) ? '-'.$this->toURI($arrColor[$i]) : '';
                        $params['url'] = $_POST['url']."-".$incre.$tmp.".jpg";
                        $des = 'public/img/product/'.$params['url'];

                        if ($v != '') {
                            $this->img_product_model->delete($params);
                            $tmpUrl = $this->uploadImg($des, $v, $params['url']);

                            $tmpArr[0] = $tmpUrl;
                            $tmpArr[1] = $tmp;
                            array_push($dataImg, $tmpArr);
                        }

                        $incre ++;
                    }
                }

                foreach ($dataImg as $k => $v) {
                    
                    if ($v != "") {

                        $_data_img = [
                            'url' => $v[0],
                            'color' => $v[1],
                            'product_id' => (int) $product_id,

                        ];
                        $this->img_product_model->save ($_data_img);
                    }
                }
                $_POST = [];
                unset($_POST);

                // GOTO LIST
                if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                     header('Location: '.base_url().'admin/list-product');
                }

                $data['success'] = true;
            }

            $data['parent_menu'] = $this->parent_menu_model->get();
            
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

            $params['order_by'] = ['id' => 'desc'];
            $product = $this->product_model->get ($params);

            $data['product'] = $product;
            $this->load->view('admin/header');
            $this->load->view('admin/list_product', $data);
            $this->load->view('admin/footer');

        }catch (Exception  $err) {

        }

    }

    // LIST PRODUCT
    public function list_orders() {

        try {

            $this->load->library('form_validation');
            $this->load->model("producer_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");
            $this->load->model("orders_model");

            $params['order_by'] = ['id' => 'desc'];
            $orders = $this->orders_model->get ($params);

            $data['product'] = $orders;
            $this->load->view('admin/header');
            $this->load->view('admin/list_order', $data);
            $this->load->view('admin/footer');

        }catch (Exception  $err) {

        }

    }

    // LIST PRODUCT
    public function order() {

        try {

            $this->load->library('form_validation');
            $this->load->model("producer_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("province_model");
            $this->load->model("img_product_model");
            $this->load->model("orders_model");
            $this->load->model("district_model");

            $params['order_by'] = ['id' => 'desc'];
            $params['id'] = intval($this->uri->segment(3));
            $orders = $this->orders_model->get ($params)[0];

            $orders->province = $this->province_model->get(['id'=>$orders->provinceid])[0];
            $orders->district = $this->district_model->get(['id'=>$orders->district_id])[0];

            $tmp = json_decode($orders->item);
            foreach ($tmp as $k => $v) {

                $item = $this->product_model->get(['id'=>$v->id])[0];
                $tmp[$k]->name = $item->name;
                $tmp[$k]->price_origin = $item->price;
                $tmp[$k]->sale_off = $item->sale_off;
                $tmp[$k]->img_url = $item->img_url;
                $tmp[$k]->type = isset($tmp[0]->type) ? $tmp[0]->type: '';
                $tmp[$k]->xuat_xu = $item->xuat_xu;

            }

            $orders->item = $tmp;
            $data['order'] = $orders;
            $this->load->view('admin/header');
            $this->load->view('admin/order', $data);
            $this->load->view('admin/footer');

        }catch (Exception  $err) {

        }

    }

    // POST NEWS
    public function post_news() {

        try {

            $this->load->library('form_validation');
            $this->load->model("news_model");
            $this->load->model("tags_model");
            $this->load->model("img_news_model");

            $this->form_validation->set_rules('title', 'Tên bài viết', 'required|max_length[200]');
            $this->form_validation->set_rules('s_content', 'Nội dung ngắn', 'required');
            $this->form_validation->set_rules('tags', 'Tags', 'required');
            $this->form_validation->set_rules('content', 'Nội dung dài', 'required');

            // EDIT
            if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                $params = ['id' => $this->uri->segment(3)];
                $data_news = $this->news_model->get($params)['result'][0];

			
			/*
                if (count($data_news) < 1) {

                    header('Location: '.base_url().'admin/list-news');
                }
*/
                // GET IMG
                $params = ['news_id' =>$this->uri->segment(3)];
                $data_img_news = $this->img_news_model->get($params);
                $data_news->img_product = $data_img_news;

                $data['data_pro'] = $data_news;
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

                $_POST['url'] = $this->toURI(trim($_POST['title']));
                $tmpTags = explode(',', $_POST['tags']);

                $arrTags = [];
                foreach ($tmpTags as $k => $v) {

                   array_push($arrTags, $this->toURI(trim($v)).','.trim($v));
                    $tmpSave = [
                        'name'=>trim($v),
                        'url' => $this->toURI(trim($v))
                    ];
                    $this->tags_model->save($tmpSave);

                }

                $_data = [
                    'title' => $_POST['title'],
                    'url' => trim($_POST['url']),
                    'content' => ($_POST['content']),
                    's_content' => ($_POST['s_content']),
                    'created_at' => date("Y-m-d H:i:s"),
                    'tags' => json_encode($arrTags),
                ];

                if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                    $news_id = intval($this->uri->segment(3));
                    $this->news_model->update($_data, $news_id);
                    $params = ['news_id' => $news_id];
                    $this->img_news_model->delete ($params);

                } else {

                    $news_id = $this->news_model->save($_data);
                }

                foreach ($_POST['img_url'] as $k => $v) {

                    if ($v != "") {

                        $_data_img = [
                            'url' => str_replace(base_url().'public/img/news/' , '' ,$v),
                            'news_id' => (int) $news_id,

                        ];
                        $this->img_news_model->save ($_data_img);
                    }
                }

                $_POST = [];
                unset($_POST);
                $data['success'] = true;

                // GOTO LIST
                if ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) {

                    header('Location: '.base_url().'admin/list-news');
                }
            }

            $this->load->view('admin/header');
            $this->load->view('admin/post_news', $data);
            $this->load->view('admin/footer');

        } catch (Exception  $err) {

        }
    }

    // LIST PRODUCT
    public function list_news() {

        try {

            $this->load->model("news_model");
            $this->load->model("img_news_model");

            $params['order_by'] = ['id' => 'desc'];
            $news = $this->news_model->get ($params)['result'];

            $data['news'] = $news;
            $this->load->view('admin/header');
            $this->load->view('admin/list_news', $data);
            $this->load->view('admin/footer');

        }catch (Exception  $err) {

        }

    }

}

