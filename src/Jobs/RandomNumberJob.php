<?php

namespace nikitakilpa\File\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use nikitakilpa\SystemJob\Facades\SystemJobFacade;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Jobs\Job;
use nikitakilpa\SystemJob\Services\SystemJobService;

class RandomNumberJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobId = 0, string $driver = '', array $params = [])
    {
        parent::__construct($jobId, $driver, $params);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SystemJobFacade::manager($this->driver)->changeStatus($this->jobId, SystemJobStatus::QUEUED);

        $str = $this->params['number'] . "\n";
        $file = fopen("num.txt", 'a');
        $result = fwrite($file, $str);
        fclose($file);

        if ($result)
        {
            SystemJobFacade::manager($this->driver)->executed($this->jobId);
        }
        else
        {
            SystemJobFacade::manager($this->driver)->changeStatus($this->jobId, SystemJobStatus::FAILED);
        }

        SystemJobFacade::manager($this->driver)->incrementAttempt($this->jobId);
    }
}
