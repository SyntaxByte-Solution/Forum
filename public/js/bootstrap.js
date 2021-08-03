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
var imageSrcs = [];
if(uid != '') {
    imageSrcs.push(`/users/${uid}/usermedia/avatars/36-l.png`);
}
imageSrcs.push(["/assets/images/icons/sp.png"]);

preloadImages(imageSrcs);

if($('#right-panel').height() > $(window).height()-52) {
    console.log('panel is greather');
    $(document).scroll(function() {
        if (document.documentElement.scrollTop + $(window).height() > 54 + $('#right-panel').height()) { 
            $('#right-panel').css({
                position: 'fixed',
                bottom: '0',
                top: 'unset'
            });
        } else {
            $('#right-panel').css({
                position: 'absolute',
                top: '0',
                bottom: 'unset'
            });
        }
    });
} else {
    console.log('panel is smaller');
    $('#right-panel').css({
        position: 'fixed',
        top: '52',
        bottom: 'unset'
    });
}