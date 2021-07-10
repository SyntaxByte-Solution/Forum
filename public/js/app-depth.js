
var userId = $('.uid').first().val();
let csrf = document.querySelector('meta[name="csrf-token"]').content;
let urlParams = new URLSearchParams(window.location.search);

// the following section is for displaying viewers based on the value of query strings
// -------------------------------

if(urlParams.has('action')) {
    if(urlParams.get('action') == 'thread-delete') {
        $('.thread-deletion-viewer').css('display', 'block');
        $('.thread-deletion-viewer').css('opacity', '1');
    }
}

// -------------------------------

if($('#right-panel').height() > $(window).height()) {
    $(document).scroll(function() {
        if (document.documentElement.scrollTop + $(window).height() > 54 + $('#right-panel').height()) { 
            $('#right-panel').css({
                position: 'fixed',
                bottom: '0',
                top: 'unset'
            });
        } else {
            $('#right-panel').css({
                position: 'absolute',
                top: '0',
                bottom: 'unset'
            });
        }
    });
} else {
    $('#right-panel').css({
        position: 'fixed',
        top: '48px',
    });
}

$('.button-with-strip').on({
    mouseenter: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'block');
    },
    mouseleave: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'none');
    }
})

$('.stop-propagation').click(function(event) {
    event.stopPropagation();
})

$('.block-click').click(function() {
    return false;
});

$('.x-close-container').click(function(event) {
    $(this).parent().addClass('none');

    event.stopPropagation();
    event.preventDefault();
})

$('.handle-image-center-positioning').each(function() {
    handle_image_dimensions($(this));
});

function handle_image_dimensions(image) {
    let image_container = image.parent();

    width = image.width();
    height = image.height();
    if(width >= height) {
        image.height(image_container.height());
    } else {
        image.width(image_container.width());
    }
}
function handle_complexe_image_dimensions(image) {
    let image_container = image.parent();

    width = image.width();
    height = image.height();
    let ratio;
    if(width >= height) {
        // if(image_container.height() > height) {
        //     ratio = height * 1 / image_container.height();
        // } else {
        //     ratio = image_container.height() * 1 / height;
        // }

        // image.width(ratio*width);
        image.height(image_container.height());
    } else {
        // if(image_container.width() < width) {
        //     ratio = image_container.width() * 1 / width; 
        // } else {
        //     ratio = image_container.width() * 1 / width;
        // }

        image.width(image_container.width());
        //image.height(width*ratio);
    }
}

$(".button-with-suboptions").each(function() {
    handle_suboptions_container($(this));
});

$(".nested-soc-button").each(function() {
    handle_nested_soc($(this));
});

$('.notification-menu-button').each(function() {
    handle_notification_menu_buttons($(this));
})

$('.notification-container').each(function() {
    handle_notification_menu_appearence($(this));
});

function handle_suboptions_container(button) {
    button.on({
        'click': function(event) {
            let container = $(this).parent().find(".suboptions-container").first();
            if(container.css("display") == "none") {
                $(".suboptions-container").css("display", "none");
                $(".nested-soc").css("display", "none");
                container.css("display", "block");
            } else {
                container.css("display", "none");
            }
            return false;
        }
    });
}

function handle_nested_soc(button) {
    // nested-soc: nested suboptions container
    button.click(function() {
        // Handle only the third level of suboptions, later we're gonna handle infinite number of suboptions level

        if(button.parent().find('.nested-soc').css('display') == 'block') {
            button.parent().find('.nested-soc').css('display', 'none');
            return;
        }
        $('.nested-soc').css('display', 'none');
        button.parent().find('.nested-soc').css('display', 'block');
        return false;
    });
}

function handle_notification_menu_buttons(button) {
    button.click(function(event) {
        $('.notification-menu-button-container').addClass('none');
        button.parent().removeClass('none');
    })
}

function handle_notification_menu_appearence(notif_container) {
    notif_container.on({
        mouseenter: function() {
            $(this).find('.notification-menu-button-container').removeClass('none');
        },
        mouseleave: function() {
            if($(this).find('.nested-soc').css('display') == 'none') {
                $(this).find('.notification-menu-button-container').addClass('none');
            }
        }
    });
}

function handle_element_suboption_containers(container) {
    if(!container.hasClass('button-with-suboptions')) {
        container.find('.button-with-suboptions').each(function() {
            handle_suboptions_container($(this));
        })
    } else {
        handle_suboptions_container(container);
    }
}

document.addEventListener("click", function(event) {
    $(".suboptions-container").css("display", "none");
}, false);

let subContainers = document.querySelectorAll('.suboptions-container');
for(let i = 0;i<subContainers.length;i++) {
    subContainers[i].addEventListener("click", function(evt) {
        $(this).css("display", "block");
        $(".nested-soc").css("display", "none");
        evt.stopPropagation();
    }, false);
}

$('.close-shadowed-view-button').click(function() {
    let shadowed_container = $(this);

    while(!shadowed_container.hasClass('full-shadowed')) {
        shadowed_container = shadowed_container.parent();
    }

    shadowed_container.css('opacity', '0');
    shadowed_container.css('display', 'none');

    $('.suboptions-container').css('display', 'none');

    return false;
});

$('.expand-button').click(function() {
    let button = $(this);
    let state = button.parent().find('.expand-text-state').val();

    if(state == '0') {
        button.parent().find('.expandable-text').text(button.parent().find('.expand-whole-text').val());
        button.parent().find('.expand-text-state').val(1);
        button.parent().find('.expand-button').text(button.parent().find('.collapse-text').val());
    } else {
        button.parent().find('.expandable-text').text(button.parent().find('.expand-slice-text').val());
        button.parent().find('.expand-text-state').val(0);
        button.parent().find('.expand-button').text(button.parent().find('.expand-text').val());
    }
});

function heart_beating() {
    let heart = $('.heart-beating');

    if(heart.height() == 16) {
        heart.css('height', '19px');
        heart.css('width', '19px');
    } else {
        heart.css('height', '16px');
        heart.css('width', '16px');
    }
    
}

var t=setInterval(heart_beating,500);

$('.login-signin-button').click(function() {
    $('#login-view').parent().css('display', 'block');
    $('#login-view').parent().css('opacity', '1');

    return false;
});

$('#left-panel').height($(window).height() - $('header').height() - 30);

