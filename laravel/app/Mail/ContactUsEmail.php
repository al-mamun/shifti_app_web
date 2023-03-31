<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * @method static orderBy(string $string)
 * @method static findOrFail(mixed $input)
 */
class ContactUsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($data)
    {
       $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (array_key_exists( 'attachment', $this->data)) {
            if ($this->data['extension'] == 'pdf') {
               $mime = 'application/pdf';
            }else{
                $mime =' image/'.$this->data['extension'];
            }
            return $this->markdown('emails.contactUs.success')
                ->with($this->data)
                ->attach($this->data['attachment'],
                    [
                        'as' => 'orpon-bd-email-attachment.'.$this->data['extension'],
                        'mime' => $mime,
                    ]
                );
        }else{
            return $this->markdown('emails.contactUs.success')->with($this->data);
        }

    }
}
