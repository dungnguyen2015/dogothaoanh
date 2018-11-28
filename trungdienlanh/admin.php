<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'app_controller.php';

class Admin extends App_controller
{
    protected $short_url_img = 'public/img/bds/';
    protected $short_url_img_user = 'public/img/user/';

    private $field_required = [
        'bds_name' =>'Tên',
        'price' => 'Giá',
        'city' => 'Giá',
        'district' => 'Giá',
        'menu' => 'Giá',
        'lat' => 'Giá',
        'lng' => 'Giá',
        'description'
        ];

    private $k_name = [
        'ban-nha-mat-pho',
        'ban-biet-thu',
        'ban-dat-nen-du-an',
        'ban-dat',
        'ban-nha-rieng',
        'ban-nha-mat-pho',
        'nha-dat',
        'cho-thue-can-ho-chung-cu',
        'ban-biet-thu-',
    ];

    public function bds_name_check($bds_name){

        $this->load->model("bds_model");
        $bds_item = $this->bds_model->get_item(['short_url' => toURI($bds_name)]);

        if($bds_item)
        {
            $this->form_validation->set_message('bds_name_check', 'Tên đã tồn tại, làm ơn hãy thay nó');
            return false;

        }
        foreach ($this->k_name as $v) {

            if(strpos(toURI($bds_name), $v) === 0) {

                $this->form_validation->set_message('bds_name_check', 'Trùng từ khóa, hãy thay thế nó như: Cần '.$bds_name);
                return false;

            }

        }

        return true;
    }
    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_ck_email_exist');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {

        } else {

            $this->load->model("admin_model");

            foreach ($_POST as $k => $v) {

                $_POST[$k] = htmlspecialchars($v, ENT_QUOTES);
                if ($k == 'password') {
                    $_POST[$k] = md5($_POST[$k]);
                }

            }

            $data_admin = $this->admin_model->get_item($_POST);

            if(count($data_admin) > 0) {

                $this->session->set_userdata(['admin_data' => $this->build_responses($data_admin[0])]);
                redirect("/admin/dashboard");
            }

        }
        $admin_data_session = $this->session->userdata('admin_data');

        if($admin_data_session) {

            redirect("/admin/dashboard");
        }

        $this->load->view('admin/login');

    }


    // Admin home page
    public function dashboard()
    {
        $admin_data_session = $this->session->userdata('admin_data');
        $data['admin_data_session'] = $admin_data_session;

        if (empty($admin_data_session)) {

            redirect("/admin");
        }

        $page = 1;
        foreach ($this->uri->segment_array() as $k => $v) {

            if (strpos($v, 'page-')===0) {
                $page = str_replace("page-", "", $v);
                break;
            }

        }
        $this->load->model('bds_model');

        $params['per_page'] = 15;
        $params['offset'] = ($page -1) * $params['per_page'];
        $params['limit'] = $params['per_page'];
        $params['admin'] = 1;
        $list_bds = $this->bds_model->get_list($params);

        $params['base_url'] = base_url()."trang-ca-nhan";

        unset($params['limit']);
        unset($params['offset']);
        $params['total_rows'] = (int) $this->bds_model->get_list($params)['num_rows'];
        $this->pagination($params);

        $data['list_bds'] =  $this->build_responses($list_bds['result']);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');

    }
    // Admin home page
    public function user()
    {
        $admin_data_session = $this->session->userdata('admin_data');
        $data['admin_data_session'] = $admin_data_session;


        if (empty($admin_data_session)) {

            redirect("/admin");
        }

        $page = 1;
        foreach ($this->uri->segment_array() as $k => $v) {

            if (strpos($v, 'page-')===0) {
                $page = str_replace("page-", "", $v);
                break;
            }

        }
        $this->load->model('user_model');

        $params['per_page'] = 15;
        $params['offset'] = ($page -1) * $params['per_page'];
        $params['limit'] = $params['per_page'];
        $params['admin'] = 1;
        $list_bds = $this->user_model->get_list($params);

        $params['base_url'] = base_url()."trang-ca-nhan";

        unset($params['limit']);
        unset($params['offset']);
        $params['total_rows'] = (int) $this->user_model->get_list($params)['num_rows'];
        $this->pagination($params);

        $data['list_user'] =  $this->build_responses($list_bds['result']);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('admin/footer');

    }

    // Update news bds for user
    public function update_news_bds(){

        $admin_data_session = $this->session->userdata('admin_data');
        $data['admin_data_session'] = $admin_data_session;


        if (empty($admin_data_session)) {

            redirect("/admin");
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('bds_name', 'Tên', 'required|max_length[100]');
        $this->form_validation->set_rules('price', 'Giá', 'required|numeric');
        $this->form_validation->set_rules('area', 'Diện tích', 'required|numeric');
        $this->form_validation->set_rules('sign_price', 'Ký hiệu giá', 'required');
        $this->form_validation->set_rules('sign_area', 'Ký hiệu diện tích', 'required');
        $this->form_validation->set_rules('city', 'Thành phố', 'required');
        $this->form_validation->set_rules('district', 'Quận', 'required');
        $this->form_validation->set_rules('menu', 'Danh mục', 'required');
        $this->form_validation->set_rules('lat', 'Lat', 'required|numeric');
        $this->form_validation->set_rules('lng', 'Lng', 'required|numeric');
        $this->form_validation->set_rules('description', 'Thông tin mô tả', 'required');
        $this->form_validation->set_rules('street', 'Tên đường', 'required');
        $this->form_validation->set_rules('ward', 'Tên phường', 'required');


        $data = [];
        $data['success'] = FALSE;

        $this->load->model('bds_model');
        $this->load->model('menu_model');
        $this->load->model('city_model');
        $this->load->model('district_model');
        $this->load->model('ward_model');
        $this->load->model('street_model');

        // Get ID
        $id = (int) $this->uri->segment(3);

        if ($this->form_validation->run() == FALSE || (isset($data['error']) && $data['error'] )) {

        } else {

            $_POST['short_url'] = toURI($_POST['bds_name']);
            $_POST['description'] = strip_tags($_POST['description'], '<br><p><strong><em>');

            foreach ($_POST as $k => $v) {

                $k = htmlspecialchars($k, ENT_QUOTES);
                $v = htmlspecialchars($v, ENT_QUOTES);
                $_POST[$k] = $v;
            }
            // Load database

            $this->load->model('bds_detail_model');


            $_POST['id'] = $id;
            $_POST['real_price'] = $_POST['price'];
            $_POST['price'] = $_POST['price']." ". $this->sign_price[(int) $_POST['sign_price']];
            if ((int) $_POST['sign_price'] == 2) {

                $_POST['real_price'] = (float) $_POST['price'] * $_POST['area'];
            }

            $_POST['city_id']  = (int) $_POST['city'];
            $_POST['menu_id']  = (int) $_POST['menu'];
            $_POST['ward_id']  = (int) $_POST['ward'];
            $_POST['street_id']  = (int) $_POST['street'];
            $_POST['district_id']  = (int) $_POST['district'];

            $this->bds_model->update($_POST);
            $this->bds_detail_model->update($_POST);


            unset($_POST);
            $data['success'] = true;
        }


        $item_city = $this->city_model->get_list();
        $data['city_data'] = $this->build_responses($item_city['result']);
        $item_menu = $this->menu_model->get_list();
        $data['menu_data'] = $this->build_responses($item_menu['result']);
        $data['sign_price'] = $this->sign_price;



        $data_bds = $this->bds_model->get_item(['id' => $id]);
        $data['data_bds'] = $this->build_responses($data_bds[0]);

        $price = explode(" ", $data['data_bds']['price']);
        $data['data_bds']['price'] = $price[0];
        $data['data_bds']['sign_price'] = $price[1];

        $item_district = $this->district_model->get_list (['city_id' => (int) $data['data_bds']['city_id']]);
        $data['district_data'] = $this->build_responses ($item_district['result']);

        $item_ward = $this->ward_model->get_list (['district_id' => (int) $data['data_bds']['district_id']]);
        $data['ward_data'] = $this->build_responses ($item_ward['result']);

        $item_street = $this->street_model->get_list(['district_id' => (int) $data['data_bds']['district_id']]);
        $data['street_data'] = $this->build_responses($item_street['result']);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/update_news_bds', $data);
        $this->load->view('admin/footer');

    }

    public function detail_bds()
    {

        // Load model and get data
        $this->load->model('bds_model');
        $short_url = trim($this->uri->segment(3));
        $item_bds = $this->bds_model->get_item(['short_url' => $short_url]);

        if (!$item_bds) {

            redirect('/not_found');

        } else {

            // Get data image by bds_id
            $this->load->model('image_bds_model');
            $bds_id = (int) $item_bds[0]->id;

            $image_data = $this->image_bds_model->get_item ($bds_id);
            $image_data = $this->build_responses($image_data);

            // Get data bds by district
            $params = [];
            $params['district_id'] = (int) $item_bds[0]->district_id;
            $params['menu_id'] = (int) $item_bds[0]->menu_id;
            $params['limit'] = 5;
            $params['offset'] = 0;
            $params['not_bds_id'] = (int) $item_bds[0]->id;

            $list_bds = $this->bds_model->get_list($params);

            // Assign data
            $data['item_bds'] = $this->build_responses($item_bds, ['detail' => true])[0];
            $data['item_bds']['image_data'] = $image_data;
            $data['list_bds'] =  $this->build_responses($list_bds['result']);
            unset($params['limit']);
            unset($params['offset']);
            unset($params['not_bds_id']);
            $data['num_total_bds'] = (int) $this->bds_model->get_list($params)['num_rows'];

            // Wrap head tag
            $data['head_h1'] = 'Website <h1>bất động sản </h1>(bds) No.1 VIỆT NAM';
            $data['title'] = 'Nhà đất| Mua bán nhà đất| Cho thuê nhà đất| Văn phòng';
            $data['keywords'] = 'sàn, giao, dịch, số, 1, về, bất, động, sản, tại, tp, Hồ, Chí, Minh';
            $data['description'] = 'Sàn giao dịch số 1 về bất động sản tại tp Hồ Chí Minh:  mua bán nhà đất, cho thuê nhà đất, văn phòng, căn hộ, biệt thự, chung cư';

            $this->load->view('header', $data);
            $this->load->view('admin/detail_bds_view', $data);
            $this->load->view('footer');
        }


    }

    public function ck_email_exist($email){

        $this->load->model("admin_model");

        $ck_admin_by_email = $this->admin_model->get_item(['email' => $email ]);

        if (empty($ck_admin_by_email)) {

            $this->form_validation->set_message('ck_email_exist', 'Email này không tồn tại');
            return false;
        }

        return true;

    }
    public function write_news()
    {

        $user_data_session = $this->session->userdata('user_data');
        $data['user_data_session'] = $user_data_session;

        if (empty($user_data_session) && $user_data_session['email'] == 'vandung842001@gmail.com') {

            redirect("/dang-ky-thanh-vien");
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Tiêu đề', 'required|max_length[200]');
        $this->form_validation->set_rules('content', 'Nội dung', 'required');

        $data['success'] = FALSE;

        if ($this->form_validation->run() == FALSE || (isset($data['error']) && $data['error'] )) {

        } else {

            $_POST['short_url'] = toURI($_POST['title']);

            foreach ($_POST as $k => $v) {

                if($k == "img_url") {

                    foreach($v as $k1 => $v1){
                        $k1 = htmlspecialchars($k1, ENT_QUOTES);
                        $v1 = htmlspecialchars($v1, ENT_QUOTES);
                        $_POST[$k][$k1] = $v1;
                    }

                } else {

                    $k = htmlspecialchars($k, ENT_QUOTES);
                    $v = htmlspecialchars($v, ENT_QUOTES);
                    $_POST[$k] = $v;

                }

            }

            // Load database
            $this->load->model('news_model');
            $this->load->model('image_news_model');
            $_POST['writer_id'] = (int) $user_data_session['id'];
            $news_id = $this->news_model->add($_POST);


            foreach ($_POST['img_url'] as $k => $v) {

                if (!empty($v)) {
                    $tmp_param['img_url'] = str_replace(base_url(), '', $v);
                    $tmp_param['news_id'] = $news_id;

                    $image_news_id = $this->image_news_model->add($tmp_param);
                }
            }

            unset($_POST);

            $data['success'] = true;
        }

        $this->load->view('admin/header');
        $this->load->view('admin/write_news', $data);
        $this->load->view('admin/footer');
    }

    public function register() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('u_name', 'Tên', 'required|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('full_name', 'Tên đầy đủ', 'required|max_length[100]');
        $this->form_validation->set_rules('tel', 'Số điện thoại', 'required|numeric|min_length[8]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'required');
        $this->form_validation->set_rules('gender', 'Giới tính', 'required');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');

        $user_data = $this->session->userdata('user_data');
        $data['user_data'] = $user_data;

        // Validation for description and image
        $this->load->model('user_model');

        if(isset($_POST) && !empty($_POST)) {
            if (isset($_FILES['fileupload']['tmp_name']) && !empty($_FILES['fileupload']['tmp_name'])) {

                switch ($_FILES['fileupload']['type']) {

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
            } else {
                $data['error'][] = "Bạn chưa tải ảnh đại diện";
            }

            $ck_user_by_email = $this->user_model->get_by_email($_POST['email']);
            if (!empty($ck_user_by_email)) {

                $data['error'][] = "Email này đã tồn tại";
            }
        }


        if ($this->form_validation->run() == FALSE || (isset($data['error']) && $data['error'] )) {

        } else {

            foreach ($_POST as $k => $v) {

                $k = htmlspecialchars($k, ENT_QUOTES);
                $v = htmlspecialchars($v, ENT_QUOTES);
                $_POST[$k] = $v;
            }
            $img = convert_image_user($_FILES['fileupload']['tmp_name'], 'public/img/user/');

            if ($img['success']) {

                $_POST['img_url'] = $img['img_url'];

                // Load database

                $user_id = $this->user_model->add($_POST);
                $this->load->helper('string');
                $token = random_string('alnum', 32);

                // Save user verify
                $this->load->model('user_verify_model');
                $this->user_verify_model->add(['user_id' => $user_id, 'token' => $token]);

                // Send mail
                $from = "info.sanbatdongsangiare@gmail.com";
                $to = "vandung842001@gmail.com";
                $subject = "[Sàn Bất Động Sản Giá Rẻ] Giới thiều về bạn đã hoàn thành việc đăng ký thành viên";
                $content = "------------------------------------------<br><br>";
                $content .= "Thông báo việc đăng ký thành viên<br><br>";
                $content .= "------------------------------------------<br><br>";
                $content .= "Cảm ơn bạn đã đăng ký thành viên với Sàn Bất Động Sản Giá Rẻ.<br>";
                $content .= "Xin vui lòng nhấp vào link dưới để xác nhận thông tin từ bạn. <br><br>";
                $content .= base_url() . "xac-nhan-dang-ky-thanh-vien/{$token}<br>";
                $content .= "Link trên là việc xác nhận cuối cùng của bạn, Nếu bạn muốn đăng ký hãy nhấn nút [Chấp nhận đăng ký],
                    <br>Nếu không bạn có thể hủy bỏ nó<br>";
                $content .= "Mọi thông tin cần thiết bạn có thể liên hệ trực tiếp với chúng tôi.<br><br><br>";
                $content .= "-------------------------------------------------------------<br><br>";
                $content .= "Sàn Bất Động Sản Giá Rẻ là trang bất động sản hàng đầu tại Tp.HCM. <br>";
                $content .= "Website: &nbsp;" . base_url();

                $this->send_email($from, $to, $subject, $content);
                unset($_POST);
                redirect('thong-bao-dang-ky-thanh-vien/');
            }
        }

        $this->load->view('header');
        $this->load->view('user/register', $data);
        $this->load->view('footer');
    }

    public function notice_register() {

        $this->load->view('header');
        $this->load->view('user/notice');
        $this->load->view('footer');
    }

    public function pre_register() {

        $this->load->model('user_verify_model');
        $token = $this->uri->segment(2);
        $data_token = $this->user_verify_model->get_by_token($token);

        if (empty($data_token)) {

            redirect('dang-ky-thanh-vien/');
        }


        $data = [];
        $data['token'] = $token;
        $this->load->view('header');
        $this->load->view('user/pre_register', $data);
        $this->load->view('footer');
    }

    public function build_response ($params = [], $options = [])
    {
        // Check data
        if (empty($params)) {
            return [];
        }
        if(isset($options['img_news_url'])) {

        } else {

            $params->img_url = isset($params->img_url) && !empty($params->img_url) ? $this->short_url_img.$params->img_url : '' ;
        }

        return get_object_vars($params);
    }

}