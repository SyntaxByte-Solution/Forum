
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

$('#login-signin-button').click(function() {
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
    let sector = window.location.href.split("/").pop();
    if(category_slug == 'all') {
        if(window.location.href.indexOf('discussions') >= 0) {
            console.log('discussions');
            url = '/'+forum_slug+'/discussions';
        } else if(window.location.href.indexOf('questions') >= 0) {
            console.log('questions');
            url = '/'+forum_slug+'/questions';
        } else {
            console.log('all');
            url = '/'+forum_slug+'/all';
        }
    } else {
        url = '/'+forum_slug+'/'+category_slug+'/'+sector;
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

$('.action-verification').click(function() {
    let action_type = $('.verification-action-type').val();

    if(action_type == 'thread.destroy') {
        $('.thread-deletion-viewer').css('display', 'block');
        $('.thread-deletion-viewer').css('opacity', '1');
    }
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

$('.button-with-container').on({
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
})
$('.button-container').on({
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
    let container = $(this).parent().find('.toggle-container');
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

$('.all-table-threads-changer').click(function() {
    if($(this).hasClass('mstsb-selected')) {
        return false;
    }

    $('.ms-table-small-button').removeClass('mstsb-selected');
    $(this).addClass('mstsb-selected');

    let table = $(this);
    while(!table.is('table')) {
        table = table.parent();
    }

    table.find('tr').each(function() {
        $(this).css('display', '');
    });
    return false;
});

$('.all-table-discussions-changer').click(function() {
    if($(this).hasClass('mstsb-selected')) {
        return false;
    }

    $('.ms-table-small-button').removeClass('mstsb-selected');
    $(this).addClass('mstsb-selected');

    let table = $(this);
    while(!table.is('table')) {
        table = table.parent();
    }

    let first = true;
    table.find('tr').each(function() {
        if(first) {
            first = false;
        }
        else {
            if($(this).find('.thread-type').val() == 1) {
                $(this).css('display', '');
            } else {
                $(this).css('display', 'none');
            }
        }
    });
    return false;
});

$('.all-table-questions-changer').click(function() {
    if($(this).hasClass('mstsb-selected')) {
        return false;
    }

    $('.ms-table-small-button').removeClass('mstsb-selected');
    $(this).addClass('mstsb-selected');

    let table = $(this);
    while(!table.is('table')) {
        table = table.parent();
    }

    let first = true;
    table.find('tr').each(function() {
        if(first) {
            first = false;
        }
        else {
            if($(this).find('.thread-type').val() == 2) {
                $(this).css('display', '');
            } else {
                $(this).css('display', 'none');
            }
        }
    });
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
        $('.remove-profile-avatar').css('display', 'flex');
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