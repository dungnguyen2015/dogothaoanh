<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'app_controller.php';

class Ajax extends App_controller {


    public function add_to_cart() {

        if (isset($_POST) && count($_POST) < 1) {

            echo "error";
            exit;
        }
        $this->load->model("product_model");
        if ($_POST['tp_id'] == '0') {
            unset($_POST['tp_id']);
        }
        if ($_POST['pror_id'] == '0') {
            unset($_POST['pror_id']);
        }
        $product_detail = $this->product_model->get($_POST);

        if (count($product_detail) < 1) {

            echo json_encode(['status' => 'error']);
            exit;
        }

        if ($product_detail[0]->sale_off > 0) {

            $price = $product_detail[0]->price - ceil (($product_detail[0]->sale_off * $product_detail[0]->price) / 100);
        } else {

            $price = ceil ($product_detail[0]->price);
        }
        
        // CHECK PRODUCT
        $user = $this->session->userdata('user');

        $color = '';
        $size = '';
        if (isset($_POST['color'])) {

            $color = $_POST['color'];
        }


        if (isset($_POST['size'])) {

            $size = $_POST['size'];
        }

        $tmpQty = $_POST['qty'];
        $key = $product_detail[0]->id.'-'.$this->toURI($color).'-'.$this->toURI($size);
        if ($user && isset($user['user_cart'])) {

            $user_cart = $user['user_cart'];
            foreach ($user_cart as $k => $v) {

                if ($k == $key) {

                    $tmpQty += $v['qty'];
                }
            }
        }

        $user_cart[$key]['url'] = $product_detail[0]->url;
        $user_cart[$key]['id'] = $product_detail[0]->id;
        $user_cart[$key]['name'] = $product_detail[0]->name;
        $user_cart[$key]['code'] = $product_detail[0]->code;
        $user_cart[$key]['price'] = $product_detail[0]->price;
        $user_cart[$key]['sale_off'] = $product_detail[0]->sale_off;
        $user_cart[$key]['xuat_xu'] = $product_detail[0]->xuat_xu;
        $user_cart[$key]['img_url'] = $_POST['img_url'];
        $user_cart[$key]['qty'] = $tmpQty;
        $user_cart[$key]['color'] = $color;
        $user_cart[$key]['size'] = $size;
        $user_cart[$key]['key'] = $key;


        if ($product_detail[0]->tp_id != 0)
            $user_cart[$key]['type'] = $product_detail[0]->type_name;
        else if ($product_detail[0]->pror_id != 0)
            $user_cart[$key]['type'] = $product_detail[0]->producer_name;
        else
            $user_cart[$key]['type'] = $product_detail[0]->parent_menu_name;

        $user['user_cart'] = $user_cart;
        $this->session->set_userdata('user', $user);

        $response['status'] = 'ok';
        $response['user_cart'] = $user['user_cart'];
        echo json_encode($response);
        exit;
    }

    // Remove item cart
    public function remove_cart_item() {

        $key = $this->uri->segment(2);
        if (isset($_POST) && count($_POST) < 1 || !isset($_POST)) {

            echo json_encode(['status' => 'error']);
            exit;
        }

        // CHECK PRODUCT
        $user = $this->session->userdata('user');

        if ($user) {

            $user_cart = $user['user_cart'];

            foreach ($user_cart as $k => $v) {

                if ($k == $key) {

                    unset($user_cart[$k]);
                }
            }

            $user['user_cart'] = $user_cart;
        }

        $this->session->set_userdata('user', $user);
        $response['status'] = 'ok';
        $response['user_cart'] = $user['user_cart'];
        echo json_encode($response);
        exit;
    }

