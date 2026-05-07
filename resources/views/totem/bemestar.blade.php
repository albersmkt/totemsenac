@extends('layouts.totem')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-display text-3xl text-senac-blue">Atendimento Bem-estar e Beleza</h2>
        <a href="{{ route('totem.home') }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 mb-8">
        <h3 class="font-display text-xl text-senac-blue mb-6 p-12">Quem pode se inscrever</h3>
        <p class="text-slate-600 mb-6">
            Para se inscrever é preciso ser maior de 18 anos. Exceto para:
        </p>
        <ul class="space-y-4 text-slate-600">
            <li class="flex items-start gap-3">
                <span class="mt-1.5 w-2 h-2 rounded-full bg-senac-orange flex-shrink-0"></span>
                <span><strong>Design Sobrancelhas e Maquiagem</strong> - Ser maior de 16 anos</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1.5 w-2 h-2 rounded-full bg-senac-orange flex-shrink-0"></span>
                <span><strong>Atendimento Estético Facial</strong> - Menores entre 13 e 17 anos de idade poderão ser atendidos apenas para o procedimento de acne e na presença do pai ou responsável, mediante Termo de Ciência de Consentimento.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1.5 w-2 h-2 rounded-full bg-senac-orange flex-shrink-0"></span>
                <span><strong>Atendimento Podológico - Onicocriptose (unha encravada)</strong> - menores de 18 anos de idade desde que acompanhados pelos pais ou responsáveis, mediante Termo de Ciência e de Consentimento.</span>
            </li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 mb-8">
        <h3 class="font-display text-xl text-senac-blue mb-6">Como se inscrever</h3>
        <ol class="space-y-6">
            <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-senac-blue text-white font-bold flex items-center justify-center">1</span>
                <span class="text-slate-600 pt-1">Escolha a unidade</span>
            </li>
            <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-senac-blue text-white font-bold flex items-center justify-center">2</span>
                <span class="text-slate-600 pt-1">Escolha o serviço</span>
            </li>
            <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-senac-blue text-white font-bold flex items-center justify-center">3</span>
                <span class="text-slate-600 pt-1">Efetue login ou registro no Login do Portal Senac</span>
            </li>
            <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-senac-blue text-white font-bold flex items-center justify-center">4</span>
                <span class="text-slate-600 pt-1">Escolha uma data e horário para agendamento</span>
            </li>
            <li class="flex items-start gap-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-senac-blue text-white font-bold flex items-center justify-center">5</span>
                <span class="text-slate-600 pt-1">Confirme o agendamento</span>
            </li>
        </ol>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-10 mb-8">
        <h3 class="font-display text-lg text-amber-800 mb-6">Informações Importantes</h3>
        <ul class="space-y-4 text-amber-800">
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-600">•</span>
                <span>O atendimento é pessoal e intransferível. Na data agendada, é obrigatória a apresentação de documento de identificação.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-600">•</span>
                <span>A não permanência do modelo até o final do tratamento implicará em restrição por falta.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-600">•</span>
                <span>Não é permitida a presença de acompanhantes durante os atendimentos, exceto em atendimentos a menores de idade.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-600">•</span>
                <span>As vagas disponibilizadas para atendimento estão condicionadas ao número de alunos e ao andamento das turmas.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-600">•</span>
                <span>O Senac reserva-se o direito de alterar a data prevista, adiar ou cancelar o atendimento.</span>
            </li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
        <h3 class="font-display text-xl text-senac-blue mb-6">Escaneie o QR Code</h3>
        <p class="text-slate-600 mb-6">Visualize as unidades que estão com agendas abertas.</p>
        <div class="inline-block p-6 bg-white rounded-xl border border-slate-200">
            <img src="/storage/qrcode_bemestar.png" alt="QR Code Senac Bem-estar" class="w-48 h-48 object-contain mx-auto">
        </div>
    </div>
@endsection
