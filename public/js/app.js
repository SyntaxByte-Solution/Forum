let urlParams = new URLSearchParams(window.location.search);
let csrf = document.querySelector('meta[name="csrf-token"]').content;

// the following section is for displaying viewers based on the value of query strings
// -------------------------------

if(urlParams.has('action')) {
    if(urlParams.get('action') == 'thread-delete') {
        $('.thread-deletion-viewer').css('display', 'block');
        $('.thread-deletion-viewer').css('opacity', '1');
    }
}


// -------------------------------



$(".button-with-suboptions").on({
    'click': function() {
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
    shadowed_container.css('display', 'none');
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

$('.share-post').click(function() {
    let btn = $(this);
    $(this).attr("disabled","disabled");
    
    const $codemirror = $('#post-reply').nextAll('.CodeMirror')[0].CodeMirror;
    let post_content = $codemirror.getDoc().getValue();

    let form = $(this).parent();
    let data = {
        '_token':csrf,
        'thread_id': form.find('.thread_id').val()
    };

    if(post_content == "") {
        $('#global-error').text('Reply field is required');
        $('#global-error').css('display', 'flex');
        $(this).prop("disabled", false);
        location.hash = "#reply-site";
    } else if(post_content.length < 2) {
        $('#global-error').text('Reply should have at least 2 characters');
        $('#global-error').css('display', 'flex');
        $(this).prop("disabled", false);
        location.hash = "#reply-site";
    }
    else {
        $(this).val('Posting your reply ..');
        form.find('#global-error').css('display', 'none');
        data.content = post_content;
        $.ajax({
            type: 'post',
            data: data,
            url: '/post',
            success: function(response) {
                $('#global-error').css('display', 'none');
                $('#replies-container').append(response);
                btn.val('Post your reply');
                btn.prop("disabled", false);
                $codemirror.getDoc().setValue('');

                $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);

            },
            error: function(response) {
                // Here we get the errors of the response as an object
                let errors = JSON.parse(response.responseText).errors;

                // The errors object hold errors keys as well as error values in form of array of errors
                // because a field could have multiple validation constraints and then it could have multiple errors
                // strings. In this case we only need the first error of the first validation
                let error = errors[Object.keys(errors)[0]][0];
                $('#global-error').text(error);
                $('#global-error').css('display', 'block');
                btn.val('Post your reply');
                btn.prop("disabled", false);
                location.hash = "#reply-site";
            }
        })
    }
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

$('.hide-post').click(function() {
    let post = $(this);
    while(!post.hasClass('post-container')) {
        post = post.parent();
    }

    $('.thread-replies-number').text(parseInt($('.thread-replies-number').text(), 10)-1);

    post.css('display', 'none');
    post.parent().find('.show-post-container').css('display', 'block');
    $(this).parent().css('display', 'none');
    
    return false;
});

$('.show-post').click(function() {
    $(this).parent().css('display', 'none');
    $(this).parent().parent().find('.post-container').css('display', 'flex');
    $('.thread-replies-number').text(parseInt($('.thread-replies-number').text(), 10)+1);

    return false;
});

$('.edit-post').click(function() {
    $('.post-content').css('display', 'block');
    $('.post-edit-container').css('display', 'none');

    $(this).parent().css('display', 'none');
    let post = $(this);
    while(!post.hasClass('post-container')) {
        post = post.parent();
    }

    post.find('.post-content').css('display', 'none');
    post.find('.post-edit-container').css('display', 'block');

    let old_value = post.find('.post-content').text();

    const $codemirror = $(post).find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
    $codemirror.getDoc().setValue(old_value);

    return false;
});

$('.delete-post-button').click(function() {
    $(this).parent().css('display', 'none');
    let post = $(this);
    while(!post.hasClass('post-container')) {
        post = post.parent();
    }

    post.parent().find('.full-shadowed').css("display", "block");
    post.parent().find('.full-shadowed').css("opacity", "1");
    return false;
});

$('.delete-post').click(function() {
    $(this).attr("disabled","disabled");
    $(this).val('Deleting ..');

    let container = $(this);
    while(!container.hasClass('full-shadowed')) {
        container = container.parent();
    }
    container = container.parent();

    let pid = $(this).parent().find('.post-id').val();

    $.ajax({
        url: '/post/'+pid,
        type: 'delete',
        data: {
            '_token':csrf,
        },
        success: function(response) {
            container.remove();
            $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)-1);
        },
        error: function(response) {
            $(this).attr("disabled","");
        }
    });

    return false;
});

$('.save-edit-post').click(function() {
    let btn = $(this);

    let error = $(this).parent().find('.error');

    let post = $(this);
    while(!post.hasClass('post-container')) {
        post = post.parent();
    }

    let old_value = post.find('.post-content').text();

    const $codemirror = $(post).find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
    let v = $codemirror.getDoc().getValue();

    console.log(v);
    // Check for the value before submit it
    if(v == '') {
        error.html('* This field is required.');
    } else if(old_value == v){
        post.find('.post-edit-container').css('display', 'none');
        post.find('.post-content').css('display', 'block');
    } else {
        btn.attr("disabled","disabled");
        btn.text('Saving Changes ..');
        error.text('');

        let post_id = $(this).parent().find('.post_id').val();
        $.ajax({
            url: '/post/'+post_id,
            type:"patch",
            data: {
                '_token': csrf,
                'content': v
            },
            success: function(response) {
                btn.text('Save Changes');
                btn.prop("disabled", false);
                post.find('.post-content').html('<p>'+v+'</p>');
                post.find('.post-edit-container').css('display', 'none');
                post.find('.post-content').css('display', 'block');

                post.find('.post-updated-date').text('updated 1s ago');
                post.find('.post-updated-date-human').text('Now');
            },
            error: function(response) {
                btn.text('Save Changes');
                btn.prop("disabled", false);

                // Here we get the errors of the response as an object
                let errors = JSON.parse(response.responseText).errors;

                // The errors object hold errors keys as well as error values in form of array of errors
                // because a field could have multiple validation constraints and then it could have multiple errors
                // strings. In this case we only need the first error of the first validation
                let er = errors[Object.keys(errors)[0]][0];
                error.text('*' + er);
            }
        });
    }

    return false;
});

$('.exit-edit-post').click(function() {
    $(this).parent().css('display', 'none');
    let post = $(this);
    while(!post.hasClass('post-container')) {
        post = post.parent();
    }

    post.find('.post-content').css('display', 'flex');

    return false;
});

$('.hide-parent').click(function() {
    $(this).parent().css('display', 'none');

    return false;
});

function handle_post_events(post) {
    
}