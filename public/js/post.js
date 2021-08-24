function handle_post_display_buttons(post) {
    post.find('.hide-post').click(function() {
        if($(this).hasClass('hide-post-from-viewer')) {
            $('.viewer-thread-replies-number').text(parseInt($('.viewer-thread-replies-number').first().text(), 10)-1);
            
            post.find('.viewer-post-main-component').css('display', 'none');
            post.find('.show-post-container').css('display', 'block');
            $(this).parent().css('display', 'none');
        } else if($(this).hasClass('hide-post-from-outside-viewer')) {
            $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)-1);
            
            post.find('.post-main-component').css('display', 'none');
            post.find('.show-post-container').css('display', 'block');
            $(this).parent().css('display', 'none');
        }
        
        return false;
    });

    post.find('.show-post').click(function() {
        if($(this).hasClass('show-post-from-viewer')) {
            post.find('.viewer-post-main-component').css('display', 'block');
            $('.viewer-thread-replies-number').text(parseInt($('.viewer-thread-replies-number').first().text(), 10)+1);
            $(this).parent().css('display', 'none');
        } else if($(this).hasClass('show-post-from-outside-viewer')) {
            $(this).parent().parent().find('.post-main-component').css('display', 'flex');
            $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);
            $(this).parent().css('display', 'none');
        }

        return false;
    });
}

let edit_post_lock = true;
let old_post_edit_value;
function handle_edit_post(post) {
    let post_id = post.find('.post-id').first().val();
    let post_edit_loading_anim = post.find('.edit-post .loading-dots-anim');
    post.find('.edit-post').click(function() {
        let edit_button = $(this);
        post_edit_loading_anim.removeClass('none');
        start_loading_anim(post_edit_loading_anim);
        $.ajax({
            type: 'get',
            url: `/post/${post_id}/content/fetch`,
            success: function(post_content) {
                old_post_edit_value = post_content;
                /**
                 * Here before displaying the editor to edit the reply we need first to get the original value of the reply
                 * which is in form of markdown and then show the editor by appending that value to it
                 */
                if(edit_button.hasClass('edit-post-from-viewer')) {
                    $('.thread-viewer-reply-content').css('display', 'block');
                    $('.post-edit-container').css('display', 'none');
                
                    edit_button.parent().css('display', 'none');
                
                    post.find('.thread-viewer-reply-content').addClass('none');
                    post.find('.post-edit-container').removeClass('none');
                    post.find('.post-edit-container').css('display', 'block');

                    const $codemirror = post.find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
                    $codemirror.getDoc().setValue(post_content);
                } else if(edit_button.hasClass('edit-post-from-outside-viewer')) {
                    $('.post-content').css('display', 'block');
                    $('.post-content').removeClass('none');
                    $('.post-edit-container').css('display', 'none');
                
                    edit_button.parent().css('display', 'none');
                
                    post.find('.post-content').addClass('none');
                    post.find('.post-edit-container').removeClass('none');
                    post.find('.post-edit-container').css('display', 'block');
                    
                    const $codemirror = post.find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
                    $codemirror.getDoc().setValue(post_content);
                }
            },
            complete: function() {
                post_edit_loading_anim.addClass('none');
                stop_loading_anim();
            }
        })
    
        return false;
    });
}

