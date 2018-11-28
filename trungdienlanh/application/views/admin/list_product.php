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
                    <h3 class="title-h">Danh sách Sản Phẩm</h3>
                    <div class="w-add-new"><a href="<?php echo base_url()?>admin/post-product">Thêm mới</a></div>
                    <table class="list-pro">
                        <thead>
                        <tr>
                            <td>STT</td>
                            <td width="37%">Tên SP</td>
                            <td width="10%">Mã SP</td>
                            <td width="10%">Xuất xứ</td>
                            <td width="5%">Giá</td>
                            <td width="5%">QTY</td>
                            <td width="5%">QTY Sold</td>
                            <td width="5%">Size</td>
                            <td width="5%">Color</td>
                            <td>Giảm giá</td>

                        </tr>
                        </thead>

                    <tbody>
                    <?php
                    foreach ($product as $k => $v) {
                        ?>
                        <tr>
                            <td><?php echo ++$k;?></td>
                            <td><a href="<?php echo base_url()?>admin/post-product/<?php echo $v->id?>"><?php echo $v->name;?></a></td>
                            <td><?php echo $v->code;?></td>
                            <td><?php echo $v->xuat_xu;?></td>
                            <td><?php echo number_format($v->price);?>K</td>
                            <td><?php echo $v->qty_entered;?></td>
                            <td>
                                <?php
                                echo $v->qty_sold;
                                ?>
                            </td>
                            <td>
                                <?php
                                $arr = json_decode($v->sizeArr);
                                if (count($arr) > 0)
                                echo implode(",",$arr);
                                ?>
                            </td>
                            <td>
                                <?php
                                $arr = json_decode($v->colorArr);
                                if (count($arr) > 0)
                                echo implode(",",$arr);
                                ?>
                            </td>
                            <td><?php echo $v->sale_off;?>%</td>
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