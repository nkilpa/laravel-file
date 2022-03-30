<?php

namespace nikitakilpa\File\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NeedleProject\LaravelRabbitMq\PublisherInterface;
use nikitakilpa\Core\Controllers\BaseController;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Facades\SystemJobFacade;

class FileController extends BaseController
{
    //private string $driver = 'mongodb';

    public function hello(): JsonResponse
    {
        return response()->json([
            'message' => 'hello, file',
        ]);
    }

    public function addJob(Request $request): JsonResponse
    {
        $driver = config('schedule.default');
        if (!is_null($request->input('driver')))
        {
            $driver = $request->input('driver');
        }

        $dto = new SchedulerDto();
        $dto->action = 'TEXT_RANDOM';
        $dto->scheduled_at = '2022-03-09 09:00:00';
        $dto->params = ['text' => Str::random(10)];

        $result = SystemJobFacade::scheduler($driver)->scheduled($dto);

        if ($result)
        {
            return response()->json([
                'status' => 'ok',
                'message' => 'Задача создана'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Задача не создана'
        ]);
    }

    public function addJobs(Request $request): JsonResponse
    {
        $driver = config('schedule.default');
        if (!is_null($request->input('driver')))
        {
            $driver = $request->input('driver');
        }

        $dto1 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
        $dto1->action = 'TEXT_RANDOM';
        $dto1->scheduled_at = '2022-03-09 09:00:00';
        $dto1->params = ["text" => Str::random(10)];

        $dto2 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
        $dto2->action = 'NUMBER_RANDOM';
        $dto2->scheduled_at = '2022-03-09 09:00:00';
        $dto2->params = ["number" => rand(0, 100)];

        $items = [$dto1, $dto2];

        $result = SystemJobFacade::scheduler($driver)->scheduledBatch($items);

        if ($result)
        {
            return response()->json([
                'status' => 'ok',
                'message' => 'Задачи созданы'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Задачи не созданы'
        ]);
    }

    public function addMessage(Request $request): JsonResponse
    {
        $driver = config('schedule.default');
        if (!is_null($request->input('driver')))
        {
            $driver = $request->input('driver');
        }

        $dto = new SchedulerDto();
        $dto->action = 'PUBLISH_MESSAGE';
        $dto->scheduled_at = '2020-01-01 00:00:00';

        $result = SystemJobFacade::scheduler($driver)->scheduled($dto);

        if ($result)
        {
            return response()->json([
                'status' => 'ok',
                'message' => 'Задача создана'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Задача не создана'
        ]);
    }
}