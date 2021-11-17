<?php

namespace App\Http\Controllers\Web\Admin\ActivityLog;

use App\Http\Services\ActivityLogService;

class ActivityLogController
{
    protected $activityLogService;

    /**
     * ActivityLogController constructor.
     * @param ActivityLogService $activityLogService
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Browse resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function browse()
    {
        $allDatas = $this->activityLogService->browse('id', 'DESC');

        return view('admin/activity_logs/browse', compact('allDatas'));
    }

    /**
     * Search resources in Browse Page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $query = request('search');

        $allDatas = $this->activityLogService->search('id', 'DESC', $query);

        return view('admin/activity_logs/browse', compact('allDatas'));
    }
}
