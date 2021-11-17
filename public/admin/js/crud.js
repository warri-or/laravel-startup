
/*============================Form submit =========================*/
function submitOperation(callback, submitButtonClassName='basic_submit',validationError){
    const submit_button = '.' + submitButtonClassName;
    $(document).on('click',submit_button, function (e) {
        Ladda.bind(this);
        const load = $(this).ladda();
        const form_id = $(this).closest('form').attr('id');
        const this_form = $('#' + form_id);
        const submit_url = $(this_form).attr('action');
        $(this_form).on('submit', function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                const formData = new FormData(this);
                makeAjaxPostFile(formData, submit_url, load, validationError).done(function (response) {
                    load.ladda('stop');
                    callback(response, this_form);
                });
            }
        });
    });
}

/*============================Form edit ============================*/

function editOperation(callback, edit_url, files= false, edit_class='edit_item'){
    $(document).on('click',"."+edit_class,function (e){
        const edit_data = {
            id : $(this).data('id')
        }
        add_loader(files);
        makeAjaxPostText(edit_data, edit_url).done (function (response) {
            remove_loader();
            $('.add_edit').html(response);
            callback();
        });
    });
}

/*============================ Delete item ============================*/

function deleteOperation(callback,delete_class,delete_url){
    $(document).on('click','.'+delete_class,function (e) {
        Ladda.bind(this);
        const load = $(this).ladda();
        const id = $(this).data('id');
        swalConfirm("Do you really want to delete this ?").then(function (s) {
            if(s.value){
                const url = delete_url;
                const data = {
                    id : id
                };
                makeAjaxPost(data, url, load).done(function (response) {
                  callback(response)
                });
            }else{
                load.ladda('stop');
            }
        })
    });
}

function statusChangeOperation(callback,status_class,status_url,confirm_msg='Do you really want to change this ?'){
    $(document).on('click','.'+status_class,function (e) {
        Ladda.bind(this);
        let load = $(this).ladda();
        let id = $(this).data('id');
        let status = $(this).data('type');
        swalConfirm(confirm_msg).then(function (s) {
            if(s.value){
                let data = {
                    id : id,
                    status : status
                };
                makeAjaxPost(data, status_url, load).done(function (response) {
                    callback(response)
                });
            }else{
                load.ladda('stop');
            }
        })
    });
}

