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
                var entity = $('#price').attr('entity');
                var height = document.querySelector('#height').value;
                var model = document.querySelector('#model').value;
                var price = document.querySelector('#price').value;		
                price = price.replace('.', '');
                price = price.replace(',', '.');		
                
                alert(typeof price);

                var params = {
                    [$('#model').attr('name')] : model,
                    [$('#height').attr('name')] : height,
                    [$('#price').attr('name')] : price
                };
                
                insertData(entity, params);
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
    
    var getHeight = function (entity) {
        getHeightRegister(entity);
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
                remove(entity, id);
                dialog_remove.data('id', id).dialog('close');
                dialog_remove.data('id', '');
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
                price = price.replace('.', '');
                var entity = $('#entity-field').attr('entity');
                var id = $(document).find('.edit-prod').find('tr').attr('id');
                var params = {
                    [$(document).find('#newPrice').attr('name')] : price.replace(',', '.'),
                }
                setNewPrice(entity, id, params);
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
    
    $(document).on('change', '.mod', function () {
        var entity = $(document).find('#auxentity').attr('entity');
        getHeight(entity);
    });

    $(document).on('change', '#height', function () {
        $('#price').removeAttr('disabled');
    });
    
    $(document).find('.edit').css('cursor', 'pointer');
    
    $(document).on('click', '.edit' ,function () {
        var id = $(this).closest('tr').attr('id');
        var entity = $('#entity-field').attr('entity');
        getEditInfo(entity, id);
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