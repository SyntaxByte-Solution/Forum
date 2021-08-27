// The reason why we move this from profile page (inline script) to here is because we're going to
// use Content Security Policy
$('.thread-component-follow-box').remove();

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



$('.follows-load').click(function(event) {
    event.preventDefault();
    let button = $(this);

    loadFollows(button);
});

function loadFollows(button) {
    let spinner = button.find('.spinner');
    let btn_txt_ing = button.parent().find('.button-text-ing').val();
    let btn_txt_no_ing = button.parent().find('.button-text-no-ing').val();

    button.val(btn_txt_ing);
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');
    

    let follow_container = button;
    while(!follow_container.hasClass('follow-container')) {
        follow_container = follow_container.parent();
    }

    let present_follows_count = follow_container.find('.follow-box-item').length;
    // The profile-s owner id not the current user id
    let user_id = follow_container.find('.profile_owner_id').val();

    start_spinner(spinner, 'load-more-followers-spinner');
    spinner.removeClass('opacity0');

    $.ajax({
        url: `/users/${user_id}/follows/load?range=8&skip=${present_follows_count}`,
        type: 'get',
        success: function(follows_rows) {
            if(follows_rows.hasNext == false) {
                button.addClass('none');
            }

            if(follows_rows.content != "") {
                $(`${follows_rows.content}`).insertBefore(button);
    
                /**
                 * Notice here when we fetch the notifications we return the number of fetched notifs
                 * because we need to handle the last count of appended components events
                 * 
                 */
                let unhandled_event_follow_components = 
                    follow_container.find('.follow-box-item').slice(follows_rows.count*(-1));
                    
                unhandled_event_follow_components.each(function() {
                    handle_follow_resource($(this).find('.follow-resource'));
                });
            }
        },
        complete: function() {
            button.find('.button-text').text(btn_txt_no_ing);
            button.attr('style', '');
            button.prop("disabled", false);
            spinner.addClass('opacity0');
            stop_spinner(spinner, 'load-more-followers-spinner');
        }
    })
}

$('.followers-load').click(function(event) {
    event.preventDefault();
    let button = $(this);

    loadFollowers(button);
});

function loadFollowers(button) {
    let spinner = button.find('.spinner');
    let btn_txt_ing = button.parent().find('.button-text-ing').val();
    let btn_txt_no_ing = button.parent().find('.button-text-no-ing').val();
    
    button.find('.button-text').text(btn_txt_ing);
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');
    
    let follow_container = button;
    while(!follow_container.hasClass('follow-container')) {
        follow_container = follow_container.parent();
    }

    let present_followers_count = follow_container.find('.follow-box-item').length;
    // The profile-s owner id not the current user id
    let user_id = follow_container.find('.profile_owner_id').val();

    start_spinner(spinner, 'load-more-followers-spinner');
    spinner.removeClass('opacity0');
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
            button.find('.button-text').text(btn_txt_no_ing);
            button.attr('style', '');
            button.prop("disabled", false);
            spinner.addClass('opacity0');
            stop_spinner(spinner, 'load-more-followers-spinner');
        }
    })
}