@extends('layouts.app')

@section('title', 'Terminal de Contacto — José Alvarado')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-24 min-h-[80vh] flex flex-col justify-center">
    
    <header class="mb-16 border-l-4 border-cyan-500/30 pl-10">
        <h2 class="text-5xl md:text-6xl font-bold text-white tracking-tighter mb-4 italic">
            Protocolo <span class="text-cyan-400">01-CONTACT</span>
        </h2>
        <p class="text-slate-500 font-mono text-xs uppercase tracking-[0.4em] animate-pulse">
            Link Status: Secure / DNS_Check: Active
        </p>
    </header>

    {{-- BLOQUE DE ÉXITO --}}
    @if(session('success'))
        <div class="mb-12 p-8 bg-cyan-500/5 border-2 border-cyan-500/30 text-cyan-400 font-mono text-base flex items-center gap-6 shadow-[0_0_30px_rgba(6,182,212,0.1)]">
            <div class="h-3 w-3 bg-cyan-500 rounded-full animate-ping"></div>
            <span class="tracking-tight">{{ session('success') }}</span>
        </div>
    @endif

    {{-- BLOQUE DE ERROR GLOBAL --}}
    @if($errors->any())
        <div class="mb-12 p-8 bg-red-500/5 border-2 border-red-500/30 text-red-400 font-mono text-base flex flex-col gap-2 shadow-[0_0_30px_rgba(239,68,68,0.1)]">
            <div class="flex items-center gap-6">
                <span class="text-2xl">⚠️</span>
                <span class="font-bold tracking-widest uppercase">Protocol_Failure_Detected</span>
            </div>
            <ul class="mt-4 list-disc list-inside text-sm opacity-80 pl-12">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" novalidate class="space-y-12 bg-[#030712]/40 border border-white/5 p-12 rounded-sm relative overflow-hidden">
        @csrf
        
        <div class="grid md:grid-cols-2 gap-16">
            <div class="flex flex-col gap-4">
                <label class="font-mono text-xs text-slate-600 uppercase tracking-[0.2em]">Identify::User_Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="bg-[#020617] border-b-2 border-white/10 text-slate-100 px-0 py-4 focus:border-cyan-500/80 outline-none transition-all text-xl placeholder:text-slate-800">
            </div>

            <div class="flex flex-col gap-4">
                <label class="font-mono text-xs text-slate-600 uppercase tracking-[0.2em]">Verify::Email_Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="bg-[#020617] border-b-2 border-white/10 text-slate-100 px-0 py-4 focus:border-cyan-500/80 outline-none transition-all text-xl @error('email') border-red-500/50 @enderror">
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <label class="font-mono text-xs text-slate-600 uppercase tracking-[0.2em]">Payload::Encrypted_Message</label>
            <textarea name="message" rows="5" required 
                class="bg-[#020617] border border-white/10 text-slate-100 p-6 focus:border-cyan-500/50 outline-none transition-all text-lg resize-none leading-relaxed"></textarea>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between pt-10 gap-6 border-t border-white/5">
            
            {{-- TERMINAL DE ESTADO (Feedback de carga) --}}
            <div id="terminal-loader" class="hidden flex-1 font-mono text-[10px] text-cyan-500/70 uppercase tracking-[0.2em] leading-relaxed border-l border-cyan-500/20 pl-4">
                <span class="block animate-pulse text-cyan-400">>> INICIANDO_PROTOCOLO_SMTP...</span>
                <div id="log-entries" class="space-y-1"></div>
            </div>

            {{-- META DATA --}}
            <div id="system-meta" class="hidden md:block font-mono text-[10px] text-slate-700 uppercase leading-relaxed tracking-tighter">
                Connection: Persistent <br/> 
                Trace: {{ request()->ip() }} <br/>
                Hops: 12-nodes-active
            </div>
            
            <button type="submit" id="submit-btn" class="group relative px-12 py-6 bg-cyan-500/5 border border-cyan-500/30 text-cyan-400 font-mono text-sm uppercase tracking-[0.4em] overflow-hidden hover:bg-cyan-500/10 hover:border-cyan-500 transition-all active:scale-95">
                <span class="relative z-10" id="btn-text">Ejecutar_Envio.sh</span>
                <div class="absolute inset-0 bg-cyan-500/10 translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500"></div>
            </button>
        </div>
    </form>
</section>
@endsection