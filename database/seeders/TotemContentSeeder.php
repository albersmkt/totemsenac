<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\EntrepreneurImage;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\IntegratorProject;
use App\Models\IntegratorProjectImage;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TotemContentSeeder extends Seeder
{
    public function run(): void
    {
        $registroId = (int) Unidade::query()
            ->where('nome', 'Senac Registro')
            ->value('id');

        $operator = User::firstOrCreate(
            ['email' => 'operador@senac.test'],
            ['name' => 'Operador Totem', 'password' => bcrypt('password'), 'unidade_id' => $registroId]
        );
        $student = User::firstOrCreate(
            ['email' => 'aluno@senac.test'],
            ['name' => 'Aluno Senac', 'password' => bcrypt('password'), 'unidade_id' => $registroId]
        );
        $demoStudent = User::firstOrCreate(
            ['email' => 'aluno.demo@senac.test'],
            ['name' => 'Aluno Demo', 'password' => bcrypt('password'), 'unidade_id' => $registroId]
        );

        foreach ([$operator, $student, $demoStudent] as $user) {
            if ($user->unidade_id === null) {
                $user->unidade_id = $registroId;
                $user->save();
            }
        }

        if (! $operator->hasRole('operador')) {
            $operator->assignRole('operador');
        }

        if (! $student->hasRole('estudante')) {
            $student->assignRole('estudante');
        }
        if (! $demoStudent->hasRole('estudante')) {
            $demoStudent->assignRole('estudante');
        }

        $this->seedActions($operator, $registroId);
        $this->seedEvents($operator, $registroId);
        $this->seedProjects($demoStudent, $registroId);
        $this->seedEntrepreneurs($demoStudent, $registroId);
    }

    private function seedActions(User $operator, int $registroId): void
    {
        if (Action::count() > 0) {
            return;
        }

        $items = [
            ['Oficina de Design Criativo', 'Exploracao de cores, formas e prototipos rapidos.'],
            ['Aula Aberta Gastronomia', 'Demonstracao ao vivo de tecnicas de confeitaria.'],
            ['Semana de Tecnologia', 'Palestras sobre IA, apps e futuro do trabalho.'],
            ['Laboratorio de Moda', 'Customizacao e tendencias para jovens criadores.'],
            ['Workshop de Fotografia', 'Iluminacao, composicao e narrativa visual.'],
            ['Maratona Empreendedora', 'Ideias de negocios locais com mentoria.'],
            ['Acoes Sustentaveis', 'Projetos verdes e impacto social no bairro.'],
            ['Oficina de Inovacao', 'Metodos ageis e design thinking.'],
        ];

        foreach ($items as $index => [$title, $description]) {
            Action::create([
                'title' => $title,
                'description' => $description,
                'start_at' => now()->addDays($index)->setTime(9 + $index % 4, 0),
                'end_at' => now()->addDays($index)->setTime(12 + $index % 4, 0),
                'location' => 'Senac Registro',
                'cover_image' => $this->seedImage("actions/action-{$index}.svg", $title, '#F36C21', '#005DAA'),
                'status' => 'published',
                'created_by' => $operator->id,
                'unidade_id' => $registroId,
                'published_at' => now()->subDays(2),
            ]);
        }
    }

    private function seedEvents(User $operator, int $registroId): void
    {
        if (Event::count() > 0) {
            return;
        }

        $items = [
            ['Festival de Talentos', 'Apresentacoes culturais, musica e exposicoes.'],
            ['Meetup de Tecnologia', 'Networking com profissionais e startups locais.'],
            ['Feira de Empreendedorismo', 'Negocios de estudantes e comunidade.'],
            ['Mostra de Gastronomia', 'Pratos criativos e degustacoes guiadas.'],
            ['Dia da Saude', 'Atendimentos, palestras e orientacoes.'],
            ['Cultura Maker', 'Prototipos, impressao 3D e robotica.'],
        ];

        foreach ($items as $index => [$title, $description]) {
            $event = Event::create([
                'title' => $title,
                'description' => $description,
                'start_at' => now()->addDays(5 + $index)->setTime(14, 0),
                'end_at' => now()->addDays(5 + $index)->setTime(18, 0),
                'location' => 'Auditorio Senac',
                'cover_image' => $this->seedImage("events/event-{$index}.svg", $title, '#005DAA', '#F36C21'),
                'status' => 'published',
                'created_by' => $operator->id,
                'unidade_id' => $registroId,
                'published_at' => now()->subDay(),
            ]);

            for ($i = 0; $i < 3; $i++) {
                EventImage::create([
                    'event_id' => $event->id,
                    'path' => $this->seedImage("events/gallery-{$index}-{$i}.svg", "{$title} {$i}", '#E9F3FF', '#005DAA'),
                    'sort_order' => $i,
                ]);
            }
        }
    }

    private function seedProjects(User $student, int $registroId): void
    {
        if (IntegratorProject::count() > 0) {
            return;
        }

        $items = [
            ['App de Mobilidade', 'Solucao de transporte comunitario para a cidade.'],
            ['Cozinha Sustentavel', 'Projeto de reaproveitamento de alimentos.'],
            ['Moda Circular', 'Colecao feita com materiais reciclados.'],
            ['Turismo Criativo', 'Roteiros culturais e gastronomicos locais.'],
            ['Educacao Financeira', 'Plataforma para jovens aprenderem financas.'],
            ['Senac Connect', 'Hub de conexoes entre alunos e empresas.'],
        ];

        foreach ($items as $index => [$title, $description]) {
            $project = IntegratorProject::create([
                'title' => $title,
                'description' => $description,
                'course' => 'Curso Tecnico',
                'class_group' => 'Turma '.(string) (10 + $index),
                'cover_image' => $this->seedImage("projects/project-{$index}.svg", $title, '#F36C21', '#005DAA'),
                'status' => 'published',
                'created_by' => $student->id,
                'unidade_id' => $registroId,
                'approved_by' => User::where('email', 'admin@senac.test')->value('id'),
                'approved_at' => now()->subDays(3),
            ]);

            for ($i = 0; $i < 2; $i++) {
                IntegratorProjectImage::create([
                    'integrator_project_id' => $project->id,
                    'path' => $this->seedImage("projects/gallery-{$index}-{$i}.svg", "{$title} {$i}", '#FFF6EE', '#F36C21'),
                    'sort_order' => $i,
                ]);
            }

            $project->members()->sync([
                $student->id => ['role_in_project' => 'Autor'],
            ]);
        }
    }

    private function seedEntrepreneurs(User $student, int $registroId): void
    {
        if (Entrepreneur::count() === 0) {
            $items = [
                ['Doces da Vila', 'sobremesa', 'Brownies, bolos no pote e brigadeiros artesanais.'],
                ['Salgados Express', 'salgado', 'Coxinhas, esfihas e combos para festas.'],
                ['Studio Criativo', 'servicos', 'Design grafico e social media para negocios locais.'],
                ['Sabores da Serra', 'salgados_doces', 'Lanches, sobremesas e kits especiais.'],
                ['Tech Ajuda', 'servicos', 'Manutencao de computadores e suporte rapido.'],
                ['Delicias Fit', 'sobremesa', 'Opcoes sem acucar e sobremesas fitness.'],
            ];

            foreach ($items as $index => [$name, $category, $description]) {
                $entrepreneur = Entrepreneur::create([
                    'display_name' => $name,
                    'category' => $category,
                    'description' => $description,
                    'whatsapp_number' => '1198888000'.(string) $index,
                    'whatsapp_message_template' => 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.',
                    'status' => 'approved',
                    'created_by' => $student->id,
                    'unidade_id' => $registroId,
                    'approved_by' => User::where('email', 'admin@senac.test')->value('id'),
                    'approved_at' => now()->subDays(2),
                ]);

                for ($i = 0; $i < 2; $i++) {
                    EntrepreneurImage::create([
                        'entrepreneur_id' => $entrepreneur->id,
                        'path' => $this->seedImage("entrepreneurs/entrepreneur-{$index}-{$i}.svg", $name, '#E9F3FF', '#005DAA'),
                        'sort_order' => $i,
                    ]);
                }
            }
        }

        if (Entrepreneur::where('status', 'pending')->count() === 0) {
            $pending = Entrepreneur::firstOrCreate(
                ['display_name' => 'Cafe da Praca'],
                [
                    'category' => 'salgado',
                    'description' => 'Lanches artesanais e cafe especial para a comunidade.',
                    'whatsapp_number' => '11999990000',
                    'whatsapp_message_template' => 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.',
                    'status' => 'pending',
                    'created_by' => $student->id,
                    'unidade_id' => $registroId,
                ]
            );

            if ($pending->images()->count() === 0) {
                EntrepreneurImage::create([
                    'entrepreneur_id' => $pending->id,
                    'path' => $this->seedImage('entrepreneurs/entrepreneur-pending.svg', 'Cafe da Praca', '#FFF6EE', '#F36C21'),
                    'sort_order' => 0,
                ]);
            }
        }
    }

    private function seedImage(string $path, string $label, string $primary, string $secondary): string
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $safeLabel = strtoupper(substr($label, 0, 24));
            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1080" height="720" viewBox="0 0 1080 720">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$primary}"/>
      <stop offset="100%" stop-color="{$secondary}"/>
    </linearGradient>
  </defs>
  <rect width="1080" height="720" fill="url(#g)"/>
  <circle cx="820" cy="120" r="120" fill="rgba(255,255,255,0.2)"/>
  <circle cx="160" cy="600" r="160" fill="rgba(255,255,255,0.18)"/>
  <rect x="90" y="260" width="900" height="220" rx="36" fill="rgba(255,255,255,0.2)"/>
  <text x="120" y="380" font-size="54" font-family="Arial, sans-serif" fill="#ffffff" letter-spacing="2">{$safeLabel}</text>
  <text x="120" y="440" font-size="26" font-family="Arial, sans-serif" fill="#ffffff">SENAC REGISTRO TOTEM</text>
</svg>
SVG;
            $disk->put($path, $svg);
        }

        return $path;
    }
}
