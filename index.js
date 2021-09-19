$(function () {
	$('form').submit(false);
	$('#submit').click(function (e) {
		e.preventDefault();
		// console.log('click submit');
		$('.error,.results,.success').hide();
		var url = $('#url').val();

		if (url) {
			// console.log(url);

			$.ajax({
				type: 'POST',
				url: 'index.php?ajax=1',
				data: `url=${url}`,
				error: function (data) {
					console.log(data);
				},
				success: function (data) {
					// console.log(data);
					$('.results').show().html(data);
					// $('.success').show().text('The link was created successfully');
				},
			});
		} else {
			$('.error').show().text('url address is empty');
		}
	});
});
