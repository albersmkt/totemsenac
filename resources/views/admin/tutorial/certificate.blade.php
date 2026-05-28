@extends('layouts.admin')

@section('content')
    @php
        $roleLabel = $audienceRole === 'operador' ? 'Operador' : 'Aluno';
        $certificateCode = 'TOTEM-'.Auth::id().'-'.$completedAt->format('Ymd');
    @endphp

    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        .cert-actions {
            max-width: 297mm;
            margin: 0 auto 14px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .cert-actions a,
        .cert-actions button {
            border: 1px solid #d6dde8;
            border-radius: 6px;
            background: #fff;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            padding: 7px 10px;
        }

        .cert-actions button {
            background: #004b8d;
            border-color: #004b8d;
            color: #fff;
        }

        .certificate-paper {
            width: 297mm;
            min-height: 185mm;
            max-width: 100%;
            margin: 0 auto;
            background: #fff;
            color: #162033;
            box-shadow: 0 20px 50px rgba(15, 23, 42, .12);
            position: relative;
            overflow: hidden;
            border: 1px solid #d9e1ec;
            font-family: Arial, Helvetica, sans-serif;
        }

        .certificate-paper::before {
            content: "SENAC";
            position: absolute;
            right: 22mm;
            top: 35mm;
            font-size: 76px;
            font-weight: 800;
            letter-spacing: .18em;
            color: rgba(0, 75, 141, .045);
            transform: rotate(-8deg);
            pointer-events: none;
        }

        .certificate-frame {
            position: absolute;
            inset: 7mm;
            border: 2px solid #004b8d;
        }

        .certificate-frame::after {
            content: "";
            position: absolute;
            inset: 3mm;
            border: 1px solid #f58220;
        }

        .certificate-content {
            position: relative;
            z-index: 1;
            padding: 14mm 18mm 10mm;
        }

        .certificate-header,
        .certificate-footer {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            height: 38px;
            width: auto;
        }

        .brand-title {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .18em;
        }

        .cert-meta {
            text-align: right;
            font-size: 11px;
            color: #64748b;
            line-height: 1.6;
        }

        .certificate-kicker {
            margin-top: 13mm;
            color: #f58220;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .32em;
            text-transform: uppercase;
            text-align: center;
        }

        .certificate-title {
            margin-top: 5mm;
            text-align: center;
            color: #004b8d;
            font-size: 48px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .certificate-lead {
            margin-top: 7mm;
            text-align: center;
            color: #475569;
            font-size: 16px;
        }

        .student-name {
            margin: 4mm auto 0;
            max-width: 210mm;
            border-bottom: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 38px;
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 700;
            line-height: 1.25;
            padding-bottom: 4mm;
            text-align: center;
        }

        .certificate-text {
            margin: 5mm auto 0;
            max-width: 235mm;
            color: #334155;
            font-size: 16px;
            line-height: 1.65;
            text-align: center;
        }

        .data-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10mm;
            margin-top: 7mm;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 4mm 0;
        }

        .data-label {
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .2em;
            text-transform: uppercase;
        }

        .data-value {
            margin-top: 2mm;
            color: #0f172a;
            font-size: 16px;
            font-weight: 800;
        }

        .program {
            margin-top: 5mm;
        }

        .program-title {
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 2mm 10mm;
            margin-top: 3mm;
            color: #334155;
            font-size: 12px;
            line-height: 1.35;
        }

        .program-item {
            display: flex;
            gap: 7px;
            border-bottom: 1px solid #eef2f7;
            padding-bottom: 2mm;
        }

        .program-number {
            color: #004b8d;
            font-weight: 800;
        }

        .certificate-footer {
            align-items: flex-end;
            margin-top: 7mm;
            color: #64748b;
            font-size: 11px;
        }

        .signature {
            width: 74mm;
            border-top: 1px solid #94a3b8;
            padding-top: 3mm;
            text-align: center;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        @media print {
            body {
                background: #fff !important;
            }

            header,
            footer,
            .no-print {
                display: none !important;
            }

            main {
                max-width: none !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .certificate-paper {
                width: 281mm;
                height: 194mm;
                min-height: 0;
                margin: 0;
                box-shadow: none !important;
                page-break-inside: avoid;
                overflow: hidden;
            }
        }
    </style>

    <div class="cert-actions no-print">
        <a href="{{ route('admin.tutorial.index', request()->only('role')) }}">Voltar</a>
        <button type="button" onclick="window.print()">Imprimir</button>
    </div>

    <section class="certificate-paper">
        <div class="certificate-frame"></div>
        <div class="certificate-content">
            <div class="certificate-header">
                <div class="brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Senac">
                    <div>
                        <div class="brand-title">Totem Digital</div>
                        <div class="text-sm font-semibold text-slate-700">Senac Registro</div>
                    </div>
                </div>
                <div class="cert-meta">
                    <div><strong>Código:</strong> {{ $certificateCode }}</div>
                    <div><strong>Emissão:</strong> {{ now()->format('d/m/Y') }}</div>
                    <div><strong>Conclusão:</strong> {{ $completedAt->format('d/m/Y') }}</div>
                </div>
            </div>

            <div class="certificate-kicker">Certificado de Conclusão</div>
            <div class="certificate-title">Tutorial do Sistema</div>

            <p class="certificate-lead">Certificamos que</p>
            <div class="student-name">{{ Auth::user()->name }}</div>
            <p class="certificate-text">
                concluiu integralmente a trilha de capacitação para utilização do sistema,
                destinada ao perfil <strong>{{ $roleLabel }}</strong>, cumprindo todas as aulas previstas.
            </p>

            <div class="data-row">
                <div>
                    <div class="data-label">Participante</div>
                    <div class="data-value">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    <div class="data-label">Perfil</div>
                    <div class="data-value">{{ $roleLabel }}</div>
                </div>
                <div>
                    <div class="data-label">Aulas concluídas</div>
                    <div class="data-value">{{ $videos->count() }}</div>
                </div>
            </div>

            <div class="program">
                <div class="program-title">Conteúdo programático</div>
                <div class="program-grid">
                    @foreach ($videos as $video)
                        <div class="program-item">
                            <span class="program-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $video->title }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="certificate-footer">
                <div>
                    Certificado gerado automaticamente pelo sistema Totem Digital Senac.
                </div>
                <div class="signature">
                    Coordenação do Sistema
                </div>
            </div>
        </div>
    </section>
@endsection
