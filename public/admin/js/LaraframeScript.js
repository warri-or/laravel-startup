$(document).ready(function (){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=laraframe]').attr('content')
        }
    });
})
$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});
$(document).on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    autoWidth: true,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
/*/ --------------------------- Ajax requests----------------------------- /*/

function makeAjaxText(url, load) {
    return $.ajax({
        url: url,
        type: 'get',
        cache: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function() {
        swalError();
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    });
}

function makeAjaxTextWithData(data, url, load) {
    return $.ajax({
        url: url,
        type: 'get',
        data: data,
        cache: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function() {
        swalError();
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    });
}

function makeAjaxPostFile(data, url, load,validationError=null) {
    return $.ajax({
        url: url,
        type: 'post',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function(response) {
        validationError(response.responseJSON.errors);
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    });
}
function makeAjaxPostText(data, url, load) {
    return $.ajax({
        url: url,
        type: 'post',
        data: data,
        cache: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function() {
        swalError();
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    });
}
function makeAjax(url, load) {
    return $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        cache: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function() {
        swalError();
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }

    });
}
function makeAjaxPost(data, url, load) {
    return $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data,
        cache: false,
        beforeSend: function(){
            if(typeof(load) != "undefined" && load !== null){
                load.ladda('start');
            }
        }
    }).always(function() {
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }
    }).fail(function() {
        swalError();
        if(typeof(load) != "undefined" && load !== null){
            load.ladda('stop');
        }

    });
}

/*/ --------------------------- Sweet alert----------------------------- /*/

function swalError(msg) {
    var message = typeof(msg) != "undefined" && msg !== null ? msg : "Something went wrong";
    Swal.fire({
        title: "Sorry !!",
        html: message,
        type: "error",
        showConfirmButton: false,
        // timer: 1000
    });
}
function swalWarning(msg) {
    var message = typeof(msg) != "undefined" && msg !== null ? msg : "Something went wrong";
    Swal.fire({
        title: "Warning !!",
        html: message,
        type: "warning",
        showConfirmButton: false,
        // timer: 1000
    });
}
function swalSuccess(msg) {
    var message = typeof(msg) != "undefined" && msg !== null ? msg : "Action has been Completed Successfully";
    Swal.fire({
        title: 'Successful !!',
        html: message,
        type: 'success',
        showConfirmButton: false,
        timer: 1500
    });
}
function swalRedirect(url, msg, mode) {
    var message = typeof(msg) != "undefined" && msg !== null ? msg : "Action has been Completed Successfully";
    var title = 'Successful !!';
    var type = 'info';
    if(typeof(mode) != "undefined" && mode !== null){
        if(mode == 'success'){
            var title = 'Successful !!';
            var type = 'success';
        } else if(mode == 'error'){
            var title = 'Failed !!';
            var type = 'error';
        }else if(mode == 'warning'){
            var title = 'Warning !!';
            var type = 'warning';
        }else if(mode == 'question'){
            var title = 'Warning !!';
            var type = 'question';
        }else{
            var title = 'Successful !!';
            var type = 'info';
        }
    }
    return Swal.fire({
        title: title,
        html: message,
        type: type,
        reverseButtons : true,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Thank You',
        allowOutsideClick: false
    }).then(function (s) {
        if(s.value){
            if(typeof(url) != "undefined" && url !== null){
                window.location.replace(url);
            }else{
                location.reload();
            }
        }
    });
}
function swalConfirm(msg) {
    var message = typeof(msg) != "undefined" && msg !== null ? msg : "You won't be able to revert this!";
    return Swal.fire({
        title: 'Are you sure?',
        html: message,
        type: 'warning',
        reverseButtons : true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No'
    });
}


function filterString(string) {
    return string.replace(/(\r\n|\n|\r)/gm, " ");
}

function checkActiveUrl(StringA, StringB){
    while(StringA !== '') {
        if (StringA === StringB) {
            return true;
        }
        var stringArr = StringA.split("/");
        StringA = stringArr.slice(0, stringArr.length - 1).join("/");

    }
    return false;
}


/*/ --------------------------- /*/
// autoselect function

/**
 *
 * @param selectizeCallback with listing view
 * @param obj with dom-attribute | remote-url | default selectize objects
 */
function selectizeFunction(selectizeCallback, obj){
    var element = $(obj.targetDom);
    if(element[0].selectize){
        element[0].selectize.destroy();
    }
    element.selectize({
        valueField: obj.valueField,
        labelField: obj.labelField,
        searchField: obj.searchField,
        create: obj.create,
        onType: function(){
            this.$input[0].selectize.renderCache = {};
            this.$input[0].selectize.clearOptions();
            this.$input[0].selectize.refreshOptions(true);
        },
        onItemRemove:function (){
            this.$input[0].selectize.renderCache = {};
            this.$input[0].selectize.clearOptions();
            this.$input[0].selectize.refreshOptions(true);
        },
        load: (query,callback)=>{
            if (!query.length) return callback();
            $.ajax({
                url : obj.url,
                type: 'GET',
                dataType: 'json',
                data: {
                    search:query
                },
                error: ()=> callback(),
                success: (res) => callback(res)
            })
        },
        render: {
            option: (item, escape)=> {
                return selectizeCallback(item,escape);
            }
        }
    });
}

function reinitializeSelectize(obj){
   $(obj.targetDom).selectize();
}
