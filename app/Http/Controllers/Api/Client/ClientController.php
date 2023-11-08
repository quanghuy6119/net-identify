<?php

namespace App\Http\Controllers\Api\Client;

use App\Services\Contracts\DailyReportServiceInterface;
use App\Services\Contracts\PeriodReportServiceInterface;
use Illuminate\Http\Request;

use App\Services\Contracts\UserServiceInterface;

class ClientController
{
    protected UserServiceInterface $userService;
    protected PeriodReportServiceInterface $periodReportService;
    protected DailyReportServiceInterface $dailyReportService;

    public function __construct(PeriodReportServiceInterface $periodReportService, DailyReportServiceInterface $dailyReportService)
    {
        $this->periodReportService = $periodReportService;
        $this->dailyReportService = $dailyReportService;
    }

    public function getPeriodByCodeLink(Request $request){
        $attributes = $request->all();
        return $this->periodReportService->getByCodeLink($attributes);
    }

    public function getDailyByCodeLink(Request $request){
        $attributes = $request->all();
        $id = $attributes['id'];
        return $this->dailyReportService->getByCodeLink($id, $attributes);
    }
}