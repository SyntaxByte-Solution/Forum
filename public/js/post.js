

let vote_tick_lock = true;

function handle_post_display_buttons(post) {
    post.find('.hide-post').click(function() {
        $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)-1);
    
        post.find('.post-main-component').css('display', 'none');
        post.find('.show-post-container').css('display', 'block');
        $(this).parent().css('display', 'none');
        
        return false;
    });

    post.find('.show-post').click(function() {
        $(this).parent().css('display', 'none');
        $(this).parent().parent().find('.post-main-component').css('display', 'flex');
        $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);

        return false;
    });
}

function handle_edit_post(post) {
    post.find('.edit-post').click(function() {
        $('.post-content').css('display', 'block');
        $('.post-edit-container').css('display', 'none');
    
        $(this).parent().css('display', 'none');
    
        post.find('.post-content').addClass('none');
        post.find('.post-edit-container').removeClass('none');
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

                    post.find('.post-edit-container').addClass('none');
                    post.find('.post-content').removeClass('none');

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
        $(this).parent().addClass('none');
        post.find('.post-content').removeClass('none');
    
        return false;    
    });
}

function handle_delete_post_button(post) {
    post.find('.delete-post-button').click(function() {
        post.find('.post-content').removeClass('none');

        $(this).parent().css('display', 'none');
        post.find('.post-edit-container').css('display', 'none');
        post.find('.post-content').css('display', 'block');
        post.find('.full-shadowed').css("display", "block");
        post.find('.full-shadowed').css("opacity", "1");
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
    post.find('.delete-post').click(function() {
        $(this).attr("disabled","disabled");
        $(this).val('Deleting ..');

        let pid = $(this).parent().find('.post-id').val();

        $.ajax({
            url: '/post/'+pid,
            type: 'delete',
            data: {
                '_token':csrf,
            },
            success: function(response) {
                post.remove();
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
    // Handle post best reply
    handle_post_reply_tick_button(post);
}

function handle_post_other_events(post) {
    // Suboption containers
    handle_element_suboption_containers(post);
    // buttons with container inside
    handle_button_container(post);
    // Handle vote buttons
    post.find('.votable-up-vote').click(function(event) {
        handle_up_vote(post.find('.votable-up-vote'));
        event.preventDefault();
    })

    post.find('.votable-down-vote').click(function(event) {
        handle_down_vote(post.find('.votable-down-vote'));
        event.preventDefault();
    })
    // Handle informer message container close button
    handle_remove_informer_message_container(post);
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
                $('.replies_header_after_thread').removeClass('none');
                $('#global-error').css('display', 'none');
                let pst;
                if ($("#ticked-post")[0]){
                    console.log('here !');
                    $("#replies-container .resource-container:first-child").after(response);
                    pst = $('#replies-container .resource-container:eq(1)');
                } else {
                    $('#replies-container').prepend(response);
                    pst = $('#replies-container .resource-container').first();
                }
                console.log(pst);
                btn.val('Post your reply');
                btn.prop("disabled", false);
                btn.attr('style', '');
                $codemirror.getDoc().setValue('');

                pst.find('textarea').each(function() {
                    var sm = new SimpleMDE({
                        element: this,
                    });
                    sm.render();
                })
                // Handling all events of the newly appended component
                handle_post_events(pst);
                handle_post_other_events(pst);

                $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);

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

function handle_post_reply_tick_button(post) {
    if(post.find('.best-reply-container')) {
        let best_reply_container = post.find('.tick-post-container');
        best_reply_container.find('.hover-informer-display-element').on({
            mouseenter: function() {
                if(post.attr('id') == "ticked-post") {
                    $(this).parent().find('.informer-message').text('Remove best reply');
                } else {
                    $(this).parent().find('.informer-message').text('Mark this reply as the best reply');
                }
                $(this).parent().find('.informer-message-container').css('display', 'block');
            },
            mouseleave: function() {
                $(this).parent().find('.informer-message-container').css('display', 'none');
            },
            click: function(event) {
                if(vote_tick_lock == false) {
                    return false;
                }
                vote_tick_lock = false;

                if(post.find('.grey-tick').hasClass('none')) {
                    post.find('.grey-tick').removeClass('none');
                    post.find('.green-tick').addClass('none');
                } else {
                    post.find('.grey-tick').addClass('none');
                    post.find('.green-tick').removeClass('none');
                }

                let post_id = $(this).parent().find('.post-id').val();
                $.ajax({
                    url: '/post/' + post_id + '/tick',
                    type: 'post',
                    data: {
                        _token: csrf
                    },
                    success: function(response) {
                        if(response == 1) {
                            post.find('.post-main-component').attr('style', 'border-color: #1c8e19b3;');
                            post.find('.post-main-section').attr('style', 'background-color: #e1ffe44a;');
                            post.find('.best-reply-ticket').removeClass('none');
                            post.attr('id', 'ticked-post');
                            console.log('best reply below: ');
                            console.log(post.find('.best-reply-ticket'));
                        } else {
                            post.find('.post-main-component').attr('style', '');
                            post.find('.post-main-section').attr('style', '');
                            post.find('.best-reply-ticket').addClass('none');
                            post.attr('id', '');
                        }
                    },
                    error: function(response) {
                        if(post.find('.grey-tick').hasClass('none')) {
                            post.find('.grey-tick').removeClass('none');
                            post.find('.green-tick').addClass('none');
                            post.find('.best-reply-ticket').addClass('none');
                        } else {
                            post.find('.grey-tick').addClass('none');
                            post.find('.green-tick').removeClass('none');
                        }

                        let error = JSON.parse(response.responseText).message;
                        best_reply_container.find('.informer-message').parent().parent().css('display', 'block');
                        best_reply_container.parent().find('.informer-message').text(error);

                        setTimeout(function() {
                            console.log('close');
                            best_reply_container.find('.informer-message').parent().parent().css('display', 'none');
                        }, 2000);
                    },
                    complete: function() {
                        vote_tick_lock = true;
                    }
                })
                event.preventDefault();
            }
        });
    }
}