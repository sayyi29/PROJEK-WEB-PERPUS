<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookAvailableNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $book;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Construct a relevant URL, e.g., to the book's detail page or a notification page
        // For now, let's link to the book's detail page.
        $bookUrl = route('books.show', $this->book->id);

        return (new MailMessage)
                    ->subject('Buku Telah Tersedia: ' . $this->book->title)
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Buku yang Anda reservasi, "' . $this->book->title . '", kini telah tersedia untuk dipinjam.')
                    ->action('Lihat Detail Buku', $bookUrl)
                    ->line('Silakan segera ambil di perpustakaan.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'greeting' => 'Halo ' . $notifiable->name . ',',
            'body' => 'Buku yang Anda reservasi, "' . $this->book->title . '", kini telah tersedia untuk dipinjam.',
            'action_url' => route('books.show', $this->book->id),
            'thanks' => 'Silakan segera ambil di perpustakaan.',
        ];
    }
}
