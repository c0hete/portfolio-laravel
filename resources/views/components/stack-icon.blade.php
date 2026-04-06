@props(['name', 'level', 'color' => 'blue'])

<div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800 hover:border-{{ $color }}-500/50 transition-all group">
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-mono text-{{ $color }}-400">{{ $name }}</span>
        <span class="text-[10px] text-slate-500 uppercase tracking-widest">{{ $level }}</span>
    </div>
    <div class="w-full bg-slate-800 h-1 rounded-full overflow-hidden">
        <div class="bg-{{ $color }}-500 h-full transition-all duration-1000" style="width: {{ $level == 'Expert' ? '100%' : '85%' }}"></div>
    </div>
</div>