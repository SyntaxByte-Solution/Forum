$('.sort-by-option').on('click', function() {
    let sort_by_key = $(this).find('.sort-by-key').val();
    window.location.href = updateQueryStringParameter(window.location.href, 'sortby', sort_by_key);
});