handle_mark_as_read();

$('.header-button-counter-indicator').css('opacity', '0');
let element = $('.notification-button');
element.off();
if($('.notification-container').length > 8) {
  $(window).scroll(function() {
      if($(window).scrollTop() + $(window).height() == $(document).height()) {
          if(button = $('.notifications-load-scroll')) {
              loadNotifications(button);
          }
      }
  });
}