<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{__('Clear cache')}}</h4>
                <p class="card-text">php artisan cache:clear</p>
                <button class="basic_command btn btn-sm btn-primary text-light" data-style="zoom-in" data-type="cache:clear"><i class="fa fa-sync"></i> {{__('Cache Clear')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{__('Route clear')}}</h4>
                <p class="card-text">php artisan route:clear</p>
                <button class="basic_command btn btn-sm btn-info text-light" data-style="zoom-in" data-type="route:clear"><i class="fa fa-sync"></i> {{__('Route Clear')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{__('View clear')}}</h4>
                <p class="card-text">php artisan view:clear</p>
                <button class="basic_command btn btn-sm btn-success text-light" data-style="zoom-in" data-type="view:clear"><i class="fa fa-sync"></i> {{__('View Clear')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{__('Config cache')}}</h4>
                <p class="card-text">php artisan config:cache</p>
                <button class="basic_command btn btn-sm btn-primary text-light" data-style="zoom-in" data-type="config:cache"><i class="fa fa-sync"></i> {{__('Config cache')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{__('Config clear')}}</h4>
                <p class="card-text">php artisan config:clear</p>
                <button class="basic_command btn btn-sm btn-info text-light" data-style="zoom-in" data-type="config:clear"><i class="fa fa-sync"></i> {{__('Config clear')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.basic_command',function (){
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
