// Arma los enlaces de email a partir de data-mail-user / data-mail-domain.
// El correo nunca aparece junto en el HTML crudo → un scraper que lee el
// markup no lo cosecha. Solo se ensambla en el cliente, al cargar.

function buildEmails() {
    document.querySelectorAll('[data-mail-user][data-mail-domain]').forEach((el) => {
        const user = el.getAttribute('data-mail-user');
        const domain = el.getAttribute('data-mail-domain');
        if (!user || !domain) return;

        const addr = `${user}@${domain}`;
        el.setAttribute('href', `mailto:${addr}`);

        // Si tiene un nodo de texto marcado, mostrar la dirección real.
        const textEl = el.querySelector('[data-mail-text]');
        if (textEl) textEl.textContent = addr;
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', buildEmails);
} else {
    buildEmails();
}