window.onresize = function(event) {
    $('#left-panel').height($(window).height() - $('header').height() - 30);
};

$('.reply-to-thread').click(function() {
    setTimeout(function(){$('textarea').focus();}, 200);
    
    location.hash = "#reply-site";
    return false;
});

$('.share-thread').click(function(event) {
    event.preventDefault();

    let data = {
        '_token':csrf,
        'subject': $('#subject').val(),
        'category_id': $('#category').val(),
        'content':simplemde.value(),
        'thread_type': $('#thread_type').val()
    };

    if(data.subject == '') {
        $('#subject').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#subject').parent().find('.frt-error').css('display', 'none');
    }

    if(data.category_id == '' || data.category_id == 0) {
        $('#category').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#category').parent().find('.frt-error').css('display', 'none');
    }

    if(data.content == '') {
        $('#content').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#thread-creation-forum').submit();
    }
    
    return false;
});

$('.turn-off-posts').click(function() {
    let button = $(this);
    let old_button_name = button.val();
    button.val('Please wait..')
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #acacac; cursor: default');

    let thread_id = $(this).parent().find('.id').val();
    let swtch = $(this).parent().find('.switch').val();

    $.ajax({
        type: 'post',
        url: '/thread/'+thread_id+'/posts/switch',
        data: {
            _token: csrf,
            switch: swtch
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            button.val(old_button_name);
            button.attr('style', '');
            button.prop("disabled", false);
        },
    })

    return false;
});

$('.edit-thread').click(function() {
    
    let thread_id = $(this).parent().find('.thread_id').val();
    let data = {
        '_token':csrf,
        'subject': $('#subject').val(),
        'category_id': $('#category').val(),
        'content':simplemde.value(),
        'thread_type': $('#thread_type').val(),
        '_method': $(this).parent().find('._method').val()
    };

    if($('#thread-post-switch').prop("checked") == true) {
        data.replies_off = 1;
    } else {
        data.replies_off = 0;
    }

    if(data.subject == '') {
        $('#subject').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#subject').parent().find('.frt-error').css('display', 'none');
    }

    if(data.category_id == '' || data.category_id == 0) {
        $('#category').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#category').parent().find('.frt-error').css('display', 'none');
    }

    if(data.content == '') {
        $('#content').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $.ajax({
            type: 'post',
            data: data,
            url: '/thread/'+thread_id,
            success: function(response) {
                document.location.href = response;
            }
        })
    }
    
    return false;
})

$('#category-dropdown').change(function() {
    let forum_slug = $('#forum-slug').val();
    let category_slug = $('#category-dropdown').val();
    if(category_slug == 'all') {
        url = '/'+forum_slug+'/all';
    } else {
        url = '/'+forum_slug+'/'+category_slug+'/threads';
    }

    document.location.href = url;
});

$('.copy-container-button').click(function() {
    $(this).parent().find('input').select();
    return false;
});

$('.copy-button').click(function() {
    $(this).parent().find('input').select();
    document.execCommand("copy");

    return false;
});

$('.action-verification').click(function(event) {
    let action_type = $(this).find('.verification-action-type').val();
    console.log(action_type);
    let container = $(this);
    while(!container.hasClass('shadow-contained-box')) {
        container = container.parent();
    }

    if(action_type == 'thread.destroy') {
        container.find('.thread-deletion-viewer').css('display', 'block');
        container.find('.thread-deletion-viewer').css('opacity', '1');
    } else if(action_type == 'turn.off.posts') {
        container.find('.turn-off-viewer').css('display', 'block');
        container.find('.turn-off-viewer').css('opacity', '1');
    }

    $('.suboptions-container').css('display', 'none');
    return false;
});

$('.tooltip-section').on({
    'mouseenter': function() {
        $(this).parent().find('.tooltip').css('display', 'block');
    },
    'mouseleave': function() {
        $(this).parent().find('.tooltip').css('display', 'none');
    }
})

let mouse_over_button = false;
let mouse_over_container = false;
let mouse_over_button_timeout;
let mouse_over_button_container_timeout;

$('.button-with-container').on({
    'mouseenter': function() {
        let button = $(this);
        setTimeout(function() {
            mouse_over_button = true;
            button.parent().find('.button-container').css('display', 'block');
            button.parent().find('.button-container').css('opacity', '1');
        }, 800);
    },
    'mouseleave': function() {
        let button = $(this);
        /*
            Here we need to check whether the mouse is over the button or container before closing the container as well
        */
        setTimeout(function() {
            mouse_over_button = false;
            if(!mouse_over_container) {
                button.parent().find('.button-container').css('display', 'none');
                button.parent().find('.button-container').css('opacity', '0');
            }
        }, 800);
    }
})
$('.button-container').on({
    mouseenter: function(event) {
        let container = $(this);
        setTimeout(function() {
            mouse_over_container = true;
            container.css('display', 'block');
            container.css('opacity', '1');
        }, 800)
        event.stopPropagation();
    },
    mouseleave: function(event) {
        let container = $(this);
        /*
            Here we need to check whether the mouse is over the button or container before closing the container as well
        */
       setTimeout(function() {
           mouse_over_container = false;
           if(!mouse_over_button) {
               container.css('display', 'none');
               container.css('opacity', '0');
           }
       }, 400);
    }
});

function handle_button_container(element) {
    element.find('.button-with-container').on({
        'mouseenter': function() {
            mouse_over_button = true;
            $(this).parent().find('.button-container').css('display', 'block');
            $(this).parent().find('.button-container').css('opacity', '1');
        },
        'mouseleave': function() {
            /*
                Here we need to check whether the mouse is over the button or container before closing the container as well
            */
            mouse_over_button = false;
            if(!mouse_over_container) {
                $(this).parent().find('.button-container').css('display', 'none');
                $(this).parent().find('.button-container').css('opacity', '0');
            }
        }
    });

    element.find('.button-container').on({
        mouseenter: function(event) {
            mouse_over_container = true;
            $(this).css('display', 'block');
            $(this).css('opacity', '1');
            event.stopPropagation();
        },
        mouseleave: function(event) {
            /*
                Here we need to check whether the mouse is over the button or container before closing the container as well
            */
            mouse_over_container = false;
            if(!mouse_over_button) {
                $(this).parent().find('.button-container').css('display', 'none');
                $(this).parent().find('.button-container').css('opacity', '0');
            }
        }
    });
}

