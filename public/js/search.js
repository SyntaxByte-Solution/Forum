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