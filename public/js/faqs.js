// Prevent scroll when refreshing the page (when question received successfully we refresh the page to displatthe flash message to user)
$(window).on('beforeunload', function() {
  $(window).scrollTop(0);
});

$('.qa-wrapper').on('click', function(event) {
    let toggled_arrow = $(this).find('.faq-toggled-arrow');
    let answer = $(this).find('.faq-answer');
    let display = answer.css('display');
    
    if(display == 'none') {
      $('.faq-toggled-arrow').rotate(0);
      toggled_arrow.rotate(180);
      $('.faq-answer').addClass('none');
      answer.removeClass('none');
    } else {
      toggled_arrow.rotate(0);
      answer.addClass('none');
    }
});

let question_lock = true;
$('.faq-question-send').on('click', function() {
  let data = {
    _token: csrf
  };
  let question = $("#question");
  let desc = $("#desc");

  $('.faq-global-error').addClass('none');

  if(question.val().trim() == '') {
    question.parent().find('.error').removeClass('none');
    question.parent().find('.error').text(question.parent().find('.question-required').val());
    question.css('border-color', '#ec4444');
    return;
  } else {
      question.parent().find('.error').addClass('none');
      data.question = question.val().trim();
  }

  if(question.val().trim().length < 10) {
      question.parent().find('.error').removeClass('none');
      question.parent().find('.error').text(question.parent().find('.question-length-error').val());
      question.css('border-color', '#ec4444');
    return;
  } else {
      question.parent().find('.error').addClass('none');
      data.question = question.val().trim();
  }

  if(desc.val().trim() != '') {
    data.desc = desc.val();
  }

  // disable inputs
  question.attr('disabled', true);
  desc.attr('disabled', true);

  if(!question_lock) {
    return;
  }
  question_lock = false;

  let button = $(this);
  let spinner = button.parent().find('.spinner');
  let button_text_ing = button.parent().find('.btn-text-ing').val();
  let button_text_no_ing = button.parent().find('.btn-text-no-ing').val();

  start_spinner(spinner, 'faqs-share-question-spinner');
  spinner.removeClass('opacity0');

  button.val(button_text_ing);
  button.attr("disabled","disabled");
  button.attr('style', 'background-color: #e9e9e9; color: black; cursor: default; cursor: not-allowed');
  $.ajax({
      url: '/faqs',
      type: 'post',
      data: data,
      success: function(response) {
        location.reload();
      },
      error: function(response) {
        button.val(button_text_no_ing);
        button.attr('disabled', false);
        button.attr('style', '');
        
        question.attr('disabled', false);
        desc.attr('disabled', false);

        let errorObject = JSON.parse(response.responseText);
        let er = errorObject.message;

        $('.faq-global-error').text(er);
        $('.faq-global-error').removeClass('none');
      },
      complete: function() {
        button.val(button_text_no_ing);
        button.attr('style', '');
        spinner.addClass('opacity0');
        stop_spinner(spinner, 'faqs-share-question-spinner');
        question_lock = true;
      }
  });
});

$('#question').on('click change', function() {
    $(this).attr('style', '');
})
