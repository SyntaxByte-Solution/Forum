if($('.textarea-chars-counter').length && $('#about').length)
  $('.textarea-chars-counter').text($('#about').val().length);

if($("#datepicker").length) {
  $(function() {
      $("#datepicker").datepicker({
          changeMonth: true,
          changeYear: true,
          maxDate: "+1m +1w",
          yearRange: '1950:2021',
          dateFormat: "yy-mm-dd"
      });
  });
}

if($("#country_selector").length) {
  $("#country_selector").countrySelect({
    preferredCountries: ['ma', 'dz', 'tn', 'eg'],
    defaultCountry: "ma"
  });
}


if($('#user-personal-country').length && $('#user-personal-country').length) {
  let country = $('#user-personal-country').val();
    if(country != '') {
        $("#country_selector").countrySelect("setCountry", country);
    }
}

$('.check-username').on('click', function() {
  let button = $(this);
  let ing = button.parent().find('.btn-text-ing').val();
  let no_ing = button.parent().find('.btn-text-no-ing').val();
  let username = $('#username').val();
  
  button.val(ing);
  button.attr("disabled","disabled");
  button.attr('style', 'background-color: #acacac; cursor: default');

  $.ajax({
      url: '/users/username/check',
      type: 'post',
      data: {
          'username': username,
          '_token': csrf
      },
      success: function(response) {
          button.val(no_ing);
          button.attr('style', '');
          button.prop("disabled", false);
          button.parent().find('.red-box').addClass('none');
          button.parent().find('.green-box').removeClass('none');
          button.parent().find('.green-box').css('display', 'flex');

          if(response.valid) {
              button.parent().find('.green').text(response.message);
          } else {
              button.parent().find('.green-box').addClass('none');
              button.parent().find('.red-box').removeClass('none');
              button.parent().find('.red-box').css('display', 'flex');

              button.parent().find('.error').text(response.message);
          }
      },
      error: function(response) {
          button.val(no_ing);
          button.attr('style', '');
          button.prop("disabled", false);

          button.parent().find('.green-box').addClass('none');;
          button.parent().find('.red-box').removeClass('none');;
          button.parent().find('.red-box').css('display', 'flex');

          let errorObject = JSON.parse(response.responseText).errors;
          let er = errorObject[Object.keys(errorObject)][0]; //returns the first error from laravel validator bag

          button.parent().find('.error').text(er);
      }
  })

  return false;
});

$('#settings-avatar-area').on({
  mouseenter: function() {
      $(this).find('.update-avatar-section-button').removeClass('none');
  },
  mouseleave: function() {
      $(this).find('.update-avatar-section-button').addClass('none');
  }
})

$('.remove-profile-avatar').click(function() {
  $('.remove-avatar-dialog').css("display", 'block');
  $('.remove-avatar-dialog').css("opacity", '1');
})

$('.remove-avatar-button').on('click', function() {
  $('.original-avatar,.uploaded-avatar').addClass("none");
  $('.default-avatar').removeClass("none");
  $('.remove-profile-avatar').addClass("none");
  
  $('.remove-avatar-dialog').css('display', 'none');
  $('.suboptions-container').css('display', 'none');

  $('.original-avatar').attr('src', '');
  $('.avatar-upload-button').val('');
  $('.avatar-removed').val('1');
});

$('.avatar-upload-button').change(function(event) {
  let avatar = [event.target.files[0]];
  if(validate_image_file_Type(avatar).length == 1) {
      $('.avatar-removed').val('0');
      $('.avatar-error,.default-avatar,.original-avatar').addClass('none');
      $('.uploaded-avatar').removeClass('none');

      $('.uploaded-avatar').attr('src', URL.createObjectURL(event.target.files[0]));
      $('.uploaded-avatar').removeClass('none');
      $('.uploaded-avatar').parent().imagesLoaded(function() {
          handle_image_dimensions($('.uploaded-avatar'));
      });

      $('.remove-profile-avatar').addClass('none');
      $('.undo-avatar-upload').removeClass('none');
  } else {
      $('.avatar-error').removeClass('none');
  }
});

$('.undo-avatar-upload').on('click', function() {
  $('.avatar-error').addClass('none');
  $('.uploaded-avatar').addClass('none');
  
  let original_avatar = $('.original-avatar');
  if(original_avatar.attr('src') == '') {
      original_avatar.addClass('none');
      $('.default-avatar').removeClass('none');
      $('.remove-profile-avatar').addClass('none');
  } else {
      original_avatar.removeClass('none');
      $('.default-avatar').addClass('none');
      $('.remove-profile-avatar').removeClass('none');
  }

  $('.avatar-upload-button').val('');
  $(this).addClass('none');
});

$('.remove-profile-cover').click(function() {
  $('.remove-cover-dialog').css('display', 'flex');
  $('.remove-cover-dialog').animate({
      'opacity': 1
  });

  return false;
});

$('.remove-cover-button').click(function() {
  let upload_text = $('.change-cover-cont').find('.upload-btn-text').val();
  $('.cover-upload-button-text').text(upload_text);

  $('.remove-cover-dialog').addClass('none');
  $('.us-cover').attr('src', '');
  $('.us-cover').addClass('none');
  $('.remove-profile-cover').addClass('none');
  
  $('.suboptions-container').css('display', 'none');

  $('.change-cover-back-container').removeClass('none');

  $('.cover-upload-button').value = '';
  $('.cover-removed').val('1');
  return false;
});

$('.discard-cover-upload').on('click', function() {
  let upload_text = $('.change-cover-cont').find('.upload-btn-text').val();
  let update_text = $('.change-cover-cont').find('.update-btn-text').val();
  $('.uploaded-us-cover').attr('src', '');
  $('.uploaded-us-cover').addClass('none');
  if($('.original-cover').attr('src') == '') {
      $('.original-cover').addClass('none');
      $('.change-cover-back-container').removeClass('none');
      $('.cover-upload-button-text').text(upload_text);
  } else {
      $('.original-cover').removeClass('none');
      $('.remove-profile-cover').removeClass('none');
      $('.cover-upload-button-text').text(update_text);
  }

  $('.cover-upload-button').val('');
  $(this).addClass('none');
});

$('.cover-upload-button').on('change', function(event) {
  let update_text = $('.change-cover-cont').find('.update-btn-text').val();
  // validate_image function accept an array
  let uploaded_cover = [event.target.files[0]];
  if(validate_image_file_Type(uploaded_cover).length == 1) {
      $('.cover-error').addClass('none');
  } else {
      $('.cover-error').removeClass('none');
      return;
  }

  // for now validating image size is done in the backend side
  $('.cover-upload-button-text').text(update_text);
  $('.us-cover').addClass('none');
  $('.uploaded-us-cover').attr('src', URL.createObjectURL(event.target.files[0]));
  $('.uploaded-us-cover').removeClass('none');

  $('.discard-cover-upload').removeClass('none');
  $('.change-cover-back-container').addClass('none');
  $('.remove-profile-cover').addClass('none');
});

$('.delete-account').click(function() {
  $('#deactivate-account-container').addClass('none');
  $('#delete-account-container').removeClass('none');
  return false;
});

$('.deactivate-account').click(function() {
  $('#deactivate-account-container').removeClass('none');
  $('#delete-account-container').addClass('none');

  return false;
});
