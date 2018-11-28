$(document).ready(function(){

    // Event for main menu
    $('.main-menu li').has('ul').hover(function(){

        $(this).removeClass('current').children('ul').show();

    }, function() {

        $(this).removeClass('current').children('ul').hide();

    });

    // Event for main menu
    $('.main-menu li:last-child').has('ul').hover(function(){

        $(this).addClass('current').children('ul').css("right", '-214px');
        $(this).addClass('current').children('ul').css("border-left", '1px solid red');

    });

    // Event hover for banner
    $(".banner a").mouseover(function(obj){
        
        $('head').append('<style>.view-click:before{width:'+$(this).width()+'px !important; height:'+$(this).height()+'px !important;}</style>');
        $('head').append('<style>.view-click:after{top: '+ ($(this).height()-30)/2 +'px; left:'+ ($(this).width()-100)/2 + 'px;}</style>');
        $(this).addClass("view-click");

    }).mouseout(function() {

        $(this).removeClass("view-click");

    });

});


// PAGE ADMIN

var required = [];
required['bds_name'] = 'Không để trống, Chiều dài lớn nhất 100 ký tự';
required['price'] = 'Không để trống trường này. ';
required['sign_area'] = 'Không để trống trường này. ';
required['sign_price'] = 'Không để trống trường này. ';
required['area'] = 'Không để trống trường này. ';
required['city_id'] = 'Không được để trống 2 trường này';
required['district_id'] = 'Không được để trống 2 trường này';
required['menu_id'] = 'Không được để trống';
required['lat'] = 'Không để trống, Chỉ chấp nhận số';
required['lng'] = 'Không để trống, Chỉ chấp nhận số';
required['street'] = 'Không để trống';
required['ward'] = 'Không để trống';

jQuery(document).ready(function() {

    // Upload image
    $("input[type=file]").change(function () {

        var id = $(this).attr("id");
        var folder = $(this).attr("data-folder");
        var name = $("#title").val();

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){

                var file = e.target.result.split(",");

                if(file[0] != 'data:image/jpeg;base64' && file[0] != 'data:image/jpg;base64')
                {
                    return false;
                }

                var url = upload_image(e.target.result, folder, name);

                $('img#s_'+id).attr('src' , e.target.result);
                $('input#url_'+id).val(url);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function upload_image(file, folder, name) {

        var url = '';
        $.ajax({
            url: "/ajax-admin/upload-image",
            type: 'POST',
            data: {'file': file, 'name': name, 'folder' : folder},
            async: false,
            dataType: "html",
            cache: false,
            success: function (data, textStatus, jqXHR) {

                url = data;
            },
        });

        return url;

    }

    $("select").change(function(){

        $.ajax({
            url: "/ajax-admin/get-child-menu",
            type: 'POST',
            data: {name: $(this)[0].name, value: $(this).val()},
            dataType: "html",
            cache: false,
            success: function (data, textStatus, jqXHR) {

                data = JSON.parse(data);
                var html = '';


                if (data.status  == 'ok') {

                    html += '<option value="">Select one value</option>';
                    for (var k in data.data) {
                        html += "<option value='"+data.data[k].id+"'>"+data.data[k].name+"</option>";
                    }
                }

                if (html != "" && data.name == 'pror_id') {

                    $("select[name=tp_id]").removeAttr('disabled');
                    $("select[name=tp_id]").html(html);

                }else if (data.name == 'pror_id'){

                    $("select[name=tp_id]").attr('disabled', true);
                }

                if (html != "" && data.name == 'parent_id') {

                    $("select[name=pror_id]").removeAttr('disabled');
                    $("select[name=pror_id]").html(html);

                } else if (data.name == 'parent_id'){

                    $("select[name=pror_id]").attr('disabled', true);
                }
            },
        });
    });
});


function form_event(obj) {

    obj.parent("span").find("span[class=show-text-required]").remove();
    var val = obj.val().trim();
    var name = obj.attr("name").trim();

    if (name in required) {

        if (!val || val == 0) {

            obj.parent("span").append("<span class='show-text-required'>" + required[name] + "</span>");
        }

        if (name == 'bds_name' && val.length > 100) {

            obj.parent("span").append("<span class='show-text-required'> Chiều dài không vượt quá 100 ký tự. </span>");
        }
        var pattern = new RegExp(/^[0-9.]+$/i);
        var valid = pattern.test(val);
        if (!valid && (name == "lat" || name == "lng" || name == "price" || name == "area")) {

            obj.parent("span").append("<span class='show-text-required'> Chỉ chấp nhận số.</span>");
        }
    }

}

function changeStateOrder(order_id, e) {
    $.ajax({
        url: "/ajax-admin/change-state-order",
        type: 'POST',
        data: {order_id: order_id, state: e.value},
        dataType: "html",
        cache: false,
        success: function (data, textStatus, jqXHR) {

            data = JSON.parse(data);
            if (data.status  == 'ok') {

                alert('Cập nhật trạng thái thành công');
            }

        },
    });
}

function showUploadImg() {

    var name = $("#name").val();
    if (name == ''){

        $("#name").focus();
        $(window).scrollTop();
        return false;

    }

    var colorArr = $("#color").val().split(',');

    var html = '';
    for (var i = 0; i < colorArr.length; i++) {

        html += '<div class="form-group"><div style="text-align: center; font-size: 22px; font-weight: 600">------- Ảnh màu ' +colorArr[i]+ ' ---------</div></div>';
        for (var j = 0; j < 5; j++) {

            html += '<div class="form-group">' +
                '<label for="img_'+ colorArr[i].trim() +'_' + j +'" class="col-sm-2 control-label">Ảnh SP <span class="require">*</span></label>' +
                '<div class="col-sm-5">' +
                '<input type="file" data-folder="product" id="img_'+ colorArr[i].trim() +'_' + j +'" name="fileupload[]"/>' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<img id="s_img_'+ colorArr[i].trim() +'_' + j +'" src="'+ base_url + 'public/img/no-img.png""/>'+
                // '<input type="hidden" id="url_img_'+ colorArr[i] +'_' + j+'" name="img_'+colorArr[i] +'_' + j+'"/>'+
                '</div>' +
                '</div>';
        }

    }

    $("#wrap-upload-img").html(html);
    $("#wrap-upload-img").show();
    $("input[type=file]").on('change', function(e) {
        uploadImg(this);
    });
}

function uploadImg($this) {
    var id = $($this).attr("id");
    var folder = $($this).attr("data-folder");

    if ($this.files && $this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){

            var file = e.target.result.split(",");
            if(file[0] != 'data:image/jpeg;base64' && file[0] != 'data:image/jpg;base64')
            {
                return false;
            }

            $('img#s_'+id).attr('src' , e.target.result);
            // $('input#url_'+id).val(e.target.result);
        };
        reader.readAsDataURL($this.files[0]);
    }

}

