<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'app_controller.php';

class Main extends App_controller
{

    function __construct()
    {
       parent::__construct();
    }

    /**
     */
    public function index()
    {

        try {

            
            $data['title'] = 'Sửa, lắp ráp, vệ sinh máy lanh, tủ lạnh, điện lạnh tại tpHCM';
            $data['keywords'] = 'Sửa, lắp ráp, vệ sinh máy lanh, tủ lạnh, điện lạnh, máy điều hòa panasonic, aqua, toshiba, Daikin tại nhà, uy tín, giá rẻ tại tpHCM';
            $data['description'] = 'Chuyên sửa, lắp ráp, vệ sinh máy lanh, tủ lạnh, điện lạnh, máy điều hòa panasonic, aqua, toshiba, Daikin tại nhà, uy tín, giá rẻ tại tpHCM';
            
            // Show view
            $this->load->view('header', $data);
            $this->load->view('main', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {


        }
    }
	public function services()
    {

        try {

            
            $data['title'] = '10 Dịch vụ sửa máy lanh, điện lạnh uy tín mà bạn không thể bỏ qua tại tpHCM';
            $data['keywords'] = 'Dịch vụ sửa chữa, lắp ráp, vệ sinh máy lanh, tủ lạnh, điện lạnh, máy điều hòa panasonic, aqua, toshiba, Daikin tại nhà, uy tín, giá rẻ tại tpHCM';
            $data['description'] = 'Dịch vụ sửa chữa, lắp ráp, vệ sinh máy lanh, tủ lạnh, điện lạnh, máy điều hòa panasonic, aqua, toshiba, Daikin tại nhà, uy tín, giá rẻ tại tpHCM';
            
            // Show view
            $this->load->view('header', $data);
            $this->load->view('main', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {


        }
    }

    /*
    Get product by menu
    */
    public function product_by_menu()
    {

        try {

            $data = [];
            $data['is_mobile'] = $this->isMobile();
            $url_parent_menu = $this->uri->segment(1);
            $url_producer = $this->uri->segment(2);

            $this->load->model("parent_menu_model");
            $this->load->model("producer_model");
            $this->load->model("type_product_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");

            //GET MENU PARENT
            $params = [
                'limit' => [15, 0],
                'active' => 1
            ];
            $parent_menu = $this->parent_menu_model->get($params);

            foreach ($parent_menu as $k => $object) {

                $params['parent_id'] = $object->id;
                $child_menu = $this->producer_model->get($params);
                $parent_menu[$k]->child_menu = $child_menu;

            }
            $data['parent_menu'] = $parent_menu;

            // GET DATA PARENT MENU BY URL
            $parent_menu_item = $this->parent_menu_model->get(
                ['url' => $url_parent_menu]
            );
            // Check data rediect 404
            if (count($parent_menu_item) < 1) {

                $this->not_found();
                return false;
            }

            $producer_item = $this->producer_model->get([
                'url' => $url_producer,
                'parent_id' => $parent_menu_item[0]->id
                ]);

            // Check data rediect 404
            if (count($producer_item) < 1) {

                $this->not_found();
                return false;
            }

            $type_product = $this->type_product_model->get([
                'pror_id' => $producer_item[0]->id
            ]);

            // Get product by ID
            $params = [];
            $params['parent_id'] = $parent_menu_item[0]->id;
            $params['pror_id'] = $producer_item[0]->id;
            $params['order_by'] = ['id' => 'desc'];
            $data_product = $this->product_model->get($params);
            // Check data rediect 404
            if (count($data_product) < 1) {

                $this->not_found();
                return false;
            }

            // Get img for product
            foreach ($data_product as $k => $ob) {

                $params = [];
                $params['product_id'] = $ob->id;
                $data_img_product = $this->img_product_model->get($params);
                $data_product[$k]->img_product = $data_img_product;
            }

            $data['title'] = $producer_item[0]->title != '' ? $producer_item[0]->title: $producer_item[0]->name;
            $data['keywords'] = $producer_item[0]->des;
            $data['description'] = $producer_item[0]->des;

            $data['pror_id'] = $producer_item[0]->id;
            $data['type_product'] = $type_product;
            $data['search_str'] = $producer_item[0];
            $data['session'] = $this->sessionData;
            $data['list_product'] = $data_product;
            $this->load->view('header', $data);
            $this->load->view('product_by_menu', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {


        }
    }

    /*
	Show product detail OR get product by parent menu
	*/
    public function detail()
    {

        try {

            $data = [];
            $data['is_mobile'] = $this->isMobile();
            $url = $this->uri->segment(1);

            $data['session'] = $this->sessionData;
            $this->load->model("producer_model");
            $this->load->model("parent_menu_model");
            $this->load->model("product_model");
            $this->load->model("img_product_model");
            $this->load->model("type_product_model");

            //GET MENU PARENT
            $params = [
                'limit' => [15, 0],
                'active' => 1
            ];
            $parent_menu = $this->parent_menu_model->get($params);

            foreach ($parent_menu as $k => $object) {

                $params['parent_id'] = $object->id;
                $child_menu = $this->producer_model->get($params);
                $parent_menu[$k]->child_menu = $child_menu;

            }
            $data['parent_menu'] = $parent_menu;

            // GET PRODUCT BY PARAMS MENU
            $params = [];
            $params['url'] = $url;
            $parent_menu = $this->parent_menu_model->get($params);
            // New and Khuyến mãi
            if ($url == 'new' || $url == 'khuyen-mai') {

                // Get product by ID
                $params = [
                    'limit' => [72, 0],
                    'active' => 1
                ];

                if ($url == 'khuyen-mai') {
                    $params['sale_off'] = 1;
                    $data['search_str'] = ['name' => 'Khuyễn mãi'];
                } else if ($url == 'new') {

                    $data['search_str'] = ['name' => 'Sản phẩm mới'];
                }
                $data['search_str'] = json_decode(json_encode($data['search_str']));
                $params['order_by'] = ['id' => 'desc'];
                $data_product = $this->product_model->get($params);

                // Check data rediect 404
                if (count($data_product) < 1) {

                    $this->not_found();
                    return false;
                }

                // Get img for product
                foreach ($data_product as $k => $ob) {

                    $params = [];
                    $params['product_id'] = $ob->id;
                    $data_img_product = $this->img_product_model->get($params);
                    $data_product[$k]->img_product = $data_img_product;
                }

                $data['list_product'] = $data_product;

                $data['title'] = $data['search_str']->name;
                $data['keywords'] = $data['search_str']->name;
                $data['description'] = $data['search_str']->name;

                $this->load->view('header', $data);
                $this->load->view('product_by_menu', $data);
                $this->load->view('footer', $data);

            } else if (count($parent_menu) > 0) {

                //Get search area
                $producer = $this->producer_model->get(
                    ['parent_id' => $parent_menu[0]->id]
                );
                $data['producer'] = $producer;

                // Get product by ID
                $params = [
                    'limit' => [72, 0],
                    'active' => 1
                ];
                $params['parent_id'] = $parent_menu[0]->id;
                $params['order_by'] = ['id' => 'desc'];
                $data_product = $this->product_model->get($params);

                // Check data rediect 404
                if (count($data_product) < 1) {

                    $this->not_found();
                    return false;
                }

                // Get img for product
                foreach ($data_product as $k => $ob) {

                    $params = [];
                    $params['product_id'] = $ob->id;
                    $data_img_product = $this->img_product_model->get($params);
                    $data_product[$k]->img_product = $data_img_product;
                }

                $data['search_str'] = $parent_menu[0];
                $data['list_product'] = $data_product;

                $data['title'] = $parent_menu[0]->title != '' ? $parent_menu[0]->title: $parent_menu[0]->name;
                $data['keywords'] = $parent_menu[0]->des;
                $data['description'] = $parent_menu[0]->des;
			
                $this->load->view('header', $data);
                $this->load->view('product_by_menu', $data);
                $this->load->view('footer', $data);

            } else {  // PAGE DETAIL

                // Get product by ID
                $params = [];
                $params['url'] = $url;
                $data_product = $this->product_model->get($params);
                $this->load->model("province_model");
                $this->load->model("district_model");

                // Check data rediect 404
                if (count($data_product) < 1) {

                    $this->not_found();
                    return false;

                }

                // Get img for product
                foreach ($data_product as $k => $ob) {

                    $params = [];
                    $params['product_id'] = $ob->id;
                    $data_img_product = $this->img_product_model->get($params);
                    $data_product[$k]->img_product = $data_img_product;
                }

                $params = [];
                if ($data_product[0]->parent_id != '0') {

                    $params['parent_id'] = $data_product[0]->parent_id;
                    $data['parent_menu_item'] = $this->parent_menu_model->get(['id' => $data_product[0]->parent_id])[0];
                }

                if ($data_product[0]->tp_id != '0') {

                    $params['tp_id'] = $data_product[0]->tp_id;
                    $data['type_product_item'] = $this->type_product_model->get(['id' => $data_product[0]->tp_id])[0];
                }
                if ($data_product[0]->pror_id != '0') {

                    $params['pror_id'] = $data_product[0]->pror_id;
                    $data['producer_item'] = $this->producer_model->get(['id' => $data_product[0]->pror_id])[0];
                }

                $params['limit'] = [100, 0];
                $params['not_id'] = $data_product[0]->id;

                $data['product_rela'] = $this->product_model->get($params);
                $data['product_detail'] = $data_product[0];
                // Get default is HCM
                $data['province'] = $this->province_model->get(['limit' => [10000, 0]]);
                $data['district'] = $this->district_model->get(['limit' => [10000, 0], 'provinceid' => 79]);

                $data['title'] = $data['product_detail']->name;
                $data['keywords'] = $data['product_detail']->s_content;
                $data['description'] = $data['product_detail']->s_content;

                $this->load->view('header', $data);
                $this->load->view('detail', $data);
                $this->load->view('footer', $data);
            }

        } catch (Exception  $err) {

            header('Location: ' . base_url() . 'not-found');
        }
    }

    /*
	Show product detail OR get product by parent menu
	*/
    public function checkout()
    {

        try {
            $data['is_mobile'] = $this->isMobile();
            $this->load->model("producer_model");
            $this->load->model("province_model");
            $this->load->model("district_model");
            $this->load->model("parent_menu_model");



            //GET MENU PARENT
            $params = [
                'limit' => [15, 0],
                'active' => 1
            ];
            $parent_menu = $this->parent_menu_model->get($params);

            foreach ($parent_menu as $k => $object) {

                $params['parent_id'] = $object->id;
                $child_menu = $this->producer_model->get($params);
                $parent_menu[$k]->child_menu = $child_menu;

            }
            $data['parent_menu'] = $parent_menu;

            $data['link'] = ['Thông tin thanh toán' => 'checkout'];
            $data['session'] = $this->sessionData;
            if (!$data['session'] || !(isset($data['session']['user_cart']) && count($data['session']['user_cart']) > 0)) {

                header('Location: ' . base_url());
            }

            $data['title'] = 'ZOZODA - Thanh toán';
            $data['keywords'] = 'Thanh toán';
            $data['description'] = 'Thanh toán';

            // Get default is HCM
            $data['province'] = $this->province_model->get(['limit' => [10000, 0]]);
            $data['district'] = $this->district_model->get(['limit' => [10000, 0], 'provinceid' => 79]);

            $this->load->view('header', $data);
            $this->load->view('checkout', $data);
            $this->load->view('footer', $data);


        } catch (Exception  $err) {

            header('Location: ' . base_url() . 'not-found');
        }
    }

    

    /*
	Get list news
	*/
    public function list_news()
    {

        try {

            $data = [];
            
            $this->load->model("news_model");
            $this->load->model("img_news_model");

            $page = 1;
            if($this->uri->segment(3) && !empty($this->uri->segment(3)))
            {
                $page = (int) $this->uri->segment(3);
            }
            if (!$page) {
                $page = 1;
            }

            $params_pagination['uri_segment'] = 3;
            $params['per_page'] = 20;
            $offset = ($page -1) * $params['per_page'];

            $params['limit'] = $params['per_page'];
            $params['offset'] = $offset;
            $params['order_by'] = ['id' => 'desc'];
            $list_news = $this->news_model->get($params)['result'];
            if (count($list_news) < 1) {

               $this->not_found();
                return false;
            }

            $data['breadcrumb'] = [
                ['url' => 'bai-viet', 'name' => 'Bài viết']
            ];

            $fix_url = trim($this->uri->segment(1));
            $params_pagination['per_page'] = $params['per_page'];
            $params_pagination['base_url'] = base_url().$fix_url.'/page';
            unset($params['limit']);
            unset($params['offset']);
            $params_pagination['total_rows'] = (int) $this->news_model->get($params)['num_rows'] ;
            $this->pagination($params_pagination);

            $data['title'] = 'Dụng cụ làm đồ da, vòng đeo tay, mỹ phẩm tại ZOZODA';
            $data['keywords'] = 'Bài viết về trang sức ngọc trai, vòng đeo tay gỗ trầm, túi xách da cao cấp, dụng cụ làm đồ da handmade, mỹ phẩm nhập ngoại hàn quốc';
            $data['description'] = 'Trang '.$page.' tìm hiểu dụng cụ làm đồ da handmade, đồ trang sức, vòng đeo tay, túi xách bằng da cao cấp tại tpHCM và Hà Nội';

            $data['list_news'] = $list_news;
            $this->load->view('header', $data);
            $this->load->view('list_news', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {


        }
    }

    /*
	Show news detail OR get product by parent menu
	*/
    public function news_detail()
    {

        try {

            $data = [];
            $url = $this->uri->segment(1);
            $this->load->model("news_model");
            $this->load->model("img_news_model");
          
            // Get news by ID
            $params = [];
            $params['url'] = $url;
            $data_news = $this->news_model->get($params)['result'];

            // Check data rediect 404
            if (count($data_news) < 1) {

                $this->not_found();
                return false;

            }

            // Get img
            $params = [];
            $params['news_id'] = $data_news[0]->id;
            $data_img = $this->img_news_model->get($params);
            $data_news[0]->img_news = $data_img;

            $params = [
                'limit' => 3,
                'not_id' => $data_news[0]->id,
                '<' => $data_news[0]->id,
                'order_by' => ['id' => 'desc']
            ];
            $data['news_older'] = $this->news_model->get($params)['result'];

            $data['breadcrumb'] = [
                ['url' => 'bai-viet', 'name' => 'Bài viết'],
                ['url' => 'bai-viet/' . $data_news[0]->url, 'name' => $data_news[0]->title]
            ];

            $data['news_detail'] = $data_news[0];

            $data['title'] = $data['news_detail']->title;
            $data['keywords'] =  $data['news_detail']->s_content;
            $data['description'] = $data['news_detail']->s_content;

            $this->load->view('header', $data);
            $this->load->view('news_detail', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {

            header('Location: ' . base_url() . 'not-found');
        }
    }

    public function not_found()
    {

        header('Status: 404', TRUE, 404);
        try {
    

        } catch (Exception  $err) {

        }

        $data['title'] = 'Sửa máy lanh, điện lạnh uy tín tại tpHCM - Không tìm thấy';
        $data['keywords'] = 'Không tìm thấy';
        $data['description'] = 'Không tìm thấy';
        
        $this->load->view('header', $data);
        $this->load->view('not_found', $data);
        $this->load->view('footer', $data);

    }

    public function other()
    {

        $data['is_mobile'] = $this->isMobile();
        $this->load->model("producer_model");
        $this->load->model("parent_menu_model");

        //GET MENU PARENT
        $params = [
            'limit' => [15, 0],
            'active' => 1
        ];
        $parent_menu = $this->parent_menu_model->get($params);

        foreach ($parent_menu as $k => $object) {

            $params['parent_id'] = $object->id;
            $child_menu = $this->producer_model->get($params);
            $parent_menu[$k]->child_menu = $child_menu;

        }
        $data['parent_menu'] = $parent_menu;

        $short_url = $this->uri->segment(1);
        if($short_url == 'thanh-toan') {

            $data['menu']['name'] = 'Thanh toán';
            $data['menu']['short_url'] = $short_url;
        } else if($short_url == 'gioi-thieu'){

            $data['menu']['name'] = 'Giới Thiệu Về ZOZODA';
            $data['menu']['short_url'] = $short_url;
        } else if($short_url == 'huong-dan-mua-hang'){

            $data['menu']['name'] = 'Hướng dẫn mua hàng';
            $data['menu']['short_url'] = $short_url;
        } else if($short_url == 'chinh-sach-doi-tra'){

            $data['menu']['name'] = 'Chính sách đổi trả hàng';
            $data['menu']['short_url'] = $short_url;
        }
        else if($short_url == 'ap-dung-ma-khuyen-mai'){

            $data['menu']['name'] = 'Áp dụng mã khuyến mãi';
            $data['menu']['short_url'] = $short_url;
        }
        else if($short_url == 'dai-ly'){

            $data['menu']['name'] = 'Đăng ký đại lý';
            $data['menu']['short_url'] = $short_url;
        }

        $data['breadcrumb'] = [
            ['url' => $data['menu']['short_url'], 'name' => $data['menu']['name']]
        ];

        $data['title'] = $data['menu']['name'];
        $data['keywords'] = $data['menu']['name'];
        $data['description'] = $data['menu']['name'];

        $this->load->view('header', $data);
        $this->load->view('other');
        $this->load->view('footer');
    }

    /*
	Get list news
	*/
    public function tag()
    {
        try {

            $url = $this->uri->segment(2);
		
            $data = [];
            
            $this->load->model("news_model");
            $this->load->model("img_news_model");
			$this->load->model("tags_model");

            
            // GET LIST NEWS

            $page = 1;
            if($this->uri->segment(3) && !empty($this->uri->segment(3)))
            {
                $page = (int) $this->uri->segment(3);
            }
            if (!$page) {
                $page = 1;
            }

            $params_pagination['uri_segment'] = 3;
            $params['per_page'] = 20;
            $offset = ($page -1) * $params['per_page'];

            $params['limit'] = $params['per_page'];
            $params['offset'] = $offset;
            $params['order_by'] = ['id' => 'desc'];
            $params['like_url'] = $url;
            $list_news = $this->news_model->get($params)['result'];

            if (count($list_news) < 1) {

                $this->not_found();
                return false;
            }

            $fix_url = trim($this->uri->segment(1)).'/'.$this->uri->segment(2);
            $params_pagination['per_page'] = $params['per_page'];
            $params_pagination['base_url'] = base_url().$fix_url.'/page';
            unset($params['limit']);
            unset($params['offset']);
            $params_pagination['total_rows'] = (int) $this->news_model->get($params)['num_rows'] ;
            $this->pagination($params_pagination);

            unset($params);
            $params['url'] = $url;
            $tags = $this->tags_model->get($params);
            
			$data['h1'] = $list_news[0]->title;
			 if (count($tags) > 0) {

                $data['h1'] = $tags[0]->name;
            }
		
            $data['title'] = $data['h1'];
            $data['keywords'] = $data['h1'];
            $data['description'] = $data['h1'];

  
            $data['list_news'] = $list_news;
            $this->load->view('header', $data);
            $this->load->view('tag', $data);
            $this->load->view('footer', $data);

        } catch (Exception  $err) {


        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */