<?php

namespace App\Http\Services;

use App\Http\Repositories\ActivityLogRepository;

class ActivityLogService extends BaseService
{

    /**
     * ActivityLogService constructor.
     *
     * @param ActivityLogRepository $activityLogRepository
     */
    public function __construct(ActivityLogRepository $activityLogRepository)
    {
        $this->repo = $activityLogRepository;
    }

    /**
     * @param mixed $columnToSort
     * @param mixed $orderBy
     *
     * @return [type]
     */
    public function browse($columnToSort, $orderBy)
    {
        return $this->repo->getActivityLogs($columnToSort, $orderBy);
    }

    /**
     * @param mixed $columnToSort
     * @param mixed $orderBy
     * @param mixed $query
     *
     * @return [type]
     */
    public function search($columnToSort, $orderBy, $query)
    {
        return $this->repo->searchActivityLogs($columnToSort, $orderBy, $query);
    }


}