function handle_close_shadowed_view(element) {
    element.click(function() {

        let shadowed_container = $(this);

        while(!shadowed_container.hasClass('full-shadowed')) {
            shadowed_container = shadowed_container.parent();
        }
        shadowed_container.css('display', 'none');
        $('.suboptions-container').css('display', 'none');

        return false;
    });
}

$('.hide-parent').click(function() {
    $(this).parent().css('display', 'none');

    return false;
});

$('.toggle-container-button').click(function() {
    let box = $(this);
    while(!box.hasClass('toggle-box')) {
        box = box.parent();
    }
    let container = box.find('.toggle-container');

    if(container.css('display') == 'none') {
        container.removeClass('none');
        container.addClass('block');
        $(this).find('.toggle-arrow').text('▾');
    } else {
        container.removeClass('block');
        container.addClass('none');
        $(this).find('.toggle-arrow').text('▸');
    }
    
    return false;
});

$('.row-num-changer').change(function() {
    let page_size = $(this).val();
    
    let urlObj = new URL(window.location.href.split('?')[0]);
    let url = '';

    urlObj.searchParams.set('pagesize', page_size);
    url = urlObj.href;

    window.location.href = url;
});

$('.check-username').click(function() {
    let button = $(this);
    let username = $('#username').val();
    
    button.val('checking..')
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #acacac; cursor: default');

    $.ajax({
        url: '/users/username/check',
        type: 'post',
        data: {
            'username': username,
            '_token': csrf
        },
        success: function(response) {
            button.val('check');
            button.attr('style', '');
            button.prop("disabled", false);
            button.parent().find('.red-box').addClass('none');
            button.parent().find('.green-box').removeClass('none');
            button.parent().find('.green-box').css('display', 'flex');

            if(response.valid) {
                button.parent().find('.green').text(response.message);
            } else {
                button.parent().find('.green-box').addClass('none');
                button.parent().find('.red-box').removeClass('none');
                button.parent().find('.red-box').css('display', 'flex');

                button.parent().find('.error').text(response.message);
            }
        },
        error: function(response) {
            button.val('check');
            button.attr('style', '');
            button.prop("disabled", false);

            button.parent().find('.green-box').addClass('none');;
            button.parent().find('.red-box').removeClass('none');;
            button.parent().find('.red-box').css('display', 'flex');

            let errorObject = JSON.parse(response.responseText).errors;
            let er = errorObject[Object.keys(errorObject)][0]; //returns the first error from laravel validator bag

            button.parent().find('.error').text(er);
        }
    })

    return false;
});

$('.remove-profile-avatar').click(function() {
    $(this).parent().find('.full-shadowed').css("display", 'block');
    $(this).parent().find('.full-shadowed').css("opacity", '1');

    return false;
})

$('.remove-avatar-button').click(function() {
    $('.us-settings-profile-picture').first().css('display', 'none');
    let shadowed_container = $(this);

    while(!shadowed_container.hasClass('full-shadowed')) {
        shadowed_container = shadowed_container.parent();
    }
    shadowed_container.css('display', 'none');
    $('.suboptions-container').css('display', 'none');

    $('.us-settings-profile-picture').last().removeClass('none');
    $('.us-settings-profile-picture').last().css('display', 'block');
    $('.remove-profile-avatar').css('display', 'none');

    $('.avatar-upload-button').value = '';
    $('.avatar-removed').val('1');
    return false;
});

$('.remove-profile-cover').click(function() {
    $(this).parent().parent().parent().find('.full-shadowed').css('display', 'flex');
    $(this).parent().parent().parent().find('.full-shadowed').animate({
        'opacity': 1
    });

    return false;
});

$('.remove-cover-button').click(function() {
    $('.us-cover').addClass('none');
    $('.remove-profile-cover').addClass('none');

    let shadowed_container = $(this);

    while(!shadowed_container.hasClass('full-shadowed')) {
        shadowed_container = shadowed_container.parent();
    }
    shadowed_container.css('display', 'none');
    $('.suboptions-container').css('display', 'none');

    $('.change-cover-back-container').removeClass('none');
    $('.change-cover-back-container').parent().removeClass('none');

    $('.cover-upload-button').value = '';
    $('.cover-removed').val('1');
    return false;
});

$('.avatar-upload-button').change(function(event) {
    if (event.target.files[0]) {
        $('.us-settings-profile-picture').first().attr('src', URL.createObjectURL(event.target.files[0]));
        $('.us-settings-profile-picture').first().css('display', 'block');
        $('.us-settings-profile-picture').last().css('display', 'none');
        $('.remove-profile-avatar').removeClass('none');
        $('.avatar-removed').val('0');
    }
});

$('.cover-upload-button').change(function(event) {
    if (event.target.files[0]) {
        $('.cub-first').addClass('none');
        $('.us-cover').attr('src', URL.createObjectURL(event.target.files[0]));
        $('.us-cover').removeClass('none');
        $('.change-cover-back-container').addClass('none');
        $('.change-cover-back-container').parent().addClass('none');
        $('.update-cover-box').removeClass('none');
        $('.remove-profile-cover').removeClass('none');

        $('.cover-removed').val('0');
    }
});

$('.delete-account').click(function() {
    $('#deactivate-account-container').addClass('none');
    $('#delete-account-container').removeClass('none');
    return false;
});

$('.deactivate-account').click(function() {
    $('#deactivate-account-container').removeClass('none');
    $('#delete-account-container').addClass('none');

    return false;
});

$('.send-feedback').click(function() {
    let button = $(this);

    let feedback_container = $(this);
    while(!feedback_container.hasClass('feedback-container')) {
        feedback_container = feedback_container.parent();
    }

    feedback_container.find('#email').attr('disabled', 'disabled');
    feedback_container.find('textarea').attr('disabled', 'disabled');
    button.attr('disabled', 'disabled');
    button.val('sending..');
    button.attr('style', 'background-color: #acacac; cursor: default');

    $.ajax({
        url: '/feedback',
        type: 'POST',
        data: {
            '_token': csrf,
            'email': feedback_container.find('#email').val(),
            'feedback': feedback_container.find('#feedback').val(),
        },
        success: function(response) {
            feedback_container.find('.feedback-sec').addClass('none');
            feedback_container.find('.feedback-sent-success-container').removeClass('none');
        },
        error: function(response) {
            feedback_container.find('#email').removeAttr('disabled');
            feedback_container.find('textarea').removeAttr('disabled');
            button.removeAttr('disabled');
            button.val('send');
            button.attr('style', '');
            let er = '';
            try {
                let errorObject = JSON.parse(response.responseText).errors;
                er = errorObject[Object.keys(errorObject)][0];
            } catch(e) {
                er = 'This form has limited attempts please try again later !';
            }

            feedback_container.find('.error').removeClass('none');
            feedback_container.find('.error').text('* ' + er);
        }
    })
});

