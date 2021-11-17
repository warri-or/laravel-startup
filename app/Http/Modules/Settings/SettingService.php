<?php

namespace App\Http\Modules\Settings;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    // Your methods for repository

    public function adminSettingsSave(array $requestArray){
        try {
            $setting = FALSE;
            if ($requestArray['option_type'] == 'text'){
                $setting = $this->insert_or_update($requestArray['option_group'],$requestArray['option_key'],$requestArray['option_value']);
            }elseif($requestArray['option_type'] == 'file'){
                $check_logo = Setting::where(['option_key'=>$requestArray['option_key'],'option_group'=>$requestArray['option_group']])->first();
                $option_value = uploadImage($requestArray['option_value'],get_image_path('settings'),$check_logo->option_value ?? '');
                $setting = $this->insert_or_update($requestArray['option_group'],$requestArray['option_key'],$option_value);
            }
            if ($setting){
                return jsonResponse(true)->message(__("Setting saved successfully."));
            }
            return jsonResponse(FALSE)->message(__("Setting saved failed."));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message(__("Setting saved failed."));
        }

    }


    private function insert_or_update($option_group,$option_key,$option_value){
        return Setting::updateOrCreate(['option_group'=>$option_group,'option_key'=>$option_key], ['option_group'=>$option_group,'option_key'=>$option_key,'option_value'=>$option_value]);
    }

    public function syncLanguageList(){
        try {
            $directory = 'lang/';
            $files = Storage::disk('resource')->listContents($directory);
            $languages = [];
            foreach ($files as $file){
                if ($file['type'] == 'file'){
                    array_push($languages,$file['filename']);
                }
            }
            Storage::disk('public')->put('languages.json',json_encode($languages));
            return jsonResponse(TRUE)->message(__('Languages synced successfully.'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }

    public function runCommand($requestArray){
        try {
            Artisan::call($requestArray['type']);
            $message = Artisan::output();
            return jsonResponse(true)->message($message);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }

    public function createCommand($requestArray){
        try {
            Artisan::call($requestArray['type']);
            $message = Artisan::output();
            return jsonResponse(true)->message($message);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }

    public function updateFaqs($id,array $requestArray){
        try {
            Faq::where('id',$id)->update($requestArray);
            return jsonResponse(TRUE)->message(__('Faqs updated successfully.'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message(__('Faqs update failed.'));
        }

    }

    public function createFaqs(array $requestArray){
        try {
            Faq::create($requestArray);
            return jsonResponse(TRUE)->message(__('Faqs created successfully.'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message(__('Faqs create failed.'));
        }
    }

    public function deleteFaqs($id){
        try {
            Faq::where('id',$id)->delete();
            return jsonResponse(TRUE)->message(__('Faqs deleted successfully.'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message(__('Faqs delete failed.'));
        }
    }

    public function order(array $requestArray){
        try {
            $column = 'order';
            if (!empty($requestArray['column']))
                $column = $requestArray['column'];

            $order = array_filter(explode(',', $requestArray['ids']));

            if (is_array($order)) {
                foreach ($order as $key => $item) {
                    DB::table($requestArray['table'])->where(['id' => $item])->update([$column => $key]);
                }
            }
            return jsonResponse(TRUE)->message(__('Order updated successfully.'));
        } catch (\Exception $exception) {
            return jsonResponse(TRUE)->default();
        }
    }
}
