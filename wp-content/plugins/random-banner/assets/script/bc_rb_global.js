/**
 * Global Function for Random Banner
 */


jQuery(document).ready(function ($) {


  $('body').on('change','.bc_rb_enable_slider',function () {
    console.log('yes');
    var change = $(this);
    if ($('option:selected', this).text() == 'Yes') {
      change.closest('.widget-content').find('.autoplay_options').removeClass('bc_rb_hide');
    } else {
      change.closest('.widget-content').find('.autoplay_options').addClass('bc_rb_hide');
    }
  });
  $('.widget-inside').on('click','input[type=submit]',function(e,data){
    console.log(e);
    console.log(data);
  });

  $('.bc_rb_enable_slider').trigger('change');

  $('body').on('click','.bc_rb_close',function (e) {
    $(this).closest('#popup').addClass('bc_rb_hide');
    e.preventDefault();
  })

});