/*============================ Render data table  ============================*/
function renderDataTable(table_id,data_url,data_column,data_order= [[ 0, "desc" ]],callBackResponse=null){
    $(table_id).DataTable({
        destroy: true,
        //dom: 'Bfrtip',
        //scrollX: true,
        processing: true,
        language:{
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Showing 0 to 0 of 0 entries",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "_MENU_ entries",
            "loadingRecords": "Loading...",
            "processing":     "Processing...",
            "search":         "<i class='fe-search'></i>",
            "zeroRecords":    "No matching records found",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "<i class='fe-chevrons-right'>",
                "previous":   "<i class='fe-chevrons-left'>"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        serverSide: true,
        pageLength: 10,
        responsive: true,
        ordering: true,
        ajax: data_url,
        order: data_order,
        autoWidth:false,
        createdRow: function(row,data){
            $(row).attr('id',data.id);
        },
        initComplete: function (settings,json){
          //
        },
        drawCallback: function (){
            if (callBackResponse){
                callBackResponse();
            }
            // $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        columns: data_column,
    });
}

function renderDataTableWithData(table_id,data_url,data_column,search_data,data_order= [[ 0, "desc" ]],callbackResponse=null){
    $(table_id).DataTable({
        destroy: true,
        //dom: 'Bfrtip',
        //scrollX: true,
        processing: true,
        language:{
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Showing 0 to 0 of 0 entries",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "_MENU_ entries",
            "loadingRecords": "Loading...",
            "processing":     "Processing...",
            "search":         "<i class='fe-search'></i>",
            "zeroRecords":    "No matching records found",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "<i class='fe-chevrons-right'>",
                "previous":   "<i class='fe-chevrons-left'>"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        serverSide: true,
        pageLength: 10,
        responsive: true,
        ajax: {
            "url": data_url,
            "type": "POST",
            "data": function(data) {
                data.search_data = search_data;
            }
        },
        order: data_order,
        autoWidth:false,
        createdRow: function(row,data){
            $(row).attr('id',data.id);
        },
        initComplete: function (settings,json){
            //
        },
        drawCallback: function (){
           if (callbackResponse){
               callbackResponse();
           }
            // $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        columns: data_column,
    });
}

function renderOrderAbleDataTable(table_id,data_url,data_column,order_route,data_order= [[ 0, "asc" ]],callbackResponse=false){
    $(table_id).DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        ordering: true,
        ajax: data_url,
        order: data_order,
        autoWidth:false,
        createdRow: function(row,data){
            $(row).attr('id',data.id);
            $(row).addClass('ui-state-default');
            $(row).attr('data-id',data.id);
        },
        initComplete: function (settings,json){
            //
        },
        drawCallback: function (){
            $( function() {
                $( ".sortable" ).sortable();
                $( ".sortable" ).disableSelection();
            });
            if (callbackResponse){
                callbackResponse();
            }
        },
        columns: data_column,
    });
    jquerySortAble(order_route);
}

function jquerySortAble(order_route){
    $(".sortable").sortable({
        start: function(e, ui) {
            $(this).attr('data-previndex', ui.item.data('id'));
        },
        update: function(e, ui) {
            let ids = [];
            $(".ui-state-default").each(function(index,key){
                ids.push($(this).data('id'));
            });

            $.ajax({
                url: order_route+"&ids="+ids,
                context: document.body
            }).done(function() {
                Toast.fire({type: 'success', text: "Order updated successfully"});
            });
            $(this).removeAttr('data-previndex');
        }
    });
    $(".sortable").disableSelection();
}

/*============================ Reset a form  ============================*/
function reset_form(files=false,callback=null){
    $(document).on('click','.reset_from',function (){
        const this_form = $(this).closest('form')[0];
        $(this_form).removeClass('was-validated');
        this_form.reset();
        $('form :input').val('');
        if (files == true){
            clearDropify();
        }
        if (callback){
            callback();
        }
    });
}

function resetValidation(formClassName){
    $("."+formClassName).on('submit', function (event) {
        $(this).addClass('was-validated');
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
        return true;
    });
}

function addLanguage(attribute){
    languageSelect();
    let first_index = $(attribute).parent('.language_class').data('type');
    $(attribute).on('input',function (){
        if ($(this).val().length > 0){
            $('.language-btn-label').removeClass('d-none');
        }else {
            $('.language-btn-label').addClass('d-none');
            $('#'+first_index).parent('.language-btn-label').removeClass('d-none');
        }
    })
}

function resetLanguage(attribute){
    $('.language-btn-label').addClass('btn-secondary d-none');
    const first_index = $(attribute).parent('.language_class').data('type');
    $('#'+first_index).parent('.language-btn-label').removeClass('d-none btn-secondary').addClass('active btn-primary');
    $('.language_class').addClass('d-none');
    $(attribute+first_index).removeClass('d-none');
}

function add_loader(files=false){
    if (files == true){
        clearDropify();
    }
    const loader_div = $('.ajax-load')
    loader_div.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>');
}
function remove_loader(){
    const loader_div = $('.ajax-load');
    loader_div.find('.card-disabled').fadeOut('fast', function () {
        loader_div.find('.card-disabled').remove();
    });
}

function clearDropify(className = '.dropify'){
    var drEvent = $(className).dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}

function clearDropifyWithSelector(selector){
    var drEvent = $(selector).dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}

function generateCategoryTree(url,callback){
    let postdata = {
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=laraframe]').attr('content')
        }
    });
    makeAjaxPostText(postdata, url).done(function (response)  {
        callback(response);
    });
}

function slugify(text) {
    return text
        .toString()                     // Cast to string
        .toLowerCase()                  // Convert the string to lowercase letters
        .normalize('NFD')       // The normalize() method returns the Unicode Normalization Form of a given string.
        .trim()                         // Remove whitespace from both sides of a string
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-');        // Replace multiple - with single -
}

function textSlugify(text) {
    let text_array = text.split(' ');
    let slug ='';
    text_array.forEach(function(item) {
        slug += item[0].toUpperCase()
    });
    return slug;
}

