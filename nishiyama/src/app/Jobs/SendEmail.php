<?php

namespace App\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $template_id;
    protected $toEmailIdsArray;
    protected $emailBodyArray;
    protected $ccEmailIds;
    protected $attachment;

    public function __construct($template_id, $toEmailIdsArray, $emailBodyArray, $ccEmailIds = null, $attachment = null)
    {
        $this->template_id = $template_id;
        $this->toEmailIdsArray = $toEmailIdsArray;
        $this->emailBodyArray = $emailBodyArray;
        $this->ccEmailIds = $ccEmailIds;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new Controller())->sendSendgridMail($this->template_id, $this->toEmailIdsArray, $this->emailBodyArray, $this->ccEmailIds, $this->attachment);
    }
}
