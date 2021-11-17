<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Services\SettingService;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    private $settingService;

    public function __construct(SettingService $service){
        $this->settingService = $service;
    }
    public function siteSetting(){
        $data['settings'] = __options(['site_settings']);
        return view('admin.settings.site_setting',$data);
    }

    public function paymentSettings(){
        $data['settings'] = __options(['payment_settings']);
        return view('admin.settings.payment.payment_settings',$data);
    }
    public function coinPaymentSettings(){
        $data['settings'] = __options(['coin_payment_settings']);
        return view('admin.settings.payment.coin_payment_settings',$data);
    }

    public function logoSetting(){
        $data['settings'] = __options(['logo_settings']);
        return view('admin.settings.logo_setting',$data);
    }

    public function socialSetting(){
        $data['settings'] = __options(['social_settings']);
        return view('admin.settings.social_setting',$data);
    }

    public function applicationSetting(){
        $data['settings'] = __options(['application_settings']);
        return view('admin.settings.application_settings',$data);
    }

    public function adminSettingsSave(Request $request){
        return $this->settingService->adminSettingsSave($request->all());
    }
    public function paymentSettingSave(Request $request){
        return $this->settingService->paymentSettingSave($request->all());
    }

    public function commandSettings(){
        return view('admin.settings.command_settings');
    }

    public function runCommand(Request $request){
       return $this->settingService->runCommand($request->all());
    }

    public function createCommand(Request $request){
        return $this->settingService->createCommand($request->all());
    }

    public function commissionRateSettings(){
        $data['settings'] = __options(['commission_settings']);
        return view('admin.settings.set_commission',$data);
    }


    public function termsConditionSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('admin.settings.web_content.terms_condition_settings',$data);
    }
    public function privacyPolicySettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('admin.settings.web_content.privacy_policy_settings',$data);
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
        return view('admin.settings.faqs.faqs_settings');
    }
    public function aboutUsSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('admin.settings.web_content.about_us_settings',$data);
    }
    public function helpCenterSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('admin.settings.web_content.help_center_settings',$data);
    }
    public function whyChooseUsSettings(){
        $data['settings'] = __options(['web_content_settings']);
        return view('admin.settings.web_content.why_choose_us_settings',$data);
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
