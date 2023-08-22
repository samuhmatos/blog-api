<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\User;
use App\Policies\PostCommentPolicy;
use App\Policies\PostCommentReactionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        PostComment::class => PostCommentPolicy::class,
        PostCommentReaction::class => PostCommentReactionPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define('is_admin', function (){
            return Auth::user()->is_admin;
        });
    }
}
