# Project Management SaaS API

A RESTful API built with Laravel 11 for managing collaborative workspaces.

## 🚀 Features
- Workspace management
- Project management
- Board & task tracking
- Comment system
- Role-based access control (RBAC)
- Authentication with Laravel Sanctum
- Email verification

## 🏗️ Architecture
- Laravel 11 (REST API)
- PostgreSQL
- Policy-based authorization
- Modular domain structure

## 📂 Domain Structure
Workspace → Project → Board → Task → Comment

## 🔐 Authentication
- Token-based authentication (Sanctum)
- Email verification flow
- Rate limiting

## ⚙️ Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
