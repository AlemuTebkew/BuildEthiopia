<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();
        // ResetPassword::createUrlUsing(function ($user, string $token) {
        //     return 'https://example.com/reset-password?token='.$token;
        // });
        // VerifyEmail::createUrlUsing(function ($notifiable) {
        //     $frontendUrl = env('FRONTEND_URL');

        //     $verifyUrl = URL::temporarySignedRoute(
        //         'verification.verify',
        //         Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //         [
        //             'id' => $notifiable->getKey(),
        //             'hash' => sha1($notifiable->getEmailForVerification()),
        //         ]
        //     );

        //     return $frontendUrl . '?verify_url=' . urlencode($verifyUrl);
        // });

        VerifyEmail::toMailUsing(function ($notifiable) {
            $frontendUrl = env('FRONTEND_URL');

            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ],false
            );

          //  $url= $frontendUrl . '/email-verification?verify_url=' . urlencode($verifyUrl);
          $url='http://10.161.178.167:80'.$verifyUrl;
          return (new MailMessage)
            ->subject('BuildGeneration : Email Verification')
            ->line('To validate your email click on the button below.')
            ->action('Verify Email Address', $url)
            ->line('Thank you for using our application!');
        });
    }
}
