@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <h2 class="text-4xl font-bold text-white mb-2">Technical <span class="text-blue-500">Stack</span></h2>
    <p class="text-slate-400 mb-12 font-mono">Layered infrastructure & development ecosystem.</p>

    <div class="grid md:grid-cols-2 gap-12">
        <div>
            <h3 class="text-emerald-400 font-mono text-sm mb-6 flex items-center gap-2">
                <span class="p-1 bg-emerald-500/10 rounded">01</span> Backend & Core
            </h3>
            <div class="grid gap-4">
                <x-stack-icon name="PHP 8.3 / Laravel" level="Expert" color="emerald" />
                <x-stack-icon name="PostgreSQL (JSONB/Indexing)" level="Advanced" color="emerald" />
                <x-stack-icon name="Redis" level="Intermediate" color="emerald" />
            </div>
        </div>

        <div>
            <h3 class="text-blue-400 font-mono text-sm mb-6 flex items-center gap-2">
                <span class="p-1 bg-blue-500/10 rounded">02</span> Infrastructure & Security
            </h3>
            <div class="grid gap-4">
                <x-stack-icon name="Docker / Containerization" level="Expert" color="blue" />
                <x-stack-icon name="Nginx Proxy Manager" level="Advanced" color="blue" />
                <x-stack-icon name="Fail2ban / Linux Hardening" level="Advanced" color="blue" />
            </div>
        </div>
    </div>
</section>
@endsection