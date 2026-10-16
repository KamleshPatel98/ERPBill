# ERPBill

ERPBill is a web-based ERP and billing management system developed using Laravel, Blade, Bootstrap, JavaScript, jQuery, AJAX, HTML, CSS, and MySQL.

The application provides a centralized system for managing products, purchases, sales, returns, stock, ledgers, reports, settings, and other business operations.

---

## 🚀 Project Overview

ERPBill is designed to simplify business and billing operations through a responsive web-based ERP panel.

The application provides modules for:

- Product Management
- Sales Management
- Purchase Management
- Sales Returns
- Purchase Returns
- Stock Management
- Ledger Management
- Master Management
- Reports
- PDF / Invoice Generation
- Settings
- Dashboard
- Authentication

The system uses Laravel Blade for server-side rendered pages and AJAX/jQuery for dynamic operations without unnecessary page reloads.

---

## 🛠️ Technologies Used

### Backend

- PHP
- Laravel
- MySQL
- Laravel Eloquent ORM
- Laravel Blade

### Frontend

- HTML5
- CSS3
- Bootstrap
- JavaScript
- jQuery
- AJAX

### Additional Libraries / Tools

- SweetAlert2
- Select2
- Datepicker
- Vite
- Composer
- NPM

---

## ✨ Main Features

### 🔐 Authentication

- User login
- Authentication layout
- Session-based authentication
- Protected ERP panel
- Validation and security

### 📊 Dashboard

- Business overview
- Important statistics
- Quick access to ERP modules
- Summary information
- Recent business activities

### 📦 Product Management

- Product management
- Product information
- Product pricing
- Product-related transactions
- Stock-related information

### 🛒 Purchase Management

- Purchase entry
- Purchase listing
- Purchase details
- Purchase transactions
- Purchase-related payments
- Purchase records

### 🔄 Purchase Returns

- Purchase return management
- Return entry
- Return details
- Return transactions
- Return-related calculations

### 💰 Sales Management

- Sales entry
- Sales listing
- Sales details
- Billing
- Invoice generation
- Payment management
- Sales calculations

### ↩️ Sales Returns

- Sales return management
- Return entry
- Return details
- Return transactions
- Refund/payment related calculations

### 📦 Stock Management

- Stock management
- Stock records
- Stock tracking
- Product stock information
- Stock-related reports

### 📒 Ledger Management

- Ledger management
- Transaction records
- Debit/Credit information
- Business transaction tracking

### 📈 Reports

The reporting section provides business-related reports for different ERP modules.

Reports may include:

- Sales Reports
- Purchase Reports
- Stock Reports
- Ledger Reports
- Return Reports
- Transaction Reports

### 🏢 Masters

Master data required for ERP operations is managed from the Masters section.

This provides centralized management of common business information used throughout the application.

### ⚙️ Settings

Application and business-related settings are managed through the Settings section.

### 🧾 PDF / Invoice

The application includes dedicated PDF-related views for:

- Invoice generation
- Invoice printing
- Business documents
- PDF output

---

# 📁 Project Structure

```text
ERPBill/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       │
│       ├── components/
│       │   ├── alert.blade.php
│       │   ├── company-header.blade.php
│       │   ├── datepicker.blade.php
│       │   ├── dropdown.blade.php
│       │   └── is-active.blade.php
│       │
│       ├── layouts/
│       │   ├── auth.blade.php
│       │   ├── invoice.blade.php
│       │   └── panel.blade.php
│       │
│       ├── panel/
│       │   ├── auth/
│       │   ├── ledgers/
│       │   ├── masters/
│       │   ├── pdfs/
│       │   ├── products/
│       │   ├── purchase-returns/
│       │   ├── purchases/
│       │   ├── reports/
│       │   ├── sale-returns/
│       │   ├── sales/
│       │   ├── settings/
│       │   └── stocks/
│       │
│       ├── dashboard.blade.php
│       └── welcome.blade.php
│
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
│
├── storage/
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
├── vite.config.js
└── README.md