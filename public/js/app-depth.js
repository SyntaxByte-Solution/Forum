// SELF-XSS warning
const warningTitleCSS = 'color:red; font-size:50px; font-weight: bold; -webkit-text-stroke: 1px black;';
const warningDescCSS = 'font-size: 14px;';
console.log('%cWARNING', warningTitleCSS);
console.log("%cThis is a browser feature intended for developers. If someone told you to copy and paste something here to enable a feature or 'hack' someone's account, it is a scam and will give them access to your gladiator account.", warningDescCSS);
console.log('%cSee https://en.wikipedia.org/wiki/Self-XSS for more information.', warningDescCSS);

var userId = $('.uid').first().val();
let csrf = document.querySelector('meta[name="csrf-token"]').content;
let urlParams = new URLSearchParams(window.location.search);

Array.prototype.contains = function(element){
    return this.indexOf(element) > -1;
};

jQuery.fn.rotate = function(degrees) {
    $(this).css({   
        '-webkit-transform' : 'rotate('+ degrees +'deg)',
        '-moz-transform' : 'rotate('+ degrees +'deg)',
        '-ms-transform' : 'rotate('+ degrees +'deg)',
        'transform' : 'rotate('+ degrees +'deg)',
    });
    return $(this);
};

// $(window).on('unload', function() {
//     $(window).scrollTop(0);
//  });

$('.button-with-strip').on({
    mouseenter: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'block');
    },
    mouseleave: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'none');
    }
})

$('.stop-propagation').on('click', function(event) {
    event.stopPropagation();
})

$('.block-click').on('click', function() {
    return false;
});

$('.x-close-container').click(function(event) {
    $(this).parent().addClass('none');

    event.stopPropagation();
    event.preventDefault();
})

$('.handle-image-center-positioning').each(function() {
    let image = $(this);
    $(this).parent().imagesLoaded(function() {
        handle_image_dimensions(image);
    });
});
function handle_image_dimensions(image) {
    width = image.width();
    height = image.height();
    if(width > height) {
        image.height('100%');
        image.css('width', 'max-content');
    } else if(width < height) {
        image.width('100%');
        image.css('height', 'max-content');
    } else {
        image.width('100%');
        image.height('100%');
    }
}
function handle_complexe_image_dimensions(image) {
    let image_container = image.parent();

    width = image.width();
    height = image.height();
    if(width >= height) {
        image.height(image_container.height());
    } else {
        image.width(image_container.width());
    }
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
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

handle_document_suboptions_hiding();
function handle_document_suboptions_hiding() {
    let subContainers = document.querySelectorAll('.suboptions-container');
    for(let i = 0;i<subContainers.length;i++) {
        subContainers[i].addEventListener("click", function(evt) {
            $(this).css("display", "block");
            $(".nested-soc").css("display", "none");
            evt.stopPropagation();
        }, false);
    }
}

function handle_section_suboptions_hinding(section) {
    section.find('.suboptions-container').each(function() {
        $(this).on('click', function(event) {
            event.stopPropagation();
        });
    });
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

function handle_expend_button_appearence(thread) {
    if(!thread.find('.expend-thread-content-button').length) {
        return;
    }
    let thread_content_section = thread.find('.thread-content-section');
    let thread_content_box = thread_content_section.find('.thread-content-box');
    
    let content_full_height = thread_content_box[0].scrollHeight;
    let content_hidden_height = thread_content_box.height();
    
    if(content_full_height != content_hidden_height) {
        thread_content_section.find('.expend-thread-content-button').removeClass('none');

        let expand_state = thread_content_box.find('.expand-state');
        let expand_button = thread_content_section.find('.expend-thread-content-button');
        let expand_arrow = expand_button.find('.expand-arrow path');

        expand_button.on('click', function() {
            let see_less = thread_content_box.find('.expand-button-collapse-text').val();
            let see_more = thread_content_box.find('.expand-button-text').val();
            if(expand_state.val() == "0") {
                thread_content_box.removeClass('thread-content-box-max-height');
                expand_button.find('.btn-text').text(see_less);
                expand_state.val('1');
                expand_arrow.attr('d', expand_button.find('.up-arr').val());
            } else {
                thread_content_box.addClass('thread-content-box-max-height');
                expand_button.find('.btn-text').text(see_more);
                expand_state.val('0');
                expand_arrow.attr('d', expand_button.find('.down-arr').val());
            }
        });
    }

}

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
setInterval(heart_beating,500);

$('.login-signin-button').each(function() {
    handle_login_lock($(this).parent());
});
function handle_login_lock(container) {
    container.find('.login-signin-button').each(function() {
        $(this).on('click', function(event) {
            $('#login-view').parent().css('display', 'block');
            $('#login-view').parent().css('opacity', '1');
    
            event.preventDefault();
        });
    });
}

if($('#right-panel').height() > $(window).height()-52) {
    $(document).scroll(function() {
        // > 54 + .. => 54 because height(header) = 52 and the border top and bottom of sidebar is 2px
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
        height: '100%',
        top: '52px',
        bottom: 'unset'
    });
}

$('#left-panel').height($(window).height() - $('header').height() - 30);
$('#quick-access-box').height($(window).height() - $('header').height() - 21); // 1px of border-bottom and 20 to make some space between bottom of viewer and the menu
if($('#thread-media-viewer').length) {
    $('#thread-media-viewer').height($(window).height() - $('header').height());
    handle_viewer_infos_height($('.thread-media-viewer-infos-content'));
}

window.onresize = function(event) {
    $('#left-panel').height($(window).height() - $('header').height() - 30);
    if($('#thread-media-viewer').length) {
        $('#thread-media-viewer').height($(window).height() - $('header').height());
        handle_viewer_infos_height($('.thread-media-viewer-infos-content'));
        handle_viewer_media_logic($("#thread-viewer-media-image"));
    }
};

function handle_viewer_infos_height(infos) {
    infos.height($('#thread-media-viewer').height() - $('.thread-media-viewer-infos-header').height() - 16);
}

$('.reply-to-thread').click(function() {
    setTimeout(function(){$('textarea').focus();}, 200);
    
    location.hash = "#reply-site";
    return false;
});

$('.share-thread').on('click', function(event) {
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

$('.turn-off-posts').on('click', function() {
    handle_turn_off_posts($(this));
});
function handle_turn_off_posts(button) {
    button.on('click', function() {
        let button_text_no_ing = button.val();
        let button_text_ing = button.parent().find('.button-text-ing').val();
        button.val(button_text_ing);
        button.attr("disabled","disabled");
        button.attr('style', 'background-color: #acacac; cursor: default');
    
        let thread_id = button.parent().find('.id').val();
        let swtch = button.parent().find('.switch').val();
    
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
                button.val(button_text_no_ing);
                button.attr('style', '');
                button.prop("disabled", false);
            },
        })
    });
}

$('#category-dropdown').change(function() {
    let forum_slug = $('#forum-slug').val();
    let category_slug = $('#category-dropdown').val();
    if(category_slug == 'all') {
        url = '/forums/'+forum_slug;
    } else {
        url = '/forums/'+forum_slug+'/'+category_slug+'/threads';
    }

    document.location.href = url;
});

$('.copy-thread-link').each(function() {
    handle_copy_thread_link($(this));
});
function handle_copy_thread_link(button) {
    button.on('click', function(event) {
        $(this).parent().find('input').trigger('select');
        document.execCommand("copy");
        $(this).parent().parent().css('display', 'none');
        basic_notification_show($(this).find('.copied').val(), 'basic-notification-round-tick');

        event.stopPropagation();
    });
}

$('.resource-container').each(function() {
    handle_thread_visibility_switch($(this));
});
function handle_thread_shadowed_viewers(thread) {
    thread.find('.open-thread-shadowed-viewer').each(function(event) {
        $(this).on('click', function(event) {
            let thread = $(this);
            while(!thread.hasClass('resource-container')) {
                thread = thread.parent();
            }
            
            let viewerclass = $(this).find('.viewer').val();
            thread.find(viewerclass).css('display', 'block');
            thread.find(viewerclass).css('opacity', '1');
            
            thread.find('.suboptions-container').css('display', 'none');
            event.stopPropagation();
        });
    })
}

$('.tooltip-section').each(function() {
    handle_tooltip($(this).parent());
})

function handle_tooltip(component) {
    component.find('.tooltip-section').on({
        'mouseenter': function() {
            $(this).parent().find('.tooltip').css('display', 'block');
        },
        'mouseleave': function() {
            $(this).parent().find('.tooltip').css('display', 'none');
        }
    });
}

// let mouse_over_button_timeout;
// let mouse_over_button_container_timeout;
// let mouse_over_displayer = false;
// let mouse_over_container = false;
let user_card_mouse_states = new Map();
let user_card_mouse_displayer_timeouts = new Map();
let user_card_mouse_container_timeouts = new Map();
/**
 * Here we have to have mouse_over_displayer and mouse_over_container values for each user-card-container
 * To accomplish that we create a map to store
 */
let index = 0;
$('.user-card-container-index').each(function() {
    $(this).val(index);
    user_card_mouse_states.set(index, {
        mouse_over_displayer: false,
        mouse_over_container: false,
    });
    user_card_mouse_displayer_timeouts.set(index, false);
    user_card_mouse_container_timeouts.set(index, false);

    index++;
});

$('.user-profile-card-box').each(function() {
    handle_user_profile_card_displayer($(this));
})
function handle_user_profile_card_displayer(user_profile_card_box) {
    user_profile_card_box.find('.user-profile-card-displayer').each(function() { 
        let container_index = $(this).parent().find('.user-card-container-index').val();

        $(this).on({
            mouseenter: function() {
                // Mouse is over displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: true,
                    mouse_over_container: false,
                });
                let inside_displayer_timeout = setTimeout(function() {
                    user_profile_card_box.find('.user-profile-card').removeClass('none');
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 1
                    }, 400);
                }, 500);
                user_card_mouse_displayer_timeouts.set(container_index, inside_displayer_timeout);
            },
            mouseleave: function() {
                // Mouse is outside displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: false,
                });
                clearTimeout(user_card_mouse_displayer_timeouts.get(container_index));
                let inside_displayer_timeout = setTimeout(function() {
                    if(user_card_mouse_states.get(container_index).mouse_over_displayer || user_card_mouse_states.get(container_index).mouse_over_container) {
                        clearTimeout(inside_displayer_timeout);
                        return false;
                    }
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 0
                    }, 400);
                    user_profile_card_box.find('.user-profile-card').addClass('none');
                }, 500);
            }
        });

        $(this).parent().find('.user-profile-card').on({
            mouseenter: function() {
                // Mouse is over displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: true,
                });
            },
            mouseleave: function() {
                // Mouse is outside displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: false,
                });
                clearTimeout(user_card_mouse_displayer_timeouts.get(container_index));
                let inside_displayer_timeout = setTimeout(function() {
                    if(user_card_mouse_states.get(container_index).mouse_over_displayer) {
                        clearTimeout(inside_displayer_timeout);
                        return false;
                    }
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 0
                    }, 400);
                    user_profile_card_box.find('.user-profile-card').addClass('none');
                }, 500);
            }
        });
    });
}

function handle_close_shadowed_view(component) {
    component.find('.close-shadowed-view-button').each(function() {
        $(this).on('click',function() {
            let shadowed_container = $(this);
            while(!shadowed_container.hasClass('full-shadowed')) {
                shadowed_container = shadowed_container.parent();
            }
            shadowed_container.css('display', 'none');
            $('.suboptions-container').css('display', 'none');
    
            return false;
        });
    })
}

$('.hide-parent').click(function() {
    $(this).parent().css('display', 'none');

    return false;
});

function handle_hide_parent(item) {
    item.find('.hide-parent').each(function() {
        $(this).on('click', function() {
            $(this).parent().css('display', 'none');
        });
    })
}

$('.toggle-container-button').on('click', function() {
    let box = $(this);
    while(!box.hasClass('toggle-box')) {
        box = box.parent();
    }
    let container = box.find('.toggle-container');

    if(container.css('display') == 'none') {
        container.removeClass('none');
        container.addClass('block');

        if(box.find('.toggle-arrow').length) {
            box.find('.toggle-arrow').css({
                transform:'rotate(90deg)',
                '-ms-transform':'rotate(90deg)',
                '-moz-transform':'rotate(90deg)',
                '-webkit-transform':'rotate(90deg)',
                '-o-transform':'rotate(90deg)'
            });
        }
    } else {
        console.log('bring it to 0deg');
        container.removeClass('block');
        container.addClass('none');

        if(box.find('.toggle-arrow').length) {
            box.find('.toggle-arrow').css({
                transform:'rotate(0deg)',
                '-ms-transform':'rotate(0deg)',
                '-moz-transform':'rotate(0deg)',
                '-webkit-transform':'rotate(0deg)',
                '-o-transform':'rotate(0deg)'
            });
        }
    }
    
    return false;
});

$('.row-num-changer').on('change', function() {
    let pagesize = $(this).val();

    window.location.href = updateQueryStringParameter(window.location.href, 'pagesize', pagesize);
});

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

