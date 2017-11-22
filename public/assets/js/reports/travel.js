$(function () {
    $(document).on('click', '.add', createRow);
    
    function createRow(e) {
        e.preventDefault();
        var counter = $(document).find('.create-area').last().attr('id');
        counter = parseInt(counter) + 1;
        var newRow = $(document).find('.create-area').last();
        var newRowContent = '<div id="'+ counter +'" class="form-row create-area">';
        newRowContent += '<div class="form-group col-md-5"><input type="text" name="info'+ counter +'[customer]" class="form-control col" placeholder="Cliente"></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-md-4"><input type="text" name="info'+ counter +'[city]" class="form-control col" placeholder="Cidade"></div><!-- form-group -->';
        newRowContent += '<div class="form-group col-md-3"><button class="form-contol btn btn-info add">Add</button>';
        newRowContent += ' <button class="form-contol btn btn-danger rm">Remove</button></div><!-- form-group -->';
        newRowContent += '</div><!--form-row -->';
        
        newRow.after(newRowContent);
    }

    $(document).on('click', '.rm', removeRow);

    function removeRow(e) {
        e.preventDefault();
        if (document.querySelectorAll('.create-area').length == 1) {
            return false;
        }
        var row = $(this).closest('.create-area');
        row.remove();
    }
});