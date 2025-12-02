<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar; // Impor model Pendaftar

class PendaftaranStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;
    public $statusBaru;
    public $subjectEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Pendaftar $pendaftar, string $statusBaru)
    {
        $this->pendaftar = $pendaftar;
        $this->statusBaru = $statusBaru;

        // Tentukan subjek email berdasarkan status
        if ($this->statusBaru === 'diterima') {
            $this->subjectEmail = 'Selamat! Pendaftaran PPDB Anda Diterima!';
        } elseif ($this->statusBaru === 'ditolak') {
            $this->subjectEmail = 'Pemberitahuan: Status Pendaftaran PPDB Anda';
        } else {
            $this->subjectEmail = 'Pembaruan Status Pendaftaran PPDB Anda';
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectEmail, // Menggunakan subjek dinamis
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran_status', // Menggunakan view Blade yang akan kita buat
            with: [ // Data yang akan tersedia di view email
                'namaPendaftar' => $this->pendaftar->nama_lengkap,
                'nisnPendaftar' => $this->pendaftar->nisn,
                'statusFinal' => $this->statusBaru,
                'linkLogin' => route('login'), // Link ke halaman login aplikasi Anda
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Tidak ada attachment untuk email ini
    }
}