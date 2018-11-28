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

    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    // Setup toggles example
    var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

    $('.toggle').on('click', function() {
        var $this = $(this);

        if ($this.data("active") === true) {
            $this.text("Switch on").data("active", false);
            api2.teardown();
        } else {
            $this.text("Switch off").data("active", true);
            api2._init();
        }
    });

    //SCROLL TO TAB
    $('#goto-relation').click(function() {
        $('html, body').animate({
            scrollTop: $("#productrelation").offset().top
        }, 2000);
    });

    // Remove item cart on header
    $(".btn-remove-item-cart").on('click', function(e) {
        e.preventDefault();
        var target =  $(this);
        deleteItem(target);
    });

    // Remove item cart on checkout
    $(".btn-remove-item-cart-chk").on('click', function(e) {
        e.preventDefault();
        var target =  $(this);
        deleteItemCK(target);
    });

    // Event for show cart
    $('.shopping-cart-link').hover(function(){

        if ($("#wrap-item").find(".wrap-item-cart").length > 0) {

            $(".wrap-shopping-cart").css('visibility', 'visible');
        }

    }, function() {

        $(".wrap-shopping-cart").css('visibility', 'hidden');

    });

    //CLOSE MODAL BUY
    $("#closeModal").click(function () {

        $("#myModal").css("display", 'none');
    });

    $(".choose-view-des a").click(function (e) {

        $(".choose-view-des a").css('color','#7a7b7c');
        $("#decription").hide();
        $("#product-info").hide();
        $(e.target.hash).css('display','block');
        $(e.target).css('color','#d4d1d1');
        e.preventDefault();
    });

    $(".qty-less").click(function (e) {

        $("#qty").val($("#qty").val().trim() == '' || parseInt($("#qty").val()) <= 0 ?  0 : parseInt($("#qty").val()) - 1);

    });
    $(".qty-more").click(function (e) {

        $("#qty").val($("#qty").val().trim() == '' ?  1 : parseInt($("#qty").val()) + 1);
    });

    $(".icon-m-down").click(function(e){

        if ($(this).hasClass('m-active')) {

            $(this).removeClass('m-active');
            $(this).parent().find("ul").css('display','none');
            $(this).removeClass('fa-chevron-up');
            $(this).addClass('fa-chevron-down');
        } else {

            $(this).removeClass('fa-chevron-down');
            $(this).addClass('fa-chevron-up');
            $(this).addClass('m-active');
            $(this).parent().find("ul").css('display','inline-block');
        }

    });

});

function eventForMenu($this) {

    if ($($this).hasClass('e-active')) {

        $($this).removeClass('e-active');
        $(".list-menu-mobile").hide();

    } else {

        $($this).addClass('e-active');
        $(".list-menu-mobile").show();
    }

}
// remove item cart header
function deleteItem(target) {
    
    var parents = target.parents(".wrap-item-cart");
    parents.css("text-align", 'center').html('<img src="'+ base_url +'public/img/load.gif">');

    $.ajax({
        url: target.attr('href'),
        method: 'POST',
        data: {data: 'data'},
        success: function(data) {

            data = JSON.parse(data);
            if (data.status == 'ok') {

                if (typeof data['user_cart'] === 'object'  && !Array.isArray(data['user_cart']) && data['user_cart'] !== null) {

                    parents.find("img").remove().empty();
                    parents.remove().empty();
                    assignTotal (data['user_cart']);

                } else {

                    $("#wrap-item").html("Giỏ hàng đang trống");
                    $("#wrap-item").css("text-align", 'center');
                    $(".money").html("-");
                }

            }else {

                window.location.href = base_url;
            }
        }
    });
}

// remove item cart on check out
function deleteItemCK(target) {

    var parents = target.parents("li");
    parents.css("text-align", 'center').html('<img src="'+ base_url +'public/img/load.gif">');

    $.ajax({
        url: target.attr('href'),
        method: 'POST',
        data: {data: 'data'},
        success: function(data) {

            data = JSON.parse(data);


            if (data.status == 'ok') {

                assignData (data['user_cart']);
                assignDataItem(data['user_cart']);
                assignTotal (data['user_cart']);
                parents.find("img").remove().empty();
                parents.remove().empty();

                if (typeof data['user_cart'] === 'object'  && !Array.isArray(data['user_cart']) && data['user_cart'] !== null) {
                    parents.find("img").remove().empty();
                    parents.remove().empty();

                } else {

                    location.href = base_url;
                }

            }
        }
    });
}

function assignDataItem($data) {

    $.each($data, function( key, obj ) {

        $price = obj.price * obj.qty;
        $price = $price.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

        $html = '<li>' +
         '<span class="order-name-r">'+ obj.name +'</span>' +
         '<span class="order-name-l">'+ $price +'<sub> đ</sub></span>'+
         '</li>';

    });

    $(".list-item-order").html ($html);
}


