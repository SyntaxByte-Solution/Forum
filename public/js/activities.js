
let urlprms = new URLSearchParams(window.location.search);

if(urlprms.has('section')) {
  console.log('has section');
    $('.activity-section-name').each(function() {
        if($(this).val() == urlprms.get('section')) {
            $(this).parent().trigger('click');
        }
    })
}