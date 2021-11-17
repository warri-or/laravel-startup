<h5 class="menu-title"><i class="fas fa-users fa-2x"></i> {{__('Users')}}</h5>
<hr class="my-1">
<ul class="nav flex-column">
    {!! menuLiAppend('users', 'Admin Users', 'fas fa-user-tie', $sub_menu) !!}
    {!! menuLiAppend('roles', 'Roles + Permission', 'fa fa-user-secret', $sub_menu) !!}
</ul>