// Assign total item cart
function assignTotal($data) {

    $html = '';
    $totalprice = 0;
    $.each($data, function( key, obj ) {

        $totalprice += obj.price * obj.qty;

    });

    $totalprice = $totalprice.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    $(".num_money").html($totalprice + '<sub> đ</sub>');

}

// Assign data when remove item cart
function assignData($data) {

    $html = '';
    $totalprice = 0;
    $.each($data, function( key, obj ) {

        $totalprice += obj.price * obj.qty;
        $price = obj.price * obj.qty;
        $price = $price.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

        $html += '<div class="wrap-item-cart"><div>'+
            '<img src="' + base_url + 'public/img/product/' + obj.img_url+ '"/>'+
            '</div><div><p>'+
            '<a href="' + base_url + obj.url + '">' + obj.name + '</a>'+
            '<a class="btn-remove-item-cart"  href="' +base_url+ 'remove-cart-item/' +  obj.key + '"><i class="fa fa-remove"></i></a>' +
            '</p> <div><strong>Giá</strong>' +
            '<span class="money">' + $price + '<sub> đ</sub></span></div>' +
            '<div><strong>Số lượng</strong> <span>' + obj.qty + '</span></div>';

        if (obj.hasOwnProperty('color') && obj.color != '') {
            $html += '<div><strong>Màu</strong> <span>' + obj.color + '</span></div>';
        }

        if (obj.hasOwnProperty('size') && obj.color != '') {
            $html += '<div><strong>Kích cỡ</strong> <span>' + obj.size + '</span></div>';
        }

        $html += '<div><strong>Xuất xứ</strong> <span>' + obj.xuat_xu + '</span></div></div></div>';

    });

    $totalprice = $totalprice.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    $(".num_money").html($totalprice + '<sub> đ</sub>');
    $("#wrap-item").html($html);
}

//Add to cart
function addToCart() {

    var f = $("#formAddtoCart");

    if(!validateFormAddCart(f.serializeArray())) return false;

    var color = $("select[name=color]").val();
    if (color == undefined) {

        color = '';
    }
    var img_url = $("li[name^=img-" + color.trim() + "] a:first-child").attr('href');
    img_url = img_url.replace(base_url + 'public/img/product/', "");

    var params = f.serializeArray();
    params.push({name: 'img_url', value: img_url});

    $(".loadding").show();
    $(".loadding img").show();
    $.ajax({
        url: f.attr('action'),
        method: f.attr('method'),
        data: params,
        success: function(data) {

            data = JSON.parse(data);
            if (data.status == 'ok') {

                $(".loadding img").hide();
                $(".loadding > span").show();
                $(".loadding > span").html("Bạn đã thêm vào giỏ hàng thành công!");
                setTimeout(function() {
                    
                        $(".loadding").hide();
                        $(".loadding > span").html("");
                        $(".loadding > span").hide();
                    
                    }, 4000);

                assignData(data.user_cart);

                $(".btn-remove-item-cart").on('click',function (e) {

                    e.preventDefault();
                    var target = $(this);
                    deleteItem(target);
                });
            }else {

                window.location.href = base_url;
            }
        }
    });
}

function validateFormAddCart($arr) {

    var flag = true;
   for (var i = 0; i < $arr.length; i++) {


       if ($arr[i].name == 'color' || $arr[i].name == 'size' ) {

           $("select[name=" + $arr[i].name + "]").css('border', 'none');
           $("#error-" + $arr[i].name).hide();
           if ($arr[i].value == '') {
               $("select[name=" + $arr[i].name + "]").css('border', '1px dotted red');
               $("#error-" + $arr[i].name).show();
               flag  = false;
           }
       }
   }

    return flag;

}

// FAST BUY
// ADD order
function fastBuy() {

    var f = $("#f-checkout");

    // VALIDATE
    if (validateForm($("#f-checkout input, #f-checkout select")) ) {

        return false;
    }

    var qty = $("input[name=qty]").val();
    var color = $("select[name=color]").val();
    var size = $("select[name=size]").val();

    var data = f.serializeArray();
    data.push({name: 'qty', value: qty});
    data.push({name: 'color', value: color});
    data.push({name: 'size', value: size});

    $.ajax({
        url: f.attr('action'),
        method: f.attr('method'),
        data: data,
        success: function(data) {

            data = JSON.parse(data);
            if (data.status == 'ok') {

                window.location.href = base_url + "ck-complete/" + data.code;
            }else {

                window.location.href = base_url;
            }
        }
    });
}

// ADD order
function addOrder() {
    
    var f = $("#f-checkout");

    // VALIDATE
    if (validateForm($("#f-checkout input, #f-checkout select")) ) {

        $("body").scrollTop(0);
        return false;
    }

    $.ajax({
        url: f.attr('action'),
        method: f.attr('method'),
        data: f.serializeArray(),
        success: function(data) {

            data = JSON.parse(data);
            if (data.status == 'ok') {

                window.location.href = base_url + "ck-complete/" + data.code;
            } else {

                window.location.href = base_url;
            }
        }
    });
}