    // Add order
    function add_to_order() {

        if (isset($_POST) && count($_POST) < 1) {

            echo json_encode(['status' => 'error']);
            exit;
        }

        $user = $this->session->userdata('user');

        $total_item = [];
        $item = [];
        foreach ($user['user_cart'] as $k => $v) {

            $item = ['id' => $v['id'], 'qty' => $v['qty'], 'price' => $v['price'], 'type'=> $v['type']];

            if (isset($v['color'])) {

                $item['color'] = $v['color'];
            }

            if (isset($v['size'])) {

                $item['size'] = $v['size'];
            }

            array_push($total_item, $item);
        }
        $params =  [
            'order_by' => ['id' => 'desc'],
            'limit' => [1,0]
        ];
        $this->load->model("orders_model");
        $order = $this->orders_model->get($params);
        $tmp_code = 1;
        
        if (count($order) > 0) {

            $tmp_code = $order[0]->id + 1;
        }
        $params = [
            'user_name' => $_POST['user_name'],
            'phone' => $_POST['phone'],
            'item' => json_encode($total_item),
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'provinceid' => $_POST['province'],
            'district_id' => $_POST['district'],
            'code' => date("Ymd").$tmp_code,
            'created_at' => date("Y-m-d h:i:s")
        ];

        $order = $this->orders_model->save($params, true);

        // Delete SESSION
        unset($user['user_cart']);
        $this->session->set_userdata('user', $user);

        echo json_encode(['status' => 'ok', 'code' => $order->code]);
        exit;
    }

    // FAST BUY
    function fast_buy() {

        if (isset($_POST) && count($_POST) < 1) {

            echo json_encode(['status' => 'error']);
            exit;
        }
        $this->load->model("orders_model");
        $this->load->model("product_model");

        $params = ['id' => (int) $_POST['product_id']];
        $product = $this->product_model->get($params);

        if ($product[0]->sale_off > 0) {

            $priceItem = $product[0]->price - ceil (($product[0]->sale_off * $product[0]->price) / 100);
        } else {

            $priceItem = ceil ($product[0]->price);
        }

        $total_item = [];
        $item = [
            'id' => $product[0]->id,
            'qty' => $_POST['qty'],
            'price' => $priceItem
        ];

        $item['type'] = '';
        if (isset($_POST['color'])) {

            $item['color'] = $_POST['color'];
        }

        if (isset($_POST['size'])) {

            $item['size'] = $_POST['size'];
        }

        array_push($total_item, $item);

        $params =  [
            'order_by' => ['id' => 'desc'],
            'limit' => [1,0]
        ];

        $order = $this->orders_model->get($params);
        $tmp_code = 1;

        if (count($order) > 0) {

            $tmp_code = $order[0]->id + 1;
        }
        $params = [
            'user_name' => $_POST['user_name'],
            'phone' => $_POST['phone'],
            'item' => json_encode($total_item),
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'provinceid' => $_POST['province'],
            'district_id' => $_POST['district'],
            'code' => date("Ymd").$tmp_code,
            'created_at' => date("Y-m-d h:i:s")
        ];

        $order = $this->orders_model->save($params, true);

        echo json_encode(['status' => 'ok', 'code' => $order->code]);
        exit;
    }

    // GET DISTRICT
    function get_district() {

        if (isset($_POST) && count($_POST) < 1) {

            echo json_encode(['status' => 'error']);
            exit;
        }

        $this->load->model("district_model");
        $district = $this->district_model->get([

            'limit' => [10000, 0],
            'provinceid' => $_POST['provinceid']

        ]);

        echo json_encode(['status' => 'ok', 'data' => $district]);
        exit;
    }

    // GET DATA BY MENU
    function get_data_by_menu() {

        if (isset($_POST) && count($_POST) < 1) {

            echo json_encode(['status' => 'error']);
            exit;
        }

        $this->load->model("product_model");

        $response = ['status'=>'ok'];
        if(isset($_POST['type-product'])) {

            // Get product
            $data = $this->product_model->get([

                'limit' => [72, 0],
                'pror_id' => $_POST['producer_id'],
                'tp_id' => $_POST['type-product']

            ]);
            $response['data'] = $data;

        } else {

            // Get product
            $data = $this->product_model->get([

                'limit' => [72, 0],
                'pror_id' => $_POST['producer_id']

            ]);
            $response['data'] = $data;

            // Get type product
            $this->load->model("type_product_model");
            $type_product = $this->type_product_model->get([
                'pror_id' => $_POST['producer_id']
            ]);
            $response['type_product'] = $type_product;
        }

        echo json_encode($response);
        exit;
    }
}