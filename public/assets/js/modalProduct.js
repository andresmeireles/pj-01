$(function () {

	var closedModal = $(document).find('#dialog-confirm');
	closedModal.dialog({
		autoOpen: false,
		resizable: true,
		height: "auto",
		width: "auto",
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
				var price = document.querySelector('.tamanho').value;
				var tam = document.querySelector('.tam').value;
				var mod = document.querySelector('.mod').value;				
				
				if (price == '' || tam == '' || mod == '') {
					$('#dialog').append('<p>Produto já cadastrado</p>')
					$(document).find('#dialog').dialog('open');
					event.preventDefault();
					return false;
				}

				ProdSend(price, tam, mod);
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
		width: '66,82%',
		modal: true,
		buttons: {
			'OK' : function() {
				$('#dialog p').remove();
				$(this).dialog('close');
			}
		},
	});

	var modalShow = () => {
		closedModal.dialog('open');
	};

	var keyNumber = () => {
		var num = event.keyCode;

		if (num === 27) {
			$(this).dialog('close');	
			return false;
		}

		if (document.querySelector('.tamanho')) {
			if (num !== 8) {
				if (num < 48 || num > 57) {
					event.preventDefault();
				}
			}
		}

		return true;
	};	

	var getHeight = () => {
		height();
	};

	var dialog_remove = $(document).find("#dialog-message").dialog({
		autoOpen: false,
		modal: false,
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

	var dialog_form =  $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: "auto",
		width: "auto",
		modal: true,
		resizable: true,
		buttons: {
			'Alterar': () => {
				var price = document.querySelector('.editable').value;

				if (document.querySelector('.editable')) {
					if (price.length < 4) {
						$('#dialog').append('<p>Preço tem de de conter no minimo quatro digitos</p>')
						$(document).find('#dialog').dialog('open');
						event.preventDefault();
						return false;
					}
				}

				var id = $(document).find('.edit-prod').find('tr').attr('id');
				setNewPrice(id, price);
			},
			Cancel: function() {
				var el = $(document).find('.edit-prod tr').remove();
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			var el = $(document).find('.edit-prod tr').remove();
			$( this ).dialog( "close" );
		}	
	}); 

	document.querySelector('#show-modal').addEventListener('click', modalShow);

	$(document).on('change', '.mod', getHeight);

	$(document).find('.edit').css('cursor', 'pointer');

	$(document).on('click', '.edit' ,function () {
		var id = $(this).closest('tr').attr('id');
		getEditInfo(id);
		dialog_form.dialog('open');
	});

	$(document).on('click', 'div .rmv' ,function () {
		var id = $(this).closest('tr').attr('id');
		var entity = $('#dialog-message input').attr('entity');
		dialog_remove.data('entity', entity);
		dialog_remove.data('id', id).dialog('open');		
	});

	if (document.querySelector('.tamanho')) {
		$(document).find('.tamanho').mask('00.000,00', {reverse: true});
	}
});