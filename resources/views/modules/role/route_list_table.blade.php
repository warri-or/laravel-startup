<div class="table-responsive">
    <table id="basic-datatable" class="table table-sm table-bordered dt-responsive nowrap w-100">
        <thead>
        <tr>
            <th style="padding-left: 8px!important; padding-right: 8px!important; padding-top: 8px!important; padding-bottom: 1px!important;"><input type="checkbox" {{ $all_checked == TRUE ? 'checked' : ''}} class="form-control check_all_routes p-2" ></th>
            <th>{{__('Name')}}</th>
            <th>{{__('Url')}}</th>
            <th>{{__('Action')}}</th>
        </tr>
        </thead>

        <tbody>
        @if(isset($routeList))
            @foreach($routeList as $route)
                <tr>
                    <th width="5%"><input type="checkbox" value="{{$route->id}}" {{in_array($route->id,$selected_routes ?? []) ? 'checked' : ''}} class="form-control p-2 checked_route"></th>
                    <td data-id="{{$route->id}}" id="route_name_{{$route->id}}">{{$route->name}}</td>
                    <td data-id="{{$route->id}}">{{$route->url}}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success general_mode_{{$route->id}} edit_route" data-id="{{$route->id}}" data-name="{{$route->name}}"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-success d-none edit_mode_{{$route->id}} save_route" data-id="{{$route->id}}" data-name="{{$route->name}}"><i class="fa fa-save"></i></button>
                        <button type="button" class="btn btn-sm btn-warning d-none edit_mode_{{$route->id}} cancel_edit" data-id="{{$route->id}}" data-name="{{$route->name}}"><i class="fa fa-undo"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function (){
        const table = $('#basic-datatable').DataTable({
            columnDefs : [
                { targets: 0, sortable: false},
            ],
            order: [[ 1, "asc" ]],
            pageLength: 20
        });

        $(document).on('change','.check_all_routes',function (){

            let checked = $(this).prop('checked');
            let route_id = [];
            table.cells(null, 0).every( function () {
                let cell = this.node();
                const id = $(cell).find('.checked_route').prop('checked', checked).val();
                if (checked == true){
                    route_id.push(id)
                }

            });
            const role_id = $('#role_id').val();
            const module_id = $('#userSelectedModule').val();
            updateRouteList(route_id,role_id,module_id,checked,'multiple');
        });
    })

    $(document).on('click','.edit_route',function (){
        const data_id = $(this).data('id');
        const data_name = $(this).data('name');
        editMode(data_id,data_name);
    });

    $(document).on('click','.cancel_edit',function (){
        const data_id = $(this).data('id');
        const edit_data_name = $(this).data('name');
        generalMode(data_id,edit_data_name);
    });

    $(document).on('click','.save_route',function (){
        const id = $(this).data('id');
        const edit_input_id = '#edit_input_'+id;
        const data = {
            route_id : $(this).data('id'),
            route_name : $(edit_input_id).val()
        }
        makeAjaxPost(data,"{{route('updateRouteName')}}").done(function (response){
            if (response.success == true){
                const route = response.data.route;
                generalMode(route.id,route.name);
            }
        })
    });

    function generalMode(data_id,data_name){
        const route_id = '#route_name_'+data_id;
        const general_mode = '.general_mode_'+data_id;
        const edit_mode = '.edit_mode_'+data_id;
        $(route_id).html(data_name);
        $(edit_mode).addClass('d-none');
        $(general_mode).data('name',data_name);
        $(edit_mode).data('name',data_name);
        $(general_mode).removeClass('d-none');
    }

    function editMode(data_id,data_name){
        const route_id = '#route_name_'+data_id;
        const general_mode = '.general_mode_'+data_id;
        const edit_mode = '.edit_mode_'+data_id;
        const edit_input_id = 'edit_input_'+data_id;
        $(route_id).html(`<input class="form-control" id="${edit_input_id}" name="edit_column" value="${data_name}">`);
        $(general_mode).data('name',data_name);
        $(edit_mode).data('name',data_name);
        $(edit_mode).removeClass('d-none');
        $(general_mode).addClass('d-none');
    }



    $(document).on('click','.checked_route',function (){
        const route_id = [];
        route_id.push($(this).val());
        const role_id = $('#role_id').val();
        const module_id = $('#userSelectedModule').val();
        const checked = $(this).prop('checked');
        updateRouteList(route_id,role_id,module_id,checked,'single');
    });



    function updateRouteList(route_id,role_id,module_id,checked,type){
        const data = {
            role_id : role_id,
            route_id : route_id,
            module_id: module_id,
            checked: checked,
            type : type
        }
        makeAjaxPostText(data,"{{route('updateRoleRoute')}}").done(function (response){
            console.log(response);
        })
    }
</script>
