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
