@extends('layouts.app')

@section('title', 'Terminal de Contacto — José Alvarado')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-24 min-h-[80vh] flex flex-col justify-center">
    
    {{-- Título más sobrio y proporcionado --}}
    <header class="mb-12 border-l-2 border-cyan-500/30 pl-6">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-300 tracking-tight mb-2">
            Protocolo <span class="text-cyan-500/70">01-CONTACT</span>
        </h2>
        <p class="text-slate-600 font-mono text-[10px] uppercase tracking-[0.3em] animate-pulse">
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

    {{-- Formulario con sutil presencia en los bordes --}}
    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" novalidate class="space-y-12 bg-[#030712]/60 border border-cyan-500/10 shadow-[0_0_15px_rgba(6,182,212,0.02)] p-12 rounded-sm relative overflow-hidden">
        @csrf
        
        <div class="grid md:grid-cols-2 gap-16">
            <div class="flex flex-col gap-3">
                <label class="font-mono text-[10px] text-slate-500 uppercase tracking-[0.2em] font-semibold">Identify::User_Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="bg-transparent border-b border-slate-700/50 text-slate-200 px-0 py-3 focus:border-cyan-500/80 outline-none transition-all text-lg placeholder:text-slate-800">
            </div>

            <div class="flex flex-col gap-3">
                <label class="font-mono text-[10px] text-slate-500 uppercase tracking-[0.2em] font-semibold">Verify::Email_Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="bg-transparent border-b border-slate-700/50 text-slate-200 px-0 py-3 focus:border-cyan-500/80 outline-none transition-all text-lg @error('email') border-red-500/50 @enderror">
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <label class="font-mono text-[10px] text-slate-500 uppercase tracking-[0.2em] font-semibold">Payload::Encrypted_Message</label>
            <textarea name="message" rows="4" required 
                class="bg-[#020617] border border-slate-800/80 text-slate-200 p-5 focus:border-cyan-500/50 outline-none transition-all text-base resize-none leading-relaxed shadow-inner"></textarea>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between pt-10 gap-6 border-t border-slate-800">
            
            {{-- TERMINAL DE ESTADO --}}
            <div id="terminal-loader" class="hidden flex-1 font-mono text-[10px] text-cyan-500/70 uppercase tracking-[0.2em] leading-relaxed border-l border-cyan-500/20 pl-4">
                <span class="block animate-pulse text-cyan-400">>> INICIANDO_PROTOCOLO_SMTP...</span>
                <div id="log-entries" class="space-y-1"></div>
            </div>

            {{-- META DATA --}}
            <div id="system-meta" class="hidden md:block font-mono text-[9px] text-slate-600 uppercase leading-relaxed tracking-tighter">
                Connection: Persistent <br/> 
                Trace: {{ request()->ip() ?? '127.0.0.1' }} <br/>
                Hops: 12-nodes-active
            </div>
            
            <button type="submit" id="submit-btn" class="group relative px-10 py-5 bg-cyan-500/5 border border-cyan-500/40 text-cyan-400 font-mono text-[11px] uppercase tracking-[0.3em] overflow-hidden hover:bg-cyan-500/10 hover:border-cyan-400 transition-all active:scale-95 shadow-[0_0_15px_rgba(6,182,212,0.1)] hover:shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                <span class="relative z-10 font-bold" id="btn-text">Ejecutar_Envio.sh</span>
                <div class="absolute inset-0 bg-cyan-500/10 translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500"></div>
            </button>
        </div>
    </form>
</section>
@endsection