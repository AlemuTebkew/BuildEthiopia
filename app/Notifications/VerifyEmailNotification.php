<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $params=[
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
         ];

         $url=env('FRONTEND_URL').'/verify?';
         foreach($params as $key=>$param){
            $url.="{$key}={$param}&";
         }

        return (new MailMessage)
                    ->line('Verify Your Email Please!!!!!.')
                    ->action('Notification Action', $url)
                    // ->action('Notification Action', $this->verificationUrl($notifiable))
                    ->line('Thank you for using our application!');
    }

    protected function verificationUrl($notifiable){
        // if (static::$createUrlCallback) {
        //     return call_user_func(static::$createUrlCallback, $notifiable);
        // }
        $prefix = config('frontend.url') . config('frontend.email_verify_url');
         $temporarySignedURL= URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

             // I use urlencode to pass a link to my frontend.
            //  return $prefix . urlencode($temporarySignedURL);
             return $prefix.urlencode($temporarySignedURL);


            //  $params=[
            //     'id' => $notifiable->getKey(),
            //     'hash' => sha1($notifiable->getEmailForVerification()),
            //  ];

            //  $url=env('FRONTEND_URL'.'/verify?');
            //  foreach($params as $key=>$param){
            //     $url.="{$key}={$param}&";
            //  }

    }

}
