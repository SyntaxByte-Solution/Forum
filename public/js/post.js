

function handle_post_display_buttons(post) {
    post.find('.hide-post').click(function() {
        while(!post.hasClass('post-container')) {
            post = post.parent();
        }
    
        $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)-1);
    
        post.css('display', 'none');
        post.parent().find('.show-post-container').css('display', 'block');
        $(this).parent().css('display', 'none');
        
        return false;
    })

    post.parent().find('.show-post').click(function() {
        $(this).parent().css('display', 'none');
        $(this).parent().parent().find('.post-container').css('display', 'flex');
        $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);

        return false;
    });
}

function handle_edit_post(post) {
    post.find('.edit-post').click(function() {
        $('.post-content').css('display', 'block');
        $('.post-edit-container').css('display', 'none');
    
        $(this).parent().css('display', 'none');
    
        post.find('.post-content').css('display', 'none');
        post.find('.post-edit-container').css('display', 'block');
    
        let old_value = post.find('.post-content').text();
        
        const $codemirror = post.find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
        $codemirror.getDoc().setValue(old_value);
    
        return false;
    });
}

function handle_save_edit_post(post) {
    post.find('.save-edit-post').click(function() {
        let btn = $(this);
        let error = $(this).parent().find('.error');

        let old_value = post.find('.post-content').text();

        const $codemirror = $(post).find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
        let v = $codemirror.getDoc().getValue();

        // Check for the value before submit it
        if(v == '') {
            error.html('* This field is required.');
        } else if(old_value == v){
            post.find('.post-edit-container').css('display', 'none');
            post.find('.post-content').css('display', 'block');
        } else {
            btn.attr("disabled","disabled");
            btn.text('Saving Changes ..');
            btn.attr('style', 'background-color: #acacac; cursor: default');
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
                    btn.attr('style', '');
                    btn.prop("disabled", false);
                    post.find('.post-content').html('<p>'+v+'</p>');
                    post.find('.post-edit-container').css('display', 'none');
                    post.find('.post-content').css('display', 'block');

                    post.find('.post-updated-date').text('updated 1s ago');
                    post.find('.post-updated-date-human').text('Now');
                },
                error: function(response) {
                    btn.text('Save Changes');
                    btn.attr('style', '');
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
}

function handle_exit_edit_changes(post) {
    post.find('.exit-edit-post').click(function() {
        $(this).parent().css('display', 'none');
        post.find('.post-content').css('display', 'flex');
    
        return false;    
    });
}

function handle_delete_post_button(post) {
    post.find('.delete-post-button').click(function() {
        $(this).parent().css('display', 'none');
        post.find('.post-edit-container').css('display', 'none');
        post.find('.post-content').css('display', 'block');
        post.parent().find('.full-shadowed').css("display", "block");
        post.parent().find('.full-shadowed').css("opacity", "1");
        return false;
    });
}

function handle_tooltips(post) {
    post.find('.tooltip-section').on({
        'mouseenter': function() {
            $(this).parent().find('.tooltip').css('display', 'block');
        },
        'mouseleave': function() {
            $(this).parent().find('.tooltip').css('display', 'none');
        }
    });
}

function handle_delete_post(post) {
    post.parent().find('.delete-post').click(function() {
        $(this).attr("disabled","disabled");
        $(this).val('Deleting ..');

        let container = post.parent();

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
}

function handle_post_events(post) {
    // Hide/show post
    handle_post_display_buttons(post);
    // Editing post
    handle_edit_post(post);
    handle_save_edit_post(post);
    handle_exit_edit_changes(post);
    // Deleting post
    handle_delete_post_button(post);
    handle_delete_post(post);
    // Tooltips
    handle_tooltips(post);
    // Handle close shadowed view for deleting
    handle_close_shadowed_view(post.parent().find('.close-shadowed-view-button'));
}

function handle_post_other_events(post) {
    // Suboption containers
    handle_element_suboption_containers(post);
    // buttons with container inside
    handle_button_container(post);
}

$('.post-container').each(function() {
    handle_post_events($(this));
})

$('.share-post').click(function() {
    let btn = $(this);
    $(this).attr("disabled","disabled");
    $(this).attr('style', 'background-color: #acacac; cursor: default');
    
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
        $(this).attr('style', '');
        location.hash = "#reply-site";
    } else if(post_content.length < 2) {
        $('#global-error').text('Reply should have at least 2 characters');
        $('#global-error').css('display', 'flex');
        $(this).attr('style', '');
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
                let last_post = $('#replies-container .post-container:last');
                
                btn.val('Post your reply');
                btn.prop("disabled", false);
                btn.attr('style', '');
                $codemirror.getDoc().setValue('');

                last_post.find('textarea').each(function() {
                    var sm = new SimpleMDE({
                        element: this,
                    });
                    sm.render();
                })
                // Handling all events of the newly appended component
                handle_post_events(last_post);
                handle_post_other_events(last_post);

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
                btn.attr('style', '');
                location.hash = "#reply-site";
            }
        })
    }
    return false;
});