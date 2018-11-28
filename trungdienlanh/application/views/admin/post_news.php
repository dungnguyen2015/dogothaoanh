<script>
    tinymce.init({
        selector: '#content',
        plugins : 'image, autolink, link, code', 
        font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace'
      
    });
</script>
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
                        <a href = "<?php echo base_url() ?>admin/post-news">Quản lý người dùng</a>
                    </li>
                    <li>
                        <a href = "<?php echo base_url() ?>admin/list-orders">Quản lý đơn hàng</a>
                    </li>
                    <li>

                    </li>
                </ul>
            </div>
            <div class="w-main-content">
            <h3 class="title-h">Đăng Bài Viết</h3>
                <?php
                if ( !empty(validation_errors()) || isset($error) )
                {
                    ?>
                    <div class="show-error">

                        <?php
                        echo validation_errors();

                        if(isset($error))
                        {
                            foreach ($error as $k => $v) {
                                ?>
                                <p> <?php echo $v; ?></p>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($success) && $success) {
                    ?>
                    <div class="success_message"> Đăng bài viết thành công. Cảm ơn.</div>
                    <?php
                }
                ?>
                <div class="wrap-content-ad">
                    <form action="<?php echo base_url()?>admin/post-news<?php echo isset($data_news) ? '/'.$data_news->id : ''; ?>" class="form-horizontal post-product" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title"  class="col-sm-2 control-label">Tên Bài Viết <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value = "<?php echo isset($data_news) ? $data_news->title: set_value('title')?>" class="form-control" name = 'title' id="title" placeholder="Tên bài viết...">
                            </div>
                        </div>
                        <?php
                        for ($i = 0; $i < 4; $i++) {

                            ?>
                            <div class="form-group">
                                <label for="img_<?php echo $i;?>" class="col-sm-2 control-label">Ảnh SP <span class="require">*</span></label>
                                <div class="col-sm-2">
                                    <input type="file" data-folder='news' id='img_<?php echo $i;?>' name='fileupload[]'/>
                                </div>
                                <div class="col-sm-2">
                                    <img id="s_img_<?php echo $i;?>" src="<?php echo base_url() ?><?php echo isset($data_news) && isset($data_news->img_product[$i]) ? 'public/img/product/'.$data_news->img_product[$i]->url : 'public/img/no-img.png'?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name=img_url[] id='url_img_<?php echo $i;?>' placeholder="Copy url image cho bài viết (nếu cần)..."
                                         value = "<?php echo isset($data_news) && isset($data_news->img_product[$i]) ? base_url().'public/img/product/'.$data_news->img_product[$i]->url : ''?>">
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label for="tags"  class="col-sm-2 control-label">Tags <span class="require">*</span></label>
                            <div class="col-sm-10">

                                <textarea class="form-control" rows="1" id = "tags" name = 'tags' placeholder="ví da, ví da nam tại hà nội">
                                    <?php echo set_value('tags');?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="s_content"  class="col-sm-2 control-label">Nội dung ngắn <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id = "s_content" name = 's_content' placeholder="Copy phần trên của nội dung dài..." rows="3">
                                    <?php echo isset($data_news) ? trim($data_news->s_content) : set_value('s_content');?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content"  class="col-sm-2 control-label">Nội dung dài <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id = 'content' name = 'content' rows="20">
                                    <?php echo isset($data_news) ? htmlspecialchars_decode($data_news->content) : htmlspecialchars_decode(set_value('content'));?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 wrap-btn-center">
                                <button type="submit" class="btn btn-success"> <?php echo isset($data_news) ? 'Cập nhật' : 'Đăng tin' ?></button>
                                <button type="reset" class="btn btn-danger"> Xóa </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</section>