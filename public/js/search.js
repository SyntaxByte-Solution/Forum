$('#forum_category_dropdown').change(function() {
    $(this).attr('disabled', true);
    $('#category_dropdown').attr('disabled', true);
    let forum_id = $(this).val();
    if(forum_id == 0) {
        $('#category_dropdown option:not(:first)').remove();

        $('#category_dropdown').attr('disabled', false);
        $('#forum_category_dropdown').attr('disabled', false);
    } else {
        $.ajax({
            type: 'get',
            url: '/forums/' + forum_id + '/categories/ids',
            success: function(response) {
                let categories = JSON.parse(response);
                $('#category_dropdown option:not(:first)').remove();
                $.each(categories, function(id, category){
                    $('#category_dropdown').append("<option value='" + id + "'>" + category + "</option>");
                });
                $('#category_dropdown').attr('disabled', false);
                $('#forum_category_dropdown').attr('disabled', false);
            }
        })
    }
})

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