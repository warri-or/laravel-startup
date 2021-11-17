@extends('admin.layouts.app')
@section('content')
    <div class="col-md-4 text-center">
        <div class="card-box">
            <button class="btn btn-primary" id="sync_language"><i class="fa fa-sync"></i> {{__('Sync Languages')}}</button>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="card-box">
            <a href="{{url('languages')}}" class="btn btn-success" target="_blank"><i class="fa fa-plus"></i> {{__('Add Language')}}</a>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).on('click','#sync_language',function (){
        Ladda.bind(this);
        const load = $(this).ladda();
        swalConfirm("Do you really want to run this ?").then(function (s) {
            if(s.value){
                makeAjax("{{route('syncLanguageList')}}",load).done(function (response){
                    if (response.success == true){
                        swalSuccess(response.message);
                    }else {
                        swalError(response.message);
                    }
                })
            }else{
                load.ladda('stop');
            }
        })
    })
</script>
@endsection