$('.emoji-button').click(function(event) {
    event.preventDefault();
    let emoji_button = $(this);

    $(this).find('.emoji-unfilled').css('display', 'none');
    $('.emoji-unfilled').animate({
        opacity: '0.5'
    }, 300);
    $(this).find('.emoji-filled').removeClass('none');

    $('.emoji-button').off('click');
    $('.emoji-button').click(function() {
        return false;
    });

    $.ajax({
        url: '/emojifeedback',
        type: 'post',
        data: {
            _token: csrf,
            emoji_feedback: emoji_button.find('.feedback-emoji-state').val()
        }
    });
});

let vote_lock = true;
$('.votable-up-vote').click(function(event) {
    handle_up_vote($(this));

    event.preventDefault();
});

$('.votable-down-vote').click(function(event) {
    handle_down_vote($(this));

    event.preventDefault();
});

let informer_container_timeout;
function handle_up_vote(button) {
    if(!vote_lock) {
        return false;
    }
    vote_lock = false;

    let vote_count = parseInt(button.parent().find('.votable-count').text());

    if(button.find('.vote-up-image').hasClass('none')) {
        // In this case the user is already votes up and then press up again so we need to delete the vote record
        button.parent().find('.votable-count').text(vote_count-1);
        button.find('.vote-up-image').removeClass('none');
        button.find('.vote-up-filled-image').addClass('none');
    
        button.parent().find('.vote-down-image').removeClass('none');
        button.parent().find('.vote-down-filled-image').addClass('none');
    } else {
        // here we have 2 cases:
        // 1- case where the user is not voted at all we only need to add 1
        if(button.parent().find('.vote-up-filled-image').hasClass('none') && button.parent().find('.vote-down-filled-image').hasClass('none')) {
            button.parent().find('.votable-count').text(vote_count+1);    
        // 2- case where the user is already down voted the resource and then he press up vote, we need to add 2 in this case
        } else {
            button.parent().find('.votable-count').text(vote_count+2);
        }
        button.find('.vote-up-image').addClass('none');
        button.find('.vote-up-filled-image').removeClass('none');
    
        button.parent().find('.vote-down-image').removeClass('none');
        button.parent().find('.vote-down-filled-image').addClass('none');
    }

    let resource_container = button;
    while(!resource_container.hasClass('resource-container')) {
        resource_container = resource_container.parent();
    }
    let votable_id = resource_container.find('.votable-id').val();
    let votable_type = resource_container.find('.votable-type').val();

    $.ajax({
        type: 'POST',
        url: '/' + votable_type + '/' + votable_id + '/vote',
        data: {
            _token: csrf,
            'vote': 1
        },
        success: function(response) {
            button.parent().find('.votable-count').text(response);
        },
        error: function(xhr, status, error) {
            if(button.find('.vote-up-image').hasClass('none')) {
                button.find('.vote-up-image').removeClass('none');
                button.find('.vote-up-filled-image').addClass('none');
            } else {
                button.find('.vote-up-image').addClass('none');
                button.find('.vote-up-filled-image').removeClass('none');
            }
            // If there's an error we simply set the old value
            button.parent().find('.votable-count').text(vote_count);

            let errorObject = JSON.parse(xhr.responseText);
            let er = errorObject.message;
            // and then print the error returned in the informer-message-container
            let vote_message_container = button.parent().find('.informer-message-container').first();
            vote_message_container.find('.informer-message').text(er);
            vote_message_container.css('display', 'block');

            informer_container_timeout = setTimeout( function(){ 
                vote_message_container.css('display', 'none');
            }, 4000);
        },
        complete: function() {
            vote_lock = true;
        }
    });
}

function handle_down_vote(button) {
    if(!vote_lock) {
        return false;
    }
    vote_lock = false;

    let vote_count = parseInt(button.parent().find('.votable-count').text());

    if(button.find('.vote-down-image').hasClass('none')) {
        button.parent().find('.votable-count').text(vote_count+1);
        button.find('.vote-down-image').removeClass('none');
        button.find('.vote-down-filled-image').addClass('none');
    
        button.parent().find('.vote-up-image').removeClass('none');
        button.parent().find('.vote-up-filled-image').addClass('none');
    } else {
        // here alse we have 2 cases:
        // 1- case where the user is not voted at all we only need to subtract 1
        if(button.parent().find('.vote-up-filled-image').hasClass('none') && button.parent().find('.vote-down-filled-image').hasClass('none')) {
            button.parent().find('.votable-count').text(vote_count-1);    
        // 2- case where the user is already up voted the resource and then he press down vote, we need to subtract 2 in this case
        } else {
            button.parent().find('.votable-count').text(vote_count-2);
        }
        button.find('.vote-down-image').addClass('none');
        button.find('.vote-down-filled-image').removeClass('none');
    
        button.parent().find('.vote-up-image').removeClass('none');
        button.parent().find('.vote-up-filled-image').addClass('none');
    }

    let resource_container = button;
    while(!resource_container.hasClass('resource-container')) {
        resource_container = resource_container.parent();
    }
    let votable_id = resource_container.find('.votable-id').val();
    let votable_type = resource_container.find('.votable-type').val();

    $.ajax({
        type: 'POST',
        url: '/' + votable_type + '/' + votable_id + '/vote',
        data: {
            _token: csrf,
            'vote': -1
        },
        success: function(response) {
            button.parent().find('.votable-count').text(response);
        },
        error: function(xhr, status, error) {
            button.find('.vote-up-filled-image').addClass('none');
            button.find('.vote-down-filled-image').addClass('none');
            button.find('.vote-up-image').removeClass('none');
            button.find('.vote-down-image').removeClass('none');

            // If there's an error we simply set the old value
            button.parent().find('.votable-count').text(vote_count);

            let errorObject = JSON.parse(xhr.responseText);
            let er = errorObject.message;
            // and then print the error returned in the vote-message-container
            let vote_message_container = button.parent().find('.informer-message-container').first();
            vote_message_container.find('.informer-message').text(er);
            vote_message_container.css('display', 'block');

            informer_container_timeout = setTimeout( function(){ 
                vote_message_container.css('display', 'none');
            }, 4000);

        },
        complete: function() {
            vote_lock = true;
        }
    })
}

