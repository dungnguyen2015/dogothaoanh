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
                <div class="wrap-order-detail">
                    <div>Tên khách hàng: </div> <div><?php echo $order->user_name?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Số điện thoại: </div> <div><?php echo $order->phone?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Địa chỉ: </div> <div><?php echo $order->address?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Quận/Huyện: </div> <div><?php echo $order->district->name?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Tỉnh/TP: </div> <div><?php echo $order->province->name?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Ngày mua hàng: </div> <div><?php echo $order->created_at?></div>
                </div>
                <div class="wrap-order-detail">
                    <div>Tình trạng: </div> <div><?php echo $order->state?></div>
                </div>
                <div class="wrap-order-detail">
                    <table class="list-pro">
                        <thead>
                        <tr>
                            <td width="35%">Tên SP</td>
                            <td width="10%">Số lượng</td>
                            <td width="10%">Giá</td>
                            <td width="15%">Chi tiết</td>
                            <td width="15%">Danh mục</td>
                            <td width="5%">Ảnh</td>
                            <td>Thành tiền</td>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($order->item as $k => $v) {

                            $totalPrice =  $v->qty * $v->price;
                            ?>
                            <tr>
                                <td><?php echo $v->name;?></td>
                                <td><?php echo $v->qty;?></td>
                                <td><?php echo $v->price;?></td>
                                <td><?php echo isset($v->color)  ? 'Màu: '.$v->color: '' ;?><?php echo isset($v->size)  ? ', Size: '.$v->size: '' ;?></td>
                                <td><?php echo $v->type;?></td>
                                <td><img width="150px" src="<?php echo base_url()?>public/img/product/<?php echo $v->img_url;?>"/></td>

                                <td>
                                    <?php echo number_format($totalPrice);?>K
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div><a href="<?php echo base_url()?>admin/list-orders">Cancel</a></div>
            </div>
        </div>
    </div>
</section>