function handle_save_edit_post(post) {
    post.find('.save-edit-post').click(function() {
        let exit_button = $(this).parent().find('.exit-edit-post');
        let btn = $(this);

        let btn_ing = btn.find('.btn-text-ing').val();
        let btn_no_ing = btn.find('.btn-text-no-ing').val();
        let error = post.find('.post-edit-container .error');

        const $codemirror = $(post).find('.reply-content').nextAll('.CodeMirror')[0].CodeMirror;
        let v = $codemirror.getValue();

        // Check for the value before submit it
        if(v == '') {
            error.html('* This field is required.');
        } else if(old_post_edit_value == v){
            post.find('.post-edit-container').css('display', 'none');
            post.find('.post-content').removeClass('none');
        } else {
            // Disable buttons
            btn.attr("disabled","disabled");
            btn.find('btn-text').text(btn_ing);
            btn.attr('style', 'background-color: #dfdfdf; cursor: not-allowed');

            exit_button.attr("disabled","disabled");
            exit_button.attr('style', 'cursor: not-allowed');

            let post_id = post.find('.post-id').first().val();
            
            error.text('');
            $codemirror.options.readOnly = 'nocursor';
            $.ajax({
                url: '/post/'+post_id,
                type:"patch",
                data: {
                    '_token': csrf,
                    'content': v
                },
                success: function(response) {
                    $.ajax({
                        type: 'get',
                        url: `/post/${post_id}/content/parsed/fetch`,
                        success: function(post_content) {
                            basic_notification_show(btn.find('.message-when-save').val(), 'basic-notification-round-tick');
                            btn.find('btn-text').text(btn_no_ing);
                            btn.attr('style', '');
                            btn.prop("disabled", false);
                            post.find('.post-content').html(post_content);
        
                            post.find('.post-edit-container').addClass('none');
                            post.find('.post-content').removeClass('none');
        
                            post.find('.post-updated-date').removeClass('none');
                            $codemirror.options.readOnly = false;

                            if(btn.hasClass('save-edit-post-from-outside-viewer')) {
                                if(last_opened_thread) {
                                    let reply;
                                    $('.viewer-thread-reply').each(function() {
                                        if($(this).find('.post-id').first().val() == post_id) {
                                            reply = $(this);
                                            return false;
                                        }
                                    });
    
                                    // Take the whole post content html (result of markdown parse) and past it to viewer reply content
                                    reply.find('.thread-viewer-reply-content').html(post.find('.post-content').html());
                                }
                            } else if(btn.hasClass('save-edit-post-from-viewer')) {
                                let reply;
                                if($('.page').length && $('.page').val() == "thread-show") {
                                    $('#replies-container .post-container').each(function() {
                                        if($(this).find('.post-id').first().val() == post_id) {
                                            reply = $(this);
                                            return false;
                                        }
                                    });
                                }

                                reply.find('.post-content').html(post.find('.thread-viewer-reply-content').html());
                            }
                        },
                        complete: function() {
                            btn.text(btn_no_ing);
                            btn.attr('style', '');
                            btn.prop("disabled", false);

                            exit_button.attr("disabled",false);
                            exit_button.attr('style', '');
                        }
                    })
                },
                error: function(response) {
                    // Here we get the errors of the response as an object
                    let errors = JSON.parse(response.responseText).errors;

                    // The errors object hold errors keys as well as error values in form of array of errors
                    // because a field could have multiple validation constraints and then it could have multiple errors
                    // strings. In this case we only need the first error of the first validation
                    let er = errors[Object.keys(errors)[0]][0];
                    error.text('*' + er);
                },
            });
        }

        return false;
    });
}

