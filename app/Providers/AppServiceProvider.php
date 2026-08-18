<?php

namespace App\Providers;

use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\ClassroomComment;
use App\Models\ClassroomPost;
use App\Models\ClassroomQuiz;
use App\Models\User;
use App\Policies\ClassroomAssignmentPolicy;
use App\Policies\ClassroomCommentPolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\ClassroomPostPolicy;
use App\Policies\ClassroomQuizPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $policies = [
        Classroom::class           => ClassroomPolicy::class,
        ClassroomPost::class       => ClassroomPostPolicy::class,
        ClassroomAssignment::class => ClassroomAssignmentPolicy::class,
        ClassroomQuiz::class       => ClassroomQuizPolicy::class,
        ClassroomComment::class    => ClassroomCommentPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // 1. Register Model Policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // 2. Global Role Gates
        Gate::define('admin', fn(User $user) => $user->isAdmin());
        Gate::define('teacher', fn(User $user) => $user->isTeacher() || $user->isAdmin());
        Gate::define('student', fn(User $user) => $user->isStudent());

        // 3. Contextual Gates
        Gate::define('access-classroom', function (User $user, Classroom $classroom) {
            return Gate::allows('view', $classroom);
        });

        Gate::define('manage-classroom', function (User $user, Classroom $classroom) {
            return $user->isAdmin() || $classroom->teacher_id === $user->id;
        });

        Gate::define('access-calendar', function (User $user) {
            return $user->status === 'active' || $user->status === null;
        });
    }
}
