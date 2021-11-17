@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'aboutUsSettings'])
@section('style')
    <link href="{{adminAsset('libs/summernote/summernote-bs4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}" name="web_content_settings" novalidate class="web_content_settings_form" method="POST" id="web_content_settings_id" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group ">
                                <h4 class="card-title">{{__('About Us')}}</h4>
                                <textarea name="about_us" id="summernote-basic" class="about_us_class">{!! $settings->about_us ?? '' !!}</textarea>
                            </div>
                            <button type="button" class="btn btn-dark btn-rounded submit_settings" data-style="zoom-in"><i class="fa fa-save"></i> {{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div
@endsection
@section('script')
    <script src="{{adminAsset('libs/summernote/summernote-bs4.min.js')}}"></script>

    <script>
        $('#summernote-basic').summernote({
            placeholder: 'About us here.',
            tabsize: 2,
            height: 300
        });

        $(document).on('click','.submit_settings', function (e) {
            Ladda.bind(this);
            let load = $(this).ladda();
            let option_key = 'about_us';
            let option_value = $('.about_us_class').val();
            let submit_url = "{{route('adminSettingsSave')}}";
            let option_group = "web_content_settings";
            let formData = {
                option_type : 'text',
                option_group : option_group,
                option_key : option_key,
                option_value : option_value
            };
            makeAjaxPost(formData, submit_url, load).done(function (response) {
                load.ladda('stop');
                if (response.success == true){
                    swalSuccess(response.message)
                }else {
                    swalError(response.message);
                }
            });
        });

    </script>
@endsection