function handle_exit_edit_changes(post) {
    post.find('.exit-edit-post').click(function() {
        let post_edit_container = $(this);
        while(!post_edit_container.hasClass('post-edit-container')) {
            post_edit_container = post_edit_container.parent();
        }

        post_edit_container.addClass('none');
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

let delete_lock = true;
function handle_delete_post(post) {
    post.find('.delete-post').click(function() {
        if(!delete_lock) {
            return;
        }
        delete_lock = false;

        let close_button = $(this).parent().find('.close-shadowed-view-button');
        let button = $(this);
        let btn_text_no_ing = button.find('.button-ing-no-text').val();
        let btn_text_ing = button.find('.button-ing-text').val();

        button.find('.btn-text').text(btn_text_ing);
        button.attr("disabled","disabled");
        button.attr('style', 'background-color: #e9e9e9; color: black; cursor: not-allowed');

        close_button.attr("disabled","disabled");
        close_button.attr('style', 'background: unset; border: unset; cursor: not-allowed');

        let pid = post.find('.post-id').first().val();

        $.ajax({
            url: '/post/'+pid,
            type: 'delete',
            data: {
                '_token':csrf,
            },
            success: function(response) {
                basic_notification_show(button.parent().find('.message-when-delete').val(), 'basic-notification-round-tick');
                post.remove();

                let new_replies_counter;
                if(button.hasClass('delete-from-outside-viewer')) {
                    new_replies_counter = parseInt($('.thread-replies-number').first().text(), 10)-1;
                    $('.thread-replies-counter').text(new_replies_counter);
                    // Remove the reply from thread viewer if it's already opened
                    if(last_opened_thread) {
                        // Update counter in viewer
                        $('.viewer-thread-replies-number').text(new_replies_counter);
                        let reply;
                        $('.viewer-thread-reply').each(function() {
                            if($(this).find('.post-id').first().val() == pid) {
                                reply = $(this);
                                return false;
                            }
                        });

                        reply.remove();
                    }
                } else if(button.hasClass('delete-from-viewer')) {
                    new_replies_counter = parseInt($('.viewer-thread-replies-number').first().text(), 10)-1;
                    $('.viewer-thread-replies-number').text(new_replies_counter);
                    let reply;
                    if($('.page').length && $('.page').val() == "thread-show") {
                        // Update counter in thread show page
                        $('.thread-replies-counter').text(new_replies_counter);
                        
                        $('#replies-container .post-container').each(function() {
                            if($(this).find('.post-id').first().val() == pid) {
                                reply = $(this);
                                return false;
                            }
                        });
                    }

                    reply.remove();
                }
            },
            error: function(response) {
                close_button.attr("disabled", false);
                close_button.attr('style', '');

                button.find('btn-text').text(btn_text_no_ing);
                button.attr("disabled","");
                button.attr("style","");
            },
            complete: function() {
                delete_lock = true;
            }
        });

        return false;
    });
}

function handle_post_events(post) {
    // Hide/show post
    handle_post_display_buttons(post);
    // Editing post
    post.find('textarea').each(function() {
        var simplemde = new SimpleMDE({
            element: this,
            placeholder: "{{ __('Edit Your reply') }}",
            hideIcons: ["guide", "heading", "link", "image"],
            spellChecker: false,
            status: false,
        });
    })
    // Handle post edit editor
    handle_edit_post(post);
    handle_save_edit_post(post);
    handle_exit_edit_changes(post);
    // Deleting post
    handle_delete_post_button(post);
    handle_delete_post(post);
    // Tooltips
    handle_tooltips(post);
    // Handle close shadowed view for deleting
    handle_close_shadowed_view(post);
    // Handle post best reply
    handle_post_reply_tick_button(post);
    // posts like buttons are already handled from app-depth script
}

function handle_post_other_events(post) {
    // Suboption containers
    handle_element_suboption_containers(post);
    // buttons with container inside
    handle_user_profile_card_displayer(post);
    // Handle vote buttons
    handle_up_vote(post.find('.votable-up-vote'));
    handle_down_vote(post.find('.votable-down-vote'));

    
    // Handle informer message container close button
    handle_remove_informer_message_container(post);
}

$('.post-container').each(function() {
    handle_post_events($(this));
});

$('.share-post').on('click', function() {
    let btn = $(this);
    let btn_text_no_ing = btn.find('.btn-text-no-ing').val();
    let btn_text_ing = btn.find('.btn-text-ing').val();
    
    const $codemirror = $('#post-reply').nextAll('.CodeMirror')[0].CodeMirror;
    let post_content = $codemirror.getDoc().getValue();

    let form = $(this).parent();
    let data = {
        '_token':csrf,
        'thread_id': form.find('.thread_id').val(),
    };

    if(post_content == "") {
        $('#global-error').text('Reply field is required');
        $('#global-error').css('display', 'flex');
        location.hash = "#reply-site";
    } else if(post_content.length < 2) {
        $('#global-error').text('Reply should have at least 2 characters');
        $('#global-error').css('display', 'flex');
        location.hash = "#reply-site";
    }
    else {
        form.find('#global-error').css('display', 'none');
        
        btn.find('.btn-text').text(btn_text_ing);
        $(this).attr("disabled","disabled");
        $(this).attr('style', 'background-color: #acacac; cursor: default');
        
        data.content = post_content;
        $.ajax({
            type: 'post',
            data: data,
            url: '/post?from=thread-show',
            success: function(response) {
                $('.replies_header_after_thread').removeClass('none');
                $('#global-error').css('display', 'none');
                let pst;
                if ($("#ticked-post")[0]){
                    $("#replies-container .resource-container:first-child").after(response);
                    pst = $('#replies-container .resource-container:eq(1)');
                } else {
                    $('#replies-container').prepend(response);
                    pst = $('#replies-container .resource-container').first();
                }
                $codemirror.getDoc().setValue('');
                btn.find('.btn-text').text(btn_text_no_ing);
                btn.prop("disabled", false);
                btn.attr('style', '');

                // Handling all events of the newly appended reply
                handle_post_events(pst);
                handle_post_other_events(pst);
                handle_resource_like(pst.find('.like-resource'));

                $('.thread-replies-number').text(parseInt($('.thread-replies-number').first().text(), 10)+1);
                if(last_opened_thread) {
                    let post_id = pst.find('.post-id').first().val();
                    $.ajax({
                        url: `/post/${post_id}/viewer/generate`,
                        type: 'get',
                        success: function(post) {
                            $('.viewer-thread-replies-number-container').removeClass('none');
                            if ($(".viewer-ticked-reply").length){
                                $(".viewer-replies-container .viewer-thread-reply:first-child").after(post);
                                pst = $('.viewer-replies-container .viewer-thread-reply:eq(1)');
                            } else {
                                $('.viewer-replies-container').prepend(post);
                                pst = $('.viewer-replies-container .viewer-thread-reply').first();
                            }
                            // Handling all events of the newly appended component
                            handle_post_events(pst);
                            handle_post_other_events(pst);
                            handle_resource_like(pst.find('.like-resource'));
                            let new_replies_counter = parseInt($('.viewer-thread-replies-number').first().text(), 10)+1;
                            $('.viewer-thread-replies-number').text(new_replies_counter);
                        }
                    });
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
                $('#global-error').text(error);
                $('#global-error').css('display', 'block');
                btn.val(btn_text_no_ing);
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
        let remove_best_reply = best_reply_container.find('.remove-best-reply').val();
        let mark_best_reply = best_reply_container.find('.mark-best-reply').val();

        best_reply_container.find('.post-tick-button').on({
            click: function(event) {
                let button = $(this);
                $('.post-tick-button').addClass('none');
                button.removeClass('none');

                let grey_tick = button.find('.grey-tick');
                let green_tick = button.find('.green-tick');

                if(grey_tick.hasClass('none')) {
                    $('.post-tick-button').removeClass('none');
                    $('.post-tick-button .grey-tick').removeClass('none');
                    
                    grey_tick.removeClass('none');
                    green_tick.addClass('none');

                    $(this).attr('title', mark_best_reply);
                    post.find('.post-main-component').attr('style', '');
                    post.find('.post-main-section').attr('style', '');
                    post.find('.best-reply-ticket').addClass('none');
                    post.attr('id', '');

                    $('.thread-component-tick').addClass('none');
                } else {
                    grey_tick.addClass('none');
                    green_tick.removeClass('none');

                    $(this).attr('title', remove_best_reply);
                    post.find('.post-main-component').attr('style', 'border-color: #28882678;');
                    post.find('.post-main-section').attr('style', 'background-color: #e1ffe438;');
                    post.find('.best-reply-ticket').removeClass('none');
                    post.attr('id', 'ticked-post');

                    $('.thread-component-tick').removeClass('none');
                }

                let post_id = $(this).parent().find('.post-id').val();
                $.ajax({
                    url: '/post/' + post_id + '/tick',
                    type: 'post',
                    data: {
                        _token: csrf
                    },
                    success: function(response) {
                        
                    },
                    error: function(response) {
                        if(grey_tick.hasClass('none')) {
                            grey_tick.removeClass('none');
                            green_tick.addClass('none');
                            
                            post.find('.post-main-component').attr('style', '');
                            post.find('.post-main-section').attr('style', '');
                            post.find('.best-reply-ticket').addClass('none');
                        } else {
                            post.find('.grey-tick').addClass('none');
                            post.find('.green-tick').removeClass('none');
                        }

                        let error = JSON.parse(response.responseText).message;
                        best_reply_container.find('.informer-message').parent().parent().css('display', 'block');
                        best_reply_container.parent().find('.informer-message').text(error);

                        setTimeout(function() {
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