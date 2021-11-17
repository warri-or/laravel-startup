<?php

namespace App\Http\Modules\Settings;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $settingService;

    public function __construct(SettingService $service){
        $this->settingService = $service;
    }
    public function siteSetting(){
        $data['settings'] = __options(['site_settings']);
        return view('modules.settings.site_setting',$data);
    }

    public function paymentSettings(){
        $data['settings'] = __options(['payment_settings']);
        return view('modules.settings.payment.payment_settings',$data);
    }
    public function coinPaymentSettings(){
        $data['settings'] = __options(['coin_payment_settings']);
        return view('modules.settings.payment.coin_payment_settings',$data);
    }

    public function logoSetting(){
        $data['settings'] = __options(['logo_settings']);
        return view('modules.settings.logo_setting',$data);
    }

    public function socialSetting(){
        $data['settings'] = __options(['social_settings']);
        return view('modules.settings.social_setting',$data);
    }

    public function applicationSetting(){
        $data['settings'] = __options(['application_settings']);
        return view('modules.settings.application_settings',$data);
    }

    public function languageSettings(){
        return view('modules.settings.language_settings');
    }

    public function socialLoginSettings(){
        $data['settings'] = __options(['social_login_settings']);
        return view('modules.settings.social_login_settings',$data);
    }

    public function emailSettings(){
        $data['settings'] = __options(['email_settings']);
        return view('modules.settings.email_settings',$data);
    }

    public function syncLanguageList(){
        return $this->settingService->syncLanguageList();
    }

    public function adminSettingsSave(Request $request){
        return $this->settingService->adminSettingsSave($request->all());
    }

    public function commandSettings(){
        $data['settings'] = __options(['system_settings']);
        return view('modules.settings.command_settings',$data);
    }

    public function runCommand(Request $request){
        return $this->settingService->runCommand($request->all());
    }

    public function createCommand(Request $request){
        return $this->settingService->createCommand($request->all());
    }

    public function commissionRateSettings(){
        $data['settings'] = __options(['commission_settings']);
        return view('modules.settings.set_commission',$data);
    }


    public function termsConditionSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('modules.settings.web_content.terms_condition_settings',$data);
    }
    public function privacyPolicySettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('modules.settings.web_content.privacy_policy_settings',$data);
    }
    public function faqsSettings(Request $request){
        if ($request->ajax()) {
            $data_list = Faq::all();
            return datatables($data_list)
                ->addColumn('move', function ($item) {
                    return '<img class="text-center" style="cursor:move" width="20px" src="' . adminAsset('images/move.svg') . '" alt="">';
                })
                ->editColumn('status',function ($item){
                    return $item->status == STATUS_ACTIVE ? '<span class="badge badge-success">'.__('Active').'</span>':'<span class="badge badge-warning">'.__('Inactive').'</span>';
                }) ->editColumn('action',function ($item){
                    $html = '<a href="javascript:void(0)" class="text-info p-1 edit_item" data-id="'.$item->id.'"><i class="fa fa-edit"></i></a>';
                    $html .='<a href="javascript:void(0)" class="text-danger p-1 delete_item" data-style="zoom-in" data-id="'.$item->id.'"><i class="fa fa-trash"></i></a>';
                    return $html;
                })->rawColumns(['move','status','action'])
                ->make(TRUE);
        }
        return view('modules.settings.faqs.faqs_settings');
    }
    public function aboutUsSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('modules.settings.web_content.about_us_settings',$data);
    }
    public function helpCenterSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('modules.settings.web_content.help_center_settings',$data);
    }
    public function whyChooseUsSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('modules.settings.web_content.why_choose_us_settings',$data);
    }

    public function getFaqItemById(Request $request){
        return Faq::where('id',$request->id)->first();
    }

    public function faqsSettingSave(Request $request){
        if (!empty($request->id)) {
            return $this->settingService->updateFaqs($request->id,$request->except('id'));
        }else{
            return $this->settingService->createFaqs($request->except('id'));
        }
    }

    public function deleteFaqsItem(Request $request){
        return $this->settingService->deleteFaqs($request->id);
    }

    public function order(Request $request){
        return $this->settingService->order($request->all());
    }

}
