<?php

namespace nikitakilpa\File\Jobs;

use nikitakilpa\SystemJob\Facades\SystemJobFacade;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Jobs\Job;

class RandomTextJob extends Job
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

        $str = $this->params["text"] . "\n";
        $file = fopen("text.txt", 'a');
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
