
        <div class="w-main container">

		
            <ul class="breadcrumba list-inline">
                <li>
                    <a href="<?php echo base_url() ?>/" title="Trang chủ"><span>Trang chủ</span></a>
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
                            <a href="<?php echo base_url() . $v['url'] ?>/"
                               title="zozoda"><span><?php echo $v['name'] ?></span></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <!-- SHOW NEW -->
            <h1 style="display: none">Thông tin về dụng cụ làm đồ da handmade, ví da, thắt lưng, mỹ phẩm, vòng đeo tay</h1>
            <div class="w-content">
                <div class="w-pagination"><?php echo  $this->pagination->create_links(); ?> </div>
                <ul class="list-news list-unstyled">
                    <?php foreach ($list_news as $k => $v) { ?>
                        <li>
                            <div class="w-content-n">
                                <div class="wrap-img-n">
                                    <a href="<?php echo base_url() ?><?php echo $v->url; ?>/"
                                       title="<?php echo $v->title; ?>"><img alt="<?php echo $v->title; ?>"
                                            src="<?php echo base_url() ?>public/img/news/<?php echo $v->img_url ?>"/></a>
                                </div>
                                <div>
                                    <h3><a href="<?php echo base_url() ?><?php echo $v->url; ?>/"
                                           title="<?php echo $v->title; ?>"><?php echo $v->title; ?></a></h3>
                                    <div class="date-first"><?php echo $v->created_at; ?></div>
                                    <p>
                                        <?php echo $v->s_content; ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="w-pagination"><?php echo  $this->pagination->create_links(); ?> </div>
            </div>
        </div>
    