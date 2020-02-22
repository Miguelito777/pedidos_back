<?php
    namespace App;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Contracts\Queue\ShouldQueue;
    class TestMail extends Mailable
    {
        use Queueable, SerializesModels;
        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }
        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this
                    ->from('initwebapps@gmail.com') // Sender mail
                    ->subject('Test Subject') // Mail subject
                    ->view('mail.index') // View file resource/views/mail/index
                    ; 
        }
    }