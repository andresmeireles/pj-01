$(function () {
	var replicate = () => {
		var el   = $(document).find('#el').last('tr');
		var add  = '<tr>';
		add += '<td width="25%">';
		add += '<select class="form-control model">';
		add += '<option selected disabled>Selecione uma opção</option>';
		add += '</select>';
		add += '</td>';
		add += '<td width="20%" class="qnt">';
		add += '</td>';
		add += '<td width="15%">';
		add += '<span id="addNewLine" style="cursor: pointer" class="badge badge-info">+</span><span style="word-spacing: 10px"> </span><span id="removeLine" style="cursor: pointer;"  class="badge badge-danger">x</span>';
		add += '</td>';
		add += '</tr>';

		el.append(add);

		axios.post('/getProductJson')
		.then(function (json) {
			var el = $(document).find('#el select').last('option');
			
			for (var c = 0; c < json.data.length; c++) {
				el.append('<option value="'+ json.data[c].id +'">'+ json.data[c].prod +'</option>');	
			};
		});
	};

	var log = function (message) {
		$('body').append('<div id="dialog" title="Aviso"></div>');

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

		$('#dialog').append('<p>'+ message +'<p>');
		$('#dialog').dialog('open');

		setTimeout(function () {
			setTimeout(function () {
				$(document).find('#dialog p').remove()
			}, 700);
			$(document).find('#dialog').remove();	
		}, 700);
	};

	var noRemove = function (event) {

		$('body').append('<div id="dialog" title="Aviso">Você não pode remover remover todos items!</div>');

		log();

		$(document).find('#dialog').dialog('open');

		setTimeout(function () {
			setTimeout(function () {
				$(document).find('#dialog p').remove()
			}, 800);
			$(document).find('#dialog').remove();	
		}, 800);
	}
	
	$('#datePicker').datepicker({
		dateFormat: 'dd/mm/yy',
		showOtherMonths: true,
		selectOtherMonths: true
	});
	$('#datePicker').datepicker('option', 'showAnim', 'slideDown');

	$(this).on('change', '.model', function () {
		if ($( this ).parent().parent().find('.qnt').find('.numberOnly').length == 0) {
			var el = $( this ).parent().parent().find('.qnt');
			var add = '<input type="number" class="form-control numberOnly" value="0">';
			
			el.append(add);	
		}

		$(this).parent().parent().find('.numberOnly').val(0);
	});

	$(document).on('focus', '.numberOnly', function () {
		$(this).val('');
	})

	$(document).on('change', '.qnt', function () {
		if ($(this).children().val() === '' || $(this).children().val() === "0") {
			$(this).children().val('0');
		}

		var total = parseInt($('#total').html());
		var nSum = 0;
		$(document).find('.numberOnly').each(function () {
			var sum = parseInt($(this).val());
			nSum = sum + nSum;
		});
		$('#total').html(nSum);
	});

	$(document).on('keydown', '#datePicker' ,function (event) {
		event.preventDefault();
		return false;
	});

	$(document).on('click', '#addNewLine', function () {
		replicate();
	});

	$(document).on('click', '#removeLine', function (event) {
		if ($(document).find('#el tr').length  === 1) {
			noRemove(event);
			event.preventDefault();
			return false;
		};

		var line = $(this).closest('tr');
		line.animate({
			opacity: 0.423,
		}, 1000, function () {
			line.remove();
		});
	});

	$(document).on('click','#enviarProd', function () {
		var qnt = new Array();
		var model = new Array();

		if ($('#datePicker').val() == "") {
			log('O campo data não pode ficar vazio');
			event.preventDefault();
			return false;
		}

		var date = $('#datePicker').val();

		$('.model').each(function () {
			var m = $(this).val();
			model.push(m);
		});

		$('.qnt').each(function () {
			if ($(this).find('.numberOnly').length === 0) {
				log('Cadatro de um ou mais itens incompleto.');
				event.preventDefault();
				return false;
			}
		});

		$('.numberOnly').each(function () {
			if ($(this).val() == 0) {
				log('Não pode-se enviar produtos com quantidade 0 (zero)');
				event.preventDefault();
				return false;
			};

			qnt.push($(this).val());
		});

		sendProduction(model, qnt, date);
	});
});