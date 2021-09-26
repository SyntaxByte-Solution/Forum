handle_mark_as_read();

$('.header-button-counter-indicator').css('opacity', '0');
let element = $('.notification-button');
element.off();

let notifications_fetch_more = $('.notifications-fetch-more');
let notifications_fetch_more_lock = true;
if(notifications_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
        // We only have to start loading and fetching data when user reach the explore more faded thread
        if(notifications_fetch_more.isInViewport()) {
            if(!notifications_fetch_more_lock) {
                return;
            }
            notifications_fetch_more_lock=false;

            let skip = $('.notifications-wrapper .notification-container').length;
            $.ajax({
                url: '/notifications/generate?range='+8+'&skip='+skip,
                type: 'get',
                success: function(notifications_components) {
            
                    if(notifications_components.content != "") {
                        $(`${notifications_components.content}`).insertBefore(notifications_fetch_more);
            
                    // The reason why we test for existence of notifications here because we need the fetch more
                    // container to insert notifs payload if exists before it
                    if(notifications_components.hasNext == false)
                        notifications_fetch_more.remove();

                        /**
                         * Notice here when we fetch the notifications we return the number of fetched notifs
                         * because we need to handle the last count of appended components events
                         * 
                         */
                        let unhandled_event_notification_components = 
                            $('.notifications-wrapper .notifs-box > .notification-container').slice(notifications_components.count*(-1));
                        
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
                    notifications_fetch_more_lock = true;
                }
            });
        }
        
        // let skip = $('.notifications-wrapper .notification-container').length;
    
        // let url = `/index/threads/loadmore?skip=${skip}&tab=${tab}`;
        // $.ajax({
        //     type: 'get',
        //     url: url,
        //     success: function(response) {
        //         $('#threads-global-container').append(response.content);
        //         let new_skip = parseInt(skip) + parseInt(response.count);
        //         $('.current-threads-count').val(new_skip);
        //         /**
        //          * When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
        //          * Notice that we have faded thread container righgt after threads collection so we have to exclude it from unhandled threads collection
        //          */
        //         let unhandled_appended_threads = 
        //         $('#threads-global-container .resource-container').slice(response.count*(-1));
                
        //         // When threads are appended we need to force lazy loading for the first appended thread for better ui experience
        //         force_lazy_load(unhandled_appended_threads.first());
    
        //         unhandled_appended_threads.each(function() {
        //             handle_thread_events($(this));
        //         });
        //         // This will prevent appended suboptions from disappearing when cursor click on suboption containers
        //         handle_document_suboptions_hiding();

        //         if(!response.hasmore) {
        //             index_fetch_more.remove();
        //         }
        //         index_fetch_more_lock = true;
        //     },
        //     error: function(response) {
    
        //     },
        //     complete: function(response) {
                
        //     }
        // });
    });
}

