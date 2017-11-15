$(function () {

	var closedModal = $(document).find('#dialog-confirm');
	closedModal.dialog({
		autoOpen: false,
		resizable: true,
		height: "auto",
		width: 400,
		modal: true,
		show: {
			effect: 'fold',
			duration: 350,
		},
		hide: {
			effect: 'fold',
			duration: 350,
		},
		buttons: {
			"Adicionar": function() {
				var entity = $('#dialog-form input').attr('entity');
				var value = $('.insert').val();
				sendItem(entity, value);
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$(document).find('#dialog').dialog({
		autoOpen: false,
		resizable: true,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			'OK' : function() {
				$(this).dialog('close')
				$(document).find('#dialog').find('p').remove();
			}
		},
	});

	var dialog_remove = $("#dialog-form").dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		height: 'auto',
		width: '30%',
		buttons: {
			'OK': function () {
				var entity = dialog_remove.data('entity');
				var id = dialog_remove.data('id');
				deleteItem(entity, id);
			},
			Cancel: function () {
				$( this ).dialog('close')
			}
		},
		
	});

	var modalShow = () => {
		closedModal.dialog('open');
	};

	var keyNumber = (event) => {
		var num = event.keyCode;

		if (num === 27) {
			$(this).dialog('close');	
			return false;
		}

		if (document.querySelector('.numberOnly')) {
			if (num !== 8) {
				if (num < 48 || num > 57) {
					event.preventDefault();
				}
			}
		}

		return true;
	};	

	document.querySelector('#show-modal').addEventListener('click', modalShow);

	document.querySelector('.insert').addEventListener('keydown', keyNumber);
	
	$(document).on('click', '.edit' ,function () {
		var id = $(this).closest('tr').attr('id');
		var entity = $('#dialog-form input').attr('entity');
		dialog_remove.data('entity', entity);
		dialog_remove.data('id', id).dialog('open');		
	});

	$(document).find('.edit').css('cursor', 'pointer');

	if (document.querySelector('.numberOnly')) {
		$('.numberOnly').mask('0.00');
	}

});