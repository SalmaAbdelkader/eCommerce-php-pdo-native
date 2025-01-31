$(function () {

	'use strict';

	// Switch Between Login & Signup

	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});

	// Trigger The Selectboxit

	$("select").selectBoxIt({

		autoWidth: false

	});

	// Hide Placeholder On Form Focus

	$('[placeholder]').focus(function () {

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function () {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});

	// Add Asterisk On Required Field

	$('input').each(function () {

		if ($(this).attr('required') === 'required') {

			$(this).after('<span class="asterisk">*</span>');

		}

	});

	// Confirmation Message On Button

	$('.confirm').click(function () {

		return confirm('Are You Sure?');

	});

	$('.live').keyup(function () {

           $($(this).data('class')).text($(this).val());
	});

	// $('.live-desc').keyup(function () {

	// 	$('.live-preview .caption p').text($(this).val());
	// });

	// $('.live-price').keyup(function () {

	// 	$('.live-preview .price-tag').text(' $ ' + $(this).val());
	// });


		// Toggle dropdown menu with fade effect
		$('.dropdown-toggle').click(function() {
			$('.dropdown-menu').fadeToggle();  // Show/hide the menu with fade effect
		});

		// Close dropdown if clicked outside
		$(document).click(function(e) {
			if (!$(e.target).closest('.btn-group').length) {  // Updated selector to .btn-group
				$('.dropdown-menu').fadeOut();  // Hide the dropdown if clicked outside
			}
		});

	
	


});



      






