<section>
    <div class="container">
        <ul class="step-buying clearfix list-inline for-desktop">
            <li class="step1">Chọn hàng online</li>
            <li class="step2">Giao hàng trong 24h</li>
            <li class="step3">Thanh toán tiện lợi</li>
            <li class="step4">Đổi trả 7 ngày</li>
        </ul>
        <div class="w-main">
            <h1 class="prod-heading"><?php echo $search_str->name;?></h1>
            <div class="area-search">Tìm kiếm:
                <?php
                if (isset($producer) && count($producer) > 0) {
                ?>
                <select id="producer" onchange = "getDataByMenu(event)">
                    <option value="">--Vui lòng chọn--</option>
                    <?php
                        foreach ($producer as $k => $v) {
                    ?>
                            <option value="<?php echo $v->id?>"><?php echo $v->name?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php
                }
                ?>
                <select id="type-product" <?php echo isset($type_product) ? '': 'disabled'?> onchange = "getDataByMenu(event)">
                    <option value="">--Vui lòng chọn--</option>
                    <?php
                    if (isset($type_product)) {
                        ?>
                            <?php
                            foreach ($type_product as $k => $v) {
                                ?>
                                <option value="<?php echo $v->id?>"><?php echo $v->name?></option>
                                <?php
                            }
                            ?>
                        <?php
                    }
                    ?>
                </select>
                <?php
                if (isset($pror_id)) {


                ?>
                    <input type="hidden" id="producer" value="<?php echo $pror_id?>">
                <?php

                }
                ?>
            </div>
            <div class="row-item-product">
                <ul class="clearfix item-product">
                    <?php foreach ($list_product as $k => $ob) { ?>
                        <li class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                            <a href="<?php echo base_url() . $ob->url; ?>/" title="<?php echo $ob->name; ?>">
                                <img class="lazy" data-original="<?php echo base_url(); ?>public/img/product/<?php echo $ob->img_url; ?>"
                                    alt="<?php echo $ob->name; ?>"/>
                            </a>
                            <div class="price-box">
                                <?php
                                if ($ob->sale_off > 0) {

                                    $priceItem = $ob->price - ceil(($ob->sale_off * $ob->price) / 100);
                                } else {

                                    $priceItem = ceil($ob->price);
                                }
                                ?>
                                <span><?php echo number_format($priceItem); ?>.000<sub> đ</sub></span>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
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