function validateForm ($object) {

    var flag = true;
    $object.each(function(index) {

        $(this).removeClass('has-error');
        if (($(this).val() == "" || $(this).val() == 0) && $(this).attr('name') != 'email') {

            $(this).addClass('has-error');
            flag = false;
        }

        if ($(this).attr('name') == 'phone' && !validatePhome($(this).val())) {

            $(this).addClass('has-error');
            flag = false;

        }


        if ($(this).val() != '' && $(this).attr('name') == 'email' && !validateEmail($(this).val())) {

            $(this).addClass('has-error');
            flag = false;

        }

    });

    if (!flag) {

        return true;
    }

    return false;

}

function validateEmail(email) {

    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhome(phone) {
    var re = /^([0-9]{8,12})$/;
    return re.test(phone);
}

// Get District
function getDistrict($this) {

    $.ajax({
        url: base_url + 'ajax/get-district',
        method: 'POST',
        data: {'provinceid' : $this.value},
        success: function(data) {

            $data = JSON.parse(data);
            $html = '<option value = "0">-- Vui lòng chọn --</option>';

            if ($data.status == 'ok') {

                $.each($data.data, function( key, obj ) {
                    $html += '<option value = "' + obj.id + '">'+ obj.name +'</option>';

                });

            }else {

                window.location.href = base_url;
            }
            $("select[name=district]").html ($html);
        }
    });
}

function buyNow() {

    $("#modal-qty").text($("input[name=qty]").val());

    if ($("select[name=size]").length > 0) {

        $("#modal-size").text($("select[name=size]").val());
    }

    if ($("select[name=color]").length > 0) {

        $("#modal-color").text($("select[name=color]").val().trim());
        $("#modal-img"). attr('src', $("li[name^=img-" + $("select[name=color]").val().trim() + "] a:first-child").attr('href'));
    }

    var total_money = parseInt($("#price").val()) * parseInt($("input[name=qty]").val());
    total_money = total_money.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    $("#modal-tmoney").html(total_money + '<sub> đ</sub>');
    $("#myModal").css("display", 'block');
}

function getDataByMenu($e) {

    if ($e.target.value == '' && $e.target.id == 'producer') {

        $("#type-product").attr('disabled', true);
        return false;
    }

    var dataout = '';
    if ($e.target.id == 'producer') {

        $.ajax({
            url: base_url + 'ajax/get-data-by-menu',
            async: false,
            method: 'POST',
            data: {'producer_id' : $e.target.value},
            success: function(data) {

                $data = JSON.parse(data);
                dataout = $data;
            }
        });
    }

    if ($e.target.id == 'type-product') {

        $.ajax({
            url: base_url + 'ajax/get-data-by-menu',
            async: false,
            method: 'POST',
            data: {'producer_id' : $('#producer').val(), 'type-product': $e.target.value},
            success: function(data) {

                $data = JSON.parse(data);
                dataout = $data;
            }
        });
    }

    if (dataout.status == 'ok') {

        if (dataout.hasOwnProperty("type_product")) {

            $("#type-product").attr('disabled', true);
            $html = '<option value = "">-- Vui lòng chọn --</option>';
            $.each(dataout.type_product, function( key, obj ) {
                $html += '<option value = "' + obj.id + '">'+ obj.name +'</option>';

            });

            $("#type-product").html($html);
            $("#type-product").attr('disabled', false);
        }

        $html = '';
        $.each(dataout.data, function( key, obj ) {

            if (obj.sale_off > 0) {

                $priceItem = obj.price - Math.ceil((obj.sale_off * obj.price) / 100);
            } else {

                $priceItem = Math.ceil(obj.price);
            }

            $html +=  '<li class="col-xs-6 col-sm-2 col-md-2 col-lg-2">';
            $html += '<a href="' + base_url + obj.url + '">';
            $html +=  '<img src="' + base_url + 'public/img/product/' + obj.img_url + '" alt="' + obj.name + '"/>';
            $html +=  '</a> <div class="price-box">';
            $html += '<span>' + $priceItem + '.000<sub> đ</sub></span>';
            $html += '</div> </li>';
        });

        $(".item-product").html($html);
    }else {

        window.location.href = base_url;
    }

}

function changeColor($e) {

    if ($e.target.value == '') {
        return true;
    }
    $("body").scrollTop(0);

    $(".w-thumnail-img div").html('<img src="'+base_url+'public/img/spinner.gif">');
    $(".w-thumnail-img div img").css("border", 'none');
    setTimeout(function(){

        $("li[name^=img-" + $e.target.value + "] a:first-child")[0].click();
        $(".w-thumnail-img div img").css("border", '1px solid #ccc');
        $("li[name^=img-]").hide();
        $("li[name^=img-"+$e.target.value+"]").show();

    }, 200);

    $("li[name^=img-] a").on('click', function() {
        var $this = $(this);

        $(".w-thumnail-img div").html('<a href="'+ $this.attr('href') +'">' +
            '<img src="' + $this.attr('href') + '" title="" width="100%" height="auto"></a>');
    });

}
