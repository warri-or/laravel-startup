<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('Generate Route List')}}</h4>
                <p>php artisan generate:routelist</p>
                <button class="application_command btn btn-sm btn-primary text-light" data-style="zoom-in" data-type="generate:routelist"><i class="fa fa-sync"></i> {{__('Generate Route List')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.application_command',function (){
        Ladda.bind(this);
        var load = $(this).ladda();
        var type = $(this).data('type');
        swalConfirm("Do you really want to run this command ?").then(function (s) {
            if(s.value){
                var command_url = "{{route('runCommand')}}";
                var data = {
                    type : type
                };
                makeAjaxPost(data, command_url, load).done(function (response) {
                    if (response.success == true){
                        swalRedirect("{{Request::url()}}",response.message,'success');
                    }else {
                        swalError(response.message);
                    }
                    load.ladda('stop');
                });
            }else{
                load.ladda('stop');
            }
        })
    });
</script>
