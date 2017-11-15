$(function () {
	var keyNumber = (event) => {
		var num = event.keyCode;
		
		if (num === 27) {


			$(this).dialog('close');	
			return false;
		}

		if ($(document).find('.numberOnly') || $(document).find('.money')) {
			if (num !== 8) {
				if (num < 48 || num > 57) {
					event.preventDefault();
				}
			}
		}

		return true;
	};	

	$(document).find('.dropable').css('cursor', 'pointer');

	$(document).on('keydown', '.numberOnly' ,keyNumber);
	
	if (document.querySelector('.money')) {
		$(document).find('.money').mask('00000.00', {reverse: true});
	}

	$(document).on('click', '#dropdownList', function () {
		$(document).find('.dropdown-content').toggle("slow");
	});

	$(document).on('click', '#dropdownListResponsive', function () {
		$(document).find('.dropdown-content-responsive').toggle('slow');
	});

	$(document).on('click', 'body', function (event) {
		if (!event.target.matches('.dropbtn')) {
			$(document).find('.dropdown-content').attr('style', 'display');
			$(document).find('.dropdown-content-responsive').attr('style', 'display');
		}	
	});

/**
	$(document).on('click', 'body', function (event) {
		if (!event.target.matches('.dropdown-responsive')) {
			$(document).find('.dropdown-content-responsive').attr('style', 'display');
		}	
	});
	*/
});