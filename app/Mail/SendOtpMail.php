<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;
    public $otp;
    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
         $this->otp=$otp;
    }

    /**
     * Get the message envelope.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
      public function build()
    {
        return $this->subject('Mã OTP của bạn') // Tiêu đề email
                    ->view('clients.Email.otp') // View sẽ dùng để hiển thị nội dung email
                    ->with([
                        'otp' => $this->otp, // Truyền dữ liệu OTP vào view
                    ]);
    }
}
