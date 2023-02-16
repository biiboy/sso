<?php

namespace App\Jobs;

use App\Mail\KpiMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 20;

    public $email;
    public $view;
    public $subject;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $view, $subject, $data)
    {
        $this->email = $email;
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new KpiMail($this->view, $this->subject, $this->data);
        Mail::to($this->email)->send($mail);
    }
}
