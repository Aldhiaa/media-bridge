<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index(Request $request): View
    {
        $conversations = Conversation::query()
            ->forUser($request->user())
            ->with(['campaign', 'proposal', 'company', 'agency'])
            ->withCount('messages')
            ->latest('last_message_at')
            ->paginate(12);

        return view('conversations.index', compact('conversations'));
    }

    public function show(Request $request, Conversation $conversation): View
    {
        $this->authorize('view', $conversation);

        $messages = $conversation->messages()
            ->with('sender')
            ->oldest()
            ->paginate(20);

        Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $request->user()->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function store(StoreMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->authorize('update', $conversation);

        $validated = $request->validated();

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('messages', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => trim(strip_tags($validated['body'] ?? '')),
            'attachment_path' => $attachmentPath,
        ]);

        $conversation->update(['last_message_at' => $message->created_at]);

        $recipient = $request->user()->id === $conversation->company_id
            ? $conversation->agency
            : $conversation->company;

        if ($recipient && $recipient->id !== $request->user()->id) {
            $recipient->notify(new NewMessageNotification($conversation, $request->user()));
        }

        return redirect()->route('conversations.show', $conversation)->with('success', 'تم إرسال الرسالة.');
    }
}
