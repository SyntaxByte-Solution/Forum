$('.contact-send-message').on('click', function() {
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
        firstname.parent().find('.error').removeClass('none');
        return;
    } else {
        firstname.parent().find('.error').addClass('none');
        data.firstname = firstname.val().trim();
    }

    if(lastname.val().trim() == '') {
        lastname.parent().find('.error').removeClass('none');
        return;
    } else {
        lastname.parent().find('.error').addClass('none');
        data.lastname = lastname.val().trim();
    }

    if(email.val().trim() == '') {
        email.parent().find('.error').text('* ' + email.parent().find('.email-required').val());
        email.parent().find('.error').removeClass('none');
        return;
    } else if(!validateEmail(email.val().trim())) {
        console.log('email is invalide');
        email.parent().find('.error').text('* ' + email.parent().find('.invalide-email').val());
        email.parent().find('.error').removeClass('none');
        return;
    } else {
        email.parent().find('.error').addClass('none');
        data.email = email.val().trim();
    }

    if(company.val().trim() != "") {
        data.company = company.val().trim();
    }

    if(phone.val().trim() != "") {
        data.phone = phone.val().trim();
    }
    
    if(message.val().trim() == '') {
        message.parent().parent().find('.error').removeClass('none');
        return;
    } else {
        message.parent().parent().find('.error').addClass('none');
        data.message = message.val();
    }

    let button = $(this);
    let spinner = button.parent().find('.spinner');
    console.log(spinner);
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
            console.log(response);
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