	$(
		function() {
            // email modal

            var easter_egg = new Konami(function() { alert('Konami code!')});
            $('#send-email').click(function(e) {
				e.preventDefault();
				$('#more-info-modal span.error-text').hide();

				if ($('#mi-email').val().trim() == "" || !/@/.test($('#mi-email').val()))
				{
					$('#more-info-modal span.error-text').css('display', 'block');
					return;
				}

				$('#send-email').button('loading');

				$.ajax({
					url: 'send.php',
					type: 'post',
					data: {email: $('#mi-email').val(), 'case': $('#mi-case').val(), 'comment':$('#mi-comment').val()},
					success: function(result) {
						console.log(result);
						$('#more-info-modal').modal('hide');
						$('#thanks-modal').modal('show');
						$('#mi-email').val('');
						$('#mi-comment').val('');
						$('#send-email').button('reset');
					},
					error: function(xhr) {
						var error = JSON.parse(xhr.responseText);

						var errorString = typeof(error.error) != "undefined" ? error.error : "Sorry, there was an error. Please try again later.";

						alert(errorString);
						$('#send-email').button('reset');
					}
				});
			});
		});			
				