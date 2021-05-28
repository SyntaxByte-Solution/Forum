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

$('.reply-to-thread').click(function() {
    location.hash = "#reply-site";
    // $(simplemde).focus();
    setTimeout(function(){$('textarea').focus();}, 50);
    return false;
});

$('.share-post').click(function() {
    let form = $(this).parent();
    let data = {
        '_token':csrf,
        'thread_id': form.find('.thread_id').val()
    };

    if(simplemde.value() == "") {
        form.find('.reply-content-error').css('display', 'flex');
    } else {
        form.find('.reply-content-error').css('display', 'none');
        data.content = simplemde.value();
        $.ajax({
            type: 'post',
            data: data,
            url: '/post',
            success: function(response) {
                $('#replies-container').append(response);
                simplemde.value('');
            }
        })
    }
    return false;
});

$('.share-thread').click(function() {
    let data = {
        '_token':csrf,
        'subject': $('#subject').val(),
        'category_id': $('#category').val(),
        'content':simplemde.value(),
        'thread_type': $('#thread_type').val()
    };

    if(data.subject == '') {
        $('#subject').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $('#subject').parent().find('.frt-error').css('display', 'none');
    }

    if(data.category_id == '' || data.category_id == 0) {
        $('#category').parent().find('.frt-error').css('display', 'flex');
        console.log('here categ!');
        return;
    } else {
        $('#category').parent().find('.frt-error').css('display', 'none');
    }

    if(data.content == '') {
        $('#content').parent().find('.frt-error').css('display', 'flex');
        return;
    } else {
        $.ajax({
            type: 'post',
            data: data,
            url: '/thread',
            success: function(response) {
                document.location.href = response;
            }
        })
    }
    
    return false;
});