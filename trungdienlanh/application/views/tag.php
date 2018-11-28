
        <div class="w-main container">

            <ul class="breadcrumba list-inline">
                <li>
                    <a href="<?php echo base_url() ?>/" title="Trang chủ"><span>Trang chủ</span></a>
                </li>
            </ul>
            <!-- SHOW NEW -->
            <h1 class="title"><?php echo ucfirst($h1);?></h1>
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
    