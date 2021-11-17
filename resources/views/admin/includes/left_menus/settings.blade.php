<h5 class="menu-title"><i class="fa fa-cogs fa-2x"></i> {{__('Settings')}}</h5>
<hr class="my-1">
<ul class="nav flex-column">
    {!! menuLiAppend('profile', 'Profile Settings', 'fa fa-user') !!}
    {!! menuLiAppend('paymentOption', 'Payment Option', 'fa fa-money-bill-wave', $sub_menu, 'paymentOption') !!}
    @if(check_module_permission(MODULE_SUPER_ADMIN)|| check_module_permission(MODULE_USER_ADMIN))
    <li class="nav-item">
        <a href="#general-settings @if(!empty($sub_menu) && in_array($sub_menu,['siteSettings','logoSettings','applicationSetting','socialSettings'])) show @endif" data-toggle="collapse" class="nav-link">
            <span><i class="fa fa-cog"></i>  {{__('General Settings')}} </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="general-settings">
            <ul class="nav-second-level">
                {{-- route_name -- menu_title -- icon_class -- $sub_menu(key to check) -- submenu_to_compare --}}
                {!! menuLiAppend('applicationSetting', 'Application Settings', 'fa fa-link', $sub_menu,'applicationSetting') !!}
                {!! menuLiAppend('siteSetting', 'Site Settings', 'fa fa-globe', $sub_menu) !!}
                {!! menuLiAppend('logoSetting', 'Logo Settings', 'fab fa-react', $sub_menu) !!}
                {!! menuLiAppend('socialSetting', 'Social Settings', 'fa fa-link', $sub_menu, 'socialSettings') !!}
            </ul>
        </div>
    </li>
    {!! menuLiAppend('commandSettings', 'System Settings', 'fa fa-terminal', $sub_menu, 'command_setting') !!}
    {!! menuLiAppend('languageSettings', 'Language Settings', 'fa fa-cogs', $sub_menu, 'language_setting') !!}
    {!! menuLiAppend('socialLoginSettings', 'Social Login Settings', 'fa fa-cogs', $sub_menu, 'social_login_setting') !!}
    {!! menuLiAppend('emailSettings', 'Email Settings', 'fa fa-envelope') !!}
    {!! menuLiAppend('paymentSettings', __('Payment Settings'), 'fa fa-credit-card') !!}
    {!! menuLiAppend('#', 'SMS Settings', 'fa fa-paper-plane') !!}
    <li class="nav-item">
        <a href="#web-contents" data-toggle="collapse" class="nav-link">
            <span><i class="fa fa-file"></i>  {{__('Web Contents')}} </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="web-contents">
            <ul class="nav-second-level">
                {!! menuLiAppend('termsConditionSettings', __('Terms & Condition'), 'fa fa-file', $sub_menu, 'termsConditionSettings') !!}
                {!! menuLiAppend('privacyPolicySettings', __('Privacy Policy'), 'fa fa-file',$sub_menu, 'privacyPolicySettings') !!}
                {!! menuLiAppend('faqsSettings', __('FAQs'), 'fa fa-file',$sub_menu, 'faqsSettings') !!}
                {!! menuLiAppend('aboutUsSettings', __('About Us'), 'fa fa-file',$sub_menu, 'aboutUsSettings') !!}
                {!! menuLiAppend('helpCenterSettings', __('Help Center'), 'fa fa-file',$sub_menu, 'helpCenterSettings') !!}
                {!! menuLiAppend('whyChooseUsSettings', __('Why Choose Us'), 'fa fa-file',$sub_menu, 'whyChooseUsSettings') !!}
            </ul>
        </div>
    </li>
    @endif
</ul>