$('.remove-informer-message-container').click(function() {
    let vote_container = $(this);
    while(!vote_container.hasClass('informer-message-container')) {
        vote_container = vote_container.parent();
    }


    clearTimeout(informer_container_timeout);

    vote_container.css('display', 'none');
});

function handle_remove_informer_message_container(element) {
    button = element.find('.remove-informer-message-container');
    button.click(function(event) {
        let vote_container = $(this);
        while(!vote_container.hasClass('informer-message-container')) {
            vote_container = vote_container.parent();
        }
    
    
        clearTimeout(informer_container_timeout);
    
        vote_container.css('display', 'none');
        event.preventDefault();
    });
}

function handle_hover_informer_display(element) {
    element.find('.hover-informer-display-element').on({
        mouseenter: function() {
            $(this).parent().find('.informer-message-container').css('display', 'block');
        },
        mouseleave: function() {
            $(this).parent().find('.informer-message-container').css('display', 'none');
        }
    })
}

function handle_resource_like(resource) {
    resource.find('.like-resource').click(function() {
        let resource_likes_counter = parseInt(resource.find('.resource-likes-counter').text());
        if($(this).find('.gray-love').hasClass('none')) {
            resource.find('.resource-likes-counter').text(resource_likes_counter - 1);
            $(this).find('.gray-love').removeClass('none');
            $(this).find('.red-love').addClass('none');
        } else {
            resource.find('.resource-likes-counter').text(resource_likes_counter + 1);
            $(this).find('.gray-love').addClass('none');
            $(this).find('.red-love').removeClass('none');
        }
    
        let likable_id = resource.find('.likable-id').val();
        let likable_type = resource.find('.likable-type').val();

        $.ajax({
            type: 'POST',
            url: '/' + likable_type + '/' + likable_id + '/like',
            data: {
                _token: csrf,
            },
            success: function(response) {
                
            },
            error: function(xhr, status, error) {
                if($(this).find('.gray-love').hasClass('none')) {
                    $(this).find('.gray-love').removeClass('none');
                    $(this).find('.red-love').addClass('none');
                } else {
                    $(this).find('.gray-love').addClass('none');
                    $(this).find('.red-love').removeClass('none');
                }
                // If there's an error we simply set the old value
                resource.find('.resource-likes-count').text(resource_likes_counter);
    
                let errorObject = JSON.parse(xhr.responseText);
                let er = errorObject.message;


            },
            complete: function() {
                vote_lock = true;
            }
        });
    
        event.preventDefault();
    });
}

$(".resource-container").each(function() {
    if($(this).find('.like-resource')[0]) {
        handle_resource_like($(this));
    }
});

$('.set-lang').click(function(event) {
    let language = $(this).find('.lang-value').val();
    
    $.ajax({
        type: 'post',
        url: '/setlang',
        data: {
            _token: csrf,
            lang: language
        },
        success: function() {
            location.reload();
        }
    });

    event.preventDefault();
});

$('.find-keys').click(function() {
    let content = $('#multilang_textarea').val();
    let result = {};
    let r = 0;
    let cursor = 0;
    let current;
    while(current=content[cursor]) {
        if(current == '_') {
            if(content[cursor+1] == '_' && content[cursor+2] == '(') {
                let closing_quote = (content[cursor+3] == "'") ? "'" : '"';
                let key = '';
                cursor = cursor+4;
                while((k=content[cursor]) != closing_quote) {
                    key += k;
                    cursor++;
                }
                result[key] = '';
                continue;
            }
        }

        cursor++;
    }

    let lang_comparison_list = $('#lang-comparison-list').val();

    // Check if the user check a file to compare keys with and remove already existed translated keys
    if(lang_comparison_list != 'none') {
        let lang = lang_comparison_list;

        $.ajax({
            type: 'get',
            url: '/languages/' + lang + '/keys' ,
            success: function(language_file_keys) {
                language_file_keys = JSON.parse(language_file_keys);
                // Now we have two language keys in for of objects
                // All we want to do is to subtract the keys exist in language file from the results generated keys
                // because we don't need to add already translated strings in our result
                // That's mean whatever is generated after the following loop have to be added to the language file
                Object.keys(result).forEach((item) => {
                    if(item in language_file_keys) {
                        delete result[item];
                    }
                });

                $('#multilang_result_textarea').val(JSON.stringify(result, null, 4));
            }
        })
    } else {
        let generated_json = JSON.stringify(result, null, " ");
        $('#multilang_result_textarea').val(generated_json + '\n');        
    }
});

$('.notification-button').click(function() {
    handle_mark_as_read();
});

function handle_mark_as_read() {
    $.ajax({
        type: 'post',
        url: '/notifications/markasread',
        data: {
            _token: csrf
        },
        success: function() {
            $('.header-button-counter-indicator').addClass('none');
            $('.header-button-counter-indicator').text('0');
        }
    })
}

