<?php

use App\Http\Boilerplate\CustomResponse;
use App\Models\Role\Role;
use App\Models\Role\RoleRoute;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/***********************************************************************************/
/***********************************************************************************/

function __options(array $option_group = ['application_settings'], string $option_key = NULL) {
    $option_value = \App\Models\Setting::select('option_key', 'option_value');
    if (is_null($option_key)) {
        $option_value->whereIn('option_group', $option_group);
        $options = $option_value->get();
        $result = [];
        if (!empty($options)) {
            foreach ($options as $data) {
                $result[$data->option_key] = $data->option_value;
            }
        }
        return (object)$result;
    } else {
        $option_value->value('option_value');
        $option_value->where('option_key', '=', $option_key);
        return !empty($option_value->first()) ? $option_value->first()->option_value : '';
    }
}
function __setOptions($option_group = '', $option_key = '', $option_value = '') {
    DB::table('sys_system_settings')
      ->updateOrInsert(
          ['option_group' => $option_group, 'option_key' => $option_key],
          ['option_value' => $option_value]
      );
}


function is_selected($key, $value): string {
    return $key === $value ? 'selected' : '';
}

function buildTree($elements, $parentId = 0, $branch = []): array {
    foreach ($elements as $element) {
        if ($element->parent_id == $parentId) {
            $children = buildTree($elements, $element->id);
            if ($children) {
                $element->children = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function generateParentTree($elements,$element_id, $branch = []): array {
    foreach ($elements as $element) {
        if ($element->id == $element_id) {
            $new_parent_id = $element->parent_id;
            if ($new_parent_id != 0) {
                $element->parent = generateParentTree($elements,$new_parent_id,$branch);
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function buildTreeForArray($elements=[], $parentId = 0, $branch = []): array {
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTreeForArray($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function language() {
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? FALSE : $lang;
}

function randomString($a, $only_number = FALSE) {
    $x = $only_number ? '0123456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

function randomNumber($a = 10) {
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}


function getNextPrimaryId($table_name) {
    $lastId = sprintf('%07d', 1);
    $item = DB::table($table_name)->orderBy('id', 'desc')->first();
    if (isset($item)) {
        $lastId = $item->id + $lastId;
    }
    return sprintf('%07d', $lastId);
}

/**
 * @param $text
 *
 * @return string
 */
function textSlugify($text): string {
    $text_array = explode(' ', $text);
    $slug = '';
    foreach ($text_array as $i => $split_text) {
        $slug = $slug . strtoupper(substr(trim($split_text), 0, 1));
    }
    return $slug;
}

/**
 * @param $code
 * @param null $index
 *
 * @return false|mixed|string|string[]
 */
function referenceCodeEdit($code, $index = NULL) {
    try {
        $code = explode('-', $code);
        return is_null($index) ? $code : $code[$index];
    } catch (\Exception $e) {
        return FALSE;
    }
}

/**
 * @param string $str
 *
 * @return string|string[]|null
 */
function create_slug($str = '') {
    $str = preg_replace('/\s\s+/', ' ', $str);
    $str = str_replace(' ', '-', $str);                // Replaces all spaces with hyphens.
    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str); // Removes special chars.
    $str = preg_replace('/-+/', '-', $str);
    $a = substr($str, -1);
    if ($a == '-') {
        $str = rtrim($str, '-');
        //$str = clean_fields($str);
    }
    return $str;
}

/**
 * @param string $str
 *
 * @return string|string[]|null
 */
function clean_reference($str = '') {
    $str = str_replace(' ', '', $str);                 // Replaces all spaces with hyphens.
    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str); // Removes special chars.
    return $str;
}

/**
 * @param bool $type
 *
 * @return CustomResponse
 */
function jsonResponse($type = TRUE) {
    return new CustomResponse($type);
}

function getResponseMessage(bool $type = FALSE, string $message = 'Something went wrong') {
    return [
        'success' => $type,
        'message' => $message,
        'data'    => []
    ];
}

function sendError($error, $errorMessages = [], $code = 404) {
    $response = [
        'success' => FALSE,
        'message' => $error,
    ];
    if (!empty($errorMessages)) {
        $response['data'] = $errorMessages;
    }
    return response()->json($response, $code);
}

function countUnreadNotification(){
    return \App\Models\Notification::where(['user_id'=>Auth::user()->id,'status'=>PROCESSING])->count();
}
