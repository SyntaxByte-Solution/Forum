function preloadImages(srcs) {
    if (!preloadImages.cache) {
        preloadImages.cache = [];
    }
    var img;
    for (var i = 0; i < srcs.length; i++) {
        img = new Image();
        img.src = srcs[i];
        preloadImages.cache.push(img);
    }
}

// then to call it, you would use this
var imageSrcs = ["/assets/images/icons/basic-sprite.png", "/assets/images/icons/sp.png", '/assets/images/logos/large-logo.png'];

preloadImages(imageSrcs);