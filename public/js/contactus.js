$(window).on('unload', function() {
    $(window).scrollTop(0);
 });

$('.contact-send-message').on('click', function() {
    let error_box = $('.error-box');
    let errors_box = $('#validation-messages');

    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let email = $('#contact-email');
    let company = $('#company');
    let phone = $('#phone');
    let message = $('#message');

    let data = {
        _token: csrf,
    };

    if(firstname.val().trim() == '') {
        firstname.parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.firstname-required').val());
        return;
    } else {
        firstname.parent().find('.err').addClass('none');
        data.firstname = firstname.val().trim();
    }

    if(lastname.val().trim() == '') {
        lastname.parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.lastname-required').val());
        return;
    } else {
        lastname.parent().find('.err').addClass('none');
        data.lastname = lastname.val().trim();
    }

    if(email.val().trim() == '') {
        email.parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.email-required').val());
        return;
    } else if(!validateEmail(email.val().trim())) {
        email.parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.email-invalide').val());
        return;
    } else {
        email.parent().find('.err').addClass('none');
        data.email = email.val().trim();
    }

    if(company.val().trim() != "") {
        data.company = company.val().trim();
    }

    if(phone.val().trim() != "") {
        data.phone = phone.val().trim();
    }
    
    if(message.val().trim() == '') {
        message.parent().parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.message-required').val());
        return;
    }else if(message.val().trim().length < 10) {
        message.parent().parent().find('.err').removeClass('none');
        error_box.removeClass('none');
        error_box.find('.error').text(errors_box.find('.message-length-error').val());
        return;
    } else {
        message.parent().parent().find('.err').addClass('none');
        data.message = message.val();
    }

    error_box.addClass('none');

    let button = $(this);
    let spinner = button.parent().find('.spinner');
    let btn_text_ing = button.parent().find('.btn-text-ing').val();
    let btn_text = button.parent().find('.btn-no-text-ing').val();
    button.val(btn_text_ing);
    button.attr("disabled","disabled");
    button.attr('style', 'background-color: #acacac; cursor: default');
    start_spinner(spinner, 'contact-spinner');
    spinner.removeClass('opacity0');

    $.ajax({
        url: '/contact',
        type: 'post',
        data: data,
        success: function() {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            stop_spinner(spinner, '');
            button.attr('style', 'contact-spinner');
            button.attr('disabled', false);
            button.val(btn_text);
        },
        complete: function() {
            
        }
    })
});