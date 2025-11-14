const numToChar = (n) => String.fromCharCode(97 + n);
const duration = 1776;

// Ini akan mengembalikan ke atas kalau laman disegarkan ulang
history.scrollRestoration = "manual";

// Kode jQuery
$(document).ready(function () {

	for (let i = 0; i < 7; i = i + 1) {
		$(`#anima-${i+1}`).css('opacity', '0');
	}

	$(window).scroll(function () {

		if ($(this).scrollTop() > 400) {
			$('#anima-1').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 635) {
			$('#anima-2').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 1110) {
			$('#anima-3').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 1730) {
			$('#anima-4').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 2590) {
			$('#anima-5').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 2690) {
			$('#anima-6').animate({ opacity: 1 }, duration);
		}
		if ($(this).scrollTop() > 3110) {
			$('#anima-7').animate({ opacity: 1 }, duration);
		}

	});
});