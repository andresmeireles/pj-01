$(function () {
	$('#tabs').tabs();

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
				var firstName = $('#name').val();
				var lastName = $('#lastname').val();
				var cpf = $('#cpf').val();
				var addrRoad = $('#road').val();
				var addrNumber = $('#number').val();
				var addrNeighborhood = $('#number').val();
				var addrZipcode = $('#zipcode').val();
				var addrComplement = $('#complement').val();
				var addrState = $('#state').val();
				var addrCity = $('#city').val();
				var email = $('#email').val();
				var email2 = $('#email2').val();
				var ddd = $('#ddd').val();
				var enumber = $('#enumber').val();
				var finalEnumber = ddd + enumber;
				var dddc = $('#dddc').val();
				var cellphone = $('#cellphone').val();
				var finalCellphoneNumber = dddc + cellphone;
				var dddo = $('#dddo').val();
				var onumber = $('#onumber').val();
				var finalOnumber = dddo + onumber;
				var dddo2 = $('#dddo2').val();
				var onumber2 = $('#onumber2').val();
				var finalOnumber2 = dddo + onumber;

				var params = {
					[$('#name').attr('name')]: firstName,
					[$('#lastname').attr('name')]: lastName,
					[$('#cpf').attr('name')] : cpf,
					[$('#road').attr('name')]: addrRoad,
					[$('#number').attr('name')]: addrNumber,
					[$('#neighborhood').attr('name')]: addrNeighborhood,
					[$('#zipcode').attr('name')]: addrZipcode,
					[$('#complement').attr('name')]: addrComplement,
					[$('#state').attr('name')]: addrState,
					[$('#city').attr('name')]: addrCity,
					[$('#email').attr('name')]: email,
					[$('#email').attr('name')]: email2,
					[$('#enumber').attr('name')]: finalEnumber,
					[$('#cellphone').attr('name')]: finalCellphoneNumber,
					[$('#onumber').attr('name')]: finalOnumber,
					[$('#onumber2').attr('name')]: finalOnumber2,
				};

				console.log(params);

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
				deleteItem(entity, id);
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
});