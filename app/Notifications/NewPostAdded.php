<?php

namespace App\Notifications;

use App\Entities\Heading;
use App\Entities\Post;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostAdded extends Notification
{
    protected $post;
    protected $heading;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Heading $heading, Post $post)
    {
        $this->post = $post;
        $this->heading = $heading;
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
        return (new MailMessage)
                    ->line($this->heading->title)
                    ->line($this->post->author->name . ' added new post')
                    ->line($this->post->text);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
