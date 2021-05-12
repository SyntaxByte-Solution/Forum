$(".button-with-suboptions").on({
    'mouseenter': function() {
        let container = $(this).parent().find(".suboptions-container");
        console.log(container);
        if(container.css("display") == "none") {
            $(".suboptions-container").css("display", "none");
            container.css("display", "block");
        } else {
            container.css("display", "none");
        }
        return false;
    },
    'mouseleave': function() {
        $(this).parent().find(".suboptions-container").css('display', 'none');
    }
});