@extends('layouts.app')

@section('title', 'Stack Tecnológico — José Alvarado Mazzei')
@section('description', 'Stack técnico honesto por dominio: Laravel/PHP en producción, Docker, Linux hardening, OpenVAS, replicación MySQL geográfica con failover, AWS, CI/CD seguro. Lo que domino, lo que he tocado y lo que no — con métricas verificables.')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-16">

    <header class="mb-12">
        <div class="flex items-center gap-4 mb-4">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Technical <span class="text-cyan-400">Stack</span></h1>
            <span class="h-px flex-1 bg-gradient-to-r from-cyan-500/20 to-transparent"></span>
        </div>
        <p class="text-slate-500 font-mono text-xs uppercase tracking-[0.3em]">
            Stack honesto · Lo que domino, lo que toqué, lo que no.
        </p>
    </header>

    {{-- Leyenda de niveles — la honestidad como sistema visual. --}}
    <div class="flex flex-wrap items-center gap-x-8 gap-y-2 mb-16 font-mono text-[10px] uppercase tracking-widest">
        <span class="flex items-center gap-2 text-cyan-300"><span class="h-2 w-2 rounded-full bg-cyan-400"></span>Producción · diario</span>
        <span class="flex items-center gap-2 text-slate-400"><span class="h-2 w-2 rounded-full bg-slate-500"></span>He trabajado / puntual</span>
        <span class="flex items-center gap-2 text-slate-600"><span class="h-2 w-2 rounded-full bg-slate-700"></span>Conceptual · no en producción</span>
    </div>

    @php
        // Cada dominio: título + items [nombre, nivel(fuerte|tocado|concept), nota].
        $dominios = [
            ['01', 'Backend & Lenguajes', [
                ['PHP 8.2–8.4 · Laravel 10–13', 'fuerte', 'Multi-tenant en producción real'],
                ['APIs REST · Sanctum · Spatie RBAC', 'fuerte', 'Diseño e implementación'],
                ['PHPUnit · Pint', 'fuerte', 'Crono: 69 tests'],
                ['Python', 'tocado', 'Automatización · CRUD AWS · pandas'],
                ['C# / .NET 8', 'tocado', 'Puente API biométrico HID'],
                ['Node.js', 'tocado', 'Soporte de build, no backends'],
            ]],
            ['02', 'Infraestructura & Linux', [
                ['Ubuntu Server 22/24 · systemd', 'fuerte', '8 VPS · 3 regiones · 60+ días uptime'],
                ['Docker · Compose (multi-container)', 'fuerte', 'Mailcow 18 svc · Hub 12 svc'],
                ['Nginx · reverse proxy / balanceo', 'fuerte', 'Producción'],
                ['WireGuard · malla VPN propia', 'fuerte', 'Entre regiones'],
                ['HAProxy', 'tocado', 'Stack BigBlueButton'],
                ['Kubernetes', 'concept', 'Conceptual · no opero clústeres'],
            ]],
            ['03', 'Seguridad & DevSecOps', [
                ['OpenVAS / Greenbone', 'fuerte', '0 hallazgos Crit/High/Med/Low'],
                ['SCA · composer/pnpm audit', 'fuerte', '3 CVEs Symfony remediados'],
                ['gitleaks · pre-commit hooks', 'fuerte', 'Secret scanning histórico'],
                ['Hardening · HSTS/CSP · fail2ban · UFW', 'fuerte', 'SDLC completo'],
                ['Cripto aplicada · GPG AES-256 · SHA-256', 'fuerte', 'Backups + integridad'],
                ['Burp / ZAP · pentesting propio', 'concept', 'Administré cuentas, no opero'],
            ]],
            ['04', 'Cloud (AWS) & Datos', [
                ['MySQL 8 · replicación geográfica', 'fuerte', 'Master-Slave + failover · RTO 5 min'],
                ['AWS · VPC · EC2 · RDS privada · IAM · KMS', 'fuerte', 'Bastion + túnel SSH · S3 ~1.25 TB'],
                ['PostgreSQL · Redis', 'fuerte', 'Pipeline datos · caché/sesiones'],
                ['MariaDB', 'tocado', 'Producción'],
                ['AWS Secrets Manager', 'concept', 'Diseño documentado, no migrado'],
                ['Azure · GCP', 'concept', 'Conceptual'],
            ]],
            ['05', 'CI/CD & Automatización', [
                ['GitHub Actions · multi-job', 'fuerte', 'quality+SCA+secrets+deploy'],
                ['Deploy Docker vía SSH', 'fuerte', 'Workflows propios desde cero'],
                ['Failover EE.UU.↔Europa · Cloudflare API', 'fuerte', 'Automatizado'],
                ['GitFlow · trunk-based · PRs', 'fuerte', 'Code review'],
            ]],
            ['06', 'Observabilidad & Frontend', [
                ['Prometheus · Grafana · Exporters', 'fuerte', 'BBB en producción'],
                ['Pipeline Nginx→Vector→Postgres', 'fuerte', 'Telemetría propia'],
                ['Blade · Alpine.js · Tailwind', 'fuerte', 'Día a día'],
                ['PWA · sync offline', 'fuerte', 'Vanadio'],
                ['Vue 3 · React', 'tocado', 'Puntual, no me dedico al front'],
                ['ELK · Dynatrace · Kibana', 'concept', 'No'],
            ]],
        ];

        $estilo = [
            'fuerte' => ['dot' => 'bg-cyan-400', 'name' => 'text-slate-200', 'note' => 'text-cyan-400/60', 'border' => 'hover:border-cyan-500/40'],
            'tocado' => ['dot' => 'bg-slate-500', 'name' => 'text-slate-300', 'note' => 'text-slate-500', 'border' => 'hover:border-slate-600'],
            'concept' => ['dot' => 'bg-slate-700', 'name' => 'text-slate-500', 'note' => 'text-slate-600', 'border' => 'hover:border-slate-700'],
        ];
    @endphp

    <div class="grid md:grid-cols-2 gap-x-12 gap-y-14">
        @foreach ($dominios as [$num, $titulo, $items])
            <div class="space-y-5">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <span class="font-mono text-cyan-500/50 text-xs">{{ $num }}</span>
                    <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">{{ $titulo }}</h2>
                </div>
                <div class="grid gap-2.5">
                    @foreach ($items as [$name, $level, $nota])
                        @php $s = $estilo[$level]; @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-900/40 border border-slate-800 {{ $s['border'] }} transition-colors duration-200">
                            <span class="h-2 w-2 rounded-full shrink-0 {{ $s['dot'] }}"></span>
                            <span class="text-sm font-mono {{ $s['name'] }} flex-1 leading-tight">{{ $name }}</span>
                            <span class="hidden sm:block font-mono text-[9px] {{ $s['note'] }} uppercase tracking-widest text-right shrink-0 max-w-[42%] leading-tight">{{ $nota }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- ════ Métricas de impacto verificables ════ --}}
    <div class="mt-20 pt-10 border-t border-white/5">
        <div class="flex items-center gap-3 mb-8">
            <span class="font-mono text-cyan-500/50 text-xs">//</span>
            <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Impacto verificable</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ([
                ['8', 'VPS Linux en producción', '3 regiones · ~40 vCPU · ~106 GB RAM'],
                ['0', 'hallazgos OpenVAS', 'Crit/High/Med/Low · host principal'],
                ['5 min', 'RTO de failover', 'Replicación MySQL EE.UU.↔Europa'],
                ['60+', 'días de uptime', 'Continuo · sin incidentes'],
            ] as [$n, $label, $sub])
                <div>
                    <p class="font-mono text-3xl md:text-4xl font-bold text-cyan-300 tracking-tight">{{ $n }}</p>
                    <p class="font-mono text-[10px] text-slate-400 uppercase tracking-widest mt-2 leading-snug">{{ $label }}</p>
                    <p class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-1 leading-snug">{{ $sub }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Footer técnico --}}
    <div class="mt-16 p-8 bg-cyan-500/[0.01] border border-cyan-500/10 rounded-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2 max-w-2xl">
                <p class="font-mono text-[10px] text-slate-500 leading-relaxed uppercase tracking-tighter">
                    <span class="text-cyan-500/60 font-bold">// RESPONSABLE_ÚNICO:</span>
                    Ciclo completo de infraestructura en producción — diseño, despliegue, seguridad y operación. Mailcow (178 buzones), 2× Moodle, BigBlueButton (275 grabaciones migradas), DNS autoritativo propio.
                </p>
                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-tighter">
                    <span class="text-cyan-500/60 font-bold">// WORKSTATION_OS:</span> Ubuntu Server, Kali Linux, PS_CLI.
                </p>
            </div>
            <div class="px-4 py-2 border border-cyan-500/20 text-cyan-400 font-mono text-[10px] uppercase tracking-[0.2em] animate-pulse shadow-[0_0_10px_rgba(6,182,212,0.1)] shrink-0">
                Verified_Node_2026
            </div>
        </div>
    </div>

    {{-- Seguridad Perimetral + Telemetría del nodo viven en /seguridad. --}}

</section>
@endsection
