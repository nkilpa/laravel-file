<?php

namespace nikitakilpa\SystemJob\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use nikitakilpa\SystemJob\Helpers\JobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;

class RandomNumberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $jobId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $jobId = 0)
    {
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $job = SystemJob::find($this->jobId);
        $job->status = JobStatus::QUEUED;
        $job->save();

        $str = rand(0, 100) . "\n";
        $file = fopen("num.txt", 'a');
        $result = fwrite($file, $str);
        fclose($file);

        if ($result)
        {
            $job->status = JobStatus::EXECUTED;
        }
        else
        {
            $job->status = JobStatus::FAILED;
        }

        $job->executed_at = date("Y-m-d H:i:s");
        $job->attempts++;
        $job->save();
    }
}