let notification_timeout;
if(userId != "") {
    Echo.private('user.' + userId + '.notifications')
        .notification((notification) => {
            // Stop animatio if there's already animation
            $('.hidden-notification-container').stop();
            clearTimeout(notification_timeout);

            $('.header-button-counter-indicator').removeClass('none');
            let notif_counter_value = $('.header-button-counter-indicator').text();
            if (!(notif_counter_value.indexOf('+') > -1)) {
                $('.header-button-counter-indicator').text(parseInt(notif_counter_value) + 1);
            }
            $('.notification-empty-box').addClass('none');

            $('.hidden-notification-container .hidden-notification-image').attr('src', notification.image);
            $('.hidden-notification-container .hidden-notification-action-taker').text(notification.action_taker_name);
            $('.hidden-notification-container .hidden-notification-content').text(notification.action_statement + notification.resource_string_slice);
            $('.hidden-notification-container').attr('href', notification.action_resource_link);

            let lastClass = $('.hidden-notification-type-icon').attr('class').split(' ').pop();
            $('.hidden-notification-type-icon').removeClass(lastClass);
            $('.hidden-notification-type-icon').addClass(notification.resource_action_icon);

            $('.hidden-notification-container').removeClass('none');
            $('.hidden-notification-container').animate({
                'opacity': 1
            }, 600);

            notification_timeout = setTimeout(function() {
                $('.hidden-notification-container').animate({
                    'opacity': 0
                }, 600, function() {
                    $('.hidden-notification-container').addClass('none');
                });
            }, 5000);

            $.ajax({
                type: 'post',
                url: '/notification/generate',
                data: {
                    _token: csrf,
                    notif_id: notification.id,
                    action_user: notification.action_user,
                    action_statement: notification.action_statement,
                    resource_string_slice: notification.resource_string_slice,
                    action_date: notification.resource_date,
                    action_resource_link: notification.action_resource_link,
                    resource_action_icon: notification.resource_action_icon,
                    notif_read: notification.notif_read,
                },
                success: function(response) {
                    $('.notifs-box').prepend(response);
                    let appended_component = $('.notifs-box').last().find('.notification-container').first();
                    handle_notification_menu_appearence(appended_component);
                    handle_notification_menu_buttons(appended_component.find('.notification-menu-button'));
                    handle_nested_soc(appended_component.find('.notification-menu-button'));
                    handle_delete_notification(appended_component.find('.delete-notification'));
                    handle_disable_switch_notification(appended_component.find('.disable-switch-notification'));
                }
            })
        });
}

$('.notifications-load').click(function(event) {
    event.preventDefault();
    let button = $(this);

    loadNotifications(button);
});

function loadNotifications(button) {
    button.val('loading..')
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');
    
    let notifs_box = button;
    while(!notifs_box.hasClass('notifs-box')) {
        notifs_box = notifs_box.parent();
    }

    let present_notifs_count = notifs_box.find('.notification-container').length;

    $.ajax({
        url: '/notifications/generate?range='+6+'&skip='+present_notifs_count,
        type: 'get',
        success: function(notifications_components) {
            if(notifications_components.hasNext == false) {
                button.addClass('none');
            }

            if(notifications_components.content != "") {
                $(`${notifications_components.content}`).insertBefore(button);
    
                /**
                 * Notice here when we fetch the notifications we return the number of fetched notifs
                 * because we need to handle the last count of appended components events
                 * 
                 */
                let unhandled_event_notification_components = 
                    $('.notifs-box > .notification-container').slice(notifications_components.count*(-1));
                
                unhandled_event_notification_components.each(function() {
                    handle_notification_menu_appearence($(this));
                    handle_notification_menu_buttons($(this).find('.notification-menu-button'));
                    handle_nested_soc($(this).find('.notification-menu-button'));
                    handle_delete_notification($(this).find('.delete-notification'));
                    handle_disable_switch_notification($(this).find('.disable-switch-notification'));
                });
            }
        },
        complete: function() {
            button.val('load more');
            button.attr('style', '');
            button.prop("disabled", false);
            $('.notif-state-couter').val(present_notifs_count+1);
        }
    })
}

$('.hidden-notification-container').on({
    mouseenter: function(event) {
        clearTimeout(notification_timeout);
        $('.header-button-counter-indicator').addClass("none")
        $('.hidden-notification-container').stop();
        $('.hidden-notification-container').removeClass('none');
        $('.hidden-notification-container').css('opacity', '1');
        handle_mark_as_read();
    }, 
    mouseleave: function(event) {
        notification_timeout = setTimeout(function() {
            $('.hidden-notification-container').animate({
                'opacity': 0
            }, 600, function() {
                $('.hidden-notification-container').addClass('none');
            });
        }, 5000);
    }
});

$('.delete-notification').each(function() {
    handle_delete_notification($(this));
})

$('.disable-switch-notification').each(function() {
    handle_disable_switch_notification($(this));
})

let notification_delete_lock = true;
function handle_delete_notification(button) {
    button.click(function() {
        if(!notification_delete_lock) {
            return false;;
        }
        notification_delete_lock = false;

        let notif_id = button.parent().find('.notif-id').val();
        let notif_container = button;
        while(!notif_container.hasClass('notification-container')) {
            notif_container = notif_container.parent();
        }

        button.find('.button-text').text(button.find('.message-ing').val());
        button.addClass('block-click');
        button.attr('style', 'background-color: #dddddd5e; cursor: default');
        $.ajax({
            url: `/notification/${notif_id}/delete`,
            type: 'delete',
            data: {
                _token: csrf,
            },
            success: function() {
                notif_container.remove();
                if(!$('.notifs-box .notification-container')[0]) {
                    $('.notification-empty-box').removeClass('none');
                }
            },
            complete: function() {
                notification_delete_lock = true;
            }
        })

        return false;
    });
}

let notification_disable_switch_lock = true;
function handle_disable_switch_notification(button) {
    button.click(function() {
        if(!notification_disable_switch_lock) {
            return false;;
        }
        notification_disable_switch_lock = false;

        let notif_id = button.parent().find('.notif-id').val();

        button.attr('style', 'background-color: #dddddd5e; cursor: default');

        let url;
        if(button.hasClass('disable-notification')) {
            button.find('.button-text').text(button.find('.disable-message-ing').val());
            url = `/notification/${notif_id}/disable`;
        } else {
            button.find('.button-text').text(button.find('.enable-message-ing').val());
            url = `/notification/${notif_id}/enable`;
        }

        $.ajax({
            url: url,
            type: 'post',
            data: {
                _token: csrf,
            },
            success: function(response) {
                if(response == 'enabled') {
                    button.find('.notif-switch-icon').removeClass('enablenotif17b-icon');
                    button.find('.notif-switch-icon').addClass('disablenotif17b-icon');

                    button.removeClass('enable-notification');
                    button.addClass('disable-notification');

                    button.find('.button-text').text(button.find('.disable-action-text').val());
                } else {
                    button.find('.notif-switch-icon').removeClass('disablenotif17b-icon');
                    button.find('.notif-switch-icon').addClass('enablenotif17b-icon');

                    button.removeClass('disable-notification');
                    button.addClass('enable-notification');

                    button.find('.button-text').text(button.find('.enable-action-text').val());
                }
            },
            complete: function() {
                button.attr('style', '');
                notification_disable_switch_lock = true;
            }
        })

        return false;
    });
}

