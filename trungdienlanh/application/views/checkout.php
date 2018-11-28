<section xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <ul class="step-buying clearfix list-inline for-desktop">
            <li class="step1">Chọn hàng online</li>
            <li class="step2">Giao hàng trong 24h</li>
            <li class="step3">Thanh toán tiện lợi</li>
            <li class="step4">Đổi trả 7 ngày</li>
        </ul>
        <div class="w-main">
            <ul class="scread-link list-inline">
                <li><a href="<?php echo base_url(); ?>"> Trang chủ </a></li>
                <?php
                $i = 0;
                $lenght = count($link);
                foreach ($link as $k => $v) {

                    $i++;
                    if ($i == $lenght) {
                        ?>
                        <li><i class="fa fa-chevron-right" aria-hidden="true"></i> <?php echo $k; ?></li>
                        <?php
                        continue;
                    }
                    ?>
                    <li><a href="<?php echo base_url() . $v; ?>"><i class="fa fa-chevron-right"
                                                                    aria-hidden="true"></i> <?php echo $k; ?> </a></li>
                    <?php
                }
                ?>
            </ul>
            <h2 class="ck-title">Thông tin giao hàng</h2>
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <div class="wrap-info-order">
                        <div class="address-order">
                            <form method="post" id='f-checkout' action="<?php echo base_url() ?>ajax/checkout">
                                <div>
                                    <h2 class="header-text"> Địa chỉ giao hàng </h2>
                                    <div class="form-order">
                                        <input class="w-100" name='user_name' type="text"
                                               placeholder="Họ tên người nhận">
                                    </div>
                                    <div class="form-order">
                                        <input class="w-50" type="text" name='phone' placeholder="Số điện thoại">
                                        <input class="w-50" type="text" name='email' placeholder="Email(nếu có)">
                                    </div>
                                    <div class="form-order">
                                        <input class="w-100" type="text" name='address' placeholder="Địa chỉ nhận hàng">
                                    </div>
                                    <div class="form-order">
                                        <select class="w-50" name='province' onchange="getDistrict(this)">
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
                                        <select class="w-50" name='district'>
                                            <option value="0">-- Vui lòng chọn --</option>
                                            <?php
                                            foreach ($district as $k => $obj) {
                                                ?>
                                                <option
                                                    value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="login-order for-desktop">
                            <form method="post" action="<?php echo base_url() ?>dang-nhap">
                                <div>
                                    <h2 class="header-text"> Đăng nhập </h2>
                                    <div class="form-order">
                                        <input class="w-100" type="text" placeholder="Email">
                                    </div>
                                    <div class="form-order">
                                        <input class="w-100" type="password" placeholder="Mật khẩu">
                                    </div>
                                    <div class="btn-login">
                                        <input type="submit" value="Đăng nhập">
                                    </div>
                                    <div class="col-md-12">
                                        <a class="link-forgot-pass" href="<?php echo base_url() ?>">Quyên tài khoản?</a>
                                    </div>
                                    <div class="w-100 quick-login-text">
                                        <div class="w-50">
                                            Đăng nhập nhanh bằng tài khoản
                                        </div>
                                        <div class="w-50">
                                            <a href=""><span></span></a>
                                            <a href=""><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h2 class="ck-title">Thông tin giỏ hàng</h2>
                    <ul class="list-unstyled list-order-item">
                        <?php
                        foreach ($session['user_cart'] as $k => $v) {
                            ?>
                            <li>
                                <div>
                                    <div>
                                        <img src="<?php echo base_url() ?>public/img/product/<?php echo $v['img_url'] ?>" title="<?php echo $v['name'] ?>" alt="<?php echo $v['name'] ?>"/>
                                    </div>
                                    <div>
                                        <div class="title-name"><h2><a href="<?php echo base_url().$v['url']?>/" title="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></a></h2>
                                            <span class="for-desktop">Mã SP: <?php echo $v['code'] ?></span></div>
                                        <table class="list-item-checkout">
                                            <thead>
                                            <th class="for-desktop">Loại sản phẩm</th>
                                            <th>Số lượng</th>
                                            <?php if ($v['color'] != '') echo '<td>Màu</td>' ?>
                                            <?php if ($v['size'] != '') echo '<td>Size</td>' ?>
                                            <th>Giá</th>
                                            <th>Thành tiền</th>
                                            </thead>
                                            <tbody>
                                            <td class="for-desktop"><?php echo $v['type'] ?></td>
                                            <td><?php echo $v['qty'] ?></td>
                                            <?php if ($v['color'] != '') echo '<td>'.$v['color'].'</td>' ?>
                                            <?php if ($v['size'] != '') echo '<td>'.$v['size'].'</td>' ?>

                                            <?php
                                            if ($v['sale_off'] > 0) {

                                                $priceItem = $v['price'] - ceil(($v['sale_off'] * $v['price']) / 100);
                                            } else {

                                                $priceItem = ceil($v['price']);
                                            }
                                            ?>

                                            <td><span class="money"><?php echo number_format($priceItem); ?>
                                                    .000<sub> đ</sub></span></td>
                                            <td><span
                                                    class="money"><?php echo number_format($v['qty'] * $priceItem); ?>
                                                    .000<sub> đ</sub></span></td>
                                            </tbody>
                                        </table>
                                        <div class="w-btn-remove-checkout">
                                            <a class="btn-remove-item-cart-chk" title="Hủy đơn hàng" href="<?php echo base_url() ?>remove-cart-item/<?php echo $v['key'] ?>">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 right-order">
                    <div>
                        <div class="form-order">
                            <input class="w-100" type="text" name='code_discount' placeholder="Mã khuyến mãi">
                        </div>
                        <div>
                            <ul class="list-unstyled list-item-order">
                                <?php
                                $total_money = 0;
                                foreach ($session['user_cart'] as $k => $v) {

                                    $total_money += $v['qty'] * $v['price'];
                                    ?>
                                    <li>
                                        <span class="order-name-r"><?php echo $v['name'] ?></span>
                                        <span class="order-name-l"><?php echo number_format($v['qty'] * $v['price']); ?>
                                            .000<sub> đ</sub></span>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="fee-trans-text">
                            <span> Phí vận chuyển </span><span class='n-fee-trans'>-</span>
                        </div>
                        <div class="fee-total-text">
                            <span> Tạm tính </span><span class="num_money"><?php echo number_format($total_money); ?>
                                .000<sub> đ</sub></span>
                        </div>
                        <div class="btn-login">
                            <input type="submit" onclick="addOrder()" value="Đặt hàng">
                        </div>
                        <div class="btn-buy">
                            <a href="<?php echo base_url() ?>" title="Mua hàng">Tiếp tục mua sắm</a>
                        </div>
                    </div>
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
</section>