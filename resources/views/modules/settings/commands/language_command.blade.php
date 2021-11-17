<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('Add a new language')}}</h4>
                <p class="copy-text">php artisan translation:add-language</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('Add a new language key')}}</h4>
                <p class="copy-text">php artisan translation:add-translation-key</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('List all of the available languages')}}</h4>
                <p class="copy-text">php artisan translation:list-languages</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('List all of missing translation key')}}</h4>
                <p class="copy-text">php artisan translation:list-languages</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('List all of the available languages')}}</h4>
                <p class="copy-text">php artisan translation:list-languages</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('List all of the missing keys')}}</h4>
                <p class="copy-text">php artisan translation:list-missing-translation-keys</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('Sync translation key')}}</h4>
                <p class="copy-text">php artisan translation:sync-translations</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-copy"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{__('Sync missing translation key')}}</h4>
                <p class="copy-text">php artisan translation:sync-missing-translation-keys</p>
                <button type="submit" class="btn btn-sm btn-primary text-light copy"><i class="fa fa-check"></i> {{__('Copy')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.copy',function (){
        copyToClipboard($(this).siblings('.copy-text'));
        $('.copy').removeClass('btn-success').addClass('btn-primary');
        $('.copy').html('<i class="fa fa-copy"></i> {{__('Copy')}}');
        $(this).addClass('btn-success').removeClass('btn-primary');
        $(this).html('<i class="fa fa-check"></i> {{__('Coppied')}}');
    })
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

</script>
