<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // CAPA 0: HONEYPOT anti-bot. Campo oculto 'website' que un humano no ve ni
        // llena. Si viene con contenido, es un bot: devolvemos "exito" sin enviar
        // nada (no revelamos la trampa) y cortamos aca. Corta el abuso automatizado
        // que inundaba el buzon y saturaba el correo saliente.
        if ($request->filled('website')) {
            return back()->with('success', 'TRANSMISION_EXITOSA: El mensaje ha sido procesado.');
        }

        // CAPA 1: VALIDACION
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns',
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'email.email' => 'SISTEMA_ERROR: No se pudo verificar la existencia del dominio de correo.',
        ]);

        $subject = $validated['subject'] ?? 'PROTOCOLO_CONTACTO: Consulta desde alvaradomazzei.cl';

        // Identidad real del buzon que el SMTP acepta como remitente.
        $systemFrom = 'web@alvaradomazzei.cl';

        try {
            // CAPA 2: NOTIFICACION AL ADMINISTRADOR (unico correo que sale del sistema).
            // Va SOLO a jose@ (destino fijo, interno). El email del visitante se usa como
            // Reply-To, NUNCA como destinatario: asi el formulario no puede usarse para
            // enviar correo a direcciones arbitrarias (vector de relay via webform que
            // causaba el flood de correo indeliverable).
            Mail::send([], [], function ($message) use ($validated, $subject, $systemFrom) {
                $message->to('jose@alvaradomazzei.cl')
                    ->from($systemFrom, 'Búnker Portfolio')
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject($subject)
                    ->html("
                            <div style='font-family: monospace; color: #333; padding: 20px; background: #f4f4f4;'>
                                <h2 style='color: #0891b2;'>TRANSMISIÓN_ENTRANTE</h2>
                                <p><strong>REMITENTE:</strong> {$validated['name']}</p>
                                <p><strong>EMAIL:</strong> {$validated['email']}</p>
                                <hr style='border: 1px solid #ddd;'>
                                <p><strong>MENSAJE:</strong></p>
                                <div style='white-space: pre-wrap; background: #fff; padding: 15px; border: 1px solid #eee;'>{$validated['message']}</div>
                            </div>
                        ");
            });

            Log::info("Contacto recibido de: {$validated['email']}");

            return back()->with('success', 'TRANSMISION_EXITOSA: El mensaje ha sido procesado.');

        } catch (\Exception $e) {
            // Guardamos el error real en el log para que lo veas por SSH
            Log::error('Fallo crítico en el nodo de correo: '.$e->getMessage());

            return back()->withErrors([
                'email' => 'SISTEMA_ERROR: Fallo de conexión con el servidor SMTP (Mailcow).',
            ])->withInput();
        }
    }
}
