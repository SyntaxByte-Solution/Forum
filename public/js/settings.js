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
