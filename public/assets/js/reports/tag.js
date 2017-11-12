$(function () {
    $(document).on('click', '.add', createRow);
    
    function createRow(e) {
        e.preventDefault();
        var counter = $(document).find('.create-area').last().attr('id');
        counter = parseInt(counter) + 1;
        var newRow = $(document).find('.create-area').last();
        var newRowContent = '<div id="'+ counter +'" class="form-row create-area">';
        newRowContent += '<div class="form-group col-md-5"><input type="text" name="info'+ counter +'[customer]" class="form-control col" placeholder="Cliente" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-md-3"><input type="text" name="info'+ counter +'[city]" class="form-control col" placeholder="Cidade" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-md-1"><input type="text" name="info'+ counter +'[amount]" class="form-control col" placeholder="qnt" required></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-md-3"><button class="form-contol btn btn-info add">Add</button>';
        newRowContent += ' <button class="form-contol btn btn-danger rm">Remove</button></div><!-- form-group -->';
        newRowContent += '</div><!--form-row -->';
        
        newRow.after(newRowContent);
    }

    $(document).on('click', '.rm', removeRow);

    function removeRow(e) {
        e.preventDefault();
        var row = $(this).closest('.create-area');
        row.remove();
    }
});