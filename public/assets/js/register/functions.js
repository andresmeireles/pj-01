$(function () {
	$(document).find('#dialog-confirm').dialog({
		autoOpen:false,
		resizable: true,
		height: 'auto',
		width: 'auto',
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
			"Adicionar": function () {
				var entity = $(document).find('#entity').attr('entity');
				var value = $(document).find('#entity').val();
				value = value.replace(',', '.');
				var params = {
					[$(document).find('#entity').attr('name')] : value,
				}
				insertData(entity, params);
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$(document).find('#dialog-form').dialog({
		autoOpen: false,
		height: "auto",
		width: "auto",
		modal: true,
		resizable: true,
		buttons: {
			'Remover': () => {
				var entity = $('#confirm').attr('entity');
				var id = $('body').data('id');
				remove(entity, id);
				var id = $('body').data('id', '');
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
	
	document.querySelector('#show-modal').addEventListener('click', function () {
		$('#dialog-confirm').dialog('open');
	});
	
	$(document).on('click', '.r', function() {
		var id = $(this).parent().parent().parent().attr('id');
		$('body').data('id', id);
		$('#dialog-form').dialog('open');
	});
	
	if ($('.h').length !== 0 ) {
		$('.h').mask('0,00');
	}
});