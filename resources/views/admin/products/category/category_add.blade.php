<div class="card">
    <div class="card-body ajax-load">
        <h4 class="card-title">{{__('Product Category Add/Edit')}}</h4>
        <div class="language-selector">
            @php
                $locales = json_decode(Storage::disk('public')->get('languages.json'));
            @endphp
            <div class="btn-group btn-group-sm" role="group" data-toggle="buttons">
                @foreach ($locales as $index => $locale)
                    <label class="btn {{ $index == 0 ? 'active btn-primary' : 'btn-secondary' }}  {{ !isset($category) ? ( $index != 0 ? 'd-none' : '' ) : ''}}  language-btn-label" >
                        <input type="radio" class="selected_language" name="i18n_selector" id="{{$locale}}" autocomplete="off" {{ $index == 0 ? 'checked' : '' }}> <span class="text-uppercase">{{$locale}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <form class="category-form" novalidate method="post" action="{{route('saveCategory')}}" id="category_form">
            <div class="form-group mb-2">

                @foreach ($locales as $index => $locale)
                    <div class="language_class {{ $index != 0 ? 'd-none' : '' }}" id="name{{$locale}}" data-type="{{$locale}}">
                        <label for="name">{{__('Category Name')}} ({{$locale}}) @if($index == 0) <span class="text-danger">*</span> @endif</label>
                        <input type="text" class="form-control" id="{{ $index == 0 ? 'name' : '' }}" name="name[{{$locale}}]"  placeholder="Category" value="{{$category->translations['name'][$locale] ?? ''}}" {{ $index == 0 ? 'required' : '' }}>
                    </div>
                @endforeach
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="slug">{{__('Slug')}}</label>
                <input type="text" class="form-control check_slug_validity" data-slugforid="name" data-exceptvalueid="id" data-slugvalidateurl="{{route('categorySlugCheck')}}" name="slug" id="slug" value="{{$category->slug ?? ''}}" required>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-2">
                <label class="col-form-label" for="icon">{{__('Icon')}}</label>
                <input type="file" name="icon" id="icon" class="dropify"
                       data-default-file="{{isset($category->icon) ? asset(get_image_path('category').'/'.$category->icon) : ''}}"
                       data-allowed-file-extensions="png jpg jpeg jfif" />
            </div>
            <div class="form-group mb-3">
                <label>{{__('Status')}}</label>
                <select class="form-control" name="status" required>
                    <option value="">{{__('Select')}}</option>
                    <option value="{{ACTIVE}}" {{is_selected(ACTIVE,$category->status ?? '')}}>{{__('Active')}}</option>
                    <option value="{{INACTIVE}}" {{is_selected(INACTIVE,$category->status ?? '')}}>{{__('Inactive')}}</option>
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="{{$category->id ?? ''}}">
            <button class="btn btn-dark waves-effect waves-light category_submit" data-style="zoom-in" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
            <button class="btn btn-outline-secondary waves-effect waves-light reset_from float-right" type="button" onclick="reset_form(true,function (){})"><i class="fas fa-sync-alt"></i> {{__('Reset')}}</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function (){
        resetValidation('category-form');
        checkSlugVlaidity();
        addLanguage('#name');
    });


</script>

