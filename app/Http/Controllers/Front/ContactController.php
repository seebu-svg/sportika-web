<?php

namespace App\Http\Controllers\Front;

use App\Filament\Resources\MessageResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\SiteSetting;
use App\Models\User;
use App\Mail\ContactMessageMail;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('front.contact', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        // Honeypot filled in → almost certainly a bot. Pretend success, store nothing.
        if ($request->filled('website')) {
            return redirect()
                ->route('contact')
                ->with('success', 'Thanks for reaching out! Our team will get back to you soon.');
        }

        $message = Message::create($request->validated() + [
            'ip_address' => $request->ip(),
        ]);

        $this->notifyAdmins($message);

        $this->sendEmailCopy($message);

        return redirect()
            ->route('contact')
            ->with('success', 'Thanks for reaching out! Our team will get back to you soon.');
    }

    /**
     * Push an in-panel database notification to every administrator.
     */
    private function notifyAdmins(Message $message): void
    {
        $recipients = User::query()->where('is_admin', true)->get();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::make()
            ->title('New contact message')
            ->body($message->name.' — '.$message->subject)
            ->icon('heroicon-o-envelope')
            ->color('info')
            ->actions([
                NotificationAction::make('open')
                    ->label('Open message')
                    ->url(MessageResource::getUrl('view', ['record' => $message->getKey()]), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($recipients);
    }

    /**
     * Mirror the submission to the site's inbox email when mail is configured.
     */
    private function sendEmailCopy(Message $message): void
    {
        $inboxEmail = SiteSetting::current()->email;

        if (blank($inboxEmail)) {
            return;
        }

        try {
            Mail::to($inboxEmail)->send(new ContactMessageMail($message));
        } catch (\Throwable $e) {
            Log::warning('Failed to send contact message email copy: '.$e->getMessage());
        }
    }
}
