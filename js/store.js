$(window).scroll(function(){
    var aTop = $('.sale_info').height();
    if($(this).scrollTop() >= aTop){
        $('header').addClass('sticky');
    } else {
        $('header').removeClass('sticky');
    }
});

$(document).on('ready', function(){
    console.log('test');
    $('ul.filters .parent').on('click', function(){
        var id = $(this).attr('data-id');

        $('ul.filters .child[data-id="'+ id +'"]').toggle();
    });

    $('.sortBy_filter select[name="sort_by"]').on('change', function(){
        var params = {
            sort_by: $(this).val(),
        };
        
        var current_url = window.location.href;
        var url = new URL(current_url);
        var categoryParam = url.searchParams.get("category");
        var sizeParam = url.searchParams.get("size");

        if(categoryParam !== null){
            params.category = categoryParam;
        }

        if(sizeParam !== null){
            params.size = sizeParam;
        }
        var site_url = location.protocol + '//' + location.host + location.pathname
        var esc = encodeURIComponent;
        var query = Object.keys(params).map(k => esc(k) + '=' + esc(params[k])).join('&');
        window.location.href = site_url + '?' + query;
    });
});