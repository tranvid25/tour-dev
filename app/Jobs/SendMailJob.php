<?php

namespace App\Jobs;

use App\Mail\SendOtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $mail_nguoi_nhan;
    public $ma_otp;
    public function __construct($mail_nguoi_nhan,$ma_otp)
    {
        $this->mail_nguoi_nhan=$mail_nguoi_nhan;
        $this->ma_otp=$ma_otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mail_nguoi_nhan)->send(new SendOtpMail($this->ma_otp));
    }
}
