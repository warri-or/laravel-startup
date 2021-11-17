@if(check_module_permission(MODULE_SUPER_ADMIN)|| check_module_permission(MODULE_USER_ADMIN) || check_module_permission(MODULE_USER))
    <h5 class="menu-title"><i class="fas fa-boxes fa-2x"></i> {{__('Admin')}}</h5>
    <hr class="my-1">
    <ul class="nav flex-column">
        {!! menuLiAppend('categories', 'Categories', 'fa fa-box', $sub_menu, '') !!}
        {!! menuLiAppend('brands', __('Brands'), 'fas fa-store', $sub_menu, 'brands') !!}
        {!! menuLiAppend('messaging', __('Messaging'), 'fa fa-envelope', $sub_menu, 'messaging') !!}
        {!! menuLiAppend('messagingSog', __('Single or Group Chat'), 'fa fa-envelope', $sub_menu, 'messagingSog') !!}
    </ul>
@endif

