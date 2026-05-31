// Botón "↻ actualizar" de los widgets de /seguridad.
// Hace fetch a los endpoints JSON propios (cumple CSP connect-src 'self'),
// trae el dato fresco (saltando el cache server-side) y actualiza el DOM
// sin recargar la página. Vanilla JS — sin dependencias.

function formatNumber(n) {
    return new Intl.NumberFormat('es-CL').format(n ?? 0);
}

// Estado visual del botón mientras carga (spin + disabled).
function setLoading(btn, loading) {
    if (!btn) return;
    btn.classList.toggle('opacity-50', loading);
    btn.classList.toggle('pointer-events-none', loading);
    const icon = btn.querySelector('[data-refresh-icon]');
    if (icon) icon.classList.toggle('animate-spin', loading);
}

// Refresca el contador de ATAQUES en vivo.
async function refreshAtaques(btn) {
    setLoading(btn, true);
    try {
        const res = await fetch('/api/telemetria/ataques', { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error('fetch failed');
        const data = await res.json();

        const totalEl = document.querySelector('[data-ataques-total]');
        if (totalEl) totalEl.textContent = formatNumber(data.total);

        // Marca de tiempo "actualizado recién".
        const stampEl = document.querySelector('[data-ataques-stamp]');
        if (stampEl) stampEl.textContent = '// actualizado recién';
    } catch (e) {
        // Silencioso: si falla, el dato cacheado sigue mostrándose.
    } finally {
        setLoading(btn, false);
    }
}

// Refresca la lista de PAÍSES (telemetría del nodo).
async function refreshPaises(btn) {
    setLoading(btn, true);
    try {
        const res = await fetch('/api/telemetria/paises', { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error('fetch failed');
        const { countries = [] } = await res.json();

        const stampEl = document.querySelector('[data-paises-stamp]');
        if (stampEl) stampEl.textContent = '// actualizado recién';

        // Si hay un total visible de visitas, lo actualizamos (las barras se
        // recalculan al recargar; acá solo refrescamos el sello y el total).
        const totalEl = document.querySelector('[data-paises-total]');
        if (totalEl) {
            const sum = countries.reduce((acc, c) => acc + (c.count ?? 0), 0);
            totalEl.textContent = formatNumber(sum);
        }
    } catch (e) {
        // Silencioso.
    } finally {
        setLoading(btn, false);
    }
}

document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-refresh]');
    if (!btn) return;
    e.preventDefault();
    const kind = btn.getAttribute('data-refresh');
    if (kind === 'ataques') refreshAtaques(btn);
    if (kind === 'paises') refreshPaises(btn);
});
