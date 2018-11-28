<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        foreach ($_POST as $k => $v){

            if (!is_array($v)) {

                $_POST[$k] = trim(htmlspecialchars($v));
            }

        }
    }

    function replace_accent($str)
    {
        $encode = mb_detect_encoding($str);
        $str = mb_convert_encoding($str, "utf-8", $encode);
        $str = strtolower ($str);
        $str= preg_replace('/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/i',"a", $str);
        $str= preg_replace('/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/i',"e", $str);
        $str= preg_replace('/ì|í|ị|ỉ|ĩ/i',"i", $str);
        $str= preg_replace('/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/i',"o", $str);
        $str= preg_replace('/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/i',"u", $str);
        $str= preg_replace('/ỳ|ý|ỵ|ỷ|ỹ/i',"y", $str);
        $str= preg_replace('/đ/i',"d", $str);
        $str= preg_replace('/Đ/i',"d", $str);
        $str= preg_replace('/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\' | |\"|\&|\#|\[|\]|~|$|_/i',"-", $str);
        $str= preg_replace('/-+-/i',"-", $str);
        $str= preg_replace('/^\-+|\-+$/i',"-", $str);

        return $str;
    }
    function toURI($str, $replace = array(), $delimiter = '-')
    {
        if(!empty($replace))
        {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = $this->replace_accent($str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    function checkValidImg($files) {
        $ck_img = 0;
        $data_img = [];
        $data = [];
        if (isset($files['fileupload']['tmp_name'])) {

            foreach ($files['fileupload']['tmp_name'] as $k => $v) {

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

                    switch ($files['fileupload']['type'][$k]) {

                        case 'image/jpeg';
                            break;
                        case 'image/gif';
                            break;
                        case 'image/png';
                            break;
                        default:
                            $data[] = "Định dạnh file ảnh bị lỗi";
                            break;
                    }
                }
            }
        }

        if($ck_img < 1){

            $data[] = 'Ảnh không được bỏ trống, ảnh được tải lên tối thiểu là 1';
        }

        return $data;
    }

    public function uploadImg($des, $v, $url)
    {

        if (file_exists($des) && $v != '') {

            unlink($des);
        }

        if ($v != '') {

            if (move_uploaded_file($v, $des)) {

                return $url;
            }
        }
    }

    function pagination($params = []) {

        $this->load->library('pagination');

        $config['use_page_numbers'] = TRUE;
        // $config['prefix'] = 'page-';
        $config['full_tag_open'] = '<ul class = "pagination-m">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";

        $config['last_link'] = 'Last';
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";

        $config["next_link"] = "Next";
        $config["next_tag_open"] = "<li>";
        $config["next_tag_close"] = "</li>";

        $config["prev_link"] = "Prev";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";

        $config["cur_tag_open"] = "<li class='current'>";
        $config["cur_tag_close"] = '</li>';

        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = '</li>';

        $config["num_links"] = 2;
        $config['uri_segment'] = $params['uri_segment'];
        $config['base_url'] = $params['base_url'];
        $config['total_rows'] = $params['total_rows'];
        $config['per_page'] = $params['per_page'];

        $this->pagination->initialize($config);

    }
}