$('.send-feedback').click(function() {
    let button = $(this);
    let btn_text_ing = button.find('.btn-text-ing').val();
    let btn_text_no_ing = button.find('.btn-text-no-ing').val();
    let message_sent = button.find('.message-sent').val();

    let data = {
        _token: csrf,
    };

    let feedback_container = $(this);
    while(!feedback_container.hasClass('feedback-container')) {
        feedback_container = feedback_container.parent();
    }

    // If this is true, it means the user is a guest
    let error_container = feedback_container.find('.error-box');
    if(feedback_container.find('#email').length) {
        let email = feedback_container.find('#email').val().trim();
        if(email == "") {
            feedback_container.find('#email').parent().find('.err').removeClass('none');
            error_container.find('.error').text(feedback_container.find('.email-required').val());
            error_container.removeClass('none');
            return;
        } else if(!validateEmail(email)) {
            feedback_container.find('#email').parent().find('.err').removeClass('none');
            feedback_container.find('.error').text(feedback_container.find('.email-invalide').val());
            error_container.removeClass('none');
            return;
        } else {
            feedback_container.find('#email').parent().find('.err').addClass('none');
            error_container.addClass('none');
            data.email = email;
        }
    }

    let feedback = feedback_container.find('#feedback').val().trim();
    if(feedback == "") {
        feedback_container.find('#feedback').parent().parent().find('.err').removeClass('none');
        error_container.removeClass('none');
        error_container.find('.error').text(feedback_container.find('.content-required').val());
        return;
    } else if(feedback.length < 10) {
        feedback_container.find('#feedback').parent().parent().find('.err').removeClass('none');
        error_container.removeClass('none');
        error_container.find('.error').text(feedback_container.find('.content-min').val());
        return;
    } else {
        feedback_container.find('#feedback').parent().parent().find('.err').addClass('none');
        error_container.addClass('none');
        data.feedback = feedback;
    }

    // Disabling inputs while sending feedback
    feedback_container.find('#email').attr('disabled', 'disabled');
    feedback_container.find('textarea').attr('disabled', 'disabled');

    button.attr('disabled', 'disabled');
    button.find('.btn-text').text(btn_text_ing);
    button.attr('style', 'padding: 5px 8px; background-color: #acacac; cursor: not-allowed');

    $.ajax({
        url: '/feedback',
        type: 'POST',
        data: data,
        success: function(response) {
            $('#send-feedback-box-sidebar').parent().find('.feedback-sent-success-container').removeClass('none');
            $('#send-feedback-box-sidebar').remove();
            basic_notification_show(message_sent, 'basic-notification-round-tick');
            
        },
        error: function(response) {
            feedback_container.find('#email').removeAttr('disabled');
            feedback_container.find('textarea').removeAttr('disabled');
            button.removeAttr('disabled');
            button.find('.btn-text').text(btn_text_no_ing);
            button.attr('style', 'padding: 5px 8px;');
            let er = '';
            try {
                let errorObject = JSON.parse(response.responseText).errors;
                er = errorObject[Object.keys(errorObject)][0];
            } catch(e) {
                er = JSON.parse(response.responseText).message;
            }

            error_container.removeClass('none');
            error_container.find('.error').text(er);
        }
    })
});

