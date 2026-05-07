-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 27/04/2026 às 13:42
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `totemsenac`
--
CREATE DATABASE IF NOT EXISTS `totemsenac` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `totemsenac`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `actions`
--

CREATE TABLE `actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','draft','published','archived') DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `actions`
--

INSERT INTO `actions` (`id`, `title`, `description`, `start_at`, `end_at`, `location`, `cover_image`, `status`, `created_by`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Oficina de Design Criativo', 'Exploracao de cores, formas e prototipos rapidos.', '2026-01-29 09:00:00', '2026-01-29 12:00:00', 'Senac Registro', 'actions/osEhl961alEX0hFOZDHrAUfmrplXJo4iNfz8BW5q.png', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 16:59:33'),
(2, 'Aula Aberta Gastronomia', 'Demonstracao ao vivo de tecnicas de confeitaria.', '2026-01-30 10:00:00', '2026-01-30 13:00:00', 'Senac Registro', 'actions/action-1.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 'Semana de Tecnologia', 'Palestras sobre IA, apps e futuro do trabalho.', '2026-01-31 11:00:00', '2026-01-31 14:00:00', 'Senac Registro', 'actions/action-2.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 'Laboratorio de Moda', 'Customizacao e tendencias para jovens criadores.', '2026-02-01 12:00:00', '2026-02-01 15:00:00', 'Senac Registro', 'actions/action-3.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 'Workshop de Fotografia', 'Iluminacao, composicao e narrativa visual.', '2026-02-02 09:00:00', '2026-02-02 12:00:00', 'Senac Registro', 'actions/action-4.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 'Maratona Empreendedora', 'Ideias de negocios locais com mentoria.', '2026-02-03 10:00:00', '2026-02-03 13:00:00', 'Senac Registro', 'actions/action-5.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(7, 'Acoes Sustentaveis', 'Projetos verdes e impacto social no bairro.', '2026-02-04 11:00:00', '2026-02-04 14:00:00', 'Senac Registro', 'actions/action-6.svg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(8, 'Oficina de Inovacao', 'Metodos ageis e design thinking.', '2026-02-05 12:00:00', '2026-02-05 15:00:00', 'Senac Registro', 'actions/V0gZn89KNGM8MwcsEKZbIM2ucxJW9jgs90PP0dCh.jpg', 'published', 2, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-04-24 14:17:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(170) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `areas`
--

INSERT INTO `areas` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Beleza e Estética', 'beleza-e-estetica', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(2, 'Bem-estar', 'bem-estar', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(3, 'Comunicação e Marketing', 'comunicacao-e-marketing', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(4, 'Desenvolvimento Social', 'desenvolvimento-social', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(5, 'Design, Artes e Arquitetura', 'design-artes-e-arquitetura', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(6, 'Educação', 'educacao', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(7, 'Gastronomia e Alimentação', 'gastronomia-e-alimentacao', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(8, 'Gestão e Negócios', 'gestao-e-negocios', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(9, 'Idiomas', 'idiomas', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(10, 'Meio Ambiente', 'meio-ambiente', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(11, 'Segurança e Saúde no Trabalho', 'seguranca-e-saude-no-trabalho', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(12, 'Moda', 'moda', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(13, 'Saúde', 'saude', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(14, 'Tecnologia da Informação', 'tecnologia-da-informacao', '2026-04-24 15:36:13', '2026-04-24 15:36:13'),
(15, 'Turismo e Hospitalidade', 'turismo-e-hospitalidade', '2026-04-24 15:36:13', '2026-04-24 15:36:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1777124280);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrepreneurs`
--

