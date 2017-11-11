var getEditInfo = (entity, id) => {
	axios({
		method: 'get',
		url: '/getSingleRegistry/'+entity+'/'+id,
	}).then(function (json) {
		var add  = '<tr id="'+id+'" class="create-form">';
		add += '<td><div class="form-group">';
		add += '<center>'+ json.data.model+'</center>';
		add += '</div></td>';
		add += '<td><div class="form-group">';
		add += '<center>'+json.data.height+'</center>';
		add += '</div></td>';
		add += '<td width="30%">';
		add += '<center><input type="text" id="newPrice" name="price" class="form-control tamanho editable" value="'+ json.data.price +'" required></center>';
		add += '</td>';  
		add += '</tr>';
		
		var el = $(document).find('.edit-prod');
		el.append(add);
	});
};        

var setNewPrice = (entity, id, params) => {
	axios({
		method: 'post',
		url: '/update/',
		data: {
			entity: entity,
			id: id,
			params: params,
		}
	}).then(function (json) {
		if (json.data) {
			if (json.data.error) {
				$(document).find('#dialog p').remove();
				$(document).find('#dialog').append('<p>'+ json.data.error +'</p>');
				$(document).find('#dialog').dialog('open');
				return false;		
			}
			document.location.reload();		
			return true;
		}
	});
};

var sendProduction = (model, qnt, date) => {
	axios({
		method: 'POST',
		url: '/sendProduction',
		data: {
			models: model,
			amount: qnt,
			date: date
		},
	})
	.then((json) => {
		if (json.data.success) {
			
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
			
			$('#dialog').append('<p>Producto inserido com sucesso<p>');
			$('#dialog').dialog('open');
			
			setTimeout(function () {
				window.location.href = '/producao';	
			}, 500);
		}
	});
};

var getHeightRegister = (entity) => {
	
	axios({
		method: 'POST',
		url: '/getReg',
		data: {
			entity: entity,
		},
	})
	.then((json) => {
		if ($('#height option').length > 1) {
			return false;
		}
		
		for (var c = 0; c < json.data.length; c++) {
			$('#height').append('<option value="'+ json.data[c].id +'">'+ json.data[c].value +'</option>')
		}
	});
};

var insertData = (entity, params) => {
	
	axios({
		method: 'POST',
		url: '/insert',
		data: {
			entity: entity,
			data: params,
		},
	})
	.then((json) => {
		if (json.data) {
			if (json.data.error) {
				$(document).find('#dialog p').remove();
				$(document).find('#dialog').append('<p>'+ json.data.error +'</p>');
				$(document).find('#dialog').dialog('open');
				return false;		
			}
			//document.location.reload();		
			return true;
		}
		
		$(document).find('#dialog p').remove();
		$(document).find('#dialog').append('<p>Produto já existe na base de dados</p>');
		$(document).find('#dialog').dialog('open');
		return false;
		
	})
	
};

var ProdSend = (pri, hei, mod) => {
	axios({
		method: 'POST',
		url: '/addP',
		data: {
			price: pri,
			height: hei,
			model: mod, 
		}
	}).then(function (json) {
		if (json.data.res === false) {	
			$(document).find('#dialog').append('<p>Produto já existe na base de dados</p>');
			$(document).find('#dialog').dialog('open');
			return false;	
		}
		
		var add = '<tr>';
		add += '<td><center>'+ json.data.id +'</center></td>';
		add += '<td><center>'+ json.data.desc +'</center></td>';
		add += '<td><center>'+ json.data.height +'</center></td>';
		add += '<td><center>'+ json.data.price +'</center></td>';
		add += '<td><center><span class="badge badge-pill badge-info edit" style="cursor: pointer">Editr</span> <div class="badge badge-pill badge-danger rmv" style="cursor: pointer">Remove</div></center></td>';
		add += '</tr>';
		var el = $(document).find('.prod');
		el.append(add);
		
		$(document).find('#dialog-confirm').dialog( "close" );
	})
};

var remove = (entity, id) => {
	axios({
		method: 'POST',
		url: '/remove',
		data: {
			id: id,
			entity: entity,
		}
	}).then(function (json) {		
		/**
		if (json.data.failmsg) {
			event.preventDefault();
			$('#dialog').append('<p> Você não pode remover esse item, pois está atrelado a um produto</p>');
			$('#dialog-form').dialog('close');
			$(document).find('#dialog').dialog('open');
			setTimeout(function () {
				$('#dialog').dialog('close');
				$(document).find('#dialog p').remove();	
			}, 3000);
			return false;		
		}
		*/
		
		$(document).find('#'+id).remove();
		$('#dialog').append('<p>Item removido com sucesso<p>');
		$('#dialog-form').dialog('close');
		$(document).find('#dialog').dialog('open');
		setTimeout(function () {
			$('#dialog').dialog('close');
			$(document).find('#dialog p').remove();	
		}, 500);		
	});
};