<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HubEventReporter;

class ContactController extends Controller
{
    public function __construct(
        private HubEventReporter $hub
    ) {}

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Send email or store in database

        // Report to Hub
        $this->hub->reportContactFormSubmitted(
            email: $validated['email'],
            subject: $validated['subject'] ?? 'Sin asunto'
        );

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
