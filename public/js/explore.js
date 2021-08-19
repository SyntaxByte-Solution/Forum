$('.sort-by-option').on('click', function() {
    let sort_by_key = $(this).find('.sort-by-key').val();
    window.location.href = updateQueryStringParameter(window.location.href, 'sortby', sort_by_key);
});

let explore_more = $('.explore-more');
let explore_lock = true;
$(window).on('DOMContentLoaded scroll', function() {
    var docElement = $(document)[0].documentElement;
    var winElement = $(window)[0];

    // We only have to start loading and fetching data when user reach the bottom
    if ((docElement.scrollHeight - winElement.innerHeight) == winElement.pageYOffset) {
        if(!explore_lock) {
          return;
        }
        explore_lock=false;

        start_spinner(explore_more, 'explore-more-spinner');

        let sortby = $('#explore-sort-key').val();
        let hours_interval = $('#explore-hours-interval').val();
        let remains = $('#explore-hours-interval-remains').val();

        let url = `/explore/loadmore?hours_interval=${hours_interval}&sortby=${sortby}&remains=${remains}`;
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
              // Increment page
              $('#explore-page').val(parseInt($('#explore-page').val())+1);
              $('#explore-hours-interval').val(response.hours_interval);
              $('#explore-hours-interval-remains').val(response.remains);

              $('#threads-global-container').append(response.content);
              
              // When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
              let unhandled_appended_threads = 
                $('.resource-container').slice(response.count*(-1));
                
                unhandled_appended_threads.each(function() {
                    $(this).find('.button-with-suboptions').each(function() {
                      // Handle all suboptions of thread component
                      handle_suboptions_container($(this));
                    })
                    // Handle votes event
                    handle_up_vote($(this).find('.votable-up-vote'));
                    handle_down_vote($(this).find('.votable-down-vote'));
                    // Handle like
                    handle_resource_like($(this).find('.like-resource'));
                    // Handle thread delete viewer && turn off posts viewer appearence
                    handle_thread_shadowed_viewers($(this));
                    // Handle close shadowed viewer
                    handle_close_shadowed_view($(this));
                    // Handle hide parent
                    handle_hide_parent($(this));
                    // Handle thread events
                    handle_save_threads($(this).find('.save-thread'));
                    handle_move_to_trash($(this).find('.move-to-trash-button'));
                    handle_turn_off_posts($(this).find('.turn-off-posts'));
                    handle_thread_display($(this));
                    handle_tooltip($(this));
                    handle_thread_visibility_switch($(this));
                    handle_follow_resource($(this).find('.follow-resource'));
                    
                    handle_thread_medias_containers($(this));
                    handle_open_media_viewer($(this));

                    // Handle link copy
                    handle_copy_thread_link($(this).find('.copy-thread-link'));
                });
                // This will prevent appended suboptions from disappearing when cursor click on suboption containers
                handle_document_suboptions_hiding();
            },
            error: function(response) {

            },
            complete: function(response) {
              explore_lock = true;
              stop_spinner(explore_more, 'explore-more-spinner');
            }
        });
    }
});