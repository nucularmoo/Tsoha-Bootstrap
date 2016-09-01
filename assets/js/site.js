$(document).ready(function() {

	$('form.destroy-form').on('submit', function(submit) {

		var confirm_message = $(this).attr('data-confirm');

		if (!confirm(confirm_nessage)) {

			submit.preventDefault();

		}

	});
});
