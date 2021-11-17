<script src="{{adminAsset('vendors/jQuery.min.js')}}"></script>
<script src="{{adminAsset('vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{adminAsset('vendors/wave.min.js')}}"></script>
<script src="{{adminAsset('vendors/simplebar.min.js')}}"></script>

<!-- Other Plugins -->

<script src="{{adminAsset('libs/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{adminAsset('libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{adminAsset('libs/dropify/js/dropify.min.js')}}"></script>
<script src="{{adminAsset('libs/tippy.js/tippy.all.min.js')}}"></script>


<!-- Init js-->
<script src="{{adminAsset('js/pages/form-fileuploads.init.js')}}"></script>
<script src="{{adminAsset('vendors/ladda/spin.min.js')}}"></script>
<script src="{{adminAsset('vendors/ladda/ladda.min.js')}}"></script>
<script src="{{adminAsset('vendors/ladda/ladda.jquery.min.js')}}"></script>

<script src="{{adminAsset('js/left_side_bar.js')}}"></script>
<script src="{{adminAsset('js/top_bar.js')}}"></script>
<script src="{{adminAsset('js/right_bar.js')}}"></script>
<script src="{{adminAsset('js/theme_manager.js')}}"></script>


<script src="{{adminAsset('js/LaraframeScript.js')}}"></script>
<script src="{{adminAsset('js/crud.js')}}"></script>
<script src="{{adminAsset('libs/toastr/build/toastr.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="{{adminAsset('vendors/DataTables/js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    @if(Session::has('dismiss') && !empty(Session::get('dismiss')))
        Toast.fire({type: 'warning', text: '{{Session::get('dismiss')}}'});
    @endif
    @if(Session::has('success') && !empty(Session::get('success')))
        Toast.fire({type: 'success', text: '{{Session::get('success')}}'});
    @endif
</script>

@yield('script')
<script src="{{adminAsset('js/pages/form-advanced.init.js')}}"></script>
<!-- App js -->
<script src="{{adminAsset('js/app.js')}}"></script>