// Thread Add scripts
let thread_add_forum_lock = true;
$('.thread-add-forum').click(function() {
    if(!thread_add_forum_lock) {
        return;
    }
    thread_add_forum_lock = false;

    let button = $(this);
    let loading_anim = button.find('.loading-dots-anim');
    loading_anim.removeClass('none');
    start_loading_anim(loading_anim);

    let thread_add_container = button;
    while(!thread_add_container.hasClass('thread-add-container')) {
        thread_add_container = thread_add_container.parent();
    }

    let forum_id = button.find('.forum-id').val();

    $.ajax({
        url: `/forums/${forum_id}/categories/ids`,
        type: 'get',
        success: function(response) {
            let categories = JSON.parse(response);
            $('.thread-add-category:not(:first)').remove();

            let first_iteration = true;
            $.each(categories, function(id, category){
                if(first_iteration) {
                    $('.thread-add-selected-category').text(category);
                    $('.thread-add-category').find('.thread-add-category-val').text(category);
                    $('.thread-add-category').find('.category-id').text(id);
                    thread_add_container.find('.category').val(id);
                    first_iteration = false;
                } else {
                    $('.thread-add-categories-container').append(`
                        <div class="thread-add-suboption thread-add-category flex align-center">
                            <span class="thread-add-category-val">${category}</span>
                            <input type="hidden" class="category-id" value="${id}">
                        </div>
                    `);

                    handle_category_selection($('.thread-add-category').last());
                }
            });
        },
        complete: function() {
            // Stop loading animation
            loading_anim.addClass('none');
            loading_anim.text('.');
            stop_loading_anim();

            thread_add_container.find('.forum').val(forum_id);

            // setting forum to posted to:
            $('.thread-add-selected-forum').text(button.find('.thread-add-forum-val').text());
            // Hide the suboptions container
            $('.thread-add-forum').removeClass('thread-add-suboption-selected');
            
            button.addClass('thread-add-suboption-selected');
            button.parent().css('display', 'none');
            thread_add_forum_lock = true;
        }
    })
});

$('.thread-add-category').each(function() {
    handle_category_selection($(this));
})

function handle_category_selection(category_button) {
    category_button.click(function(event) {
        event.stopPropagation();
        $(".thread-add-selected-category").text(category_button.find('.thread-add-category-val').text());

        let container = category_button;
        while(!container.hasClass('thread-add-container')) {
            container = container.parent();
        }
        container.find('.category').val(category_button.find('.category-id').val());

        $(this).parent().parent().css('display', 'none');
    });
}

let loading_anim_interval;
function start_loading_anim(loading_anim) {
    loading_anim_interval = window.setInterval(function(){
        if(loading_anim.text() == "•") {
            loading_anim.text("••");
        } else if(loading_anim.text() == "••") {
            loading_anim.text("•••");
        } else {
            loading_anim.text("•");
        }
    }, 300);
}

function stop_loading_anim() {
    clearInterval(loading_anim_interval);
}

$('.thread-add-share').click(function(event) {
    event.preventDefault();

    let data = {
        '_token':csrf,
        'subject': $('#subject').val(),
        'category_id': $('.category').val(),
        'status_id': $('.thread-add-status-slug').val(),
        'content':simplemde.value(),
    };

    let button = $(this);
    let container = $(this);
    while(!container.hasClass('thread-add-container')) {
        container = container.parent();
    }

    if(data.subject == '') {
        $('#subject').parent().find('.error').removeClass('none');
        container.find('.thread-add-error').text($('#subject').parent().find('.required-text').val());
        container.find('.thread-add-error').removeClass('none');
        return;
    } else {
        $('#subject').parent().find('.error').addClass('none');
        container.find('.thread-add-error').text("");
        container.find('.thread-add-error').addClass('none');
    }

    if(data.content == '') {
        $('#content').parent().find('.error').removeClass('none');
        container.find('.thread-add-error').text($('#content').parent().find('.required-text').val());
        container.find('.thread-add-error').removeClass('none');
        return;
    } else {
        $('#content').parent().find('.error').addClass('none');
        container.find('.thread-add-error').addClass('none');
    }

    button.val(button.parent().find('.message-ing').val());
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #acacac; cursor: default');
    $.ajax({
        url: '/thread',
        type: 'post',
        data: data,
        success: function(response) {
            $('#subject').val('');
            simplemde.value('');
            // Show notification flash
            window.location.href = response;
        },
        error: function(response) {
            let er;
            let error = JSON.parse(response.responseText).error;
            if(error) {
                er = JSON.parse(response.responseText).error;
            } else {
                let errorObject = JSON.parse(response.responseText).errors;
                er = errorObject[Object.keys(errorObject)[0]][0];
            }

            container.find('.thread-add-error').removeClass('none');
            container.find('.thread-add-error').html(er);
        },
        complete: function(response) {
            button.val(button.parent().find('.message-no-ing').val());
            button.attr('style', '');
            button.prop("disabled", false);
        }
    })
    $('#thread-creation-forum').submit();
    
    return false;
})

$('.thread-container-box').each(function() {
    handle_thread_display($(this));
});

function handle_thread_display(thread_container_box) {
    thread_container_box.find('.thread-display-button').click(function() {
        let thread_component_display = thread_container_box.find('.thread-component').css('display');

        if(thread_component_display == 'none') {
            thread_container_box.find('.thread-component').css('display', 'flex');
            thread_container_box.find('.hidden-thread-section').addClass('none');
        } else {
            thread_container_box.find('.thread-component').css('display', 'none');
            thread_container_box.find('.hidden-thread-section').removeClass('none');
        }
    });
}

