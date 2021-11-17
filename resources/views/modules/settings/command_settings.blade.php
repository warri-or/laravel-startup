@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'command_setting'])
@section('style')
    <link href="{{adminAsset('libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="widget-rounded-circle card-box text-center">
                    <div class="form-group">
                        <label for="app_in_production"> {{__('Application In Production')}} </label>
                        <input type="checkbox" id="app_in_production" {{isset($settings->app_in_production) && $settings->app_in_production == ACTIVE ? 'checked' : ''}} class="check_system_settings"  name="app_in_production" data-plugin="switchery" data-color="#039cfd"/>
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div>
            <div class="col-md-3">
                <div class="widget-rounded-circle card-box text-center">
                    <div class="form-group">
                        <label for="app_debug"> {{__('Application Debug')}} </label>
                        <input type="checkbox" id="app_debug" {{isset($settings->app_debug) && $settings->app_debug == ACTIVE ? 'checked' : ''}} class="check_system_settings"  name="app_debug" data-plugin="switchery" data-color="#039cfd"/>
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card-box">
            <ul class="nav nav-pills navtab-bg nav-justified">
                <li class="nav-item">
                    <a href="#basic" data-toggle="tab" aria-expanded="true" class="nav-link active">{{__('Basic Commands')}}</a>
                </li>
                <li class="nav-item">
                    <a href="#application" data-toggle="tab" aria-expanded="false" class="nav-link">{{__('Application Command')}}</a>
                </li>
                <li class="nav-item">
                    <a href="#languages" data-toggle="tab" aria-expanded="false" class="nav-link">{{__('Language Settings Command')}}</a>
                </li>
                <li class="nav-item">
                    <a href="#others" data-toggle="tab" aria-expanded="false" class="nav-link">{{__('Others')}}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="basic">
                    @include('modules.settings.commands.basic_command')
                </div>

                <div class="tab-pane" id="application">
                    @include('modules.settings.commands.application_command')
                </div>

                <div class="tab-pane" id="languages">
                    @include('modules.settings.commands.language_command')
                </div>

                <div class="tab-pane" id="others">
                    @include('modules.settings.commands.other_command')
                </div>
            </div>
        </div>
    </div
@endsection
@section('script')
    <script src="{{adminAsset('libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script>
        $('.check_system_settings').on('change',function (){
            const input_name = $(this).attr('name');
            const submit_url = "{{route('adminSettingsSave')}}";
            const option_group = "system_settings";
            const formData = new FormData();
            formData.append('option_type', 'text');
            formData.append('option_group', option_group);
            formData.append('option_key', input_name);
            if ($(this).prop('checked') == true){
                formData.append('option_value', "{{ACTIVE}}");
            }else {
                formData.append('option_value', "{{INACTIVE}}");
            }
            makeAjaxPostFile(formData,submit_url).done(function (response){
                if (response.success == true){
                   swalSuccess(response.message);
                }else{
                    swalError(response.message);
                }

            });
        });
    </script>

@endsection
