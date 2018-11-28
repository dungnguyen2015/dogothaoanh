<script>
    tinymce.init({
        selector: '#content',
        plugins : 'image, autolink, link, code', 
        font_formats: 'MyriadPro, Arial, sans-serif'
      
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
            <h3 class="title-h">Đăng Sản Phẩm</h3>
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
                    <div class="success_message"> Đăng sản phẩm thành công. Cảm ơn.</div>
                    <?php
                }
                ?>
                <div class="wrap-content-ad">
                    <form action="<?php echo base_url()?>admin/post-product<?php echo isset($data_pro) ? '/'.$data_pro->id : ''; ?>" class="form-horizontal post-product" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name"  class="col-sm-2 control-label">Tên SP <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value = "<?php echo isset($data_pro) ? $data_pro->name: set_value('name')?>" class="form-control" name = 'name' id="name" placeholder="Tên sản phẩm...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="xuat_xu"  class="col-sm-2 control-label">Xuất xứ <span class="require">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value = "<?php echo isset($data_pro) ? $data_pro->xuat_xu: set_value('xuat_xu')?>" name = 'xuat_xu' id="xuat_xu" placeholder="Xuất xứ...">
                            </div>
                            <label for="kg_ml"  class="col-sm-2 control-label">Dung tích(kg-ml)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value = "<?php echo isset($data_pro) ? $data_pro->kg_ml: set_value('kg_ml')?>" name = "kg_ml" id="kg_ml" placeholder="Dung tích SP...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price"  class="col-sm-2 control-label">Giá sp <span class="require">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value = "<?php echo isset($data_pro) ? $data_pro->price: set_value('price')?>" name = "price" id="price" placeholder="300...">
                            </div>
                            <label for="sale_off"  class="col-sm-2 control-label">Giảm giá (%)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value = "<?php echo isset($data_pro) ? $data_pro->sale_off: set_value('sale_off')?>" name = "sale_off" id="sale_off" placeholder="20...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color"  class="col-sm-2 control-label">Màu</label>
                            <div class="col-sm-4">
                                <input type="text" <?php echo isset($data_pro) ? 'readonly': ''?> value = "<?php
                                if (isset($data_pro)) {
                                    $arr = json_decode($data_pro->colorArr);
                                }
                                echo isset($data_pro) && count($arr) > 0 ? implode(",",$arr): set_value('sale_off')
                                ?>" class="form-control" id="color" name="color" placeholder="Vàng, Đỏ, Xanh,...">
                            </div>
                            <label for="size"  class="col-sm-2 control-label">Kích cỡ</label>
                            <div class="col-sm-4">
                                <input type="text"  value = "<?php
                                if (isset($data_pro)) {
                                    $arr = json_decode($data_pro->sizeArr);
                                }
                                echo isset($data_pro) && count($arr) > 0 ? implode(",",$arr): set_value('sale_off')
                                ?>" class="form-control" name="size" placeholder="41,42,M,L,...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qty_entered"  class="col-sm-2 control-label">QTY nhập</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="qty_entered">
                            </div>
                            <label for="sale_off"  class="col-sm-2 control-label">Danh mục cha<span class="require">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name = 'parent_id' >
                                    <option value = "">Select one value</option>
                                    <?php
                                    foreach ($parent_menu as $k => $v) {

                                        ?>
                                        <option <?php echo (isset($data_pro) && $data_pro->parent_id == $v->id) || set_value('parent_id') == $v->id ? 'selected':'' ?> value = "<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price"  class="col-sm-2 control-label">Danh mục</label>
                            <div class="col-sm-4">
                                <select class="form-control" name = 'pror_id' <?php echo isset($data_pro) && $data_pro->pror_id != '0' ? '' : 'disabled';?>>
                                    <option value = "">Select one value</option>
                                    <?php
                                    foreach ($producer_menu as $k => $v) {

                                        ?>
                                        <option <?php echo (isset($data_pro) && $data_pro->pror_id == $v->id) || set_value('pror_id') == $v->id ? 'selected':'' ?> value = "<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="sale_off"  class="col-sm-2 control-label">Danh mục con</label>
                            <div class="col-sm-4">
                                <select class="form-control" name = 'tp_id' <?php echo isset($data_pro) && $data_pro->tp_id != '0' ? '' : 'disabled';?>>
                                    <option value = "">Select one value</option>
                                    <?php
                                    foreach ($type_menu as $k => $v) {

                                        ?>
                                        <option <?php echo (isset($data_pro) && $data_pro->tp_id == $v->id) || set_value('tp_id') == $v->id ? 'selected':'' ?> value = "<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display: <?php echo isset($data_pro) ? 'none': ''?>" >
                            <div class="col-sm-12" style="text-align: center">
                                <button type="button" onclick="showUploadImg()" class="btn btn-info">Upload image</button>
                            </div>

                        </div>
                        <div style="display: <?php echo isset($data_pro) ? 'none': ''?>" id = 'wrap-upload-img'>
                        </div>
                        <div class="form-group">
                            <label for="s_content"  class="col-sm-2 control-label">Nội dung ngắn <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id = "s_content" name = 's_content' placeholder="Copy phần trên của nội dung dài..." rows="3">
                                    <?php echo isset($data_pro) ? trim($data_pro->s_content) : set_value('s_content');?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content"  class="col-sm-2 control-label">Nội dung dài <span class="require">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id = 'content' name = 'content' rows="20">
                                    <?php echo isset($data_pro) ? htmlspecialchars_decode($data_pro->content) : htmlspecialchars_decode(set_value('content'));?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 wrap-btn-center">
                                <button type="submit" class="btn btn-success"> <?php echo isset($data_pro) ? 'Cập nhật' : 'Đăng tin' ?></button>
                                <button type="reset" class="btn btn-danger"> Xóa </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</section>