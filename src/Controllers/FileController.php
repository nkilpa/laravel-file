<?php

namespace nikitakilpa\File\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use nikitakilpa\Core\Controllers\BaseController;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Facades\SystemJobFacade;

class FileController extends BaseController
{
    public function hello(): JsonResponse
    {
        return response()->json([
            'message' => 'hello',
        ]);
    }

    public function addJob(): JsonResponse
    {
        $dto = new SchedulerDto();
        $dto->action = 'TEXT_RANDOM';
        $dto->scheduled_at = '2022-03-09 09:00:00';
        $dto->params = ['text' => Str::random(10)];

        SystemJobFacade::scheduler('mongodb')->scheduled($dto);

        return response()->json([
            'status' => 'ok',
            'message' => 'Задача создана'
        ]);
    }

    public function addJobs(): JsonResponse
    {
        $dto1 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
        $dto1->action = 'TEXT_RANDOM';
        $dto1->scheduled_at = '2022-03-09 09:00:00';
        $dto1->params = ["text" => Str::random(10)];

        $dto2 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
        $dto2->action = 'NUMBER_RANDOM';
        $dto2->scheduled_at = '2022-03-09 09:00:00';
        $dto2->params = ["number" => rand(0, 100)];

        $items = [$dto1, $dto2];

        SystemJobFacade::scheduler('mongodb')->scheduledBatch($items);

        return response()->json([
            'status' => 'ok',
            'message' => 'Задачи созданы'
        ]);
    }
}