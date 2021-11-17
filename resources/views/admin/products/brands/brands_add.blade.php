<div class="card">
    <div class="card-body ajax-load">
        <h4 class="card-title">{{__('Brand  Add/Edit')}}</h4>
        <form class="brands-form" novalidate method="post" action="{{route('saveBrand')}}" id="brand_form">
            <div class="form-group mb-2">
                <label for="name">{{__('Name')}}</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="{{__('Name')}}" value="{{$brand->name ?? ''}}" required>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-2">
                <label class="col-form-label" for="icon">{{__('Icon')}}</label>
                <input type="file" name="icon" id="icon" class="dropify" data-allowed-file-extensions="png jpg jpeg jfif" data-max-file-size="1M"
                       data-default-file="{{isset($brand->icon) ? asset(get_image_path('brand').'/'.$brand->icon) : ''}}"/>
            </div>

            <div class="form-group mb-2">
                <label>{{__('Status')}}</label>
                <select class="form-control" name="status" required>
                    <option value="">{{__('Select')}}</option>
                    <option value="{{ACTIVE}}" {{is_selected(ACTIVE,$brand->status ?? '')}}>{{__('Active')}}</option>
                    <option value="{{INACTIVE}}" {{is_selected(INACTIVE,$brand->status ?? '')}}>{{__('Inactive')}}</option>
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <input type="hidden" name="id" value="{{$brand->id ?? ''}}" id="id">
            <button class="btn btn-dark waves-effect waves-light submit_basic" data-style="zoom-in" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
            <button class="btn btn-outline-secondary waves-effect waves-light reset_from float-right" type="button" onclick="reset_form(true,function (){ $('input:checkbox').removeAttr('checked') })"><i class="fas fa-sync-alt"></i> {{__('Reset')}}</button>

        </form>
    </div>
</div>

<script>
    $(document).ready(function (){
        resetValidation('brands-form');
    });
</script>
