<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Tache;

class TacheAssigneeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    // Canaux de notification (e-mail et temps réel)
    public function via($notifiable)
    {
        return ['mail', 'database']; // Mail pour l'e-mail, database pour le stockage, broadcast pour Echo
    }

    // Notification par e-mail
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle tâche assignée')
            ->line("Une nouvelle tâche vous a été assignée : {$this->task->titre}")
            ->action('Voir la tâche', url('/tasks/' . $this->task->id))
            ->line('Merci de la traiter dès que possible.');
    }

    // Notification en base de données
    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => "Nouvelle tâche : {$this->task->titre}",
            'message' => "Une nouvelle tâche vous a été assignée.",
            'url' => url('/tasks/' . $this->task->id),
        ];
    }

    // Notification en temps réel avec Laravel Echo
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'title' => "Nouvelle tâche : {$this->task->titre}",
            'message' => "Une nouvelle tâche vous a été assignée.",
            'url' => url('/tasks/' . $this->task->id),
        ]);
    }
}
