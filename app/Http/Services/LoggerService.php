<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;

class LoggerService
{
    protected $path;
    public function __construct($path=null)
    {
        if(is_null($path)) {
            $this->path = storage_logs().'default.log';
        } else {
            $this->path = $path;
        }
        if (!(File::exists($this->path))) {
            File::put($this->path, '');
        }
        //$this->path = is_null($path) ? env('DEFAULT_LOG_PATH') : $path;
    }

    public function log($type, $text = '', $timestamp = true)
    {
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $file = basename($caller['file']);
        $line = $caller['line'];

        if ($timestamp) {
            $datetime = date("Y-m-d H:i:s");
            $appEnv = config('app.env');
            $text = "[$datetime] $appEnv.DEBUG: $file:$line -> $type: $text \r\n\r";
        } else {
            $text = "$type\r\n\r";
        }
        error_log($text, 3, $this->path);
    }
}
