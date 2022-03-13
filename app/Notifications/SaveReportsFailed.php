<?php

namespace App\Notifications;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SaveReportsFailed extends Notification
{
    use Queueable;

    private Batch $batch;

    /**
     * @return void
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Ocorreu uma falha ao salvar os prontuários')
            ->greeting('')
            ->line(sprintf('Batch ID: %s', $this->batch->id));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }
}