let thread_status_lock = true;
$('.thread-status-button').click(function() {
    if(!thread_status_lock) {
        return;
    }
    thread_status_lock = false;

    thread_container_box = $(this);
    while(!thread_container_box.hasClass('status-box')) {
        thread_container_box = thread_container_box.parent();
    }

    thread_container_box.find('.thread-status-button').attr('style','background-color: rgb(250, 250, 250); color: gray');
    $(this).attr('style', 'background-color: rgb(240, 240, 240); color: black');
    let loading = $(this).find('.loading-dots-anim');
    loading.removeClass('none');
    start_loading_anim(loading);
    
    let button = $(this);

    let thread_id = $(this).parent().find('.thread-id').val();
    let status_slug = $(this).find('.thread-add-status-slug').val();

    $.ajax({
        url: `/thread/status/patch`,
        type: 'patch',
        data: {
            _token: csrf,
            thread_id: thread_id,
            status_slug: status_slug
        },
        success: function() {
            let button_ico = thread_container_box.find('.thread-status-button-14icon');
            let lastClass = button_ico.attr('class').split(' ').pop();
            button_ico.removeClass(lastClass);
            button_ico.addClass(button.find('.icon-when-selected').val());
        },
        complete: function() {
            thread_status_lock = true;
            stop_loading_anim(loading);
            loading.addClass('none');
            thread_container_box.find('.thread-status-button').attr('style','');

            button.parent().css('display', 'none');
        }
    });

});

$('.thread-add-status').click(function(event) {
    event.stopPropagation();

    let container = $(this);
    while(!container.hasClass('thread-add-container')) {
        container = container.parent();
    }

    container.find('.thread-add-status-slug').val($(this).find('.thread-state').val())

    let icon_when_selected = $(this).find('.icon-when-selected').val();
    let status_ico = container.find('.thread-add-status-icon');
    let lastClass = status_ico.attr('class').split(' ').pop();

    status_ico.removeClass(lastClass);
    status_ico.addClass(icon_when_selected);
    console.log($(this).parent());
    $(this).parent().css('display', 'none');
});

$('.follow-resource').each(function() {
    handle_follow_resource($(this));
});

let follow_resource_lock = true;
function handle_follow_resource(button) {
    button.click(function() {
        if(!follow_resource_lock) {
            return;
        }
        follow_resource_lock = false;

        let follow_box = $(this);
        while(!follow_box.hasClass('follow-box')) {
            follow_box = follow_box.parent();
        }
    
        button.attr('style', 'background-color: #009fffad; border-color: #009fffad; cursor: default');
    
        if(button.find('.status').val() == '1') {
            button.find('.btn-txt').text(button.find('.unfollowing-text').val());
        } else {
            button.find('.btn-txt').text(button.find('.following-text').val());
        }
    
        let followable_id = button.find('.followable-id').val();
        let followable_type = button.find('.followable-type').val();
    
        $.ajax({
            type: 'post',
            url: `/${followable_type}s/${followable_id}/follow`,
            data: {
                _token: csrf
            },
            success: function(response) {
                let followers_counter = follow_box.find('.followers-counter');
                let button_icon = button.find('.follow-button-icon');
                let lastClass = button_icon.attr('class').trim().split(' ').pop();
                button_icon.removeClass(lastClass);
                if(response == -1) {
                    button.find('.status').val(-1);
                    button_icon.addClass(button.find('.unfollowed-icon').val());
                    button.find('.btn-txt').text(button.find('.follow-text').val());
                    followers_counter.text(parseInt(followers_counter.text()) - 1);
                } else {
                    button.find('.status').val(1);
                    button_icon.addClass(button.find('.followed-icon').val());
                    button.find('.btn-txt').text(button.find('.followed-text').val());
                    followers_counter.text(parseInt(followers_counter.text()) + 1);
                }
            },
            complete: function() {
                button.attr('style', '');
                follow_resource_lock = true;
            }
        });
    })
}

// ---------------- THREAD ADD EMBBED MEDIA SHARING ----------------

let uploaded_thread_assets = [];
// This will track image uploads --- [Now it is possible to share more than one image] ---
$("#thread-photos").change(function(event) {
    /**
     * IMPORTANT: Because this is input file, if it gets clicked two times a row, then it will remove all the first files and
     * replace them with the new files so we will handle the situation where we upload more than one file; then we put them in an array;
     * then later if the user want to add more image or video; we'll take that addition and append it to the array(uploaded_thread_assets)
     * First we get the container and store it in a variable, then we loop through files and assign each one to the container and append
     * it to the post container to show it to the user
     */

    /**
     * First get the new uploaded files and passed them to validation function.
     * Images type validation function get the files, verify their types and then return an array of validated images
     * If the length of the returned array matches the length of original array of files; that means all files are validated :)
     * If not display the 
     */
     let media_container = $(this);
     while(!media_container.hasClass('thread-add-media-section')) {
         media_container = media_container.parent();    
     }

    let images = event.originalEvent.target.files;
    if(images.length != validate_image_file_Type(images).length) {
        /**
         * Print error: Only jpeg, png .. are supported
         * (tame: thread add media error)
         */
        media_container.find('.tame-image-type').removeClass('none');
    } else {
        media_container.find('.tame-image-type').addClass('none');
    }

    images = validate_image_file_Type(images);
    uploaded_thread_assets.push(...images);

    /**
     * Now we loop through the new files and append them to thread-add-uploaded-medias-container by cloning 
     * thread-add-uploaded-media-projection-model container
     * About the other validations like file size we're gonna implement them in the backend
     */
    for (let i = 0; i < images.length; i++) {
        let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
        $('.thread-add-uploaded-medias-container').append(clone);

        // We get the last uploaded image container
        let last_uploaded_image = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
        last_uploaded_image.removeClass('none thread-add-uploaded-media-projection-model');
        let img = last_uploaded_image.find(".thread-add-uploaded-image");
        img.removeClass('none');

        // Preview the image
        load_image(images[i], img);

        
    }
});

let load_image = function(file, image) {
    let reader = new FileReader();
    reader.onload = function(){
        image.attr('src', reader.result);
        image.on('load', function() {
            handle_image_dimensions(image);
        })
        
    };
    reader.readAsDataURL(file);
};

$('.close-thread-media-upload').click(function() {
    console.log('closing ..');
});

Array.prototype.contains = function(element){
    return this.indexOf(element) > -1;
};

// Validate images upload
function validate_image_file_Type(files){
    let extensions = ["jpg", "jpeg", "png", "gif"];
    let result = [];
    for(let i = 0; i<files.length;i++) {
        fileName = files[i].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if(extensions.contains(extFile)) {
            result.push(files[i]);
        }
    }

    return result;
}