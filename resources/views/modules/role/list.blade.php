<div class="card-box">
    <div class="row">
        <div class="col-md-4">
            <h4 class="header-title">{{__('Role List')}}</h4>
            <p class="sub-header">
                {{__('Here goes the role list')}}
            </p>
        </div>
        <div class="col-md-8">
            <button class="btn btn-sm btn-info m-1 text-light update_route"><i class="fa fa-sync"></i> {{__('Update route list')}}</button>
            <button class="btn btn-sm btn-info m-1 text-light application_command" data-style="zoom-in" data-type="generate:routelist"><i class="fa fa-sync"></i> {{__('Generate route list')}}</button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="roleTable" class="table dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>{{__('Title')}}</th>
                <th>{{__('Module')}}</th>
                <th>{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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
