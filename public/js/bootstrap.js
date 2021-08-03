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