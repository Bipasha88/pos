# Point of Sale (POS)

A multi-business **Point of Sale** platform. It has two parts:

1. A **Laravel 8 backend** that serves a super-admin panel and a **JWT-secured REST API**.
2. A **Vue.js client app** where business owners manage their branches, staff and inventory.

<!-- Team project: say who built it and what YOUR part was, for example:
> Built as a team project during <program / course name>.
> **My contributions:** <e.g. JWT auth, Branch & Vendor APIs, the repository/service layer, Dockerfile, Vue product pages>
-->

<!-- Add screenshots: admin business list, client dashboard, product list -->

## Features

**Super-admin panel (Laravel + Blade, AdminLTE)**
- Admin login, protected by an admin middleware
- List, search, edit and delete businesses
- Archive and unarchive businesses
- Public landing page

**Business owner API (JWT)**
- Register and log in to receive a JWT
- Registration creates the owner account and their business in one **database transaction**, then sends a registration email
- Full CRUD for **branches, employees, products, categories and vendors**
- Vendor ↔ branch ownership lookups

**Client app (Vue.js, CoreUI)**
- Login and registration
- Dashboard
- Pages to add, edit and list branches, employees, products and categories

## Architecture

```
point-of-sale/
├── PointOfSale/          # Laravel 8 – admin panel + REST API
│   └── app/
│       ├── Http/Controllers/   # Admin/ (web) and User/ (API)
│       ├── Http/Middleware/    # JwtMiddleware, AdminMiddleware
│       ├── Http/Requests/      # Form Request validation per action
│       ├── Services/           # Business logic (interface + implementation per domain)
│       ├── Repository/         # Data access (interface + implementation per domain)
│       ├── BusinessObjects/    # Domain objects passed between layers
│       ├── ApiModels/          # Response models for the API
│       └── ViewModels/         # Data for the Blade admin views
├── pointofsaleview/      # Vue.js client (CoreUI template)
└── docs/                 # UI themes used (AdminLTE, CoreUI, Arsha)
```

Requests pass through **Controller → Service → Repository**, and each layer depends on an interface. The REST API is protected by JWT middleware (`tymon/jwt-auth`), and the admin panel by a separate admin middleware.

## API (prefix `/api`)

| Method | Endpoint                                      | Description                      |
|--------|-----------------------------------------------|----------------------------------|
| POST   | `/register`                                   | Register a business owner        |
| POST   | `/login`                                      | Log in and get a JWT             |
| CRUD   | `/business/branch`                            | Branches                         |
| CRUD   | `/business/employee`                          | Employees                        |
| CRUD   | `/business/product`                           | Products                         |
| CRUD   | `/business/category`                          | Categories                       |
| CRUD   | `/business/vendor`                            | Vendors                          |
| GET    | `/business/list`, `/business/brancheslist`, … | Lookups for the owner's data     |

All `/business/*` routes require the header `Authorization: Bearer <token>`.

## Tech stack

| Part     | Technology                                    |
|----------|-----------------------------------------------|
| Backend  | PHP 7.4, Laravel 8, JWT (`tymon/jwt-auth`), MySQL |
| Admin UI | Blade, AdminLTE 3, Arsha (landing page)       |
| Client   | Vue.js 2, CoreUI, Axios                       |
| DevOps   | Docker (PHP-FPM image)                        |

## Getting started

### Backend & admin panel

```bash
cd PointOfSale
composer install
npm install

cp .env.example .env
php artisan key:generate
# In .env: set the DB_* and MAIL_* values

php artisan migrate --seed
php artisan jwt:secret

php artisan serve          # http://localhost:8000 (admin: /admin)
```

Or build the backend image with Docker:

```bash
cd PointOfSale
docker build -t pos-backend .
```

### Client app

```bash
cd pointofsaleview
yarn install
yarn serve                 # http://localhost:8080
```
