<div class="card-box">
    <div class="row">
        <div class="col-md-6">
            <h4 class="header-title">{{__('Select Route List')}}</h4>
            <p class="sub-header">
                {{__('Here goes the all route lists by module')}}
            </p>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <select class="form-control" name="module_id" id="userSelectedModule">
                    <option value="">{{__('Select module')}}</option>
                    @if(isset($module_list))
                        @foreach($module_list as $module)
                            <option value="{{$module['key']}}">{{$module['value']}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
        </div>
    </div>
    <div id="show_routes_table"></div>
</div>

<script>
    $('#userSelectedModule').on('change',function (){
        const module_id = $(this).val();
        if (module_id.length > 0){
            const data = {
                module_id : module_id,
                role_id : "{{$role_id ?? ''}}"
            }
            makeAjaxPostText(data,"{{route('getRouteListByModuleId')}}").done(function (response){
                $('#show_routes_table').html(response);
            });
        }else {
            $('#show_routes_table').html('');
        }
    });
</script>
