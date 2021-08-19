$('.sort-by-option').on('click', function() {
    let sort_by_key = $(this).find('.sort-by-key').val();
    window.location.href = updateQueryStringParameter(window.location.href, 'sortby', sort_by_key);
});

let explore_more = $('.explore-more');
let explore_lock = true;

$(window).on('DOMContentLoaded scroll', function() {
  // We only have to start loading and fetching data when user reach the explore more faded thread
  if(explore_more.isInViewport()) {
    console.log('reached !');
    // if(!explore_lock) {
    //   return;
    // }
    // explore_lock=false;

    // let sortby = $('#explore-sort-key').val();
    // let hours_interval = $('#explore-hours-interval').val();
    // let remains = $('#explore-hours-interval-remains').val();

    // let url = `/explore/loadmore?hours_interval=${hours_interval}&sortby=${sortby}&remains=${remains}`;
    // $.ajax({
    //     type: 'get',
    //     url: url,
    //     success: function(response) {
    //       // Increment page
    //       $('#explore-page').val(parseInt($('#explore-page').val())+1);
    //       $('#explore-hours-interval').val(response.hours_interval);
    //       $('#explore-hours-interval-remains').val(response.remains);

    //       $('#threads-global-container').append(response.content);
          
    //       // When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
    //       let unhandled_appended_threads = 
    //         $('.resource-container').slice(response.count*(-1));
            
    //       // When threads are appended we need to force lazy loading for the first appended thread for better ui experience
    //       force_lazy_load(unhandled_appended_threads.first());

    //       unhandled_appended_threads.each(function() {
    //           handle_thread_events($(this));
    //       });
    //       // This will prevent appended suboptions from disappearing when cursor click on suboption containers
    //       handle_document_suboptions_hiding();
    //     },
    //     error: function(response) {

    //     },
    //     complete: function(response) {
    //       explore_lock = true;
    //       stop_spinner(explore_more, 'explore-more-spinner');
    //     }
    // });
  }
});