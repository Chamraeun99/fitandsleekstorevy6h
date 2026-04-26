# FitandSleek Pro

FitandSleek Pro is a full-stack eCommerce platform with a Laravel API backend and a React frontend.  
This repository includes the application code, local environment scripts, and Docker-based development setup.

## Table of Contents

- [Project Overview](#project-overview)
- [Key Features](#key-features)
- [Technology Stack](#technology-stack)
- [Repository Structure](#repository-structure)
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Manual Setup](#manual-setup)
- [Environment Variables](#environment-variables)
- [Running with Docker](#running-with-docker)
- [API Overview](#api-overview)
- [Database](#database)
- [Common Development Commands](#common-development-commands)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Project Overview

The platform supports a complete commerce workflow:

- Product catalog browsing with categories and search
- Customer authentication and profile management
- Cart and checkout processing
- Payment handling and order tracking
- Admin modules for products, categories, customers, and orders

## Key Features

- **Storefront**: product listings, detail pages, cart, and checkout
- **Authentication**: Laravel Sanctum-based auth endpoints and session/token flow
- **Admin operations**: management pages and APIs for commerce operations
- **Media support**: product imagery and static assets for storefront and admin
- **Multi-service architecture**: Laravel backend, React frontend, and supporting services

## Technology Stack

- **Backend**: Laravel 12, PHP, PostgreSQL, Sanctum
- **Frontend**: React 18, Vite, Tailwind CSS
- **Supporting services**: Python/FastAPI modules in `fastapi/` and `ai-service/`
- **Tooling**: Docker Compose, Composer, npm

## Repository Structure

- `backend/` - Laravel application (API, business logic, migrations, seeders)
- `frontend/` - React application (Vite + Tailwind)
- `fastapi/` - Additional Python API service components
- `ai-service/` - AI-related service code and integration utilities
- `docker-compose.yml` - Core container orchestration
- `docker-compose.fullstack.yml` - Extended full-stack compose setup
- `setup.bat` / `setup.sh` - One-step local bootstrap scripts

## Prerequisites

Install these dependencies before setup:

- PHP 8.1+ and Composer
- Node.js 18+ and npm
- PostgreSQL 13+
- Docker Desktop (recommended)

## Quick Start

Run from the project root.

### Windows

```bat
setup.bat
```

### macOS/Linux

```bash
sh setup.sh
```

What setup scripts do:

1. Create `backend/.env` from `backend/.env.example` if missing
2. Install backend dependencies (`composer install`)
3. Install frontend dependencies (`npm install`)
4. Run Laravel migrations
5. Start containers via Docker Compose

## Manual Setup

Use manual setup when you want explicit control of each step.

### 1) Backend setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Default backend URL: `http://127.0.0.1:8001`

### 2) Frontend setup

```bash
cd frontend
npm install
npm run dev
```

Default frontend URL: `http://127.0.0.1:5173`

## Environment Variables

### Backend (`backend/.env`)

Configure database, app URL, cache/session, mail, and external service credentials.

Important notes:

- Ensure DB credentials match your PostgreSQL instance.
- Keep secrets private and never commit sensitive keys.

### Frontend (`frontend/.env`)

Recommended local values:

```env
VITE_API_BASE_URL=http://127.0.0.1:8001/api
VITE_BACKEND_ORIGIN=http://127.0.0.1:8001
```

## Running with Docker

From project root:

```bash
docker compose up -d --build
```

If your environment uses older Docker Compose:

```bash
docker-compose up -d --build
```

To stop services:

```bash
docker compose down
```

## API Overview

Representative endpoint groups used by the frontend:

- **Auth**: `POST /api/auth/register`, `POST /api/auth/login`, `POST /api/auth/logout`, `GET /api/me`
- **Catalog**: `GET /api/categories`, `GET /api/products`, `GET /api/products/{slug}`
- **Cart**: `GET /api/cart`, `POST /api/cart/items`, `PATCH /api/cart/items/{id}`, `DELETE /api/cart/items/{id}`
- **Orders**: `POST /api/checkout`, `GET /api/orders`
- **Admin**: `/api/admin/categories`, `/api/admin/products`, `/api/admin/orders`, `/api/admin/customers`

## Database

- Migrations: `backend/database/migrations/`
- Seeders: `backend/database/seeders/`
- Optional sample import: `fitandsleekpro.sql` (if available in your local copy)

## Common Development Commands

### Backend

```bash
cd backend
php artisan serve
php artisan migrate
php artisan test
```

### Frontend

```bash
cd frontend
npm run dev
npm run build
npm run preview
```

## Troubleshooting

- **Frontend folder appears as submodule on GitHub**
  - Remove gitlink tracking and nested `frontend/.git`, then commit and push frontend as normal files.
- **`npm install` or `composer install` fails**
  - Confirm required versions of Node.js, npm, PHP, and Composer are installed.
- **Database connection error**
  - Verify database host, port, username, password, and database name in `backend/.env`.
- **CORS or API URL issues**
  - Check `VITE_API_BASE_URL` and `VITE_BACKEND_ORIGIN` in `frontend/.env`.

## Contributing

This is an internal project repository.

Recommended workflow:

1. Create a feature branch from `main`
2. Keep commits focused and descriptive
3. Run relevant tests/builds before opening a pull request
4. Request review and address feedback before merge

## License

All rights reserved unless explicitly stated otherwise by the repository owner.
