let profile_threads_fetch_more = $('.profile-fetch-more');
let profile_threads_fetch_more_lock = true;
if(profile_threads_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
      // We only have to start loading and fetching data when user reach the bottom
      if(profile_threads_fetch_more.isInViewport()) {
        if(!profile_threads_fetch_more_lock) {
            return;
        }
        profile_threads_fetch_more_lock=false;
    
        let skip = $('.current-threads-count').val();
        let user_id = $('.profile_owner_id').val();

        let url = `/users/{user}/threads/loadmore?skip=${skip}&user=${user_id}`;
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                $('#threads-global-container').append(response.content);
              if(!response.hasmore) {
                profile_threads_fetch_more.remove();
              }

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

                profile_threads_fetch_more_lock = true;
            },
            error: function(response) {
              
            },
            complete: function(response) {
                
            }
        });
      }
    });
}