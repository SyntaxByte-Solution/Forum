let forum_selection_lock = true;
$('.select-forum').on('click', function(event) {
    if(!forum_selection_lock)
        return;
    forum_category_dropdown = false;

    let button = $(this);
    let spinner = $('#forum-changer-box .spinner');
    let forum_id = $(this).find('.forum-id').val();

    if(forum_id == 0) {
        $('#forum').val('0');
        $('#category_dropdown option:not(:first)').remove();

        $('.select-forum').attr('style', '');
        button.attr('style', '');
        button.parent().css('display', 'none');
        forum_category_dropdown = true;
    } else {
        $('#forum').val(forum_id);
        $('.select-forum').attr('style', 'cursor: default');
        button.attr('style', 'background-color: #ddd; cursor: default');
        start_spinner(spinner, 'search_forum_changer_spinner');
        spinner.removeClass('opacity0');

        $.ajax({
            type: 'get',
            url: '/forums/' + forum_id + '/categories/ids',
            success: function(response) {
                let categories = JSON.parse(response);
                $('#category_dropdown option:not(:first)').remove();
                $.each(categories, function(id, category){
                    $('#category_dropdown').append("<option value='" + id + "'>" + category.category + "</option>");
                });
                $('#category_dropdown').attr('disabled', false);
                $('#forum_category_dropdown').attr('disabled', false);
                $('#selected-forum-ico').html(button.find('.forum-ico').html());

                forum_category_dropdown = true;
                button.parent().css('display', 'none');
            },
            complete: function() {
                stop_spinner(spinner, 'search_forum_changer_spinner');
                spinner.addClass("opacity0");
                $('.select-forum').attr('style', '');
            }
        })
    }
    event.stopPropagation();
});

$('.adv-search-remove-filter').on('click', function() {
    let removed_filer = $(this).parent().find('.removed-filter').val();

    window.location.href = removeURLParameter(window.location.href, removed_filer);
});

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}

let forum_exists = category_exists = false;
let forum;
$('.removed-filter').each(function() {
    if($(this).val() == 'forum') {
        forum = $(this).parent().find('.adv-search-remove-filter');
        forum_exists = true;
    }
    if($(this).val() == 'category') {
        category_exists = true;
    }
});

if(forum_exists && category_exists) {
    forum.parent().css('padding-right', '8px')
    forum.remove();
}