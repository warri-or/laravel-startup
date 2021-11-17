<?php

namespace App\Http\Services;

use Symfony\Component\Process\Process;

class RunEnvoyCommand
{
    public static function run()
    {
        $command = [base_path().'/vendor/bin/envoy run update-deploy'];
        $result = [];
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->setIdleTimeout(300);
        $process->setWorkingDirectory(base_path());
        $process->run( function ($type, $buffer) use(&$result) {
            $buffer = str_replace('[127.0.0.1]: ', '', $buffer);
            $result[] = $buffer;
        });
        return $result;
    }
}
