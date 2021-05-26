let csrf = document.querySelector('meta[name="csrf-token"]').content;

$(".button-with-suboptions").on({
    'click': function() {
        let container = $(this).parent().find(".suboptions-container");
        if(container.css("display") == "none") {
            $(".suboptions-container").css("display", "none");
            container.css("display", "block");
        } else {
            container.css("display", "none");
        }
        return false;
    }
});

document.addEventListener("click", function(event) {
    $(".suboptions-container").css("display", "none");
}, false);

let subContainers = document.querySelectorAll('.suboptions-container');
for(let i = 0;i<subContainers.length;i++) {
    subContainers[i].addEventListener("click", function(evt) {
        $(this).css("display", "block");
        evt.stopPropagation();
    }, false);
}

$('.close-shadowed-view').click(function() {
    $(this).parent().css('display', 'none');

    return false;
});

$('#login-signin-button').click(function() {
    $('#login-view').parent().css('display', 'block');
    $('#login-view').parent().css('opacity', '1');

    return false;
});

$('#left-panel').height($(window).height() - $('header').height() - 30);

window.onresize = function(event) {
    $('#left-panel').height($(window).height() - $('header').height() - 30);
};

$('.share-post').click(function() {
    let form = $(this).parent();
    let data = {
        '_token':csrf,
        'thread_id': form.find('.thread_id').val()
    };

    if(form.find('.reply-content').val() == "") {
        form.find('.reply-content-error').css('display', 'flex');
    } else {
        form.find('.reply-content-error').css('display', 'none');
        data.content = form.find('.reply-content').val();

        $.ajax({
            type: 'post',
            data: data,
            url: '/post',
            success: function(response) {
                console.log(response);
            }
        })
    }
    return false;
});