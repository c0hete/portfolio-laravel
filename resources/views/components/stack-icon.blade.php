@props(['name', 'level', 'color' => 'cyan'])

@php
    // Definimos el ancho según tus nuevos niveles técnicos
    $percentage = match($level) {
        'senior_level', 'senior_architect' => '100%',
        'orchestrated', 'hardened', 'enterprise_deploy' => '90%',
        'optimized', 'full_stack_integrated' => '85%',
        'audited' => '75%',
        default => '80%',
    };
@endphp

<div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800 hover:border-{{ $color }}-500/50 transition-all group">
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-mono text-{{ $color }}-400">{{ $name }}</span>
        <span class="text-[10px] text-slate-500 uppercase tracking-widest">{{ $level }}</span>
    </div>
    <div class="w-full bg-slate-800 h-1 rounded-full overflow-hidden">
        <div class="bg-{{ $color }}-500 h-full transition-all duration-1000" style="width: {{ $percentage }}"></div>
    </div>
</div>