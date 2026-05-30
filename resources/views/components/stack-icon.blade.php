@props(['name', 'level', 'color' => 'cyan'])

@php
    // Traducimos la clave técnica a una etiqueta honesta y legible (sin barras de % inventadas).
    $label = match($level) {
        'senior_level'           => 'Producción · Diario',
        'senior_architect'       => 'Diseño de esquemas',
        'optimized'              => 'Caché / colas',
        'full_stack_integrated'  => 'Front + Back',
        'orchestrated'           => 'Multi-contenedor',
        'hardened'               => 'Hardening aplicado',
        'audited'                => 'Auditoría de vulns',
        'enterprise_deploy'      => 'Despliegues reales',
        default                  => 'En uso',
    };
@endphp

{{-- Clase cyan fija: Tailwind v4 no compila clases interpoladas como border-{$color}-500
     (el JIT no las "ve" en el source y las purga). Si algún día se necesitan otros colores,
     mapear con un match() a clases literales completas. --}}
<div class="flex items-center justify-between gap-4 p-4 rounded-lg bg-slate-900/40 border border-slate-800 hover:border-cyan-500/40 hover:bg-slate-900/70 transition-colors duration-200 group">
    <span class="text-sm font-mono text-slate-200 group-hover:text-cyan-300 transition-colors">{{ $name }}</span>
    <span class="shrink-0 font-mono text-[9px] text-cyan-400/70 uppercase tracking-widest whitespace-nowrap px-2.5 py-1 rounded bg-cyan-500/5 border border-cyan-500/15">
        {{ $label }}
    </span>
</div>
