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
                    <h3 class="title-h">Danh sách Bài Viết</h3>
                    <div class="w-add-new"><a href="<?php echo base_url()?>admin/post-news">Thêm mới</a></div>
                    <table class="list-pro">
                        <thead>
                        <tr>
                            <td width="40%">Tên Bài Viết</td>
                            <td width="40%">Nội dung ngắn</td>
                            <td width="15%">Ngày tạo</td>
                            <td>Lượt xem</td>
                        </tr>
                        </thead>

                    <tbody>
                    <?php
                    foreach ($news as $k => $v) {
                        ?>
                        <tr>
                            <td><a href="<?php echo base_url()?>admin/post-news/<?php echo $v->id?>"><?php echo $v->title;?></a></td>
                            <td><?php echo $v->s_content;?></td>
                            <td><?php echo $v->created_at;?></td>
                            <td><?php echo $v->viewed;?></td>
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