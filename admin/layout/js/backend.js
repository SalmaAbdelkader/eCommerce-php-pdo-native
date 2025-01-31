$(function () {

   'use strict';

   //Dashboard 

   $('.toggle-info').click(function () {


        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if($(this).hasClass('selected')){

            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else{

            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
   });

   // Trigger Plugins IN Jquery

   $("select").selectBoxIt({

     autoWidth : false
   });

   //Hide Placeholder On Form Focus

   $('[placeholder]').focus(function () {
       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder', '');
   }).blur(function () {
       $(this).attr('placeholder', $(this).attr('data-text'));
   });

   // Add Asterisk To Input Fields

   $('input').each(function () {
       if ($(this).attr('required') === 'required') {
           $(this).after('<span class="asterisk">*</span>');
       }
   });

   // Convert A Password Field To Text Field

   var field_name = $('input[type="password"]');  // Updated selector

   $('.show-pass').hover(function () {
       field_name.attr('type', 'text');
   }, function () {
       field_name.attr('type', 'password');
   });

   // Confirmation Message On Button Delete

   $('.confirm').click(function () {
       return confirm('Are You Sure To Delete This User?');
   });


   // Category View Options 

   $('.cat h3').click(function () {

      $(this).next('.full-view').fadeToggle(500);

   });


   $('.option span').click(function () {

      $(this).addClass('active').siblings('span').removeClass('active');
  
      if ($(this).data('view') === 'full') {
          $('.cat .full-view').fadeIn(200);  
      } else {
          $('.cat .full-view').fadeOut(200);  
      }
  });

});



      






