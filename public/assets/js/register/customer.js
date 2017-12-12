$(function () {
	$('#tabs').tabs();
	$('#tabs-update').tabs();
	
	$(document).find('#dialog-confirm').dialog({
		autoOpen:false,
		resizable: false,
		height: 'auto',
		width: '86%',
		position: { 
			my: "bottom", 
			at: "center" 
		},
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
				var params = getInfo('dialog-confirm');
				
				insertData(entity, params);
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}, 
		close: function () {
			var state = document.querySelectorAll('#state option');
			var cityReset = document.querySelectorAll('#city option');
			
			for (var c = 1; c < state.length; c++) {
				state[c].removeAttribute('selected');
			}
			for (var c = 1; c < cityReset.length; c++) {
				cityReset[c].remove();
			}
			document.querySelector('form').reset();
		}	
	});

	$(document).find('#dialog-update').dialog({
		autoOpen: false,
		resizable: true,
		height: 'auto',
		width: '66,82%',
		modal: true,
		buttons: {
			"Atualizar": function () {
				var entity = $(document).find('#entity').attr('entity');
				var params = getInfo('dialog-update');
				var id = this.querySelector('#idRegister').value;
				
				update(entity, params, id);
			},
			"Remover": function () {
				var entity = $(document).find('#entity').attr('entity');
				var id = this.querySelector('#idRegister').value;
				if (removeSelectedItem()){
					alert('apagou!');
				}
				//remove(entity, id);
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
	});
	
	$(document).find('#dialog-remove').dialog({
		autoOpen: false,
		resizable: true,
		height: 'auto',
		width: '66,82%',
		modal: true,
		buttons: {
			'OK' : function() {
				console.log(this);
				var entity = $(document).find('#entity').attr('entity');
				var id = this.querySelector('input').value;
				
				//from ajax.js
				remove(entity, id);

				$('#dialog-remove p').remove();
				$(this).dialog('close');
				return true;
			}, 
			'Fechar': function () {
				$('#dialog-remove p').remove();
				$(this).dialog('close');
				return false;
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
	
	
	document.querySelector('#state').addEventListener('change', getCity);
	document.querySelector('#dialog-update #state').addEventListener('change', getCity);
	
	document.querySelector('#completeWithCep').addEventListener('click', completeMap);

	// AXIOS UPDATE
	var update = (entity, params, id) => {
		axios({
			method: 'POST',
			url:'/registros/clientes',
			data: {
				entity: entity,
				params: params,
				id: id,
			},
		}).then(function (info) {
			console.log(info);
		})
	};

	// UPDATE
	var infos = document.querySelectorAll('.info');
	
	for (var c = 0; c < infos.length; c++) {
		infos[c].addEventListener('click', function () {
			var element = this.parentElement.parentElement.parentElement;
			var td = element.querySelectorAll('td')[0];
			var entityId = td.getAttribute('entityId');
			var entity = document.querySelector('#entity').getAttribute('entity');
			
			axios.options('/registros/clientes/'+ entityId +'/'+ entity)
			.then( function (json) {
				var data = json.data; 

				var dialog = document.querySelector('#dialog-remove input');
				dialog.value = data.id;

				var customerUpdate = document.querySelector('#dialog-update');
				if (typeof data.id != 'number') {
					alert(data);
				}

				customerUpdate.querySelector('#idRegister').value = data.id;
				customerUpdate.querySelector('#name').value = data.customerFirstName;
				customerUpdate.querySelector('#lastname').value = data.customerLastName;
				customerUpdate.querySelector('#cpf').value = data.customerCPF;
				customerUpdate.querySelector('#socialName').value = data.customerSocialName;
				customerUpdate.querySelector('#fantasyName').value = data.customerFantasyName;			
				customerUpdate.querySelector('#cnpj').value = data.customerCnpj;
				customerUpdate.querySelector('#stateSubscription').value = data.customerStateSubscription;
				customerUpdate.querySelector('#municipalSubscription').value = data.customerMunicipalSubscription
				customerUpdate.querySelector('#road').value = data.customerAddressRoad;
				customerUpdate.querySelector('#number').value = data.customerAddressHouseNumber;
				customerUpdate.querySelector('#neighborhood').value = data.customerAddressNeighborhood;
				customerUpdate.querySelector('#zipcode').value = data.customerAddressZipcode;
				customerUpdate.querySelector('#complement').value = data.customerAddressComplement;
				matchStateId(data.customerState.Id);
				setTimeout(() => {
					matchCityId(data.customerCity.Id);
				}, 500)
				customerUpdate.querySelector('#email').value = data.customerEmail;
				customerUpdate.querySelector('#email2').value = data.customerEmail2;
				customerUpdate.querySelector('#ddd').value = data.customerEnterpriseNumberDdd;
				customerUpdate.querySelector('#enumber').value = data.customerEnterpriseNumber;
				customerUpdate.querySelector('#dddc').value = '';
				customerUpdate.querySelector('#cellphone').value = data.customerCellphoneNumber;
				customerUpdate.querySelector('#dddo').value = '';
				customerUpdate.querySelector('#onumber').value = data.customerNumber;
				customerUpdate.querySelector('#dddo2').value = '';
				customerUpdate.querySelector('#onumber2').value = data.customerNumber2;

				$(document).find('#dialog-update').dialog('open');
			});
		});
	}	

	var getInfo = (query) => {
		var element = document.querySelector('#'+query);

		var firstName = element.querySelector('#name').value;
		var lastName = element.querySelector('#lastname').value;
		var cpf = element.querySelector('#cpf').value;
		var socialName = element.querySelector('#socialName').value;
		var fantasyName = element.querySelector('#fantasyName').value;				
		var cnpj = element.querySelector('#cnpj').value;
		var stateSubscription = element.querySelector('#stateSubscription').value;
		var municipalSubscription = element.querySelector('#municipalSubscription').value;
		var addrRoad = element.querySelector('#road').value;
		var addrNumber = element.querySelector('#number').value;
		var addrNeighborhood = element.querySelector('#neighborhood').value;
		var addrZipcode = element.querySelector('#zipcode').value;
		var addrComplement = element.querySelector('#complement').value;
		var addrState = element.querySelector('#state').value;
		var addrCity = element.querySelector('#city').value;
		var email = element.querySelector('#email').value;
		var email2 = element.querySelector('#email2').value;
		var ddd = element.querySelector('#ddd').value;
		var enumber = element.querySelector('#enumber').value;
		var dddc = element.querySelector('#dddc').value;
		var cellphone = element.querySelector('#cellphone').value;
		var dddo = element.querySelector('#dddo').value;
		var onumber = element.querySelector('#onumber').value;
		var dddo2 = element.querySelector('#dddo2').value;
		var onumber2 = element.querySelector('#onumber2').value;

		var params = {
			[$('#name').attr('name')]: firstName,
			[$('#lastname').attr('name')]: lastName,
			[$('#cpf').attr('name')] : cpf,

			[document.querySelector('#socialName').getAttribute('name')] : socialName, 
			[document.querySelector('#fantasyName').getAttribute('name')] : fantasyName,
			[document.querySelector('#cnpj').getAttribute('name')] : cnpj,
			[document.querySelector('#stateSubscription').getAttribute('name')] : stateSubscription,				
			[document.querySelector('#municipalSubscription').getAttribute('name')]: municipalSubscription,

			[$('#road').attr('name')] : addrRoad,
			[$('#number').attr('name')] : addrNumber,
			[$('#neighborhood').attr('name')] : addrNeighborhood,
			[$('#zipcode').attr('name')] : addrZipcode,
			[$('#complement').attr('name')] : addrComplement,
			[$('#state').attr('name')] : addrState,
			[$('#city').attr('name')] : addrCity,
			[$('#email').attr('name')] : email,
			[$('#email2').attr('name')] : email2,
			[$('#ddd').attr('name')] : ddd,
			[$('#enumber').attr('name')] : enumber,
			[$('#dddc').attr('name')] : dddc,
			[$('#cellphone').attr('name')] : cellphone,
			[$('#dddo').attr('name')] : dddo,
			[$('#onumber').attr('name')] : onumber,
			[$('#dddo2').attr('name')] : dddo2,
			[$('#onumber2').attr('name')] : onumber2,
		};	

		return params;
	};

	function completeMap() {
		var zipcode = document.querySelector('#zipcode').value;
		getAddressByCep(zipcode);
	};
	
	var getAddressByCep = (zipcode) => {
		axios.get('https://viacep.com.br/ws/'+ zipcode +'/json/').
		then( (json) => {
			var address = json.data;
			this.querySelector('#road').value = address.logradouro;
			this.querySelector('#neighborhood').value = address.bairro;
			var opt = this.querySelectorAll('#state option');
			for (var c = 0; c < opt.length; c++) {
				if (opt[c].getAttribute('uf') == address.uf) {
					opt[c].setAttribute('selected', '');
					document.querySelector('#state').dispatchEvent(new Event('change'));
					break;
				}
			}
			setTimeout(() => {
				matchCity(zipcode);
			}, 100); 
		});
	}
	
	var matchCity = (zipcode) => {
		axios.get('https://viacep.com.br/ws/'+ zipcode +'/json/').
		then( (json) => {
			var opt = document.querySelectorAll('#city option');
			var address = json.data;
			for (var c = 0; c < opt.length; c++) {
				if (opt[c].innerHTML == address.localidade) {
					opt[c].setAttribute('selected', '');
					break;
				}
			}
		});
	}

	var matchStateId = (id) => {
		var element = document.querySelector('#dialog-update');
		var opt = element.querySelectorAll('#state option');
		for (var c = 0; c < opt.length; c++) {
			if (opt[c].value == id) {
				opt[c].setAttribute('selected', '');
				break;
			}
		}
		document.querySelector('#dialog-update #state').dispatchEvent(new Event('change'));
	}

	var matchCityId = (id) => {
		var element = document.querySelector('#dialog-update'); 
		var opt = element.querySelectorAll('#city option');
		for (var c = 0; c < opt.length; c++) {
			if (opt[c].value == id) {
				opt[c].setAttribute('selected', '');
				break;
			}
		}
	}

	function getCity() {
		var element = this.parentElement.parentElement;

		var state = this.options[this.options.selectedIndex].getAttribute('uf');
		var entity = document.querySelector('#entity').getAttribute('entity');

		var info = {
			'Uf' : state,
		}
		axios.put('/registros/clientes', {
			entity: entity,
			args: info,
		}).then(function (json) {
			var cities = json.data;

			var cod = element.querySelectorAll('#city option');

			for (var i = 0; i < cod.length; i++) {
				if (cod[i].disabled == false) {	
					cod[i].remove();
				}
			}
			
			for (var c = 0; c < cities.length; c++) {	
				var el = element.querySelector('#city');
				var opt = document.createElement('option');
				opt.value = cities[c].Id;
				opt.text = cities[c].Nome;
				el.add(opt, null);
			}
		});
	}

	function removeSelectedItem() {
		var p = document.createElement('p');
		var text = document.createTextNode('Você deseja remover esse item?');
		p.appendChild(text);
		var dialog = document.querySelector('#dialog-remove');
		dialog.appendChild(p);
		$('#dialog-remove').dialog('open');
	}

	//Ends here!
});