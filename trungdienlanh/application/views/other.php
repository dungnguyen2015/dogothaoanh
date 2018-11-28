<section>
    <div class="container">
        <ul class="step-buying clearfix list-inline for-desktop">
            <li class="step1">Chọn hàng online</li>
            <li class="step2">Giao hàng trong 24h</li>
            <li class="step3">Thanh toán tiện lợi</li>
            <li class="step4">Đổi trả 7 ngày</li>
        </ul>
        <div class="w-main">
            <ul class="breadcrumba list-inline">
                <li>
                    <a href="<?php echo base_url() ?>" title="Trang chủ"><span>Trang chủ</span></a>
                </li>
                <?php
                foreach ($breadcrumb as $k => $v) {

                    if (($k + 1) == count($breadcrumb)) {
                        ?>
                        <li>
                            <span><?php echo $v['name'] ?></span>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a href="<?php echo base_url() . $v['url'] ?>"
                               title="zozoda"><span><?php echo $v['name'] ?></span></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <h2 class="prod-heading"><?php echo $menu['name']?></h2>
            <div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="step-card">
            <ul class="list-inline step-deliver">
                <li class="step1 col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <span> </span>
                    <div>
                        <h2> Sản phẩm đạt yêu cầu </h2>
                        <p>
                            Được kiểm duyệt hàng <br> trước khi giao hàng
                        </p>
                    </div>
                </li>
                <li class="step2 col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <span> </span>
                    <div>
                        <h2> Đóng gói hàng cẩn thận </h2>
                        <p>
                            Nhân viên làm việc với <br> niềm đam mê
                        </p>
                    </div>
                </li>
                <li class="step3 col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <span> </span>
                    <div>
                        <h2> Giao hàng hỏa tốc </h2>
                        <p>
                            Giao hàng nhanh trong <br> vòng 3h
                        </p>
                    </div>
                </li>
                <li class="step4 col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <span> </span>
                    <div>
                        <h2> Đổi trả miễn phí </h2>
                        <p>
                            Đổi trả hàng miễn phí trong <br> vòng 14 ngày
                        </p>
                    </div>
                </li>
            </ul>
            <div class="f-connect for-desktop">
                <span>Kết nối với chúng tôi</span>
                <span></span>
            </div>
            <div class="social">
                <a href="https://www.facebook.com/zozodavn/" class="face" title="Facebook"></a>
                <a href="https://twitter.com/zozodavn" class="twister" title="Twister"></a>
                <a href="https://www.linkedin.com/in/zozoda/" class="linke" title="Linkedin"></a>
                <a href="" class="gplus" title="Google Plus"></a>
                <a href="" class="you" title="Youtube"></a>
                <a href="https://www.pinterest.com/zozodavn/" class="pin" title="Pinterest"></a>
            </div>
        </div>
    </div>
</section>