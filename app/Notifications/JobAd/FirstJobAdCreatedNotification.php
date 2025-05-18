<?php

namespace App\Notifications\JobAd;

use App\Actions\JobAd\GetJobAdById;
use App\Actions\User\GetUserById;
use App\Models\JobAd;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class FirstJobAdCreatedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private User $employer, private JobAd $job) {}

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(
        object $notifiable,
        GetUserById $getUser,
        GetJobAdById $getJob
    ): BroadcastMessage {
        return new BroadcastMessage([
            'employer' => $getUser->handle($this->employer->id),
            'job' => $getJob->handle($this->job->id),
        ]);
    }

    public function toBroadcastType(): string
    {
        return 'first-job-created';
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'employer_id' => $this->employer->id,
            'job_id' => $this->job->id,
        ];
    }

    public function toDatabaseType(): string
    {
        return 'first-job-created';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'employer_id' => $this->employer->id,
            'job_id' => $this->job->id,
        ];
    }
}
