$('.followers-display').click(function() {
    $('.followers-viewer').css('display', 'block');
    $('.followers-viewer').animate({
        opacity: '1'
    }, 200);
});

$('.follows-display').click(function() {
    $('.follows-viewer').css('display', 'block');
    $('.follows-viewer').animate({
        opacity: '1'
    }, 200);
});



$('.followers-load').click(function(event) {
    event.preventDefault();
    let button = $(this);

    loadFollowers(button);
});

function loadFollowers(button) {
    button.val('loading..')
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');
    
    let follow_container = button;
    while(!follow_container.hasClass('follow-container')) {
        follow_container = follow_container.parent();
    }

    let present_followers_count = follow_container.find('.follow-box-item').length;
    // The profile-s owner id not the current user id
    let user_id = follow_container.find('.profile_owner_id').val();

    $.ajax({
        url: `/users/${user_id}/followers/load?range=8&skip=${present_followers_count}`,
        type: 'get',
        success: function(followers_rows) {
            if(followers_rows.hasNext == false) {
                button.addClass('none');
            }

            if(followers_rows.content != "") {
                $(`${followers_rows.content}`).insertBefore(button);
    
                /**
                 * Notice here when we fetch the notifications we return the number of fetched notifs
                 * because we need to handle the last count of appended components events
                 * 
                 */
                let unhandled_event_follow_components = 
                    follow_container.find('.follow-box-item').slice(followers_rows.count*(-1));
                    
                unhandled_event_follow_components.each(function() {
                    handle_follow_resource($(this).find('.follow-resource'));
                });
            }
        },
        complete: function() {
            button.val('load more');
            button.attr('style', '');
            button.prop("disabled", false);
        }
    })
}