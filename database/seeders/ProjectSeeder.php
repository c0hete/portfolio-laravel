<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project; 

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    // Proyecto 1: VANADIO (Blindado)
    Project::create([
        'title'       => 'VANADIO',
        'category'    => 'BIOMETRÍA & ALTA DISPONIBILIDAD',
        'role'        => 'Arquitecto de Infraestructura & Dev Lead',
        'description' => 'Arquitectura de misión crítica con replicación Master-Slave distribuida geográficamente (USA - Europa) para garantizar 99.9% de uptime. Control de asistencia bajo Res. 38 de la DT con integridad de registros vía SHA-256 y túneles WireGuard VPN para interconexión segura de nodos.',
        'stack'       => ['Laravel 11', 'MySQL (Master-Slave)', 'WireGuard', 'SHA-256', 'Digital Persona SDK'],
        'url'         => 'https://vanadio.cl/acceso',
        'logo'        => 'assets/img/vanadio_blanco.png',
    ]);

    // Proyecto 2: FARMAPLACE
    // Project::create([
    //     'title'       => 'FARMAPLACE',
    //     'category'    => 'SII & LOGÍSTICA',
    //     'role'        => 'Fullstack Developer',
    //     'description' => 'Ecosistema farmacéutico con integración de facturación electrónica (SII). Control de inventario inteligente por lotes, gestión de recetas retenidas y optimización de procesos logísticos con reportabilidad en tiempo real.',
    //     'stack'       => ['PHP 8.2', 'MySQL', 'API REST', 'Facturación SII', 'Docker'],
    //     'url' => 'https://farmaplace.cl',
    //     'logo' => null, // O la ruta si la tienes
    // ]);

    // Proyecto 3: SUSTANTIVA (Cumplimiento Estatal)
    Project::create([
        'title'       => 'SUSTANTIVA',
        'category'    => 'EDTECH & SENCE',
        'role'        => 'Frontend Developer & UI Architect',
        'description' => 'Landing page institucional diseñada bajo las bases técnicas de licitación SENCE. Optimización extrema de Core Web Vitals para procesos de postulación masiva y accesibilidad garantizada para usuarios finales de capacitación estatal.',
        'stack'       => ['Tailwind CSS', 'Alpine.js', 'Vite', 'SEO Optimization'],
        'url'         => 'https://sustantiva.cl',
        'logo'        => 'assets/img/sustantiva_logo.png',
    ]);

    // Proyecto 4: AULA VIRTUAL ENERGIZA
    Project::create([
        'title'       => 'AULA VIRTUAL ENERGIZA',
        'category'    => 'EDTECH & E-LEARNING (LMS)',
        'role'        => 'LMS Architect & SysAdmin',
        'description' => 'Implementación y despliegue de plataforma de aprendizaje basada en Moodle. Configuración de entorno LAMP optimizado para alta concurrencia, gestión de backups automatizados y personalización de rutas de aprendizaje para programas de capacitación técnica y habilidades digitales.',
        'stack'       => ['Moodle (LMS)', 'PHP 8.2', 'MySQL', 'Ubuntu Server', 'Apache / Nginx'],
        'url'         => 'https://aula.energiza.cl', // Confirma si este es el subdominio
        'logo'        => 'assets/img/moodle_logo.png', // O el logo de Energiza si prefieres
    ]);

    // Proyecto 5: MEET ENERGIZA (BBB con Mediasoup)
    Project::create([
        'title'       => 'MEET ENERGIZA (BIGBLUEBUTTON)',
        'category'    => 'COMUNICACIONES & WEBRTC',
        'role'        => 'DevOps & Platform Architect',
        'description' => 'Despliegue de infraestructura de videoconferencia de alta escalabilidad. Migración a arquitectura basada en Mediasoup para optimización de recursos SFU, garantizando baja latencia en sesiones masivas y seguridad perimetral mediante Nginx Reverse Proxy.',
        'stack'       => ['BigBlueButton', 'Mediasoup (SFU)', 'WebRTC', 'Greenlight', 'Redis'],
        'url'         => 'https://meet.energizavirtual.cl',
        'logo'        => 'assets/img/bbb_logo.png',
    ]);

    // Proyecto 6: SERVIDOR DE CORREO PRIVADO (MAILCOW)
    Project::create([
        'title'       => 'SISTEMA DE MENSAJERÍA CORPORATIVA',
        'category'    => 'INFRAESTRUCTURA & SEGURIDAD DE CORREO',
        'role'        => 'SysAdmin & Security Engineer',
        'description' => 'Implementación de stack de correo soberano basado en Mailcow (Dockerized). Configuración avanzada de seguridad con Rspamd, ClamAV y políticas estrictas de autenticación DNS (SPF, DKIM, DMARC) para asegurar entregabilidad y protección contra spoofing.',
        'stack'       => ['Mailcow', 'Docker', 'Postfix', 'Dovecot', 'SOGo Webmail'],
        'url'         => 'https://mail.alvaradomazzei.cl',
        'logo'        => 'assets/img/am-correo.png', 
    ]);
}
}