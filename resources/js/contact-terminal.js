document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const loader = document.getElementById('terminal-loader');
            const logEntries = document.getElementById('log-entries');
            const meta = document.getElementById('system-meta');

            // Bloquear UI
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            if (btnText) btnText.innerText = "PROCESANDO...";

            // Mostrar Terminal
            if (loader) loader.classList.remove('hidden');
            if (meta) meta.classList.add('hidden');

            // Logs técnicos
            const steps = [
                ">> VALIDANDO_REGISTROS_MX...",
                ">> CIFRANDO_PAYLOAD_OPENSSL...",
                ">> ESTABLECIENDO_HANDSHAKE_SMTP...",
                ">> TRANSMITIENDO_PAQUETES..."
            ];

            steps.forEach((step, index) => {
                setTimeout(() => {
                    if (logEntries) {
                        const line = document.createElement('span');
                        line.className = "block opacity-80 animate-in fade-in slide-in-from-left-2 duration-300";
                        line.innerText = step;
                        logEntries.appendChild(line);
                    }
                }, (index + 1) * 600);
            });
        });
    }
});