CREATE TABLE `entrepreneurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `category` enum('sobremesa','salgado','salgados_doces','servicos') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `whatsapp_message_template` varchar(255) NOT NULL DEFAULT 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `entrepreneurs`
--

INSERT INTO `entrepreneurs` (`id`, `display_name`, `category`, `description`, `whatsapp_number`, `whatsapp_message_template`, `status`, `created_by`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 'Doces da Vila', 'sobremesa', 'Brownies, bolos no pote e brigadeiros artesanais.', '11988880000', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(2, 'Salgados Express', 'salgado', 'Coxinhas, esfihas e combos para festas.', '11988880001', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(3, 'Studio Criativo', 'servicos', 'Design grafico e social media para negocios locais.', '11988880002', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(4, 'Sabores da Serra', 'salgados_doces', 'Lanches, sobremesas e kits especiais.', '11988880003', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(5, 'Tech Ajuda', 'servicos', 'Manutencao de computadores e suporte rapido.', '11988880004', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(6, 'Delicias Fit', 'sobremesa', 'Opcoes sem acucar e sobremesas fitness.', '11988880005', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 5, 1, '2026-01-27 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(8, 'Doces da Vila2', 'sobremesa', NULL, '13981102265', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 3, 1, '2026-03-25 19:10:29', '2026-02-11 16:07:57', '2026-03-25 22:10:29'),
(9, 'Brigadeiros Delicia', 'sobremesa', 'Cansado do básico? Nossa vitrine de hoje traz os clássicos repaginados com um toque gourmet que você nunca provou igual. Cada mordida é uma explosão de sabor!\r\n\r\nNossos sucessos do dia:\r\n\r\n🥥 Beijinho Brûlée: Com aquela casquinha de açúcar queimado crocante.\r\n\r\n🍫 Ao Leite Clássico: O equilíbrio perfeito do cacau.\r\n\r\n🥜 Ninho com Nutella: A combinação que não tem erro.\r\n\r\n🍋 Limão Siciliano: Refrescância e doçura na medida certa.\r\n\r\nConsulte nossos kits e monte sua caixa personalizada!', '11988880000', 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.', 'approved', 4, 1, '2026-04-24 10:57:01', '2026-03-20 19:40:06', '2026-04-24 13:57:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrepreneur_images`
--

CREATE TABLE `entrepreneur_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entrepreneur_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `entrepreneur_images`
--

INSERT INTO `entrepreneur_images` (`id`, `entrepreneur_id`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'entrepreneurs/entrepreneur-0-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(2, 1, 'entrepreneurs/entrepreneur-0-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 2, 'entrepreneurs/entrepreneur-1-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 2, 'entrepreneurs/entrepreneur-1-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 3, 'entrepreneurs/entrepreneur-2-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 3, 'entrepreneurs/entrepreneur-2-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(7, 4, 'entrepreneurs/entrepreneur-3-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(8, 4, 'entrepreneurs/entrepreneur-3-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(9, 5, 'entrepreneurs/entrepreneur-4-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(10, 5, 'entrepreneurs/entrepreneur-4-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(11, 6, 'entrepreneurs/entrepreneur-5-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(12, 6, 'entrepreneurs/entrepreneur-5-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(13, 1, 'entrepreneurs/oJ5fPkjMrRYmG2MwhrNqW6kTOilfgGqYAvDvEtMH.png', 2, '2026-02-11 16:01:22', '2026-02-11 16:01:22'),
(14, 8, 'entrepreneurs/B13m0GPU7dmTkkpYxYy4MN8W97xxTACCyd0fZOmo.png', 0, '2026-02-11 16:07:57', '2026-02-11 16:07:57'),
(15, 9, 'entrepreneurs/UquujRUSAAp1kMq5KAuez132MbzDSapKVYvdN8MA.jpg', 0, '2026-04-23 20:47:54', '2026-04-23 20:47:54');

-- --------------------------------------------------------

--
-- Estrutura para tabela `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','draft','published','archived') DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_at`, `end_at`, `location`, `cover_image`, `status`, `created_by`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Festival de Talentos', 'Apresentacoes culturais, musica e exposicoes.', '2026-02-03 14:00:00', '2026-02-03 18:00:00', 'Auditorio Senac', 'events/event-0.svg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(2, 'Meetup de Tecnologia', 'Networking com profissionais e startups locais.', '2026-02-04 14:00:00', '2026-02-04 18:00:00', 'Auditorio Senac', 'events/event-1.svg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 'Feira de Empreendedorismo', 'Negocios de estudantes e comunidade.', '2026-02-05 14:00:00', '2026-02-05 18:00:00', 'Auditorio Senac', 'events/event-2.svg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 'Mostra de Gastronomia', 'Pratos criativos e degustacoes guiadas.', '2026-02-06 14:00:00', '2026-02-06 18:00:00', 'Auditorio Senac', 'events/event-3.svg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 'Dia da Saude', 'Atendimentos, palestras e orientacoes.', '2026-02-07 14:00:00', '2026-02-07 18:00:00', 'Auditorio Senac', 'events/event-4.svg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 'Cultura Maker', 'Prototipos, impressao 3D e robotica.', '2026-02-08 14:00:00', '2026-02-08 18:00:00', 'Auditorio Senac', 'events/A7x0OaD6hKlHH1BXaUQRLpAPkZYvEAa4yQ0tOlDs.jpg', 'published', 2, '2026-01-28 02:53:53', '2026-01-29 05:53:53', '2026-01-29 17:12:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `event_images`
--

