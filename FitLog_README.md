# FitLog 🏋️

Diário de treino full-stack: registre treinos e exercícios, acompanhe sua evolução de volume, bata recordes pessoais e visualize sua frequência num calendário — tudo com autenticação por usuário.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-38B2AC?logo=tailwind-css&logoColor=white)

## ✨ Funcionalidades

- 🔐 **Autenticação completa** — registro, login e logout. Cada usuário vê apenas os próprios treinos (escopo de dados + verificação de dono).
- 📊 **Painel com evolução** — gráfico de volume ao longo das sessões (Chart.js).
- 🏆 **Recordes pessoais** — maior carga por exercício, calculada no banco.
- 📅 **Calendário mensal** — dias treinados destacados.
- 🔎 **Busca** — filtre treinos por título.
- 🌗 **Tema claro/escuro** — com preferência salva no navegador.

## 🛠️ Tecnologias

- **Laravel 13** (Eloquent, Blade, validação, middleware, rotas resource)
- **PHP 8.4**
- **SQLite** (banco leve, zero configuração)
- **Tailwind CSS** + **Chart.js**

## 🏛️ Arquitetura

- Padrão **MVC** com controllers enxutos.
- Relações **Eloquent**: `User hasMany Workout hasMany Exercise`.
- **Autorização** por dono do recurso (HTTP 403 em acesso indevido).
- Agregações no banco (`MAX`, `groupBy`) para os recordes.

## 🚀 Como rodar localmente

```bash
# 1. Clone o repositório
git clone https://github.com/Robertopiress19/fitlog.git
cd fitlog

# 2. Instale as dependências
composer install

# 3. Configure o ambiente
cp .env.example .env
php artisan key:generate

# 4. Crie o banco e popule com dados de exemplo
php artisan migrate:fresh --seed

# 5. Suba o servidor
php artisan serve
```

Acesse **http://localhost:8000**.

### Conta de demonstração

> **E-mail:** demo@fitlog.test
> **Senha:** password

Ou crie a sua própria conta na tela de registro.

## 📋 Próximos passos

- Login social (Google OAuth via Laravel Socialite)
- Testes automatizados (PHPUnit)
- API REST para um futuro app mobile

---

Desenvolvido por **Roberto Pires Neto** · [GitHub](https://github.com/Robertopiress19)
