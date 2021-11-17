<?php

namespace App\Http\Controllers\Web\Admin\ActivityLog;

use Illuminate\Http\Request;
use AWT\Contracts\ApiLoggerInterface;
use App\Models\ApiLog;

class ApiLogController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ApiLoggerInterface $logger)
    {
        $allDatas = ApiLog::with('user')
            ->orderBy('created_at', 'DESC')
            ->paginate();

        return view('admin/api_logs/browse',compact('allDatas'));
    }

    /**
     * Delete all api_logs from DB
     *
     * @param ApiLoggerInterface $logger
     *
     * @return void
     */
    public function delete(ApiLoggerInterface $logger)
    {
        ApiLog::truncate();

        return redirect()->back();

    }
}