CREATE TABLE `event_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `event_images`
--

INSERT INTO `event_images` (`id`, `event_id`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'events/gallery-0-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(2, 1, 'events/gallery-0-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 1, 'events/gallery-0-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 2, 'events/gallery-1-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 2, 'events/gallery-1-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 2, 'events/gallery-1-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(7, 3, 'events/gallery-2-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(8, 3, 'events/gallery-2-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(9, 3, 'events/gallery-2-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(10, 4, 'events/gallery-3-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(11, 4, 'events/gallery-3-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(12, 4, 'events/gallery-3-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(13, 5, 'events/gallery-4-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(14, 5, 'events/gallery-4-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(15, 5, 'events/gallery-4-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(16, 6, 'events/gallery-5-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(17, 6, 'events/gallery-5-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(18, 6, 'events/gallery-5-2.svg', 2, '2026-01-29 05:53:53', '2026-01-29 05:53:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `integrator_projects`
--

CREATE TABLE `integrator_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course` varchar(255) NOT NULL,
  `class_group` varchar(255) NOT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `member_names` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','published','archived') NOT NULL DEFAULT 'pending',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `integrator_projects`
--

INSERT INTO `integrator_projects` (`id`, `title`, `description`, `course`, `class_group`, `area_id`, `member_names`, `cover_image`, `status`, `created_by`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 'App de Mobilidade', 'Solucao de transporte comunitario para a cidade.', 'Curso Tecnico', 'Turma 10', NULL, NULL, 'projects/D6lv3bYp6gTyI1hyWI0tQjfp3ZUMyUymDzhRbo6R.webp', 'published', 5, 1, '2026-01-29 13:58:56', '2026-01-29 05:53:53', '2026-03-13 21:50:26'),
(2, 'Cozinha Sustentavel', 'Projeto de reaproveitamento de alimentos.', 'Curso Tecnico', 'Turma 11', NULL, NULL, 'projects/CLQZUvzd7Uxs28AjF5lH2UcOiW5hpTDmmWweQ5qu.webp', 'published', 5, 1, '2026-03-25 19:10:22', '2026-01-29 05:53:53', '2026-03-25 22:10:22'),
(3, 'Moda Circular', 'Colecao feita com materiais reciclados.', 'Curso Tecnico', 'Turma 12', NULL, NULL, 'projects/project-2.svg', 'published', 5, 1, '2026-03-20 13:40:18', '2026-01-29 05:53:53', '2026-03-20 16:40:18'),
(4, 'Turismo Criativo', 'Roteiros culturais e gastronomicos locais.', 'Curso Tecnico', 'Turma 13', NULL, NULL, 'projects/project-3.svg', 'published', 5, 1, '2026-01-26 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(5, 'Educacao Financeira', 'Plataforma para jovens aprenderem financas.', 'Curso Tecnico', 'Turma 14', NULL, NULL, 'projects/project-4.svg', 'published', 5, 1, '2026-01-26 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(6, 'Senac Connect', 'Hub de conexoes entre alunos e empresas.', 'Curso Tecnico', 'Turma 15', NULL, NULL, 'projects/project-5.svg', 'published', 5, 1, '2026-01-26 02:53:53', '2026-01-29 05:53:53', '2026-02-11 16:05:06'),
(7, 'Nutrição Sustentável em Comunidades', 'Projeto integrador de Nutrição Sustentável em Comunidades no Vale do Ribeira\r\n\r\nEste projeto tem como objetivo promover a segurança alimentar e a sustentabilidade nas comunidades do Vale do Ribeira por meio do reaproveitamento de alimentos que seriam descartados. A iniciativa busca estabelecer parcerias com feiras, mercados e produtores locais para coletar alimentos ainda próprios para consumo, mas fora do padrão comercial, destinando-os à produção de refeições nutritivas e acessíveis.\r\n\r\nAlém disso, o projeto inclui ações educativas sobre aproveitamento integral dos alimentos, redução do desperdício e práticas de alimentação saudável. Oficinas, palestras e atividades comunitárias serão realizadas para capacitar moradores, incentivando hábitos sustentáveis e fortalecendo a autonomia alimentar local. Dessa forma, a proposta contribui para a diminuição do desperdício, o combate à insegurança alimentar e o desenvolvimento social e ambiental da região.', 'Curso Tecnico Farmácia', 'B26', NULL, 'Luis Gustavo\nAndre Leonardo\nHelena Maria\nAluno Senac', 'projects/5qEZShqwfgIlUAz1Jn6FKmzL22p53oyYHKNTMvTe.jpg', 'published', 3, 1, '2026-03-25 18:33:14', '2026-03-20 15:00:26', '2026-03-25 21:33:24'),
(8, 'Pulseira Security Pink', 'Projeto Pulseira Security Pink\r\n\r\nO projeto Pulseira Security Pink tem como objetivo aumentar a segurança e a proteção das mulheres em ambientes públicos e privados por meio de uma tecnologia acessível e discreta. A proposta consiste no desenvolvimento de uma pulseira inteligente equipada com botão de emergência, geolocalização em tempo real e conexão com um aplicativo móvel, permitindo que a usuária envie alertas rápidos para contatos de confiança ou autoridades em situações de risco.\r\n\r\nAlém da tecnologia, o projeto também busca promover a conscientização sobre a segurança feminina, incentivando a prevenção e o apoio coletivo. A iniciativa contribui para fortalecer a autonomia das mulheres, oferecendo uma ferramenta prática que pode ser utilizada no dia a dia, aumentando a sensação de segurança em deslocamentos, trabalho, estudos e lazer.', 'Curso Tecnico Informática', 'A25', NULL, 'Julia Simoes\nLeonardo Prado', 'projects/RCDveKl9iD5MM5pqx5Fqywd66Qs1pxRP0ClqEb1C.webp', 'published', 4, 1, '2026-03-20 16:32:04', '2026-03-20 15:34:52', '2026-03-20 19:32:12'),
(9, 'ConectaVizinhos', 'O ConectaVizinho é uma plataforma digital projetada para transformar a dinâmica de bairros e condomínios, criando um ecossistema de confiança, conveniência e colaboração. O objetivo central é conectar vizinhos que buscam produtos e serviços àqueles que residem nas proximidades e possuem as competências ou itens desejados, fomentando a economia circular e o senso de comunidade.', 'Curso Tecnico Informática', 'A25', NULL, 'Ricardo Silva mdeiros', 'projects/0DTtiFNnMrCC7bklOfhM4rfE262eh6rsSQWEMzeP.png', 'pending', 7, NULL, NULL, '2026-04-23 20:44:09', '2026-04-23 20:44:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `integrator_project_images`
--

CREATE TABLE `integrator_project_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `integrator_project_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `integrator_project_images`
--

INSERT INTO `integrator_project_images` (`id`, `integrator_project_id`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'projects/gallery-0-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(2, 1, 'projects/gallery-0-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 2, 'projects/gallery-1-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 2, 'projects/gallery-1-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 3, 'projects/gallery-2-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 3, 'projects/gallery-2-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(7, 4, 'projects/gallery-3-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(8, 4, 'projects/gallery-3-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(9, 5, 'projects/gallery-4-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(10, 5, 'projects/gallery-4-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(11, 6, 'projects/gallery-5-0.svg', 0, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(12, 6, 'projects/gallery-5-1.svg', 1, '2026-01-29 05:53:53', '2026-01-29 05:53:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `integrator_project_user`
--

CREATE TABLE `integrator_project_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `integrator_project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_in_project` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `integrator_project_user`
--

