<section>
    <div class="container">
        <div class="w-main">
            <div class="row h-product-name">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <h1><?php echo $product_detail->name; ?></h1>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ul class="choose-view-des">
                        <li>
                            <a href="#decription" style="color: #d4d1d1" title="Thông tin SP">Thông tin SP</a>
                        </li>
                        <li>
                            <a href="#product-info" title="Chi tiết">Chi tiết</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4 w-thumnail-img">
                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a href="<?php echo base_url() . 'public/img/product/' . $product_detail->img_product[0]->url; ?>" title="<?php echo $product_detail->name; ?>">
                            <img src="<?php echo base_url() . 'public/img/product/' . $product_detail->img_product[0]->url; ?>"
                                title="<?php echo $product_detail->name; ?>" alt="<?php echo $product_detail->name; ?>"
                                width="100%" height="auto">
                        </a>
                    </div>
                </div>
                <?php
                $colorArr = json_decode($product_detail->colorArr);
                ?>
                <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <ul class="thumbnails">
                        <?php foreach ($product_detail->img_product as $k => $obj) {?>
                            <li name = 'img-<?php echo trim($obj->color);?>' style='display: <?php echo $colorArr == null || (count($colorArr) > 0 && trim($colorArr[0]) == trim($obj->color)) ? "" : "none"?>'>
                                <a href="<?php echo base_url() . 'public/img/product/' . $obj->url; ?>" title="<?php echo $product_detail->name; ?>"
                                   data-standard="<?php echo base_url() . 'public/img/product/' . $obj->url; ?>">
                                    <img src="<?php echo base_url() . 'public/img/product/' . $obj->url; ?>"
                                         title="<?php echo $product_detail->name; ?>"
                                         alt="<?php echo $product_detail->name; ?>">
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                    <form action="<?php echo base_url() ?>addtocart" id="formAddtoCart" method="POST">
                        <div id="product-info" style="display: none">
                            <div>
                                <span>Loại sản phẩm</span>
                                <span>
                                    <?php
                                    if (isset($type_product_item))
                                        echo trim($type_product_item->name);
                                    else if (isset($producer_item))
                                        echo $producer_item->name;
                                    else
                                        echo $parent_menu_item->name;
                                    ?>
                                </span>
                            </div>
                            <div><span>Xuất xứ</span><span> <?php echo $product_detail->xuat_xu; ?></span></div>
                            <div><span>Khối lượng - thể tích</span><span> <?php echo $product_detail->kg_ml; ?></span>
                            </div>
                        </div>
                        <div id="decription">
                            <?php echo htmlspecialchars_decode($product_detail->content); ?>
                        </div>
                        <div class="wrap-detail-price">
                            <?php
                            if ($product_detail->sale_off > 0) {
                                ?>
                                <div class="sale-off">
                                    <span>GIÁ BAN ĐẦU: </span>
                                    <span><?php echo number_format($product_detail->price); ?>.000<sub> đ</sub></span>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="price">
                                <span>GIÁ: </span>
                                <?php
                                if ($product_detail->sale_off > 0) {

                                    $priceItem = $product_detail->price - ceil(($product_detail->sale_off * $product_detail->price) / 100);
                                } else {

                                    $priceItem = ceil($product_detail->price);
                                }
                                ?>
                                <span><?php echo number_format($priceItem); ?>.000<sub> đ</sub></span>
                            </div>
                            <div class="wrap-qty">
                                <span>SỐ LƯỢNG: </span>
                            <span>
                                <button type="button" class="qty-less"><i class="fa fa-chevron-left"
                                                                          aria-hidden="true"></i></button>
                                <input type="text" name="qty" value="1" id="qty" title="Số lượng">
                                 <button type="button" class="qty-more"><i class="fa fa-chevron-right"
                                                                           aria-hidden="true"></i></button>
                            </span>
                            </div>
                            <?php
                            if (count($colorArr) > 0) {
                                ?>
                                <div class="wrap-color">
                                    <span>MÀU: </span>
                            <span>
                                <select name="color" onchange = "changeColor(event)">
                                    <option value="">--Vui lòng chọn--</option>
                                    <?php
                                    foreach ($colorArr as $k => $v) {
                                        ?>
                                        <option <?php echo $k == 0 ? 'selected': ''?> value="<?php echo trim($v); ?>"><?php echo trim(ucfirst($v)); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                                </div>
                                <?php
                            }
                            ?>
                            <div id="error-color" style="display: none">
                                <span>&nbsp</span>
                                <span><i class="fa fa-long-arrow-up" aria-hidden="true"></i>&nbsp Màu không được bỏ trống!</span>
                            </div>
                            <?php
                            $sizeArr = json_decode($product_detail->sizeArr);
                            if (count($sizeArr) > 0) {
                                ?>
                                <div class="wrap-color">
                                    <span>KÍCH CỠ: </span>

                            <span>
                                <select name="size">
                                    <option value="">--Vui lòng chọn--</option>
                                    <?php
                                    foreach ($sizeArr as $k => $v) {

                                        ?>
                                        <option value="<?php echo $v; ?>"><?php echo ucfirst($v); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                                </div>
                                <?php
                            }
                            ?>
                            <div id="error-size" style="display: none">
                                <span>&nbsp</span>
                                <span><i class="fa fa-long-arrow-up" aria-hidden="true"></i>&nbsp Kích cỡ không được bỏ trống!</span>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $product_detail->id; ?>">
                            <input type="hidden" name="parent_id" value="<?php echo $product_detail->parent_id; ?>">
                            <input type="hidden" name="pror_id" value="<?php echo $product_detail->pror_id; ?>">
                            <input type="hidden" name="tp_id" value="<?php echo $product_detail->tp_id; ?>">
                            <input type="hidden" id="price" value="<?php echo $priceItem; ?>">
                        </div>
                        <div class="type-ship">
                            <div><span>Điều kiện:</span></div>
                            <ul>
                                <li>Giao hàng trên toàn quốc.</li>
                                <li>Khách hàng muốn chọn vui lòng đến Cửa hàng ZOZODA.</li>
                                <li>Khách hàng đăng ký giao hàng tận nơi, nhân viên sẽ liên hệ trước khi giao hàng.</li>
                            </ul>
                        </div>
                        <div class="loadding"><img alt="Ví nam da bò" src="<?php echo base_url() ?>public/img/load.gif"><span></span></div>
                        <div class="btn_buy">
                            <div><a href="javascript:void(0)" onclick="addToCart()" title="Thêm vào giỏ">Thêm vào giỏ</a></div>
                            <div><a href="javascript:void(0)" onclick="buyNow()" title="Mua ngay">Mua ngay</a></div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="detail-tabs">
                <h2 class="prod-heading">
                    <?php
                    if (isset($type_product_item))
                        echo trim($type_product_item->name);
                    else if (isset($producer_item))
                        echo $producer_item->name;
                    else
                        echo $parent_menu_item->name;
                    ?>
                </h2>
                <div class="row-item-product">
                    <ul class="clearfix item-product">
                        <?php foreach ($product_rela as $k => $ob) { ?>
                            <li class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                                <a href="<?php echo base_url() . $ob->url; ?>" title="<?php echo $ob->name; ?>">
                                    <img src="<?php echo base_url(); ?>public/img/product/<?php echo $ob->img_url; ?>" alt="<?php echo $ob->name; ?>"/>
                                </a>
                                <div class="price-box">
                                    <?php
                                    if ($ob->sale_off > 0) {

                                        $priceItem2 = $ob->price - ceil(($ob->sale_off * $ob->price) / 100);
                                    } else {

                                        $priceItem2 = ceil($ob->price);
                                    }
                                    ?>
                                    <span><?php echo number_format($priceItem2); ?>.000<sub> đ</sub></span>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
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

    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="h-modal"><h3>Mua hàng nhanh với ZOZODA</h3><i class="fa fa-remove" id="closeModal"></i></div>
            <div class="modal-main">
                <div>
                    <img id = 'modal-img' src="<?php echo base_url() . 'public/img/product/' . $product_detail->img_product[0]->url; ?>"
                         title="<?php echo $product_detail->name ?>" alt="<?php echo $product_detail->name ?>">
                </div>
                <div>
                    <div class="title-name"><h2><?php echo $product_detail->name; ?></h2>
                        <span class="for-desktop">Mã SP: <?php echo $product_detail->code; ?></span></div>
                    <table class="list-item-checkout">
                        <thead>
                        <tr>
                            <td class="for-desktop" width="25%">Loại sản phẩm</td>
                            <td width="20%">Số lượng</td>
                            <?php
                            if (count($sizeArr) > 0) {
                                echo '<td width="8%">Size</td>';
                            }
                            ?>
                            <?php
                            if (count($colorArr) > 0) {
                                echo '<td width="8%">Màu</td>';
                            }
                            ?>
                            <td width="19%">Giá</td>
                            <td width="20%">Thành tiền</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="for-desktop">
                                <?php
                                if (isset($type_product_item))
                                    echo trim($type_product_item->name);
                                else if (isset($producer_item))
                                    echo $producer_item->name;
                                else
                                    echo $parent_menu_item->name;
                                ?>
                            </td>
                            <td id='modal-qty'>1</td>
                            <?php
                            if (count($sizeArr) > 0) {
                                echo '<td id=\'modal-size\'>1</td>';
                            }
                            ?>
                            <?php
                            if (count($colorArr) > 0) {
                                echo '<td id=\'modal-color\'>1</td>';
                            }
                            ?>
                            <td><span class="money"><?php echo number_format($priceItem); ?>.000<sub> đ</sub></span>
                            </td>
                            <td><span class="money" id='modal-tmoney'><?php echo number_format($priceItem); ?>.000<sub> đ</sub></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <form method="post" id="f-checkout" action="<?php echo base_url() ?>ajax/fast-buy">
                        <div>
                            <h2 class="header-text"> Địa chỉ giao hàng </h2>
                            <div class="form-order">
                                <input class="w-100" name="user_name" type="text" placeholder="Họ tên người nhận">
                                <input name="product_id" type="hidden" value="<?php echo $product_detail->id; ?>">
                            </div>
                            <div class="form-order">
                                <input class="w-50" type="text" name="phone" placeholder="Số điện thoại">
                                <input class="w-50" type="text" name="email" placeholder="Email(nếu có)">
                            </div>
                            <div class="form-order">
                                <input class="w-100" type="text" name="address" placeholder="Địa chỉ nhận hàng">
                            </div>
                            <div class="form-order">
                                <select class="w-50" name="province" onchange="getDistrict(this)">
                                    <option value="0">-- Vui lòng chọn --</option>
                                    <?php
                                    foreach ($province as $k => $obj) {
                                        ?>
                                        <option
                                            value="<?php echo $obj->id; ?>" <?php echo $obj->id == 79 ? "selected" : ""; ?>><?php echo $obj->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <select class="w-50" name="district">
                                    <option value="0">-- Vui lòng chọn --</option>
                                    <?php
                                    foreach ($district as $k => $obj) {
                                        ?>
                                        <option value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-btn-order"><input class="btn-order" type="submit" onclick="fastBuy()" value="Đặt hàng"></div>
            <div class="footer-modal for-desktop">
                <div class="promotion-content">
                    <h3>Thời gian giao hàng:</h3>
                    <p>▪ Trong vòng 24h tại TP.HCM &amp; 3-5 ngày với các tỉnh/thành phố khác</p>
                    <p style="font-style: italic;">▪ Miễn phí giao hàng với đơn hàng trên 500.000đ (TP. HCM)</p>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($is_mobile) {
        ?>
        <div class="btn_buy_mobile">
            <div><a href="<?php echo base_url() ?>gioi-thieu/" title="Liên hệ">Liên hệ</a></div>
            <div><a href="javascript:void(0)" onclick="buyNow()" title="Mua ngay">Mua ngay</a></div>
        </div>
        <?php
    }
    ?>
</section>