function checkSlugVlaidity(type = ''){
    $('.check_slug_validity').each(function (){
        const this_slug_input = $(this);
        const validation_url = this_slug_input.data('slugvalidateurl');
        const id_to_match = this_slug_input.data('slugforid');
        const this_source_input = $('#'+id_to_match);
        const except_value_of = this_slug_input.data('exceptvalueid');
        const this_except_value_input = $('#'+except_value_of);
        const this_closest_form = this_source_input.closest('form');
        const this_submit_button = this_closest_form.find(':submit');
        let slug_value = '';

        this_source_input.on('input', function(e) {
            if (this_closest_form.hasClass('was-validated')){
                this_closest_form.removeClass('was-validated');
            }
            if (type == 'user'){
                slug_value = textSlugify(this_source_input.val());
            }else {
                slug_value = slugify(this_source_input.val());
            }

            this_slug_input.val(slug_value);
            requestForSlugValidation(slug_value, validation_url, this_except_value_input.val(), this_slug_input, this_submit_button);
        });

        this_slug_input.on('input', function(e) {
            slug_value = this_slug_input.val();
            requestForSlugValidation(slug_value, validation_url, this_except_value_input.val(), this_slug_input, this_submit_button);
        });
    });
}

function requestForSlugValidation(slug_value, url, this_except_value, this_slug_input, this_submit_button){
    const data = {slug: slug_value, id: this_except_value};
    makeAjaxPost(data, url).done(function (response){
        if(response.success == true){
            this_slug_input.next().removeClass('invalid-feedback');
            this_slug_input.next().addClass('valid-feedback');
            this_slug_input.removeClass('is-invalid').siblings('.valid-feedback').text(response.message);
            this_submit_button.attr('disabled',false);
        }else {
            this_slug_input.next().removeClass('valid-feedback');
            this_slug_input.next().addClass('invalid-feedback');
            this_slug_input.addClass('is-invalid').siblings('.invalid-feedback').text(response.message);
            this_submit_button.attr('disabled',true);
        }
    });
}

function languageSelect(name='name'){
    $('.selected_language').on('click',function (){
        $('.language-btn-label').removeClass('btn-primary btn-secondary active').addClass('btn-secondary');
        $(this).parent('.language-btn-label').removeClass('btn-secondary').addClass('active btn-primary');
        $('.language_class').addClass('d-none');
        const lang_id = $(this).attr('id');
        $('#'+name+lang_id).removeClass('d-none');
    })
}

function checkReferenceValidity(){
    $('.check_reference_validity').each(function (){
        const this_reference_input = $(this);
        const validation_url = this_reference_input.data('referencevalidateurl');
        const id_to_match = this_reference_input.data('referenceforid');
        const this_source_input = $('#'+id_to_match);
        const except_value_of = this_reference_input.data('exceptvalueid');
        const this_except_value_input = $('#'+except_value_of);
        const this_closest_form = this_source_input.closest('form');
        const this_submit_button = this_closest_form.find(':submit');
        let reference_value = '';
        let prev_reference_value = '';

        this_reference_input.on('input', function(e) {
            reference_value = this_reference_input.val();
            reference_value = validateReference(reference_value);
            this_reference_input.val(reference_value);
            if(prev_reference_value !== reference_value) {
                requestForReferenceValidation(reference_value, validation_url, this_except_value_input.val(), this_reference_input, this_submit_button);
            }
            prev_reference_value = reference_value;
        });
    });
}

function validateReference (text) {
    return text
        .toString()                     // Cast to string
        .replace(' ', '-')           // Replace spaces with -
        .replace(/[^A-Za-z0-9\-]/, '')       // Remove all non-word chars
}

function requestForReferenceValidation(reference_value, url, this_except_value, this_reference_input, this_submit_button){
    const data = {reference: reference_value, id: this_except_value};
    makeAjaxPost(data, url).done(function (response){
        if(response.success === true){
            this_reference_input.next().removeClass('invalid-feedback');
            this_reference_input.next().addClass('valid-feedback');
            this_reference_input.removeClass('is-invalid').siblings('.valid-feedback').text(response.message);
            this_submit_button.attr('disabled',false);
        }else {
            this_reference_input.next().removeClass('valid-feedback');
            this_reference_input.next().addClass('invalid-feedback');
            this_reference_input.addClass('is-invalid').siblings('.invalid-feedback').text(response.message);
            this_submit_button.attr('disabled',true);
        }
    });
}

