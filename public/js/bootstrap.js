/**
 * The reason why we move preloading here again is because when we preload images in app.js or app-depth.js files,
 * we have to wait everything to be finish loading (because we use DEFER attribute) to load these images which is 
 * not a good idea. so we have to run the preloading in here to load the images in the beginning
 */

// // preload important images that needs to be shown in the beginning
// function preloadImages(srcs) {
//     if (!preloadImages.cache) {
//         preloadImages.cache = [];
//     }
//     var img;
//     for (var i = 0; i < srcs.length; i++) {
//         img = new Image();
//         img.src = srcs[i];
//         preloadImages.cache.push(img);
//     }
// }

// var imageSrcs = ["/assets/images/icons/sp.png"];
// preloadImages(imageSrcs);

// Handling lazy loading images
$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();return elementBottom > viewportTop && elementTop < viewportBottom;
};
$(window).on('DOMContentLoaded load resize scroll', function() {
    $('.has-lazy').each(function() {
        let lazy_container = $(this);
        if(lazy_container.isInViewport()) {
            $(this).find('.lazy-image').each(function() {
                let img = $(this);
                img.attr('src', img.attr('data-src'));
                img.removeAttr('data-src');
                img.parent().imagesLoaded(function() {
                    handle_media_image_dimensions(img);
                    if(img.hasClass('image-with-fade')) {
                        img.parent().find('.fade-loading').remove();
                    }
                    if(img.hasClass('thread-media')) {
                        handle_thread_media_one_item(lazy_container);
                    }
                });
            });
            
            lazy_container.removeClass('has-lazy');
        }
    });
});
function handle_thread_media_one_item(thread_medias_container) {
    if(thread_medias_container.find('.thread-media-container').length == 1) {
        let media_container = thread_medias_container.find('.thread-media-container');
        let media = media_container.find('.thread-media');
        let media_type = media.parent().find('.media-type').val();
        if(media_type == 'image') {
            if(media.height() > media_container.height()) {
                let max_height = parseInt(media_container.css('max-height'), 10);
                let container_height = media_container.height();
    
                while(container_height < max_height && container_height < media.height()) {
                    media_container.height(container_height++);
                }
                media_container.css('align-items', 'flex-start');
            }
        }
    }
}