$('.emoji-button').click(function(event) {
    event.preventDefault();
    let emoji_button = $(this);

    $(this).find('.emoji-unfilled').addClass('none');
    $('.emoji-unfilled').animate({
        opacity: '0.5'
    }, 300);
    $(this).find('.emoji-filled').removeClass('none');

    $(this).parent().find('.emoji-button').off('click');

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
$('.votable-up-vote').each(function() {
    handle_up_vote($(this));
});

$('.votable-down-vote').each(function() {
    handle_down_vote($(this));
});

let informer_container_timeout;

function handle_up_vote(button) {
    button.on('click', function() {
        if(!vote_lock) {
            return false;
        }
        vote_lock = false;
    
        let vote_icons_state = '';
        let new_vote_count;
        let vote_box = button;
        while(!vote_box.hasClass('vote-box')) {
            vote_box = vote_box.parent();
        }
    
        let votable_id = vote_box.find('.votable-id').val();
        let votable_type = vote_box.find('.votable-type').val();
        let vote_count = parseInt(vote_box.find('.votable-count').text());
    
        $.ajax({
            type: 'POST',
            url: '/' + votable_type + '/' + votable_id + '/vote',
            data: {
                _token: csrf,
                'vote': 1
            },
            success: function(response) {
                // Only synch thread component with viewer if the vote went successfully
                handle_vote_sync(button, vote_icons_state, new_vote_count);
            },
            error: function(xhr, status, error) {
                if(!up_vote_filled.hasClass('none')) {
                    up_vote_filled.addClass('none');
                    up_vote.removeClass('none');
                    vote_icons_state = 'remove-up';
                } else {
                    up_vote_filled.removeClass('none');
                    up_vote.addClass('none');
                    vote_icons_state = 'fill-up';
                }
    
                // If there's an error we simply set the old value
                vote_box.find('.votable-count').text(vote_count);
                new_vote_count = vote_count;

                let errorObject = JSON.parse(xhr.responseText);
                let er = errorObject.message;
                // Here we change displaying from thread embedded message container to global message notification
                display_top_informer_message(er, 'warning');
            },
            complete: function() {
                vote_lock = true;
            }
        });
    
        let up_vote = button.find('.up-vote');
        let up_vote_filled = button.find('.up-vote-filled');
        let down_vote = vote_box.find('.down-vote');
        let down_vote_filled = vote_box.find('.down-vote-filled');
    
        if(!up_vote_filled.hasClass('none')) {
            // In this case the user is already votes up and then press up again so we need to delete the vote record
            vote_box.find('.votable-count').text(vote_count-1);
            up_vote_filled.addClass('none');
            up_vote.removeClass('none');
    
            vote_icons_state = 'remove-up';
            new_vote_count = vote_count-1;
    
        } else {
            // here we have 2 cases:
            // 1- case where the user is not voted at all we only need to add 1
            if(!up_vote.hasClass('none') && !down_vote.hasClass('none')){
                vote_box.find('.votable-count').text(vote_count+1);
                up_vote.addClass('none');
                up_vote_filled.removeClass('none');
    
                vote_icons_state = 'fill-up';
                new_vote_count = vote_count+1;
            // 2- case where the user is already down voted the resource and then he press up vote, we need to add 2 in this case
            } else {
                vote_box.find('.votable-count').text(vote_count+2);
                down_vote_filled.addClass('none');
                down_vote.removeClass('none');
                up_vote.addClass('none');
                up_vote_filled.removeClass('none');
    
                vote_icons_state = 'remove-down-fill-up';
                new_vote_count = vote_count+2;
            }
        }
    });
}
function handle_down_vote(button) {
    button.on('click', function() {
        if(!vote_lock) {
            return false;
        }
        vote_lock = false;
    
        let vote_icons_state = '';
        let new_vote_count;
        let vote_box = button;
        while(!vote_box.hasClass('vote-box')) {
            vote_box = vote_box.parent();
        }
    
        let votable_id = vote_box.find('.votable-id').val();
        let votable_type = vote_box.find('.votable-type').val();
        let vote_count = parseInt(vote_box.find('.votable-count').text());
        // Send the request
        $.ajax({
            type: 'POST',
            url: '/' + votable_type + '/' + votable_id + '/vote',
            data: {
                _token: csrf,
                'vote': -1
            },
            success: function(response) {
                // Only synch thread component with viewer if the vote went successfully
                handle_vote_sync(button, vote_icons_state, new_vote_count);
            },
            error: function(xhr, status, error) {
                if(!down_vote_filled.hasClass('none')) {
                    down_vote_filled.addClass('none');
                    down_vote.removeClass('none');
                    vote_icons_state = 'remove-down';
                } else {
                    down_vote_filled.removeClass('none');
                    down_vote.addClass('none');
                    vote_icons_state = 'fill-down';
                }

                // If there's an error we simply set the old value
                vote_box.find('.votable-count').text(vote_count);
                new_vote_count = vote_count;
    
                let errorObject = JSON.parse(xhr.responseText);
                let er = errorObject.message;
                // Here we change displaying from thread embedded message container to global message notification
                display_top_informer_message(er, 'warning');
            },
            complete: function() {
                vote_lock = true;
            }
        });
        // Then we handle the ui components
        let down_vote = button.find('.down-vote');
        let down_vote_filled = button.find('.down-vote-filled');
        let up_vote = vote_box.find('.up-vote');
        let up_vote_filled = vote_box.find('.up-vote-filled');
    
        if(!down_vote_filled.hasClass('none')) {
            // In this case the user is already voted down and then press down again so we need to add 1 
            // (because the previous down change the counter to -1 no we need to rewind to 0 by adding 1)
            vote_box.find('.votable-count').text(vote_count+1);
            down_vote_filled.addClass('none');
            down_vote.removeClass('none');
            new_vote_count = vote_count+1;
            vote_icons_state = 'remove-down';
        } else {
            // here we have 2 cases:
            // 1- case where the user is not voted at all we only need to subtract 1
            if(!down_vote.hasClass('none') && !up_vote.hasClass('none')) {
                vote_box.find('.votable-count').text(vote_count-1);
                down_vote.addClass('none');
                down_vote_filled.removeClass('none');
                new_vote_count = vote_count-1;
                vote_icons_state = 'fill-down';
            // 2- case where the user is already up voted the resource and then he press down vote, we need to subtract 2 in this case
            } else {
                vote_box.find('.votable-count').text(vote_count-2);
                up_vote_filled.addClass('none');
                up_vote.removeClass('none');
                down_vote.addClass('none');
                down_vote_filled.removeClass('none');
    
                new_vote_count = vote_count-2;
                vote_icons_state = 'remove-up-fill-down';
            }
        }
    });
};
function handle_vote_sync(button, vote_icons_state, new_vote_count) {
    let from = button.hasClass('outside-viewer') ? 'outside' : 'inside';
    let votable_id = button.parent().find('.votable-id').val();
    let votable_type = button.parent().find('.votable-type').val();
    let votable_box;

    switch(from) {
        case 'outside':
            // If the thread viewer is not opened we have to stop the execution flow
            if(!last_opened_thread) return;

            if(votable_type == 'thread') {
                /**
                 * Here we have to check if the viewer is already opened and the thread opened is the same as the 
                 * voted thread before update the viewer voting items
                 */
                let loaded_to_viewer = (last_opened_thread == votable_id) ? 1 : 0;
                if(loaded_to_viewer) {
                    // Thread vote section inside viewer
                    votable_box = $('#thread-media-viewer').find('.thread-vote-box');
                } else {
                    // Here the votable thread is not the thread loaded into the viewer; so we have to stop the execution
                    return;
                }
            } else if(votable_type == 'post') {
                $('.viewer-replies-container .viewer-thread-reply').each(function() {
                    if($(this).find('.post-id').val() == votable_id) {
                        votable_box = $(this).find('.vote-box');
                        return false;
                    }
                });
            }

            break;
        case 'inside':
            if(votable_type == 'thread') {
                votable_box = opened_thread_component.find('.vote-box');
            } else if(votable_type == 'post') {
                if($('#replies-container').length) {
                    $('#replies-container .post-container').each(function() {
                        if($(this).find('.post-id').first().val() == votable_id) {
                            votable_box = $(this).find('.vote-box');
                            return false;
                        }
                    });
                }

            }

            break;
    }

    // After getting the votable box of the inside or outside section, we begin by editing the counter
    votable_box.find('.votable-count').text(new_vote_count);
    // votable paths that we have to change their none class when thread vote get clicked from outside
    let up_vote = votable_box.find('.up-vote');
    let up_vote_filled = votable_box.find('.up-vote-filled');
    let down_vote = votable_box.find('.down-vote');
    let down_vote_filled = votable_box.find('.down-vote-filled');
    switch(vote_icons_state) {
        case 'remove-up':
            up_vote_filled.addClass('none');
            up_vote.removeClass('none');
            break;
        case 'fill-up':
            up_vote_filled.removeClass('none');
            up_vote.addClass('none');
            break;
        case 'remove-down-fill-up':
            down_vote_filled.addClass('none');
            down_vote.removeClass('none');
            up_vote_filled.removeClass('none');
            up_vote.addClass('none');
            break;
        case 'remove-down':
            down_vote_filled.addClass('none');
            down_vote.removeClass('none');
            break;
        case 'fill-down':
            down_vote_filled.removeClass('none');
            down_vote.addClass('none');
            break;
        case 'remove-up-fill-down':
            up_vote_filled.addClass('none');
            up_vote.removeClass('none');
            down_vote_filled.removeClass('none');
            down_vote.addClass('none');
            break;
    }
}

$('.like-resource').each(function() {
    handle_resource_like($(this));
});
function handle_resource_like(like_button) {
    like_button.click(function() {
        let likable_id = like_button.find('.likable-id').val();
        let likable_type = like_button.find('.likable-type').val();

        $.ajax({
            type: 'POST',
            url: '/' + likable_type + '/' + likable_id + '/like',
            data: {
                _token: csrf,
            },
            success: function(response) {
                
            },
            error: function(xhr, status, error) {
                // If there's an error we simply set the old value
                like_button.find('.resource-likes-count').text(resource_likes_counter);
            },
            complete: function() {
            }
        });

        let resource_likes_counter = parseInt(like_button.find('.resource-likes-counter').text());
        let grey_like = like_button.find('.grey-like');
        let red_like = like_button.find('.red-like');

        let new_like_count;
        let like_icon_status;
        if(!red_like.hasClass('none')) {
            like_button.find('.resource-likes-counter').text(resource_likes_counter-1);
            red_like.addClass('none');
            grey_like.removeClass('none');
            
            new_like_count = resource_likes_counter-1;
            like_icon_status = 'grey';
        } else {
            like_button.find('.resource-likes-counter').text(resource_likes_counter+1);
            red_like.removeClass('none');
            grey_like.addClass('none');
            
            new_like_count = resource_likes_counter+1;
            like_icon_status = 'red';
        }

        handle_like_sync(like_button, like_icon_status, new_like_count);
    });
}
function handle_like_sync(button, like_icon_status, new_like_count) {
    // If the thread viewer is not opened we have to stop the execution flow
    if(!last_opened_thread) 
        return;

    let from = button.hasClass('like-resource-from-viewer') ? 'inside' : 'outside'; // inside/outside viewer
    let likable_id = button.find('.likable-id').val();
    let likable_type = button.find('.likable-type').val();
    let target_button;

    let loaded_to_viewer = 
        (last_opened_thread == likable_id && likable_type == "thread") ? 1 : 0;

    switch(from) {
        case 'outside':
            if(likable_type == 'thread') {
                // We only need to update the viewer thread like if the liked thread is the same thread loaded in viewer
                if(loaded_to_viewer) {
                    target_button = $('#thread-media-viewer').find('.viewer-thread-like');
                }
            } else if(likable_type == 'post') {
                $('.viewer-replies-container .viewer-thread-reply').each(function() {
                    if($(this).find('.post-id').val() == likable_id) {
                        target_button = $(this).find('.like-resource');
                        return false;
                    }
                });
            }
            break;
        case 'inside':
            if(likable_type == 'thread') {
                // We only need to update the viewer thread like if the liked thread is the same thread loaded in viewer
                if(loaded_to_viewer)
                    target_button = opened_thread_component.find('.like-resource');
            } else if(likable_type == 'post') {
                $('#replies-container .post-container').each(function() {
                    if($(this).find('.post-id').first().val() == likable_id) {
                        target_button = $(this).find('.like-resource');
                        return false;
                    }
                });
            }
            break;
    }

    target_button.find('.resource-likes-counter').text(new_like_count);
    let target_button_red = target_button.find('.red-like');
    let target_button_grey = target_button.find('.grey-like');
    if(like_icon_status == 'grey') {
        target_button_red.addClass('none');
        target_button_grey.removeClass('none');
    } else {
        target_button_red.removeClass('none');
        target_button_grey.addClass('none');
    }
}

$('.set-lang').click(function(event) {
    let language = $(this).find('.lang-value').val();
    let loading = $(this).find('.loading-dots-anim');
    loading.removeClass('none');
    start_loading_anim(loading);
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

$('.notification-button').on('click', function() {
    handle_mark_as_read();
    handle_lazy_loading();
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
                    action_type: notification.action_type
                },
                success: function(response) {
                    $('.notifs-box').prepend(response);
                    let appended_component = $('.notifs-box').last().find('.notification-container').first();
                    handle_image_dimensions(appended_component.find('.action_takers_image'));
                    handle_notification_menu_appearence(appended_component);
                    handle_notification_menu_buttons(appended_component.find('.notification-menu-button'));
                    handle_nested_soc(appended_component.find('.notification-menu-button'));
                    handle_delete_notification(appended_component.find('.delete-notification'));
                    handle_disable_switch_notification(appended_component.find('.disable-switch-notification'));
                    handle_lazy_loading();
                }
            })

            if($("#page").length) {
                if($("#page").val() == "notifications-page") {
                    handle_mark_as_read();
                }
            }
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
                    handle_image_dimensions($(this).find('.action_takers_image'));
                    handle_lazy_loading();
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
$('.thread-add-forum').on('click', function() {
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
            // First change the icon
            $('.thread-add-forum-icon').html(button.find('.forum-ico').html());

            let categories = JSON.parse(response);
            $('.thread-add-category:not(:first)').remove();

            let first_iteration = true;
            $.each(categories, function(id, category){
                if(first_iteration) {
                    $('.thread-add-selected-category').text(category.category);
                    $('.thread-add-category').find('.thread-add-category-val').text(category.category);
                    $('.thread-add-category').find('.category-id').text(category.id);
                    thread_add_container.find('.category').val(category.id);
                    first_iteration = false;
                } else {
                    $('.thread-add-categories-container').append(`
                        <div class="thread-add-suboption thread-add-category flex align-center">
                            <span class="thread-add-category-val">${category.category}</span>
                            <input type="hidden" class="category-id" value="${category.id}">
                        </div>
                    `);

                    handle_category_selection($('.thread-add-category').last());
                }
            });
        },
        complete: function() {
            // Stop loading animation
            loading_anim.addClass('none');
            loading_anim.text('•');
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

$('.thread-container-box').each(function() {
    handle_thread_medias_containers($(this));
    handle_open_media_viewer($(this));
    handle_thread_shadowed_viewers($(this));
    handle_expend_button_appearence($(this));
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

/**
 * NOTICE: Later, add a feature where the user click on locked button and the lock is false add this click in kind 
 * of queue and when the loc is released check the queue and trigger the event again and so on ;)
 */
let thread_visibility_lock = true;
function handle_thread_visibility_switch(component) {
    component.find('.thread-visibility-button').each(function() {
        $(this).on('click', function() {
            if(!thread_visibility_lock) {
                return;
            }
            thread_visibility_lock = false;

            let button = $(this);
            let visibility_box = button;
            while(!visibility_box.hasClass('visibility-box')) {
                visibility_box = visibility_box.parent();
            }
        
            visibility_box.find('.thread-visibility-button').attr('style','background-color: rgb(250, 250, 250); color: gray');
            button.attr('style', 'background-color: rgb(240, 240, 240); color: black');
            let loading = button.find('.loading-dots-anim');
            loading.removeClass('none');
            start_loading_anim(loading);
        
            let thread_id = visibility_box.find('.thread-id').val();
            let visibility_slug = button.find('.thread-add-visibility-slug').val();
        
            $.ajax({
                url: `/thread/visibility/patch`,
                type: 'patch',
                data: {
                    _token: csrf,
                    thread_id: thread_id,
                    visibility_slug: visibility_slug
                },
                success: function() {
                    let button_ico = visibility_box.find('.thread-resource-visibility-icon');
                    let new_path = button.find('.icon-path-when-selected').val();
                    basic_notification_show(visibility_box.find('.message-after-change').val(), 'basic-notification-round-tick');
                    button_ico.find('path').attr('d', new_path);
                },
                complete: function() {
                    thread_visibility_lock = true;
                    stop_loading_anim();
                    loading.addClass('none');
                    visibility_box.find('.thread-visibility-button').attr('style','');
        
                    button.parent().css('display', 'none');
                }
            });
        });    
    });
}

$('.thread-add-visibility').on('click', function(event) {
    event.stopPropagation();

    let container = $(this);
    while(!container.hasClass('thread-add-container')) {
        container = container.parent();
    }

    container.find('.thread-add-visibility-slug').val($(this).find('.thread-visibility').val())

    let selected_icon_path = $(this).find('.selected-icon-path').val();
    let status_ico = container.find('.thread-add-visibility-icon');

    status_ico.find('path').attr('d', selected_icon_path);
    
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

        let follow_text = follow_box.find('.follow-text').val();
        let followed_text = follow_box.find('.followed-text').val();
        let unfollow_text = follow_box.find('.unfollow-text').val();
        let following_text = follow_box.find('.following-text').val();
        let unfollowing_text = follow_box.find('.unfollowing-text').val();

        if(button.hasClass('follow-button-with-icon')) {
            button.attr('style', 'background: rgb(207, 239, 255); border-color: rgb(207, 239, 255); cursor: default');
        }

        if(follow_box.find('.status').val() == '1') {
            button.find('.btn-txt').text(unfollowing_text);
        } else {
            button.find('.btn-txt').text(following_text);
        }
    
        let followable_id = follow_box.find('.followable-id').val();
        let followable_type = follow_box.find('.followable-type').val();

        $.ajax({
            type: 'post',
            url: `/${followable_type}s/${followable_id}/follow`,
            data: {
                _token: csrf
            },
            success: function(response) {
                if(button.hasClass('follow-button-toggle-with-bell')) {
                    // Here after following or unfollowing the user, we have to loop over every thread of this user and update his following box as well
                    $('.follow-box').each(function() {
                        let fbox = $(this);
                        let fid = fbox.find('.followable-id').val();
                        let ftype = fbox.find('.followable-type').val();
                        
                        if(fid == followable_id && ftype == followable_type) {
                            if(fbox.find('.status').val() == '1') {
                                fbox.find('.status').val(-1);
                                fbox.find('.follow-notif-container').addClass('none');
                                fbox.find('.follow-text-button .btn-txt').text(follow_text);
                                fbox.find('.follow-text-button').removeClass('none');
                            } else {
                                fbox.find('.status').val(1);
                                fbox.find('.follow-notif-container').removeClass('none');
                                fbox.find('.follow-button-toggle-with-bell .btn-txt').text(unfollow_text);
                                fbox.find('.follow-text-button').addClass('none');
                                basic_notification_show(fbox.find('.follow-success-text').val(), 'basic-notification-round-tick');
                            }     
                        }
                    });
                } else if(button.hasClass('follow-button-with-icon')) {
                    if(button.hasClass('viewer-follow')) {
                         if(response == -1) {
                            button.find('.status').val(-1);
                            button.find('.btn-txt').text(follow_text);
                            button.find('.follow').removeClass('none');
                            button.find('.followed').addClass('none');
                        } else {
                            button.find('.status').val(1);
                            button.find('.btn-txt').text(followed_text);
                            button.find('.follow').addClass('none');
                            button.find('.followed').removeClass('none');
                        }
                    } else if(button.hasClass('followers-follows-follow-inline')) {
                        let followers_counter = follow_box.find('.followers-counter');
                        if(response == -1) {
                            button.find('.status').val(-1);
                            button.find('.btn-txt').text(follow_text);
                            followers_counter.text(parseInt(followers_counter.text())-1);
                            button.find('.follow').removeClass('none');
                            button.find('.followed').addClass('none');
    
                            if($('.followers-viewer').length) {
                                $('.followers-viewer .follow-box-item').each(function() {
                                    let fid = $(this).find('.followable-id').val();
                                    if(fid == userId) {
                                        $(this).remove();
                                    }
                                })
                            }
                        } else {
                            button.find('.status').val(1);
                            button.find('.btn-txt').text(button.find('.followed-text').val());
                            followers_counter.text(parseInt(followers_counter.text()) + 1);
                            button.find('.follow').addClass('none');
                            button.find('.followed').removeClass('none');
    
                            // Generate follower component with the current user and append it to the followers viewer
                            $.ajax({
                                type: 'get', 
                                url: `/users/${userId}/followers/generate`,
                                success: function(response) {
                                    $('#followers-box').append(response);
                                }
                            });
                        }
                    }
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
$('.thread-add-share').on('click', function(event) {
    const $codemirror = $('.thread-add-container #content').nextAll('.CodeMirror')[0].CodeMirror;

    let form_data = new FormData();
    form_data.append('_token' ,csrf);
    form_data.append('subject' ,$('#subject').val());
    form_data.append('category_id' ,$('.category').val());
    form_data.append('visibility_id' ,$('.thread-add-visibility-slug').val());
    form_data.append('content' ,$codemirror.getValue());

    let button = $(this);
    let btn_text_ing = button.parent().find('.message-ing').val();
    let btn_text_no_ing = button.parent().find('.message-no-ing').val();
    let container = $(this);
    while(!container.hasClass('thread-add-container')) {
        container = container.parent();
    }

    if(form_data.get('subject') == '') {
        $('#subject').parent().find('.error').removeClass('none');
        container.find('.thread-add-error').text($('#subject').parent().find('.required-text').val());
        container.find('.thread-add-error-container').removeClass('none');
        move_element_by_id('thread-add-wrapper');
        return;
    } else {
        $('#subject').parent().find('.error').addClass('none');
        container.find('.thread-add-error').text("");
        container.find('.thread-add-error-container').addClass('none');
    }

    if(form_data.get('content') == '') {
        $('#content').parent().find('.error').removeClass('none');
        container.find('.thread-add-error').text($('#content').parent().find('.required-text').val());
        container.find('.thread-add-error-container').removeClass('none');
        move_element_by_id('thread-add-wrapper');
        return;
    } else {
        $('#content').parent().find('.error').addClass('none');
        container.find('.thread-add-error-container').addClass('none');
    }

    let has_upload = false;
    // Checking images existence in the thread
    /**
     * Update: instead of directly append files to form data, we take first the old filename and extract the extension
     * then we use the counter and append the extension to the counter value, in that way we get ascending order of file names to maintain order
     * when saving those files
     */
    if(uploaded_thread_images_assets.length) {
        has_upload = true;
        // Append image files
        for(let i = 0;i<uploaded_thread_images_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_images_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            // Then we store the file with the combination of counter and extension to preserve the order when saving files
            filename = uploaded_thread_images_assets[i][0] + ext;
            form_data.append('images[]', uploaded_thread_images_assets[i][1], filename);
        }
    }
    // Checking videos existence in the thread
    if(uploaded_thread_videos_assets.length) {
        has_upload = true;
        // Append videos files
        for(let i = 0;i<uploaded_thread_videos_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_videos_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            // Then we store the file with the combination of counter and extension to preserve the order when saving files
            filename = uploaded_thread_videos_assets[i][0] + ext;
            form_data.append('videos[]', uploaded_thread_videos_assets[i][1], filename);
        }
    }
    // When user click share and everything is validated we need to disable both subject and content inputs
    $('#subject').attr('disabled', 'disabled');
    $codemirror.setOption('readOnly', 'nocursor');

    button.text(btn_text_ing);
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #acacac; cursor: default');
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
        
            if(has_upload) {
                let progress_bar_box = container.find('.progress-bar-box');
                let progress_bar = progress_bar_box.find('.progress-bar');
                progress_bar_box.removeClass('none');

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        progress_bar.css('width', percentComplete+"%");
                        progress_bar_box.find('.progress-bar-percentage-counter').text(percentComplete);
                        if(percentComplete >= 50) {
                            progress_bar_box.find('.progress-bar-percentage').css('color', 'white');
                        }
                
                        if (percentComplete === 100) {
                            if(progress_bar_box.find('.text-above-progress-bar').length) {
                                progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.upload-finish-text').val());
                            }
                        }
                    }
                }, false);
            }
        
            return xhr;
        },
        url: '/thread',
        type: 'post',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success: function(response) {
            if($('#threads-global-container').length) {
                // Show notification flash
                $.ajax({
                    url: `/threads/${response.id}/component/generate`,
                    type: 'get',
                    success: function(thread) {
                        if(has_upload) {
                            let progress_bar_box = container.find('.progress-bar-box');
                            let progress_bar = progress_bar_box.find('.progress-bar');
            
                            progress_bar_box.addClass('none');
                            progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
                            progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
                            progress_bar.css('width', '0%');
                        }

                        $('.thread-add-uploaded-media').slice(1).remove();
                        // Clear thread add component inputs
                        $('.uploaded-images-counter').val('0');
                        $('.uploaded-videos-counter').val('0');
                        $('#subject').attr('disabled', false);
                        $('#subject').val('');
                        $codemirror.setOption('readOnly', false);
                        $codemirror.getDoc().setValue("");
                        $('#thread-photos').val('');
                        $('#thread-videos').val('');
                        uploaded_thread_images_assets = [];
                        uploaded_thread_videos_assets = [];
                        uploaded_thread_media_counter = 0;

                        button.text(btn_text_no_ing);
                        button.attr("disabled",false);
                        button.attr('style', '');

                        $('#threads-global-container').prepend(thread);

                        let unhandled_thread = $('#threads-global-container').find('.thread-container-box').first();
                        force_lazy_load(unhandled_thread);
                        handle_thread_events(unhandled_thread);
                        handle_document_suboptions_hiding();
                        basic_notification_show(button.parent().find('.successful-share').val(), 'basic-notification-round-tick');
                    }
                })
            } else {
                window.location.href = response.link;
            }
        },
        error: function(response) {
            if(has_upload) {
                let progress_bar_box = container.find('.progress-bar-box');
                let progress_bar = progress_bar_box.find('.progress-bar');

                progress_bar_box.addClass('none');
                progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
                progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
                progress_bar.css('width', '0%');
            }
            
            let errors = JSON.parse(response.responseText);
            let error;

            if(errors.message) {
                error = errors.message;
            } else if(errors.error) {
                error = errors.error;
            } else {
                // The errors object hold errors keys as well as error values in form of array of errors
                // because a field could have multiple validation constraints and then it could have multiple errors
                // strings. In this case we only need the first error of the first validation
                error = errors[Object.keys(errors)[0]][0];
            }

            container.find('.thread-add-error-container').removeClass('none');
            container.find('.thread-add-error').html(error);

            $('#subject').attr('disabled', false);
            $codemirror.setOption('readOnly', false);

            button.text(btn_text_no_ing);
            button.attr("disabled",false);
            button.attr('style', '');

            move_element_by_id('thread-add-wrapper');
        },
        complete: function(response) {
            
        }
    });
    
    return false;
});

function move_element_by_id(id) {
    location.hash = "#" + id;
    var y = $(window).scrollTop();  //your current y position on the page
    $(window).scrollTop(y-56);
}

// The following three variables will be used in edit thread (look at /thread/edit.js)
let already_uploaded_thread_images_assets = [];
let already_uploaded_thread_videos_assets = [];
let edit_deleted_medias = [];

let uploaded_thread_images_assets = [];
let uploaded_thread_videos_assets = [];
let uploaded_thread_media_counter = 0;
// This will track image uploads --- [Now it is possible to share more than one image] ---
$("#thread-photos").on('change', function(event) {
    // First we close the error if it is opened
    $('.thread-add-media-error p').addClass('none');
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
    let validated_images = validate_image_file_Type(images);

    // First we check if all images passes image type by comparing uploaded images with validated images lengths
    if(images.length != validated_images.length) {
        /**
         * Print error: Only jpeg, png .. are supported
         * (tame: thread add media error)
         */
        media_container.find('.tame-image-type').removeClass('none');
    } else {
        media_container.find('.tame-image-type').addClass('none');
        media_container.find('.tame-video-type').addClass('none');
    }

    /** 
     * then we check the limit of uploaded images 
     * Notice: already uploaded videos and images is useful in edit page where the user has already upload images
     * we place those uploaded medias in separate arrays and then we check if the global number of medias is passable
     * ex: If user already uploaded 5 images, and then later he want to edit the thread by adding
     * 18 images, here we have to check if 18 + 5 < 20; If so then OK
     * Otherwise: we have to take only 15 from 18
     */
    if(validated_images.length + uploaded_thread_images_assets.length > 20
        || validated_images.length + uploaded_thread_images_assets.length + already_uploaded_thread_images_assets.length > 20) {
        media_container.find('.tame-image-limit').removeClass('none');
        validated_images = validated_images.slice(0, 20-(uploaded_thread_images_assets.length+already_uploaded_thread_images_assets.length));
    }
    
    images = validated_images;
    for(let i=0;i<images.length;i++) {
        /**
         * Here instead of pushing only the file to the array we have to pass also the counter (used to preserve the order) 
         * of uploaded file and then increment it
         */
        uploaded_thread_images_assets.push([uploaded_thread_media_counter, images[i]]);
        uploaded_thread_media_counter++;
    }
    /**
     * Now we loop through the new files and append them to thread-add-uploaded-medias-container by cloning 
     * thread-add-uploaded-media-projection-model container
     * About the other validations like file size we're gonna implement them in the backend
     */
    for (let i = 0; i < images.length; i++) {
        let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
        $('.thread-add-uploaded-medias-container').append(clone);

        // Increment uploaded images index
        let upload_images_index = $('.thread-add-uploaded-medias-container').find('.uploaded-images-counter');
        let images_counter = parseInt(upload_images_index.val()) + 1;
        upload_images_index.val(images_counter);

        let global_medias_count = images_counter
        + already_uploaded_thread_images_assets.length
        + already_uploaded_thread_videos_assets.length
        + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter').val());

        // We get the last uploaded image container
        let last_uploaded_image = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
        last_uploaded_image.find('.uploaded-media-index').val(images_counter-1); // we want 0 based indexes here
        last_uploaded_image.find('.uploaded-media-genre').val('image'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)

        last_uploaded_image.removeClass('none thread-add-uploaded-media-projection-model');
        if(global_medias_count >= 5) {
            if(global_medias_count == 5)
                $('.thread-add-uploaded-medias-container').addClass('scrollx');
                
                // Scroll to the end position of x axe
                let c = $('.thread-add-uploaded-medias-container');
                c[0].scrollLeft = c[0].scrollWidth;
        }

        let img = last_uploaded_image.find(".thread-add-uploaded-image");
        img.removeClass('none');

        // Preview the image
        load_image(images[i], img);
    }

    // Clear the input because we don't need its value; we use arrays to store files
    $(this).val('');
});
$("#thread-videos").on('change', function(event) {
    // First we close the error if it is opened
    $('.thread-add-media-error p').addClass('none');
    /**
     * IMPORTANT: see notices inside thread-image change event handler above
     */
    console.log(already_uploaded_thread_videos_assets.length);
     let media_container = $(this);
     while(!media_container.hasClass('thread-add-media-section')) {
         media_container = media_container.parent();    
     }

    let videos = event.originalEvent.target.files;
    let validated_videos = validate_video_file_Type(videos);

    if(videos.length != validated_videos.length) {
        media_container.find('.tame-video-type').removeClass('none');
    } else {
        media_container.find('.tame-video-type').addClass('none');
        media_container.find('.tame-image-type').addClass('none');
    }

    videos = validated_videos;

    /** First let's limit the number of uploaded files */
    if(videos.length + uploaded_thread_videos_assets.length > 4 
        || videos.length + uploaded_thread_videos_assets.length + already_uploaded_thread_videos_assets.length > 4) {
        videos = videos.slice(0, 4-(uploaded_thread_videos_assets.length+already_uploaded_thread_videos_assets.length));
        media_container.find('.tame-video-limit').removeClass('none');
    } else {
        media_container.find('.tame-video-limit').addClass('none');
    }

    for(let i=0;i<videos.length;i++) {
        uploaded_thread_videos_assets.push([uploaded_thread_media_counter, videos[i]]);
        uploaded_thread_media_counter++;
    }
    
    for (let i = 0; i < videos.length; i++) {
        let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
        $('.thread-add-uploaded-medias-container').append(clone);
        // Increment the index
        let upload_videos_index = $('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter');
        let videos_counter = parseInt(upload_videos_index.val()) + 1;
        upload_videos_index.val(videos_counter);
        
        let global_medias_count = videos_counter
            + already_uploaded_thread_images_assets.length
            + already_uploaded_thread_videos_assets.length
            + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-images-counter').val());
        
        // We get the last uploaded video container
        let last_uploaded_video = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
        last_uploaded_video.find('.uploaded-media-index').val(videos_counter-1); // we want 0 based indexes here
        last_uploaded_video.find('.uploaded-media-genre').val('video'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)
        
        last_uploaded_video.find('.thread-add-video-indicator').removeClass('none');

        last_uploaded_video.removeClass('none thread-add-uploaded-media-projection-model');
        if(global_medias_count >= 5) {
            if(global_medias_count == 5)
                $('.thread-add-uploaded-medias-container').addClass('scrollx');

            // Scroll to the end position of x axe
            let c = $('.thread-add-uploaded-medias-container');
            c[0].scrollLeft = c[0].scrollWidth;
        }

        
        // Preview the image (here image should be a snapshot from the video uploaded)
        let img = last_uploaded_video.find(".thread-add-uploaded-image");
        img.removeClass('none');
        try {
            // get the frame at 1.5 seconds of the video file
            get_thumbnail(videos[i], 1.5, img.parent()).then(value => {
                img.attr("src", value);
                handle_image_dimensions(img);
            });
        } catch(e) {
            
        }
    }

    // Clear the input because we don't need its value; we use arrays to store files
    $(this).val('');
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

$('.thread-add-uploaded-media').each(function() {
    handle_close_uploaded_media($(this));
});

function handle_close_uploaded_media(container) {
    container.find('.close-thread-media-upload').on('click', function() {
        // First we close the error if it is opened
        $('.thread-add-media-error p').addClass('none');
        /**
         * Before deleting the component we need the whole components container to decrement the 
         * global upload media counter and the genre of the component whether it's an image or video
         */
        let container = $(this);
        while(!container.hasClass('thread-add-uploaded-medias-container')) {
            container = container.parent();
        }
        let component_genre = $(this).parent().find('.uploaded-media-genre').val();
        let index_to_remove = $(this).parent().find('.uploaded-media-index').val();

        // Then we have to know the genre of component(image/video) in rorder to delete it from the array container type
        if(component_genre == 'image') {
            // decrement the uploaded images counter
            let global_images_counter = container.find('.uploaded-images-counter');
            global_images_counter.val(parseInt(global_images_counter.val()) - 1);

            uploaded_thread_images_assets.splice(index_to_remove, 1);
        } else if(component_genre == 'video') {
            // decrement the uploaded videos counter
            let global_videos_counter = container.find('.uploaded-videos-counter');
            global_videos_counter.val(parseInt(global_videos_counter.val()) - 1);
            
            uploaded_thread_videos_assets.splice(index_to_remove, 1);
        }

        // Then we need to remove the component
        $(this).parent().remove();

        // After removeing the component we need to adjust indexes
        adjust_uploaded_medias_indexes();

        global_counter = 
            $('#thread-uploads-wrapper .thread-add-uploaded-media').length;
        if(global_counter <= 4) {
            $('.thread-add-uploaded-medias-container').removeClass('scrollx');
        }
    })
}
function adjust_uploaded_medias_indexes() {
    let images_count = 0;
    let videos_count = 0;
    $('.thread-add-uploaded-media').each(function() {
        if($(this).find('.uploaded-media-genre').val() == 'image') {
            $(this).find('.uploaded-media-index').val(images_count);
            images_count++;
        } else if($(this).find('.uploaded-media-genre').val() == 'video') {
            $(this).find('.uploaded-media-index').val(videos_count);
            videos_count++;
        }
    });
}
// The following three functions used to fetch image thumbnail from the uploaded video if user upload a video
const get_thumbnail = async function(file, seekTo, thumbnail_container) {
    let response = await getVideoCover(file, seekTo, thumbnail_container);

    return response;
}
function createPoster(video) {
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
    return canvas.toDataURL("image/jpeg");;
}
function getVideoCover(file, seekTo = 0.0, thumbnail_container) {
    return new Promise((resolve, reject) => {
        // load the file to a video player
        const videoPlayer = document.createElement('video');
        videoPlayer.setAttribute('src', URL.createObjectURL(file));
        videoPlayer.load();
        videoPlayer.addEventListener('error', (ex) => {
            reject("error when loading video file", ex);
        });
        // load metadata of the video to get video duration and dimensions
        videoPlayer.addEventListener('loadedmetadata', () => {
            // seek to user defined timestamp (in seconds) if possible
            if (videoPlayer.duration < seekTo) {
                reject("video is too short.");
                return;
            }
            // delay seeking or else 'seeked' event won't fire on Safari
            setTimeout(() => {
              videoPlayer.currentTime = seekTo;
            }, 200);
            // extract video thumbnail once seeking is complete
            videoPlayer.addEventListener('seeked', () => {
                // define a canvas to have the same dimension as the video
                const canvas = document.createElement("canvas");
                canvas.width = videoPlayer.videoWidth;
                canvas.height = videoPlayer.videoHeight;
                // draw the video frame to canvas
                const ctx = canvas.getContext("2d");
                ctx.drawImage(videoPlayer, 0, 0, canvas.width, canvas.height);
                // return the canvas image as a blob
                ctx.canvas.toBlob(
                    blob => {
                        resolve(createPoster(videoPlayer));
                    },
                    "image/jpeg",
                    0.75 /* quality */
                );
            });
        });
    });
}

// Validate images upload
function validate_image_file_Type(files){
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];
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
function is_image(url) {
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];

    var idxDot = url.lastIndexOf(".") + 1;
    var extFile = url.substr(idxDot, url.length).toLowerCase();
    if(extensions.contains(extFile)) {
        return true;
    }

    return false;
}
// Validate videos upload
function validate_video_file_Type(files) {
    let result = [];
    for(let i = 0; i<files.length;i++) {
        fileName = files[i].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="mp3" || extFile=="webm" || extFile=="mpg" 
        || extFile=="mp2"|| extFile=="mpeg"|| extFile=="mpe" 
        || extFile=="mpv"|| extFile=="ogg"|| extFile=="mp4" 
        || extFile=="m4p"|| extFile=="m4v"|| extFile=="avi"){
            result.push(files[i]);
        }
    }

    return result;
}
function is_video(url) {
    let extensions = ["mp3", "webm", "mpg", "mp2", "mpeg", "mpe", "mpv", "ogg", "mp4", "m4p", "m4v", "avi"];
    var idxDot = url.lastIndexOf(".") + 1;
    var extFile = url.substr(idxDot, url.length).toLowerCase();
    if(extensions.contains(extFile)) {
        return true;
    }

    return false;
}

function handle_thread_medias_containers(thread) {
    let thread_medias_container = thread.find('.thread-medias-container');
    let media_count = thread_medias_container.find('.thread-media-container').length;
    let medias = thread_medias_container.find('.thread-media-container');
    let full_media_width = thread_medias_container.width();
    let half_media_width = (full_media_width / 2);

    if(media_count == 1) {
        handle_thread_media_one_item(thread_medias_container);
    } else if(media_count == 2) {
        medias.each(function() {
            $(this).width(half_media_width-2);
            $(this).height(half_media_width-2);
        })
    } else if(media_count == 3) {
        $(medias[0]).width(half_media_width-2);
        $(medias[0]).height(half_media_width-2);
        
        $(medias[1]).width(half_media_width-2);
        $(medias[1]).height(half_media_width-2);
        
        $(medias[2]).width(full_media_width);
        $(medias[2]).height(half_media_width);

        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');
    } else if(media_count == 4) {
        medias.each(function() {
            $(this).width(half_media_width-2);
            $(this).height(half_media_width-2);
        });
        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');
    } else {
        for(let i = 0;i<4;i++) {
            $(medias[i]).width(half_media_width-2);
            $(medias[i]).height(half_media_width-2);
        }

        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');

        for(i=4;i<medias.length;i++) {
            $(medias[i]).addClass('none');
        }

        let more = medias.length - 4;
        $(medias[3]).find('.full-shadow-stretched').removeClass('none');
        $(medias[3]).find('.thread-media-more-counter').text(more);
    }
}

let images_loaded = false;
let infos_fetched = false;
let viewer_media_count = 0;
let viewer_medias = [];
let last_opened_thread = 0;
let opened_thread_component;
let viewer_loading_finished = false;
function handle_open_media_viewer(thread) {
    thread.find('.open-media-viewer').each(function() {
        $(this).on('click', function(event) {
            event.preventDefault();

            infos_fetched = images_loaded = false;

            let media_viewer = $('#thread-media-viewer');
            // all thread medias container
            let medias_container = $(this);
            while(!medias_container.hasClass('thread-medias-container')) {
                medias_container = medias_container.parent();
            }
            // selected media container
            let media_container = $(this);
            while(!media_container.hasClass('thread-media-container')) {
                media_container = media_container.parent();
            }
            let selected_media = media_container.find('.media-count').val();
            
            medias_container.find('.thread-media-container').each(function() {
                // Here before pushing the sources, we need to check media type
                let media_type = $(this).find('.media-type').val();
                let media_source;
                if(media_type == "image") {
                    var attr = $(this).find('.thread-media').attr('data-src');
                    // we check for data-src due to lazy loaded more images (because +4 images are hidden and therefor they are not handled by lazy loading function)
                    if (typeof attr !== 'undefined' && attr !== false)
                        media_source = $(this).find('.thread-media').attr('data-src');
                    else
                        media_source = $(this).find('.thread-media').attr('src');
                } else if(media_type == "video") {
                    media_source = $(this).find('video source').attr('src');
                }
                viewer_medias.push(media_source);
            });
            viewer_media_count = selected_media;
            let selected_media_url = viewer_medias[selected_media];

            // Viewer navigation buttons
            if(viewer_medias.length == 1) {
                $('.thread-viewer-right').addClass('none');
                $('.thread-viewer-left').addClass('none');
            } else {
                if(selected_media != 0) {
                    $('.thread-viewer-left').removeClass('none');
                }

                if(selected_media == viewer_medias.length-1) {
                    $('.thread-viewer-right').addClass('none');
                } else {
                    $('.thread-viewer-right').removeClass('none');
                }
            }
            // media index indicator
            if(viewer_medias.length > 1) {
                media_viewer.find('.thread-viewer-medias-indicator').removeClass('none');
                media_viewer.find('.thread-counter-total-medias').text(viewer_medias.length);
                media_viewer.find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);
            }
            
            /**
             * Before opening thread media viewer we need to make sure all medias are loaded
             */
            medias_container.imagesLoaded( function() {
                images_loaded = true;
                $('body').css('overflow', 'hidden');
                media_viewer.removeClass('none');
                // Check type of media
                if(is_image(selected_media_url)) {
                    // It's an image
                    let viewer_image = $('#thread-viewer-media-image');
                    let viewer_video = $('#thread-viewer-media-video');
                    viewer_image.removeClass('none');
                    viewer_video.addClass('none');
                    viewer_image.attr('src', viewer_medias[selected_media]);
                    handle_thread_viewer_image(viewer_image);
                } else if(is_video(selected_media_url)) {
                    // It's a video
                    let viewer_image = $('#thread-viewer-media-image');
                    let viewer_video = $('#thread-viewer-media-video');
                    viewer_image.addClass('none');
                    viewer_video.removeClass('none');
                    viewer_video.attr('src', selected_media_url);
                    viewer_video[0].load();
                }
                if(infos_fetched) {
                    stop_loading_strip();
                    viewer_loading_finished = true;
                }
            });

            opened_thread_component = $(this);
            while(!opened_thread_component.hasClass('resource-container')) {
                opened_thread_component = opened_thread_component.parent();
            }
            let thread_id = opened_thread_component.find('.thread-id').first().val();
            if(last_opened_thread != thread_id) {
                viewer_loading_finished = false;
                start_loading_strip();
                $('.tmvis').html('');
                $('.thread-media-viewer-infos-header-pattern').removeClass('none');
                // First we send ajax request to get thread infos component
                $.ajax({
                    url: `/threads/${thread_id}/viewer_infos_component`,
                    type: 'get',
                    success: function(thread_infos_section) {
                        infos_fetched = true;
                        last_opened_thread = thread_id;
                        $('.thread-media-viewer-infos-header-pattern').addClass('none');
                        $('.tmvisc').html(thread_infos_section);
                        // Bind mde to viewer reply editor
                        $('#viewer-reply-container textarea').each(function() {
                            let viewer_reply_simplemde = new SimpleMDE({
                                hideIcons: ["guide", "heading", "link", "image"],
                                spellChecker: false,
                                showMarkdownLineBreaks: true,
                            });
                        });
                        // ----- HANDLING EVENTS -----
                        $('.tmvisc').find('.follow-resource').not('#viewer-replies-box .follow-resource').each(function() {
                            handle_follow_resource($(this));
                        });
                        $('.tmvisc').find('.button-with-suboptions').not('#viewer-replies-box .button-with-suboptions').each(function() {
                            handle_suboptions_container($(this));
                        });
                        $('.tmvisc').find('.expand-button').not('#viewer-replies-box .expand-button').each(function() {
                            handle_expend($(this));
                        });
                        $('.tmvisc').find('.move-to-thread-viewer-reply').on('click', function() {
                            location.hash = "#viewer-reply-text-label";
                            // After taking the user to replying section we need to delete the anchor from url
                            location.hash = '';
                            // and then get rid of the last hash in url
                            history.replaceState({}, document.title, window.location.href.split('#')[0]);
                            // and focus the editor
                            viewer_reply_simplemde.codemirror.focus();
                        });
                        $('.tmvisc').find('.like-resource').not('.viewer-thread-reply .like-resource').each(function() {
                            handle_resource_like($(this));
                        });
                        $('.tmvisc').find('.login-signin-button').not('.viewer-thread-reply .login-signin-button').each(function() {
                            handle_login_lock($(this).parent());
                        });
                        handle_save_threads($('.tmvisc').find('.save-thread'));
                        handle_document_suboptions_hiding();
                        $('.tmvisc').find('.votable-up-vote').not('.viewer-thread-reply .votable-up-vote').each(function() {
                            handle_up_vote($(this));
                        })
                        $('.tmvisc').find('.votable-down-vote').not('.viewer-thread-reply .votable-down-vote').each(function() {
                            handle_down_vote($(this));
                        })
                        if($('.tmvisc').find('#viewer-replies-load').length) {
                            handle_viewer_replies_load($('.tmvisc').find('#viewer-replies-load'));
                        }
                        $('.tmvisc').find('.viewer-thread-reply').each(function() {
                            handle_viewer_reply_events($(this));
                        });
                        // ---- HANDLE REPLY BUTTON ---- //
                        $('.tmvisc').find('.share-viewer-reply').on('click', function() {

                            const $codemirror = $('#viewer-reply-input').nextAll('.CodeMirror')[0].CodeMirror;
                            let button = $(this);
                            let button_text_ing = $(this).parent().find('.button-text-ing').val();
                            let button_text_no_ing = $(this).parent().find('.button-text-no-ing').val();
                            
                            let post_content = $codemirror.getValue();
                            let thread_id = button.parent().find('.thread-id').val();

                            let data = {
                                '_token':csrf,
                                'thread_id': thread_id,
                                'content': post_content,
                            };

                            if(post_content == "") {
                                $('.reply-error').removeClass('none');
                                $('.reply-error').text(button.parent().find('.required-error').val());
                                button.prop("disabled", false);
                                button.attr('style', '');
                            } else if(post_content.length < 2) {
                                $('.reply-error').text(button.parent().find('.reply-size-error').val());
                                $('.reply-error').removeClass('none');
                                button.prop("disabled", false);
                                button.attr('style', '');
                            }
                            else {
                                button.val(button_text_ing);
                                button.attr("disabled","disabled");
                                button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');
                                $('.reply-error').addClass('none');
                                // Disable editor while saving the reply
                                $codemirror.options.readOnly = 'nocursor';

                                $.ajax({
                                    type: 'post',
                                    data: data,
                                    url: '/post?from=thread-viewer',
                                    success: function(response) {
                                        $('.viewer-thread-replies-number-container').removeClass('none');
                                        if ($(".viewer-ticked-reply").length){
                                            $(".viewer-replies-container .viewer-thread-reply:first-child").after(response);
                                            pst = $('.viewer-replies-container .viewer-thread-reply:eq(1)');
                                        } else {
                                            $('.viewer-replies-container').prepend(response);
                                            pst = $('.viewer-replies-container .viewer-thread-reply').first();
                                        }
                                        
                                        handle_viewer_reply_events(pst);

                                        $codemirror.getDoc().setValue('');
                                        let new_replies_counter = parseInt($('.viewer-thread-replies-number').first().text(), 10)+1;
                                        $('.viewer-thread-replies-number').text(new_replies_counter);

                                        // 1. Handle replies counter
                                        opened_thread_component.find('.thread-replies-counter').text(new_replies_counter);
                                        // Handle thread replies outside the viewer, but just in case the user is located in thread show page
                                        // To verify that, we can check if thread show replies container exists
                                        if($('#replies-container').length) {
                                            // 2. Handle reply appending to thread show page
                                            let post_id = pst.find('.post-id').val();
                                            $.ajax({
                                                url: `/post/${post_id}/show/generate`,
                                                type: 'get',
                                                success: function(post) {
                                                    $('#replies-container').find('.replies_header_after_thread').removeClass('none');
                                                    $('#global-error').css('display', 'none');
                                                    let pst;
                                                    if ($("#ticked-post")[0]){
                                                        $("#replies-container .resource-container:first-child").after(post);
                                                        pst = $('#replies-container .resource-container:eq(1)');
                                                    } else {
                                                        $('#replies-container').prepend(post);
                                                        pst = $('#replies-container .resource-container').first();
                                                    }
                                                    $('.thread-replies-number').text(new_replies_counter);

                                                    // Handling all events of the newly appended component
                                                    handle_post_events(pst);
                                                    handle_post_other_events(pst);
                                                }
                                            })
                                        }
                                    },
                                    error: function(response) {
                                        let errors = JSON.parse(response.responseText);
                                        let error;

                                        if(errors.message) {
                                            error = errors.message
                                        } else {
                                            // Here we get the errors of the response as an object
                                            let errors = JSON.parse(response.responseText);
                            
                                            // The errors object hold errors keys as well as error values in form of array of errors
                                            // because a field could have multiple validation constraints and then it could have multiple errors
                                            // strings. In this case we only need the first error of the first validation
                                            error = errors[Object.keys(errors)[0]][0];
                                        }
                                        $('.reply-error').removeClass('none');
                                        $('.reply-error').text(error);
                                    },
                                    complete: function() {
                                        button.val(button_text_no_ing);
                                        button.prop("disabled", false);
                                        button.attr('style', '');
                                        $codemirror.options.readOnly = false;
                                    }
                                });
                            }
                        });           
                        // ---------------------- //
                        handle_viewer_infos_height($('.tmvisc').find('.thread-media-viewer-infos-content'));
                        if(images_loaded) {
                            stop_loading_strip();
                            viewer_loading_finished = true;
                        }
                    }
                });
            } else {
                viewer_loading_finished = true;
            }
        })
    })
}

function handle_viewer_reply_events(reply_component) {
    handle_resource_like(reply_component.find('.like-resource'));
    handle_tooltip(reply_component);
    handle_post_display_buttons(reply_component);
    // Handle reply edit editor
    reply_component.find('textarea').each(function() {
        var simplemde = new SimpleMDE({
            element: this,
            hideIcons: ["guide", "heading", "link", "image"],
            spellChecker: false,
            status: false,
        });
    });
    // ------------------------
    handle_edit_post(reply_component);
    handle_save_edit_post(reply_component);
    handle_exit_edit_changes(reply_component);
    handle_delete_post_button(reply_component);
    handle_delete_post(reply_component);
    handle_close_shadowed_view(reply_component);
    handle_login_lock(reply_component);

    reply_component.find('.button-with-suboptions').each(function() {
        handle_suboptions_container($(this));
    });
    reply_component.find('.follow-resource').each(function() {
        handle_follow_resource($(this));
    });
    reply_component.find('.votable-up-vote').each(function() {
        handle_up_vote($(this));
    })
    reply_component.find('.votable-down-vote').each(function() {
        handle_down_vote($(this));
    });
    reply_component.find('.expand-button').each(function() {
        handle_expend($(this));
    });
}

$('.close-thread-media-viewer').on('click', function() {
    handle_viewer_closing();
});

$('.thread-viewer-left').on('click', function(event) {
    event.stopPropagation();
    
    if(viewer_media_count == 1) {
        $('.thread-viewer-left').addClass('none');
        $('.thread-viewer-right').removeClass('none');
    } else {
        $('.thread-viewer-right').removeClass('none');
    }

    let previous_media_url = viewer_medias[parseInt(viewer_media_count)-1];
    if(is_image(previous_media_url)) {
        let viewer_image = $('#thread-viewer-media-image');
        handle_thread_viewer_image(viewer_image);

        $('#thread-viewer-media-video').addClass('none');
        viewer_image.removeClass('none');

        viewer_image.attr('src', "");
        viewer_image.attr('src', viewer_medias[--viewer_media_count]);
    } else if(is_video(previous_media_url)) {
        let viewer_video = $('#thread-viewer-media-video');

        $('#thread-viewer-media-image').addClass('none');
        viewer_video.removeClass('none');

        viewer_video.attr('src', "");
        viewer_video.attr('src', viewer_medias[--viewer_media_count]);
        viewer_video[0].load();
    }

    $('#thread-media-viewer').find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);
});
$('.thread-viewer-right').on('click', function(event) {
    event.stopPropagation();

    $('.thread-viewer-left').removeClass('none');
    let next_media_url = viewer_medias[parseInt(viewer_media_count)+1];
    if(is_image(next_media_url)) {
        let viewer_image = $('#thread-viewer-media-image');
        handle_thread_viewer_image(viewer_image);
        $('#thread-viewer-media-video').addClass('none');
        viewer_image.removeClass('none');

        viewer_image.attr('src', "");
        viewer_image.attr('src', viewer_medias[++viewer_media_count]);
    } else if(is_video(next_media_url)) {
        let viewer_video = $('#thread-viewer-media-video');

        $('#thread-viewer-media-image').addClass('none');
        viewer_video.removeClass('none');

        viewer_video.attr('src', "");
        viewer_video.attr('src', viewer_medias[++viewer_media_count]);
        viewer_video[0].load();
    }
    $('#thread-media-viewer').find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);

    if(viewer_media_count == viewer_medias.length-1) {
        $('.thread-viewer-right').addClass('none');
    }
});

$('#thread-viewer-media-image').click(function(event) {
    event.stopPropagation();
});

$('.thread-media-viewer-content-section').click(function() {
    handle_viewer_closing();
})
function handle_viewer_closing() {
    viewer_media_count = 0;
    viewer_medias = [];
    
    let viewer = $('#thread-media-viewer');
    let viewer_video = $('#thread-viewer-media-video');
    viewer_video[0].pause();
    $('.thread-viewer-nav').addClass('none');
    viewer.find('.thread-viewer-medias-indicator').addClass('none');
    viewer.addClass('none');
    $('body').css('overflow-y', '');
    stop_loading_strip();
}
function handle_thread_viewer_image(image) {
    image.parent().imagesLoaded(function() {
        handle_viewer_media_logic(image);
    });
}

/**
 * Keep in mind that the result dimensions for the passed image must be in percentage (%)
 * because we call this handler in resize event of browser
 */
function handle_viewer_media_logic(image) {
    image.attr('style', '');
    let container_height = image.parent().height();
    let original_width = image.width();
    let original_height = image.height();

    if(original_width > original_height) {
        image.css('width', '100%');
        let new_width = image.width(); // get the new width after setting it to 100%
        let new_height = image.height(); // get newer height dimension because width is changed and affect the height

        if(new_height > container_height) {
            image.css('height', '100%');
            let ratio = container_height * original_width / original_height;
            image.css('width', ratio + 'px');
        } else {
            
        }
    } else {
        image.css('height', '100%');
    }
}

/**
 * This function take an image as its only parameter and stratch it to it container
 * The container must be its first direct parent
 * The function handle all image dimensions possibilities and container possibilities
 * Container possibilities (3 possibilites):
 *      container_width == container_height
 *      container_width > container_height
 *      container_width < container_height
 * Image possibilities (10 possibilities) ----------- THE CASES IN DOCS ARE MESSY THEY NEED TO BE UPDATED BECAUSE I UPDATED THE LOGIC -------------
 *      case#1 = container_width < container_height && image_width > image_height
 *      case#2 = container_width < container_height && image_width < image_height && image_height > container_height
 *      case#3 = container_width < container_height && image_width < image_height && image_height > container_height
 *      case#4 = container_width < container_height && image_width < image_height && image_height < container_height
 * 
 *      case#5 = container_width > container_height && image_width < image_height
 *      case#6 = container_width > container_height && image_width > image_height && image_height < container_height
 *      case#7 = container_width > container_height && image_width > image_height && image_height > container_height
 *      case#8 = container_width > container_height && image_width > image_height && image_height < container_height
 * 
 *      case#9 = container_width == container_width && image_width >= image_height
 *      case#10 = container_width == container_width && image_width < image_height
 */
function handle_media_image_dimensions(image) {
    let image_container = image.parent();
    let container_width = image_container.width();
    let container_height = image_container.height();

    let width = image.width();
    let height = image.height();

    if(container_width > container_height) {
        if(height > width) {
            if(height > container_height) {
                if(width < container_width) {
                    /** CASE #2 */
                    image.width(container_width);
                    image.css('height', 'max-content');
                } else {
                    /** CASE #3 */
                    image.height(container_height);
                    if(image.width() < container_width) {
                        // Calculate the ratio
                        let ratio = container_width / image.width();
                        let new_height = image.height() * ratio;
                        image.width(container_width);
                        image.height(new_height);
                    }
                }
            } else {
                /** CASE #4 */
                image.height(container_height);
                if(image.width() < container_width) {
                    // Calculate the ratio
                    let ratio = container_width / image.width();
                    let new_height = image.height() * ratio;
                    image.width(container_width);
                    image.height(new_height);
                }
            }
        } else if(height < width) {
            /** CASE #1 */
            if(height > container_height) {
                if(width < container_width) {
                    /** CASE #2 */
                    image.css('width', '100%');
                    image.css('height', 'max-content');
                } else {
                    /** CASE #3 */
                    image.css('height', '100%');
                    image.css('width', 'max-content');
                }
            } else {
                image.height('100%');
                image.css('width', '100%');
            }
        } else {
            image.css('width', '100%');
            image.css('height', 'max-content');
        }
    } else if(container_height < container_width) {
        if(width > height) {
            if(width > container_width) {
                if(height < container_height) {
                    /** CASE #2 */
                    image.height(container_height);
                } else {
                    /** CASE #3 */
                    image.width(container_width);
                    if(image.height() < container_height) {
                        // Calculate the ratio
                        let ratio = container_height / image.height();
                        let new_width = image.width() * ratio;
                        image.height(container_height);
                        image.height(new_width);
                    }
                }
            } else {
                /** CASE #4 */
                image.width(container_width);
                if(image.height() < container_height) {
                    // Calculate the ratio
                    let ratio = container_height / image.height();
                    let new_width = image.width() * ratio;
                    image.height(container_height);
                    image.height(new_width);
                }
            }
        } else {
            image.width(container_width);
            image.css('height', 'max-content');
        }
    } else {
        if(width >= height) {
            /** CASE #9 */
            image.height(container_height);
        } else {
            /** CASE #10 */
            image.width(container_width);
        }
    }
}

function handle_thread_video_dimensions(video) {
    let medias_container = video;
    while(!medias_container.hasClass('thread-medias-container')) {
        medias_container = medias_container.parent();
    }
    
    let videoWidth = video[0].videoWidth;
    let videoHeight = video[0].videoHeight;
}

// go to index resource give video media a specific class and then come back here to handle each video

$('.fade-loading').each(function(event) {
    let fade_item = $(this);
    window.setInterval(function(){
        let target_color;
        if(fade_item.css('background-color') == "rgb(230, 230, 230)") {
            target_color = "rgb(200, 200, 200)";
        } else {
            target_color = "rgb(230, 230, 230)";
        }
        fade_item.css({
            backgroundColor: target_color,
            transition: "background-color 0.8s"
        });
    }, 800);
});
function handle_fade_loading_removing(fade_container) {
    fade_container.imagesLoaded(function() {
        fade_container.find('.fade-loading').remove();
    });
}
function handle_fade_loading(fade_container) {
    fade_container.find('.fade-loading').each(function() {
        let fade_item = $(this);
        window.setInterval(function(){
            let target_color;
            if(fade_item.css('background-color') == "rgb(240, 240, 240)") {
                target_color = "rgb(200, 200, 200)";
            } else {
                target_color = "rgb(240, 240, 240)";
            }
            fade_item.css({
                backgroundColor: target_color,
                transition: "background-color 1.2s"
            });
        }, 1200);
    });
}

let strip_loading_interval;
function start_loading_strip() {
    let loading_strip = $('#loading-strip');
    let loading_strip_line = loading_strip.find('.loading-strip-line');
    loading_strip.removeClass('none');
    strip_loading_interval = window.setInterval(function(){
        loading_strip_line.animate({
            left: '100%'
        }, 800, function() {
            loading_strip_line.css('left', '-100%');
        });
    }, 800);
}
function stop_loading_strip() {
    $('#loading-strip').addClass('none');
    clearInterval(strip_loading_interval);
}

function handle_viewer_replies_load(button) {
    button.click(function() {
        let button_text_ing = button.parent().find('.button-text-ing').val();
        let button_text_no_ing = button.parent().find('.button-text-no-ing').val();
        
        button.val(button_text_ing);
        button.attr("disabled","disabled");
        button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default');

        let viewer_replies_container = $('.viewer-replies-container');
        
        let present_replies_count = viewer_replies_container.find('.viewer-thread-reply').length;
        let thread_id = button.parent().find('.thread-id').val();

        $.ajax({
            url: `/thread/${thread_id}/viewer/posts/load?range=6&skip=${present_replies_count}`,
            type: 'get',
            success: function(replies_payload) {
                if(replies_payload.hasNext == false) {
                    button.addClass('none');
                }

                if(replies_payload.content != "") {
                    $(`${replies_payload.content}`).insertBefore(button);

                    let unhandled_replies = 
                        $('.viewer-thread-reply').slice(replies_payload.count*(-1));
                    
                    unhandled_replies.each(function() {
                        handle_viewer_reply_events($(this));
                    });
                }
            },
            complete: function() {
                button.val(button_text_no_ing);
                button.attr('style', '');
                button.prop("disabled", false);
            }
        })
    });
}

$('.move-to-thread-replies').each(function() {
    handle_move_to_thread_replies($(this));
});

function handle_move_to_thread_replies(button) {
    button.click(function() {
        if($('#thread-show-replies-section').length) {
            location.hash = "#thread-show-replies-section";
            // we scroll to top by 50 because header's height is 52px and header is absolute (50 and not 52 because 50 look better :=D )
            window.scrollBy(0,-50);
        } else {
            let container = button;
            while(!container.hasClass('resource-container')) {
                container = container.parent();
            }

            // Only open thread viewer if there's a media
            if(container.find('.thread-medias-container').length) {
                // Here also we check if the viewer is opened for the same thread
                let c = container.find('.thread-media-container').first();
                let c_type = c.find('.media-type').val();
                if(c_type == 'image') {
                    container.find('.thread-media-container').first().click();
                    if(last_opened_thread && last_opened_thread == container.find('.thread-id').first().val()) {
                        document.getElementById("viewer-replies-site").scrollIntoView(true);
                    } else {
                        /**
                         * If the viewer is not opened at all we have to wait for viewer infos to be loaded
                         * and then we scroll to the replies secction
                         */
                        var wait_for_viewer_infos = window.setInterval(function() {
                            if($('.tmvisc').find('.thread-media-viewer-infos-content').length) {
                                document.getElementById("viewer-replies-site").scrollIntoView(true);
                                clearInterval(wait_for_viewer_infos);
                            }
                        }, 400);
                    }
                } else if(c_type == 'video') {
                    $('.open-media-viewer').trigger('click');
                }
                
            }
        }
    });
}

$('.save-thread').each(function() {
    handle_save_threads($(this));
});

function handle_save_threads(save_button) {
    save_button.click(function() {
        let loading = save_button.find('.loading-dots-anim');
        loading.removeClass('none');
        start_loading_anim(loading);

        let thread_id = save_button.find('.thread-id').first().val();
        let save_switch = save_button.find('.status').val();

        $.ajax({
            type: 'post',
            url: `/thread/${thread_id}/save`,
            data: {
                _token: csrf,
                save_switch: save_switch
            },
            success: function(response) {
                loading.addClass('none');
                stop_loading_anim();

                if(response == 1) {
                    save_button.find('.status').val('unsave');
                    save_button.find('.icon').attr('d', save_button.find('.unsave-icon').val());
                    save_button.find('.button-text').text(save_button.find('.button-text-unsave').val());
                    basic_notification_show(save_button.find('.saved-message').val(), 'basic-notification-round-tick');
                } else {
                    save_button.find('.status').val('save');
                    save_button.find('.icon').attr('d', save_button.find('.save-icon').val());
                    save_button.find('.button-text').text(save_button.find('.button-text-save').val());
                    basic_notification_show(save_button.find('.unsaved-message').val(), 'basic-notification-round-tick');
                }

                save_button.parent().css('display', 'none');
            }
        });
    });
}

let basic_notification;
function basic_notification_show(message, icon='') {
    if(icon != '') {
        $('.basic-notification-container').find('.'+icon).removeClass('none');
    }

    $('.basic-notification-container').removeClass('none');
    $('.basic-notification-container').find('.basic-notification-content').html(message);

    setTimeout(function() {
        $('.basic-notification-container').addClass('none');
        $('.basic-notification-container').find('.basic-notification-content').html('');
   }, 5000);
}

// -------------------------------------    reporting section    -------------------------------------
$('.close-report-container').click(function() {
    let report_container = $(this);
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    close_report_container(report_container);
});
function close_report_container(container) {
    container.animate({
        opacity: 0
    }, 500, function() {
        container.addClass('none');
        container.css('opacity', '1');
    })
}
$('.open-thread-report').on('click', function() {
    $('#post-report-container').addClass('none');
    let container = $('.thread-report-container');

    container.css('opacity', '0');
    container.removeClass('none');
    
    container.find('.report-input').prop('checked', false);
    container.find('.child-to-be-opened').css('height', '0');
    $('.resource-report-option').css('background-color', '');
    $('.report-section-textarea').val('');

    let report_button = container.find('.submit-report');
    report_button.attr("disabled","disabled");
    report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
    report_button.removeClass('blue-background');

    container.animate({
        opacity: 1
    }, 300);

    container.find('.reportable-id').val($(this).find('.thread-id').val());
    container.find('.reportable-type').val('thread');
});
$('.resource-report-option').each(function() {
    $(this).on('click', function() {
        $('.resource-report-option').css('background-color', '');
        $(this).css('background-color', 'rgb(242, 242, 242)');
        let value = $(this).find('.report-input').val();

        let report_container = $(this);
        while(!report_container.hasClass('report-resource-container')) {
            report_container = report_container.parent();
        }
        let report_button = report_container.find('.submit-report');

        if(value == 'moderator-intervention') {
            $(this).find('.child-to-be-opened').animate({
                height: '100%'
            }, 400);

            report_button.attr("disabled","disabled");
            report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
            report_button.removeClass('blue-background');

            handle_report_textarea(report_container.find('.report-section-textarea'));
        } else {
            $('.child-to-be-opened').animate({
                height: '0'
            }, 400);

            report_button.attr('style', '');
            report_button.prop("disabled", false);
            report_button.addClass('blue-background');
        }
    });
});
$('.report-section-textarea').on('input', function() {
    handle_report_textarea($(this));
});
function handle_report_textarea(textarea) {
    let report_container = textarea;
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    let counter_container = textarea.parent().find('.report-content-counter');
    let maxlength = 500;
    let currentLength = textarea.val().length;

    let report_button = report_container.find('.submit-report');

    counter_container.addClass('gray');
    if(currentLength == 0) {
        counter_container.attr('style', '');
        counter_container.find('.report-content-count').text('');
        counter_container.find('.report-content-count-phrase').text(counter_container.parent().find('.first-phrase-text').val());        

        // Disable submit report button
        report_button.attr("disabled","disabled");
        report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
    } else if(currentLength > maxlength ){
        let more_than_max = currentLength - maxlength;
        let chars_text = more_than_max > 1 ? counter_container.parent().find('.characters-text').val() : counter_container.parent().find('.characters-text').val().slice(0, -1);
        let counter_phrase = counter_container.parent().find('.too-long-text').val() + ' ' + more_than_max + ' ' + chars_text;
        counter_container.find('.report-content-count').text('');
        counter_container.find('.report-content-count-phrase').text(counter_phrase);

        counter_container.removeClass('gray');
        counter_container.css('color', '#e83131');

        // Disable submit report button
        report_button.attr("disabled","disabled");
        report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
        report_button.removeClass('blue-background');
    } else {
        counter_container.attr('style', '');
        if(currentLength < 10) {
            let left_to_10 = 10 - currentLength;
            let counter_phrase = counter_container.parent().find('.more-to-go-text').val();
            counter_container.find('.report-content-count').text(left_to_10);
            counter_container.find('.report-content-count-phrase').text(counter_phrase);

            // Disable submit report button
            report_button.attr("disabled","disabled");
            report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
            report_button.removeClass('blue-background');
        } else {
            let chars_left = maxlength - currentLength;
            let counter_phrase = counter_container.parent().find('.chars-left-text').val();
            counter_container.find('.report-content-count').text(chars_left);
            counter_container.find('.report-content-count-phrase').text(counter_phrase);

            report_button.attr('style', '');
            report_button.prop("disabled", false);
            report_button.addClass('blue-background');
        }
    }
}
$('.submit-report').on('click', function() {
    let button = $(this);
    let button_text_ing = $(this).parent().find('.button-ing-text').val();
    let button_text_no_ing = $(this).parent().find('.button-no-ing-text').val();
    
    button.val(button_text_ing);
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #a6d5ff; cursor: default; font-weight: bold');

    let report_container = $(this);
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    let reportable_type = report_container.find('.reportable-type').val();
    let reportable_id = report_container.find('.reportable-id').val();
    let report_type = report_container.find('input[name="report"]:checked').val();

    let data = {
        _token: csrf,
        report_type: report_type  
    };

    if(report_type == "moderator-intervention") {
        data.body = report_container.find('.report-section-textarea').val();
    }

    $.ajax({
        type: 'post',
        url: `/${reportable_type}/${reportable_id}/report`,
        data: data,
        success: function(response) {
            if(reportable_type == 'post') {
                // We have to set already reported to 1 inside report 
                let pid = reportable_id;
                $('.already-reported').each(function() {
                    if($(this).parent().find('.post-id').val() == pid) {
                        $(this).val('1'); // Set already reported to 1
                        return false;
                    }
                });
            }

            close_report_container(report_container);
            // Wait for closing annimation
            setTimeout(function() {
                report_container.find('.report-section').remove();
                report_container.find('.already-reported-container').removeClass('none');
            }, 400);
            basic_notification_show(button.parent().find('.reported-text').val(), 'basic-notification-round-tick');
        },
        error: function(response) {
            report_container.addClass('none');
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;

            display_top_informer_message(er, 'error');
        },
        complete: function() {
            button.val(button_text_no_ing);
            button.attr("disabled",false);
            button.attr('style', '');
        }
    });
});
$('.open-post-report').on('click', function(event) {
    $('.thread-report-container').addClass('none');
    $(this).parent().css('display', 'none');
    // Stop propagation to close the button container because if propagation not stop container won't disappear 
    // because clicking on container or its content doesn't close the container
    event.stopPropagation(); 
    let container = $('#post-report-container');
    let button = $(this);
    // Already reported not equal to zero means it is already reported
    if(button.find('.already-reported').val() != '0') {
        container.find('.already-reported-container').removeClass('none');
        container.find('.report-section').addClass('none');
    } else {
        container.find('.already-reported-container').addClass('none');
        container.find('.report-section').removeClass('none');

        // clear all inputs
        container.find('.report-input').prop('checked', false);
        container.find('.child-to-be-opened').css('height', '0');
        $('.resource-report-option').css('background-color', '');
        $('.report-section-textarea').val('');

        let report_button = container.find('.submit-report');
        report_button.attr("disabled","disabled");
        report_button.attr('style', 'background-color: #a6d5ff; cursor: default');
        report_button.removeClass('blue-background');

        container.find('.reportable-id').val($(this).find('.post-id').val());
        container.find('.reportable-type').val('post');
    }
    // Display report container
    container.css('opacity', '0');
    container.removeClass('none');

    container.animate({
        opacity: 1
    }, 300);
});
// -----------------------------------------------------------------------

$('.close-thread-media-upload-edit').on('click', function() {
    // First we close the error if it is opened
    $('.thread-add-media-error p').addClass('none');

    edit_deleted_medias.push($(this).parent().find('.uploaded-media-url').val());

    $(this).parent().remove();
});

$('.thread-media-options .open-media-viewer').on('click', function() {
    let medias_container = $(this);
    while(!medias_container.hasClass('thread-medias-container')) {
        medias_container = medias_container.parent();
    }

    medias_container.find('video').each(function() {
        $(this)[0].pause();
    });
});

$('.inline-button-style').on('click', function() {
    $(this).parent().find('.inline-button-style').removeClass('selected-inline-button-style');
    $(this).addClass('selected-inline-button-style');
});

let activities_section_opened = 'threads';
let activities_sections_apperance_switch = new Map([
    ['threads', true],
    ['saved-threads', false],
    ['liked-threads', false],
    ['voted-threads', false],
    ['activity-log', false],
]);
let section_switcher_lock = true;
$('.activity-section-switcher').on('click', function() {
    let spinner = $('#activities-sections-loading-container').find('.spinner');
    let section = $(this).find('.activity-section-name').val();

    // If the section is already opened we don't to do anything
    if(section == activities_section_opened) {
        return;
    }

    // If the section is already fetched we only need to hide the other opened sections and show it
    // If the section doesn't exists we need to send GET request to fetch the section
    if(activities_sections_apperance_switch.get(section)) {
        $('#activities-sections-content').find('.activities-section').addClass('none');
        $('.activities-' + section + '-section').removeClass('none');
        activities_section_opened = section;
    } else {
        if(!section_switcher_lock) {
            return;
        }
        section_switcher_lock = false;
        $('#activities-sections-loading-container').removeClass('none');
        setTimeout(function() {
            start_spinner(spinner, 'activities-sections-switcher');
        }, 10);

        
        let user =  $('.activities-user').val()
        $.ajax({
            url: `/users/${user}/activities/sections/${section}/generate`,
            type: 'get',
            success: function(payload) {
                $('#activities-sections-content').append(payload);
                $('#activities-sections-content').find('.activities-section').addClass('none');
                $('#activities-sections-content').find('.activities-' + section + '-section').removeClass('none');

                let appended_section = $('.activities-section').last();
                handle_activity_load_more_button(appended_section.find('.activity-section-load-more'));
                appended_section.find('.thread-container-box').each(function() {
                    let thread_container = $(this);
                    handle_element_suboption_containers($(this));
                    handle_section_suboptions_hinding($(this));
                    handle_thread_display($(this));
                    handle_tooltip($(this).find('.tooltip-section'));
                    $(this).imagesLoaded(function() {
                        thread_container.find('.activity-thread-user-image').each(function(){
                            handle_image_dimensions($(this));
                        });
                    });
                    handle_restore_thread_button($(this));
                    handle_permanent_delete($(this));
                    handle_permanent_destroy_button($(this));
                    handle_hide_parent($(this));
                });
            },
            complete: function() {
                activities_sections_apperance_switch.set(section, true);
                activities_section_opened = section;
                $('#activities-sections-loading-container').addClass('none');
                stop_spinner(spinner, 'activities-sections-switcher');
                section_switcher_lock = true;
            }
              
        })
    }
});

let spinners_intervals = new Map();
let spinner_rotation = 0;
function start_spinner(spinner, spinner_interval_name) {
    spinner_rotation = 360;
    spinner.rotate(spinner_rotation);
    spinners_intervals.set(spinner_interval_name, 
        setInterval(function() {
            spinner_rotation+= 360;
            spinner.rotate(spinner_rotation);
        }, 1500, true)
    );
}

function stop_spinner(spinner, spinner_interval_name) {
    clearInterval(spinners_intervals.get(spinner_interval_name));
    spinner.rotate(0);
    spinner_rotation = 0;
}

handle_activity_load_more_button(
    $('#activities-sections-content').find('.activity-section-load-more'));
function handle_activity_load_more_button(button) {
    button.on('click', function() {
        let section_container = button;
        while(!section_container.hasClass('activities-section')) {
            section_container = section_container.parent();
        }
    
        button.find('.spinner').removeClass('opacity0');
        start_spinner(button.find('.spinner'), 'threads-section-load-more');
    
        let activity_user = $('.activities-user').val();
        let present_threads_in_section = section_container.find('.thread-container-box').length;
        let section = button.find('.section').val();
    
        $.ajax({
            url: `/users/${activity_user}/activities/sections/generate?section=${section}&range=10&skip=${present_threads_in_section}`,
            type: 'get',
            success: function(response) {
                if(response.hasNext == false) {
                    button.addClass('none');
                }
    
                $(`${response.content}`).insertBefore(button);
    
                let unhandled_activities_threads = section_container.find('.thread-container-box').slice(response.count*(-1));
                
                unhandled_activities_threads.each(function() {
                    handle_element_suboption_containers($(this));
                    handle_section_suboptions_hinding($(this));
                    handle_thread_display($(this));
                    handle_tooltip($(this).find('.tooltip-section'));
                    $(this).find('.handle-image-center-positioning').each(function() {
                        let image = $(this);
                        $(this).parent().imagesLoaded(function() {
                            handle_image_dimensions(image);
                        });
                    });
                    handle_restore_thread_button($(this));
                    handle_permanent_delete($(this));
                    handle_permanent_destroy_button($(this));
                    handle_hide_parent($(this));
                });
    
                let c = parseInt(section_container.find('.current-section-thread-count').text()) + parseInt(response.count);
                section_container.find('.current-section-thread-count').text(c);
            },
            complete: function() {
                stop_spinner(button.find('.spinner'), 'threads-section-load-more');
                button.find('.spinner').addClass('opacity0');
            }
        });
    })
}

$('.countable-textarea').on('input', function() {
    let textarea = $(this);
    let container = $(this);
    while(!container.hasClass('countable-textarea-container')) {
        container = container.parent();
    }

    let counter_container = container.find('.textarea-counter-box');
    let counter = container.find('.textarea-chars-counter');
    let maxlength = container.find('.max-textarea-characters').val();
    let currentLength = textarea.val().length;

    counter_container.addClass('gray');
    counter.text(currentLength);
    if(currentLength <= maxlength) {
        counter_container.attr('style', '');
    } else {
        counter_container.removeClass('gray');
        counter_container.css('color', '#e83131');
    }
});

function handle_permanent_delete(thread) {
    thread.find('.thread-permanent-delete').on('click', function() {
        let container = $(this);
        while(!container.hasClass('suboptions-container')) {
            container = container.parent();
        }
        container.css('display', 'none');

        let thread_container = $(this);
        while(!thread_container.hasClass('thread-container-box')) {
            thread_container = thread_container.parent();
        }

        thread_container.find('.thread-permanent-deletion-dialog').css('display', 'block');
        thread_container.find('.thread-permanent-deletion-dialog').animate({
            opacity: 1
        }, 200);
    });
}
function handle_permanent_destroy_button(thread) {
    thread.find('.destroy-thread-button').on('click', function(event) {
        let button = $(this);
        let button_text_ing = button.parent().find('.btn-text-ing').val();

        button.text(button_text_ing);
        button.attr("disabled","disabled");
        button.attr('style', 'background-color: #acacac; cursor: default');

        let spinner = $(this).parent().parent().find('.spinner');
        start_spinner(spinner, 'destroy-thread');
        spinner.removeClass('opacity0');

        let data = {
            _token: csrf,
            _method: 'DELETE',
        };

        $.ajax({
            type: 'post',
            url: button.parent().find('.thread-destroy-link').val(),
            data: data,
            success: function() {
                let container = button;
                while(!container.hasClass('thread-container-box')) {
                    container = container.parent();
                }

                let section = container;
                while(!section.hasClass('activities-section')) {
                    section = section.parent();
                }

                container.remove();

                let present_threads_count = section.find('.current-section-thread-count');
                let global_threads_count = section.find('.current-section-global-threads-count');
                let present_t_c = parseInt(present_threads_count.text()) - 1;
                let global_t_c = parseInt(global_threads_count.text()) - 1;
                
                present_threads_count.text(present_t_c);
                global_threads_count.text(global_t_c);
            },
            complete: function() {
                stop_spinner(spinner, 'destroy-thread');
                button.text(button_text_ing);
                button.attr("disabled",false);
                button.attr('style', 'background-color: #d03535; color: white');
            }
        });

        return false;
    });
}
function handle_restore_thread_button(thread) {
    thread.find('.restore-thread-button').on('click', function() {
        let button = $(this);
        let button_text_no_ing = button.find('.btn-text-no-ing').val();
        let button_text_ing = button.find('.btn-text-ing').val();

        button.find('.btn-text').text(button_text_ing);
        button.find('.btn-text').attr("disabled","disabled");
        button.find('.btn-text').attr('style', 'cursor: default');

        let spinner = button.find('.spinner');
        start_spinner(spinner, 'restore-thread-inline-button');
        spinner.removeClass('opacity0');

        $.ajax({
            type: 'post',
            url: button.find('.restore-link').val(),
            data: {
                _token: csrf
            },
            success: function(response) {
                window.location.href = response;
            },
            error: function() {
                button.find('.btn-text').text(button_text_no_ing);
                button.find('.btn-text').attr("disabled",false);
                button.find('.btn-text').attr('style', '');
            },
            complete: function() {
                spinner.addClass('opacity0');
                stop_spinner(spinner, 'restore-thread-inline-button');
            }
        });

        return false;
    });
}

$('.move-to-trash-button').each(function() {
    handle_move_to_trash($(this));
});
function handle_move_to_trash(button) {
    button.click(function() {
        let button_text_no_ing = button.find('.btn-text-no-ing').val();
        let button_text_ing = button.find('.btn-text-ing').val();
        let moved_successfully = button.find('.moved-successfully').val();
        let go_to_archive = button.find('.go-to-archive').val();
    
        let thread = button;
        while(!thread.hasClass('thread-container-box')) {
            thread = thread.parent();
        }

        button.find('.btn-text').text(button_text_ing);
        button.find('.btn-text').attr("disabled","disabled");
        button.find('.btn-text').attr('style', 'cursor: default');
    
        let spinner = button.parent().find('.spinner');
        start_spinner(spinner, 'restore-thread-inline-button');
        spinner.removeClass('opacity0');
    
        $.ajax({
            type: 'post',
            url: button.find('.trash-move-link').val(),
            data: {
                _token: csrf,
                _method: 'DELETE'
            },
            success: function(response) {
                thread.remove();
                basic_notification_show(moved_successfully + "<a class='blue no-underline bold' href='" + response + "'>" + go_to_archive + "</a>", 'basic-notification-round-tick');
            },
            error: function() {
                button.find('.btn-text').text(button_text_no_ing);
                button.find('.btn-text').attr("disabled",false);
                button.find('.btn-text').attr('style', '');
            },
            complete: function() {
                spinner.addClass('opacity0');
                stop_spinner(spinner, 'restore-thread-inline-button');
            }
        });
    });
}

function handle_thread_events(thread) {
    thread.find('.button-with-suboptions').each(function() {
        // Handle all suboptions of thread component
        handle_suboptions_container($(this));
    });
    // Handle votes event
    handle_up_vote(thread.find('.votable-up-vote'));
    handle_down_vote(thread.find('.votable-down-vote'));
    // Handle like
    handle_resource_like(thread.find('.like-resource'));
    // Handle thread delete viewer && turn off posts viewer appearence
    handle_thread_shadowed_viewers(thread);
    // Handle close shadowed viewer
    handle_close_shadowed_view(thread);
    // Handle hide parent
    handle_hide_parent(thread);
    // Handle thread events
    handle_save_threads(thread.find('.save-thread'));
    handle_move_to_trash(thread.find('.move-to-trash-button'));
    handle_turn_off_posts(thread.find('.turn-off-posts'));
    handle_thread_display(thread);
    handle_tooltip(thread);
    handle_thread_visibility_switch(thread);
    handle_follow_resource(thread.find('.follow-resource'));
    handle_expend_button_appearence(thread);
    // Keep in mind that images dimensions also handled withing lazy loading logic
    handle_thread_medias_containers(thread);
    handle_login_lock(thread);
    /**
     * Handle image fade loading when image is not fetched from server yet 
     * Remember fade removing is handled in lazy loading scroll feature when scroll reach the image it will
     * check at the end if the image comes with a fade loader and it will delete it immedietely when the image fully loaded
     */
    handle_fade_loading(thread);
    handle_open_media_viewer(thread);
    // Handle link copy
    handle_copy_thread_link(thread.find('.copy-thread-link'));
}

let index_fetch_more = $('.index-fetch-more');
let index_fetch_more_lock = true;
if(index_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
      // We only have to start loading and fetching data when user reach the explore more faded thread
      if(index_fetch_more.isInViewport()) {
            if(!index_fetch_more_lock) {
                return;
            }
            index_fetch_more_lock=false;
        
            let skip = $('.current-threads-count').val();
            let tab = $('.date-tab').val();
        
            let url = `/index/threads/loadmore?skip=${skip}&tab=${tab}`;
            $.ajax({
                type: 'get',
                url: url,
                success: function(response) {
                    $('#threads-global-container').append(response.content);
                    let new_skip = parseInt(skip) + parseInt(response.count);
                    $('.current-threads-count').val(new_skip);
                    /**
                     * When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
                     * Notice that we have faded thread container righgt after threads collection so we have to exclude it from unhandled threads collection
                     */
                    let unhandled_appended_threads = 
                    $('#threads-global-container .resource-container').slice(response.count*(-1));
                    
                    // When threads are appended we need to force lazy loading for the first appended thread for better ui experience
                    force_lazy_load(unhandled_appended_threads.first());
        
                    unhandled_appended_threads.each(function() {
                        handle_thread_events($(this));
                    });
                    // This will prevent appended suboptions from disappearing when cursor click on suboption containers
                    handle_document_suboptions_hiding();
                    index_fetch_more_lock = true;
                },
                error: function(response) {
        
                },
                complete: function(response) {
                    
                }
            });
      }
    });
}

$('.thread-add-display-toggler').on('click', function() {
    let thread_add_component = $('#thread-add-component');
    if(thread_add_component.hasClass('none')) {
        thread_add_component.removeClass('none');
    } else {
        thread_add_component.addClass('none');
    }
});

let top_informer_timeout;
function display_top_informer_message(message, type="normal") {
    clearTimeout(top_informer_timeout);
    let informer_box = $('.top-informer-box');
    let informer_container = informer_box.find('.top-informer-container');
    informer_box.removeClass('none');
    informer_box.find('.top-informer-text').text(message);


    switch(type) {
        case 'normal':
            break;
        case 'warning':
            informer_container.find('.tiei-icon').addClass('none');
            informer_container.find('.top-informer-icon-box').removeClass('none');
            informer_container.find('.top-informer-error-icon').removeClass('none');
            informer_container.find('.top-informer-error-icon').css('fill', 'black');
            break;
        case 'error':
            informer_container.css('border-color', '#ff9696');
            informer_container.css('box-shadow', '0px 0px 6px 0px #ffd4d4');
            informer_container.css('background-color', 'rgb(255, 237, 237)');
            informer_container.find('.top-informer-text').css('color', 'rgb(104, 28, 28)');
            informer_container.find('.tiei-icon').addClass('none');
            informer_container.find('.top-informer-error-icon').removeClass('none');
            break;
    }
    
    // This timeout will wait for 6 sec before close the message
    top_informer_timeout = setTimeout(function() {
        informer_box.addClass('none');
        informer_box.find('.top-informer-text').text('');
   }, 6000);
}

$('.remove-top-informer-container').on('click', function() {
    clearTimeout(top_informer_timeout);
    $('.top-informer-box').addClass('none');
    $('.top-informer-box').find('.top-informer-text').text('');
});


$('.thread-add-container textarea').each(function() {
    let simplemde = new SimpleMDE({
        hideIcons: ["guide", "heading", "image"],
        spellChecker: false,
        mode: 'markdown',
        showMarkdownLineBreaks: true,
    });
});

let fcc_lock = true;
function handle_fcc(button) {
    button.on('click', function() {
        if(!fcc_lock) {
            return false;
        }
        fcc_lock = false;
        
        let btn = $(this);
        let changer_box = btn;
        while(!changer_box.hasClass('forum-category-changer-box')) {
            changer_box = changer_box.parent();
        }
        let spinner = changer_box.find('.fcc_spinner');
    
        start_spinner(spinner, 'fcc_spinner');
        spinner.removeClass('opacity0');
        btn.attr('style', 'background-color: #e3e3e3');
    
        let forum_id = btn.find('.forum-id').val();
    
        $.ajax({
            url: `/forums/${forum_id}/categories/ids`,
            type: 'get',
            success: function(response) {
                // // First change the icon
                changer_box.find('.fcc-selected-forum-ico').html(btn.find('.forum-ico').html());
                changer_box.find('.fcc-selected-forum').text(btn.find('.forum-name').text());
    
                let categories = JSON.parse(response);
                changer_box.find('.fcc-category:not(:first)').remove();
    
                let first_iteration = true;
                $.each(categories, function(id, category){
                    if(first_iteration) {
                        first_iteration = false;
                        changer_box.find('.fcc-category:first').attr('href', category.forum_link);
                    } else {
                        $('.fcc-categories-container').append(`
                            <a href="${category.link}" class="no-underline black thread-add-suboption fcc-category flex align-center">
                                <span class="thread-add-category-val">${category.category}</span>
                            </a>
                        `);
                    }
                });
            },
            complete: function() {
                button.attr('style', '');
                fcc_lock = true;
                spinner.addClass('opacity0');
                stop_spinner(spinner, 'fcc_spinner');
    
                let forums_container = button;
                while(!forums_container.hasClass('suboptions-container')) {
                    forums_container = forums_container.parent();
                }
    
                forums_container.css('display', 'none');
            }
        })
    
        return false;
    });
}
function handle_search_path_switcher(container) {
    container.find('.search-path-switcher').each(function() {
        $(this).on('click', function() {
            container.find('.search-path-switcher').removeClass('search-path-switcher-selected');
            $(this).addClass('search-path-switcher-selected');
            let path = $(this).find('.search-path').val();
            container.find('.quick-access-search-form').attr('action', path);
        });
    })
}

let quick_access_fetched = false;
$('.quick-access-generate').on('click', function() {
    if(quick_access_fetched) {
        return;
    }
    $.ajax({
        type: 'get',
        url: '/generatequickaccess',
        success: function(response) {
            $('#quick-access-content-box').html('');
            $('#quick-access-content-box').html(response);

            handle_search_path_switcher($('#quick-access-box'));
            handle_fcc($('#quick-access-box').find('.forum-category-changer'));
            $('#quick-access-box .nested-soc-button').each(function() {
                handle_nested_soc($(this));
            });
            quick_access_fetched = true;
        }
    })
});