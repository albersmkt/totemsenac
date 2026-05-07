# Totem Digital Senac Registro

Sistema Laravel 11 (PHP 8.2+) para totem digital em modo kiosk (portrait) e painel administrativo.

## Requisitos

- PHP 8.2+
- Composer
- Node 18+
- MySQL 8+

## Configuracao rapida

1) Instale dependencias

```bash
composer install
npm install
```

2) Configure o banco (arquivo `.env`)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=totemsenac
DB_USERNAME=root
DB_PASSWORD=
```

3) Gere chave, migre e crie os seeders

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

4) Rode os assets e o servidor

```bash
npm run dev
php artisan serve
```

## Acessos

- Totem (publico): `http://localhost:8000/`
- Painel admin: `http://localhost:8000/admin`

### Cadastro de aluno

- URL: `http://localhost:8000/register`
- Novos registros recebem automaticamente o role `estudante` e vao direto para o painel.

### Recuperacao de senha

- URL: `http://localhost:8000/forgot-password`
- URL alternativa: `http://localhost:8000/esqueci-senha`
- O usuario informa o email e recebe um link para redefinir a senha.


### Cursos (iframe)

- URL do iframe configuravel via `.env`:
  `SENAC_COURSES_URL=https://www.sp.senac.br`

### Super Admin padrao

- Email: `admin@senac.test`
- Senha: `password`

### Usuarios de exemplo

- Operador: `operador@senac.test` / `password`
- Estudante: `aluno@senac.test` / `password`
- Estudante demo (dados seed): `aluno.demo@senac.test` / `password`

## Funcionalidades

### Totem (kiosk)

- Layout portrait 1080x1920 (responsivo)
- Secoes: Acoes, Eventos, Projetos Integradores, Empreendedores
- Cards grandes e touch-friendly
- Inatividade: volta para ` / ` apos 45s sem interacao
- Links externos nao abrem no totem (WhatsApp via QR Code)

### Painel administrativo

- Auth Breeze
- Roles: `super_admin`, `operador`, `estudante`
- Policies + ownership
- CRUD com upload de imagens
- Aprovacoes: empreendedores e projetos integradores


## Roles adicionais

Para criar usuarios operador/estudante:

1) Crie o usuario via /register
2) Atribua o role via tinker:

```bash
php artisan tinker
```

```php
use App\Models\User;
User::where('email', 'operador@exemplo.com')->first()->assignRole('operador');
User::where('email', 'aluno@exemplo.com')->first()->assignRole('estudante');
```


## Observacoes

- Imagens ficam em `storage/app/public` e sao publicadas via `storage:link`.
- Empreendedores e Projetos Integradores so aparecem no totem quando aprovados/publicados.

## Email (recuperacao de senha)

Para envio real de email, configure SMTP no `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=SEU_SMTP
MAIL_PORT=587
MAIL_USERNAME=SEU_USUARIO
MAIL_PASSWORD=SUA_SENHA
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nao-responda@seu-dominio.com
MAIL_FROM_NAME="Senac Registro"
APP_URL=http://127.0.0.1:8000
```

Em ambiente local voce pode manter `MAIL_MAILER=log`; o link de recuperacao sera salvo em `storage/logs/laravel.log`.

## Upload de imagens

- Recomendado: proporcao 16:9 (ex: 1280x720) e ate 8MB.
- Se ocorrer erro "failed to upload", ajuste os limites do PHP (upload_max_filesize/post_max_size).
- Para ambientes Apache/Nginx com PHP-FPM, este projeto inclui `.user.ini` com limites maiores.

## Comandos uteis

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```
