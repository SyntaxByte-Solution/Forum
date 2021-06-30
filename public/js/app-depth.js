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
    let image_container = $(this).parent();
    let image = $(this);
    let height;
    let width;

    image.on('load', function(){
        width = $(this).width();
        height = $(this).height();

        if(width >= height) {
            image.height(image_container.height());
        } else {
            let ratio = height / width;
            image.width(image_container.width());
            image.height(image_container.width() * ratio);
        }
    });

});

$(".button-with-suboptions").each(function() {
    handle_suboptions_container($(this));
});

function handle_suboptions_container(button) {
    button.on({
        'click': function(event) {
            let container = $(this).parent().find(".suboptions-container");
            if(container.css("display") == "none") {
                $(".suboptions-container").css("display", "none");
                container.css("display", "block");
            } else {
                container.css("display", "none");
            }
            return false;
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
        evt.stopPropagation();
    }, false);
}

$('.close-shadowed-view-button').click(function() {
    let shadowed_container = $(this);

    while(!shadowed_container.hasClass('full-shadowed')) {
        shadowed_container = shadowed_container.parent();
    }
    shadowed_container.animate({
        opacity: 0
    }, 300, function() {
        shadowed_container.css('display', 'none');
    });

    $('.suboptions-container').css('display', 'none');

    return false;
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
        data.status_id = 3;
    } else {
        data.status_id = 1;
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
                console.log(response);
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
    let action_type = $('.verification-action-type').val();

    if(action_type == 'thread.destroy') {
        $('.thread-deletion-viewer').css('display', 'block');
        $('.thread-deletion-viewer').css('opacity', '1');
    } else if(action_type == 'turn.off.posts') {
        $('.turn-off-viewer').css('display', 'block');
        $('.turn-off-viewer').css('opacity', '1');
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
    console.log('clicked');
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

    console.log($(this).find('.feedback-emoji-state').val());
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
        },
        success: function(response) {
            console.log('success');
        },
        error: function(response) {
            console.log('error');
        }
    });

    console.log('emoji icon pressed !');
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
    let button = $(this);

    button.parent().find('.header-button-counter-indicator').addClass('none');
    button.parent().find('.header-button-counter-indicator').text('0');

    $.ajax({
        type: 'post',
        url: '/notifications/markasread',
        data: {
            _token: csrf
        },
        success: function() {

        }
    })
});

let notification_timeout;
if(userId) {
    Echo.private('user.' + userId + '.notifications')
        .notification((notification) => {
            // Stop animatio if there's already animation
            $('.hidden-notification-container').stop();
            clearTimeout(notification_timeout);

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

            console.log(notification);

            $.ajax({
                type: 'post',
                url: '/notification/generate',
                data: {
                    _token: csrf,
                    action_user: notification.action_user,
                    action_statement: notification.action_statement,
                    resource_string_slice: notification.resource_string_slice,
                    action_date: notification.resource_date,
                    action_resource_link: notification.action_resource_link,
                    resource_action_icon: notification.resource_action_icon,
                },
                success: function(response) {
                    $('.notifs-box').prepend(response);
                }
            })
            
            console.log('run ajax request to fetch component ui and prepand it to notification box');
            console.log('notification type: ' + notification.type);

            $('.header-button-counter-indicator').removeClass('none');
            let notif_counter_value = $('.header-button-counter-indicator').text();
            if (!(notif_counter_value.indexOf('+') > -1)) {
                $('.header-button-counter-indicator').text(parseInt(notif_counter_value) + 1);
            }
        });
}

$('.hidden-notification-container').on({
    mouseenter: function(event) {
        clearTimeout(notification_timeout);
        $('.hidden-notification-container').stop();
        $('.hidden-notification-container').removeClass('none');
        $('.hidden-notification-container').css('opacity', '1');
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