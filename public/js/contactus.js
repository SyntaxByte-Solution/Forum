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
        data.firstname = firstname.val();
    }

    if(lastname.val().trim() == '') {
        lastname.parent().find('.error').removeClass('none');
        return;
    } else {
        lastname.parent().find('.error').addClass('none');
        data.lastname = lastname.val();
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
        data.email = email.val();
    }

    if(company.val().trim() != "") {
        data.company = company.val();
    }

    if(phone.val().trim() != "") {
        data.phone = phone.val();
    }
    
    if(message.val().trim() == '') {
        message.parent().parent().find('.error').removeClass('none');
        return;
    } else {
        message.parent().parent().find('.error').addClass('none');
        data.message = message.val();
    }
});