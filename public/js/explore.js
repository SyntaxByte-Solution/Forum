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

              $('#threads-global-container').append(response.content);

              $('#explore-page').val(parseInt($('#explore-page').val())+1);
              $('#explore-hours-interval').val(response.hours_interval);
              $('#explore-hours-interval-remains').val(response.remains);
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