INSERT INTO `integrator_project_user` (`id`, `integrator_project_id`, `user_id`, `role_in_project`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Autor', '2026-01-29 05:53:53', '2026-03-13 21:50:26'),
(2, 2, 3, 'Autor', '2026-01-29 05:53:53', '2026-03-13 21:11:38'),
(3, 3, 3, 'Autor', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(4, 4, 3, 'Autor', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(5, 5, 3, 'Autor', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(6, 6, 3, 'Autor', '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(7, 2, 5, 'Autor', '2026-03-13 21:11:38', '2026-03-13 21:11:38'),
(8, 1, 5, 'Autor', '2026-03-13 21:50:26', '2026-03-13 21:50:26'),
(9, 7, 3, 'Autor', '2026-03-20 15:00:26', '2026-03-20 15:18:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_29_020035_create_permission_tables', 1),
(5, '2026_01_29_020117_create_actions_table', 1),
(6, '2026_01_29_020121_create_events_table', 1),
(7, '2026_01_29_020124_create_event_images_table', 1),
(8, '2026_01_29_020128_create_integrator_projects_table', 1),
(9, '2026_01_29_020131_create_integrator_project_images_table', 1),
(10, '2026_01_29_020135_create_entrepreneurs_table', 1),
(11, '2026_01_29_020138_create_entrepreneur_images_table', 1),
(12, '2026_01_29_020140_create_integrator_project_user_table', 1),
(13, '2026_01_29_023925_create_sessions_table', 2),
(14, '2026_02_11_132213_add_photo_to_users_table', 3),
(15, '2026_03_20_000001_add_member_names_to_integrator_projects_table', 4),
(16, '2026_03_20_180000_update_entrepreneur_category_ambos', 5),
(17, '2026_03_25_000001_update_integrator_projects_approved_to_published', 5),
(18, '2026_03_25_000002_add_pending_status_to_actions_events', 5),
(19, '2026_04_24_000001_create_areas_table', 6),
(20, '2026_04_24_000002_add_area_id_to_integrator_projects_table', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-01-29 05:53:52', '2026-01-29 05:53:52'),
(2, 'operador', 'web', '2026-01-29 05:53:52', '2026-01-29 05:53:52'),
(3, 'estudante', 'web', '2026-01-29 05:53:52', '2026-01-29 05:53:52');

-- --------------------------------------------------------

--
-- Estrutura para tabela `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Tbhp8R8t0Aaw6raghLJSGyLlJDYJeFHFGQiAutKF', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnZOZGFvUzNGb2t6S0ZxaUdNZ2tkM0h6QWVJdVlVRnRhTGZXU2JubiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777072479),
('Z61jDQFt1eMnOW97W01WYudNmizPEQHV97jSatSN', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHJ3OElSZzkwN25YekN6RVAxTVE0T2p5M2pmS1lNZWRpY3RKU2h1SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777290110);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@senac.test', NULL, '$2y$12$.oUCU8VmcRagbGAS6hGNc.FSg0SW/Xf4ZMmruViGnH/pdRkJHDkga', 'profiles/SIdcmPPYfTpC49PsbT6CT87DFkSSkxSkn6WtGLSs.png', NULL, '2026-01-29 05:53:53', '2026-03-25 21:26:55'),
(2, 'Operador Totem', 'operador@senac.test', NULL, '$2y$12$sR/yFw3wCmZBmoKTI9wPYOsfQjs03wZqWSxHt2110F2OYx5vT.E1m', NULL, NULL, '2026-01-29 05:53:53', '2026-01-29 05:53:53'),
(3, 'Aluno Senac', 'aluno@senac.test', NULL, '$2y$12$/fUBSe0gY7tzgwGad1.LhuP6uou3tOG..lLic65pSu1c75nb7qgha', 'profiles/wKelmFzo1BjcCxQXHeAnNQgW8aRZieKvXXtdNPca.jpg', NULL, '2026-01-29 05:53:53', '2026-03-13 21:04:58'),
(4, 'Leonardo Prado', 'leonardo@gmail.com', NULL, '$2y$12$.yPf.7zmvlVZLbmxuTMMIODTxba.HPQmnKSsMXMQDTaf3AFLYtwVe', NULL, NULL, '2026-01-29 17:33:52', '2026-04-23 20:45:36'),
(5, 'Aluno Demo', 'aluno.demo@senac.test', NULL, '$2y$12$fGNVl.veqNEyTbxI2VMkieo1u7yvp6lWq90wvSqcIamUOew5OEos2', NULL, NULL, '2026-02-11 16:05:06', '2026-02-11 16:05:06'),
(6, 'Cassio Maciel Gomes', 'cassio@example.com', NULL, '$2y$12$Uko.fObMS9C5Gar1KYYsI.gusALyZoQzopGrFJZnlMwx0KFxu2kfW', NULL, NULL, '2026-03-25 22:32:25', '2026-03-25 22:32:25'),
(7, 'Ricardo Silva mdeiros', 'ricardo@gmail.com', NULL, '$2y$12$ePqNNFSNjA0B8zgW8vkr1OB/yTBNEn.9cn4HQO7.cLl81DTcSsxpa', NULL, NULL, '2026-04-23 20:09:46', '2026-04-23 20:09:46'),
(8, 'Bruno Oliveira', 'bruno@gmail.com', NULL, '$2y$12$vU8Jipzscp3W6jMdZrM7L.Lm9UR1EtAQP.4ZurvNUd8jGwXH3sRGq', NULL, NULL, '2026-04-23 21:22:35', '2026-04-23 21:22:35');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actions_created_by_foreign` (`created_by`);

--
-- Índices de tabela `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `areas_name_unique` (`name`),
  ADD UNIQUE KEY `areas_slug_unique` (`slug`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entrepreneurs_created_by_foreign` (`created_by`),
  ADD KEY `entrepreneurs_approved_by_foreign` (`approved_by`);

--
-- Índices de tabela `entrepreneur_images`
--
ALTER TABLE `entrepreneur_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entrepreneur_images_entrepreneur_id_foreign` (`entrepreneur_id`);

--
-- Índices de tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`);

--
-- Índices de tabela `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_images_event_id_foreign` (`event_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `integrator_projects`
--
ALTER TABLE `integrator_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `integrator_projects_created_by_foreign` (`created_by`),
  ADD KEY `integrator_projects_approved_by_foreign` (`approved_by`),
  ADD KEY `integrator_projects_area_id_foreign` (`area_id`);

--
-- Índices de tabela `integrator_project_images`
--
ALTER TABLE `integrator_project_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `integrator_project_images_integrator_project_id_foreign` (`integrator_project_id`);

--
-- Índices de tabela `integrator_project_user`
--
ALTER TABLE `integrator_project_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `integrator_project_user_integrator_project_id_user_id_unique` (`integrator_project_id`,`user_id`),
  ADD KEY `integrator_project_user_user_id_foreign` (`user_id`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices de tabela `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices de tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices de tabela `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `actions`
--
ALTER TABLE `actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `entrepreneur_images`
--
ALTER TABLE `entrepreneur_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `event_images`
--
ALTER TABLE `event_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `integrator_projects`
--
ALTER TABLE `integrator_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `integrator_project_images`
--
ALTER TABLE `integrator_project_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `integrator_project_user`
--
ALTER TABLE `integrator_project_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  ADD CONSTRAINT `entrepreneurs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `entrepreneurs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `entrepreneur_images`
--
ALTER TABLE `entrepreneur_images`
  ADD CONSTRAINT `entrepreneur_images_entrepreneur_id_foreign` FOREIGN KEY (`entrepreneur_id`) REFERENCES `entrepreneurs` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `integrator_projects`
--
ALTER TABLE `integrator_projects`
  ADD CONSTRAINT `integrator_projects_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `integrator_projects_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `integrator_projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `integrator_project_images`
--
ALTER TABLE `integrator_project_images`
  ADD CONSTRAINT `integrator_project_images_integrator_project_id_foreign` FOREIGN KEY (`integrator_project_id`) REFERENCES `integrator_projects` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `integrator_project_user`
--
ALTER TABLE `integrator_project_user`
  ADD CONSTRAINT `integrator_project_user_integrator_project_id_foreign` FOREIGN KEY (`integrator_project_id`) REFERENCES `integrator_projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `integrator_project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
