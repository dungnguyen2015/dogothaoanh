<section>
    <div class="container">
        <div class="w-main">
            <div class="w-left">
                <ul class="list-unstyled main-menu">
                    <li><i class="line3"></i>Danh mục</li>
                    <li>
                        <a href = "<?php echo base_url() ?>admin/list-product">Danh sách sản phẩm</a>
                    </li>
                    <li>
                        <a href = "<?php echo base_url() ?>admin/list-news">Danh sách bài viết</a>
                    </li>
                    <li>
                        <a href = "<?php echo base_url() ?>admin/post-product">Quản lý người dùng</a>
                    </li>
                    <li>
                        <a href = "<?php echo base_url() ?>admin/list-orders">Quản lý đơn hàng</a>
                    </li>
                    <li>

                    </li>
                </ul>
            </div>
            <div class="w-main-content">
                <div class="wrap-content-ad">
                    <h3 class="title-h">Danh sách đặt hàng</h3>
                    <div class="w-add-new">
                        <select>
                            <option  value="">Choose one item</option>
                            <option  value="new">Chưa giao hàng</option>
                            <option value="receiving">Đang giao hàng</option>
                            <option value="received">Đã nhận</option>
                        </select>
                    </div>
                    <table class="list-pro">
                        <thead>
                        <tr>
                            <td>STT</td>
                            <td width="13%">Mã Order</td>
                            <td width="15%">Tên KH</td>
                            <td width="10%">Số ĐT</td>
                            <td width="25%">Địa chỉ</td>
                            <td width="5%">Tổng tiền</td>
                            <td width="10%">Ngày mua</td>
                            <td>Tình trạng</td>
                        </tr>
                        </thead>

                    <tbody>
                    <?php
                    foreach ($product as $k => $v) {

                            $tmp = json_decode($v->item);

                        $totalPrice = 0;
                        foreach ($tmp as $kt => $vt) {

                            $totalPrice += $vt->qty * $vt->price;
                        }

                        ?>
                        <tr>
                            <td><?php echo ++$k;?></td>
                            <td><a href="<?php echo base_url()?>admin/order/<?php echo $v->id?>"><?php echo $v->code;?></a></td>
                            <td><?php echo $v->user_name;?></td>
                            <td><?php echo $v->phone;?></td>
                            <td><?php echo $v->address;?></td>

                            <td>
                                <?php echo number_format($totalPrice);?>K
                            </td>
                            <td><?php echo $v->created_at;?></td>
                            <td>
                                <select onchange="changeStateOrder('<?php echo $v->id?>', this)">
                                    <option <?php echo $v->state == 'new' ? "selected" : ''; ?> value="new">Chưa giao hàng</option>
                                    <option <?php echo $v->state == 'receiving' ? "selected" : ''; ?> value="receiving">Đang giao hàng</option>
                                    <option <?php echo $v->state == 'received' ? "selected" : ''; ?> value="received">Đã nhận</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>