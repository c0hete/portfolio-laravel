<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // 🛡️ CAPA 1: VALIDACIÓN
        $validated = $request->validate([
            'email'   => 'required|email:rfc,dns', 
            'name'    => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'email.email' => 'SISTEMA_ERROR: No se pudo verificar la existencia del dominio de correo.',
        ]);

        $subject = $validated['subject'] ?? 'PROTOCOLO_CONTACTO: Consulta desde alvaradomazzei.cl';
        
        // 🚨 CORRECCIÓN CRÍTICA: Forzamos la identidad que el SMTP acepta
        $systemFrom = 'web@alvaradomazzei.cl'; 

        try {
            // 📨 CAPA 2: TRANSMISIÓN AL ADMINISTRADOR
            Mail::send([], [], function ($message) use ($validated, $subject, $systemFrom) {
                $message->to('jose@alvaradomazzei.cl') 
                        ->from($systemFrom, 'Búnker Portfolio')
                        ->replyTo($validated['email'], $validated['name']) // Permite responder al cliente
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

            // 📩 CAPA 3: ACUSE DE RECIBO AL USUARIO
            Mail::send([], [], function ($message) use ($validated, $systemFrom) {
                $message->to($validated['email']) 
                        ->from($systemFrom, 'José Alvarado — Systems Engineer')
                        ->subject('CONFIRMACIÓN: Mensaje recibido en el nodo alvaradomazzei.cl')
                        ->html("
                            <div style='font-family: monospace; background: #020617; color: #94a3b8; padding: 40px; border: 1px solid #1e293b;'>
                                <h2 style='color: #22d3ee; margin-bottom: 20px;'>SISTEMA_NOTIFICACIÓN</h2>
                                <p>Hola, <strong>{$validated['name']}</strong>.</p>
                                <p>Tu mensaje ha sido enrutado correctamente a través del nodo central de <strong>alvaradomazzei.cl</strong>.</p>
                                <div style='border: 1px solid #0891b2; padding: 20px; margin: 30px 0; background: rgba(8, 145, 178, 0.05);'>
                                    <p style='font-size: 12px; color: #22d3ee; margin: 0;'>
                                        STATUS: Mensaje en cola de revisión.<br>
                                        ID_REF: ". bin2hex(random_bytes(4)) ."<br>
                                        ETA: Respuesta en breve.
                                    </p>
                                </div>
                                <p>Este es un acuse de recibo automático. Por favor, no respondas directamente a este correo.</p>
                                <hr style='border: 0; border-top: 1px solid #1e293b; margin-top: 40px;'>
                                <p style='font-size: 10px; color: #475569;'>© 2026 — Protocol Implementation / Built with Laravel</p>
                            </div>
                        ");
            });

            Log::info("Intercambio de mensajes completado: {$validated['email']}");
            return back()->with('success', 'TRANSMISIÓN_EXITOSA: El mensaje y el acuse de recibo han sido procesados.');

        } catch (\Exception $e) {
            // Guardamos el error real en el log para que lo veas por SSH
            Log::error("Fallo crítico en el nodo de correo: " . $e->getMessage());
            
            return back()->withErrors([
                'email' => 'SISTEMA_ERROR: Fallo de conexión con el servidor SMTP (Mailcow).'
            ])->withInput();
        }
    }
}