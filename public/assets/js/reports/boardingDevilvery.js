$(function () {
    $(document).on('click', '.add', createRow);
    
    function createRow(e) {
        e.preventDefault();
        var counter = $(document).find('.create-area').last().attr('id');
        counter = parseInt(counter) + 1;
        var newRow = $(document).find('.create-area').last();
        var newRowContent = '<div id="'+ counter +'" class="form-row create-area">';
        newRowContent += '<div class="form-group col-3" style="width: 20%"><input type="text" name="info'+ counter +'[customer]" class="form-control " placeholder="Cliente" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col" style="width: 20%"><input type="text" name="info'+ counter +'[city]" class="form-control  col" placeholder="Cidade" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-1" style="width: 5%;"><input type="text" name="info'+ counter +'[gAmount]" class="form-control  col-xs-01" placeholder="QNT" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-1" style="width: 5%;"><input type="text" name="info'+ counter +'[mAmount]" class="form-control  col" placeholder="QNT" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-1" style="width: 5%;"><input type="number" name="info'+ counter +'[pAmount]" class="form-control " placeholder="QNT" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col" style="width: 10%;"><select name="info'+ counter +'[formPg]" id="" class="form-control " required><option selected disabled>PG</option><option value="Á vista">A vista</option><option value="Boleto">Boleto</option><option value="Cheque">Cheque</option></select></div><!-- form-group -->';
        newRowContent += '<div class="form-group col" style="width: 10%;"><input type="number" name="info'+ counter +'[ship]" class="form-control " placeholder="R$" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-1" style="max-width: 20%"><input type="button" class="btn btn-sm btn-info add" value="+"> <input type="button" class="btn btn-sm btn-danger rm" value="X"></div><!-- form-group -->';
        newRowContent += '</div><!--form-row --><!-- /create area -->';
        
        newRow.after(newRowContent);
    }
    
    $(document).on('keydown', '.num', notNegative);
    
    $(document).on('click', '.rm', removeRow);
    
    function notNegative(e) {
        if (e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 189) {
            console.log('esse caractere não é permitido');
            e.preventDefault();
        }
    }
        
    function removeRow(e) {
        e.preventDefault();
        if (document.querySelectorAll('.create-area').length == 1) {
            return false;
        }
        var row = $(this).closest('.create-area');
        row.remove();
    }
    
    
});