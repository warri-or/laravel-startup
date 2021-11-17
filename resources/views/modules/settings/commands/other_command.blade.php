<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <form method="post" id="create_service_id" novalidate class="create_service_class" action="{{route('createCommand')}}">
                    <div class="form-group">
                        <h4 class="header-title">{{__('Create New Service')}}</h4>
                        <p>php artisan make:service FolderName/ServiceName</p>
                        <input type="text" class="form-control" name="name" placeholder="{{__('FolderName/ServiceName')}}" required>
                        <input type="hidden" name="type" value="make:service">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary text-light create_command" data-style="zoom-in"><i class="fa fa-plus-circle"></i> {{__('Create')}}</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <form method="post" id="create_repository_id" novalidate class="create_service_class" action="{{route('createCommand')}}">
                    <div class="form-group">
                        <h4 class="header-title">{{__('Create New Repository')}}</h4>
                        <p>php artisan make:repository FolderName/RepositoryName</p>
                        <input type="text" class="form-control" name="name" placeholder="{{__('FolderName/RepositoryName')}}" required>
                        <input type="hidden" name="type" value="make:repository">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary text-light create_command" data-style="zoom-in"><i class="fa fa-plus-circle"></i> {{__('Create')}}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <form method="post" id="create_request_id" novalidate class="create_service_class" action="{{route('createCommand')}}">
                    <div class="form-group">
                        <h4 class="header-title">{{__('Create New Request')}}</h4>
                        <p>php artisan make:request FolderName/RequestName</p>
                        <input type="text" class="form-control" name="name" placeholder="{{__('FolderName/RequestName')}}" required>
                        <input type="hidden" name="type" value="make:request">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary text-light create_command" data-style="zoom-in"><i class="fa fa-plus-circle"></i> {{__('Create')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.create_command',function (){
        Ladda.bind(this);
        var load = $(this).ladda();
        var form_id = $(this).closest('form').attr('id');
        var this_form = $('#' + form_id);
        var submit_url = $(this_form).attr('action');
        $(this_form).on('submit', function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var formData = new FormData(this);
                makeAjaxPostFile(formData, submit_url, load).done(function (response) {
                    if (response.success == true){
                        swalRedirect("{{Request::url()}}",response.message,'success');
                    }else {
                        swalError(response.message);
                    }
                    load.ladda('stop');
                });
            }
        });
    });
</script>
