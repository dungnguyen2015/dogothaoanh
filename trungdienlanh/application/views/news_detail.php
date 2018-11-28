
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
                               title="<?php echo $v['name'] ?>"><span><?php echo $v['name'] ?></span></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <!-- SHOW NEW -->
            <div class="w-content">
                <div class="news-detail-title">
                    <h1><?php echo ucfirst($news_detail->title); ?></h1>
                    <div class="date-first"><?php echo $news_detail->created_at; ?></div>
                </div>
                <div class="wrap-desc-content content-news">
                    <?php echo ucfirst(htmlspecialchars_decode($news_detail->content)) ?>
                </div>
                <div class="tags">
                    <span>Tags: </span>
                    <?php
                    $tags = json_decode($news_detail->tags);
                    foreach ($tags as $k => $v) {
                        $tmp = explode(',', $v);
                    ?>
                        <a href="<?php echo base_url()?>tag/<?php echo $tmp[0];?>/" rel="tag"><?php echo ucfirst($tmp[1])?></a>
                    <?php
                    }
                    ?>
                </div>
				<h4>BÀI VIẾT LIÊN QUAN</h4>
				<?php if (count($news_older) > 0) { ?>
                    <ul class="older-news">
                        <?php foreach ($news_older as $k => $v) { ?>
                            <li>
                                <a href="<?php echo base_url() ?><?php echo $v->url; ?>/"
                                   title="<?php echo ucfirst($v->title); ?>">
                                    <span><?php echo ucfirst($v->title); ?></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                <?php } ?>
            </div>

        </div>
    