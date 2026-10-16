# ERPBill – Billing, Inventory & Business Management System

ERPBill is a Laravel-based billing, inventory, and business management application designed to help businesses manage daily sales, purchases, products, customers, invoices, and reports.

This repository contains a **limited demo version** of ERPBill. The complete commercial version includes additional modules and advanced functionalities that are not included in this public demo.

## 🚀 Project Overview

ERPBill provides a centralized admin panel for essential business operations. The demo version allows users to explore customer management, product management, sales transactions, invoice printing, customer ledgers, and sales reports.

The full commercial version extends these capabilities with purchase management, supplier management, stock monitoring, purchase and sales returns, GST configuration, financial year management, and additional reporting features.

## ✨ Demo Version Features

### 1. Authentication & Dashboard
- Admin login and logout
- Authenticated dashboard
- Centralized navigation to available modules

### 2. Customer Management
- Create, view, update, and delete customer records
- Maintain customer information for sales transactions

### 3. Product Management
- Add and manage products
- View and update product information
- Delete product records

### 4. Sales Management
- Create and manage sales transactions
- View and update sales records
- Generate and print sales invoices

### 5. Customer Ledger
- View customer ledger information
- Print customer ledger details

### 6. Sales Reports
- View sales reports
- Print sales report details

### 7. Application Settings
- View application configuration data
- Update supported application settings

## 💼 Full Commercial Version – Advanced Features

The complete commercial version includes additional business modules designed to support broader billing, inventory, purchasing, and transaction-management workflows.

### 1. Master Management
- **Financial Year Management:** Manage financial year records
- **Category Management:** Organize products into categories
- **Unit Management:** Manage product measurement units
- **GST Management:** Configure GST rates
- **Payment Mode Management:** Maintain payment mode records
- **State Management:** Manage state master records
- **Supplier Management:** Maintain supplier information
- **Customer Management:** Maintain customer records

### 2. Purchase Management
- Create and manage purchase transactions
- Generate and print purchase invoices
- Maintain purchase records
- Manage purchase return transactions
- Generate and print purchase return invoices
- Access purchase reports

### 3. Sales & Return Management
- Manage sales transactions
- Generate and print sales invoices
- Process sales return transactions
- Generate and print sales return invoices
- Access sales reports

### 4. Inventory & Stock Management
- View current stock
- Identify low-stock products
- Monitor inventory through stock-related modules

### 5. Customer & Supplier Ledgers
- View and print customer ledger information
- View and print supplier ledger information
- Access transaction-related ledger records

### 6. Business Reports
- Sales reports
- Purchase reports
- Printable sales report details
- Printable purchase report details

### 7. Application Configuration
- Manage supported website and application settings

*Note: Advanced features listed above describe the full version's intended modules. Exact calculations and workflows depend on their implementation in the commercial release.*

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming |
| Laravel | Web application framework |
| MySQL | Database management |
| HTML5 | Page structure |
| CSS3 | Styling |
| Bootstrap | Responsive user interface |
| JavaScript | Client-side interactions |
| AJAX | Asynchronous requests |

## 📋 Prerequisites

Before installing the project, ensure you have:

- PHP compatible with the Laravel version used by this project
- Composer
- MySQL or MariaDB
- Apache or another supported web server
- Required PHP extensions

## ⚙️ Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/KamleshPatel98/ERPBill.git
cd ERPBill
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure the Environment

Create the environment configuration file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Update the database configuration in your `.env` file:

```env
APP_NAME=ERPBill
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erpbill
DB_USERNAME=root
DB_PASSWORD=
```

Use the database credentials configured on your local system. Create a MySQL database named `erpbill` before proceeding.

### 4. Run Database Migrations

Run the migrations to create the required database tables:

```bash
php artisan migrate
```

### 5. Seed Demo Data

Populate the database with the required demo data, including the demo administrator account configured in the project's seeders:

```bash
php artisan db:seed
```

Make sure the project's `DatabaseSeeder.php` calls the appropriate seeder and that the administrator account is created correctly.

### 6. Start the Application

Run the Laravel development server:

```bash
php artisan serve
```

Open the application in your browser:

http://127.0.0.1:8000

The root URL redirects to the login page.

## 🔑 Demo Login Credentials

After successfully running the database migrations and seeders, use the following credentials to log in.

| Field | Value |
|---|---|
| Email | `admin@gmail.com` |
| Password | `password1@` |

**Login URL:** http://127.0.0.1:8000/panel/login

**Important:** These credentials are intended for local demonstration only. Change or disable the demo credentials before deploying the application publicly. Do not use this password for any personal or production account.

## 🔐 Security

- Never commit `.env` files, database passwords, API keys, or sensitive business data.
- Set `APP_DEBUG=false` in production.
- Use strong passwords for administrator accounts.
- Restrict access to authenticated business modules.
- Configure HTTPS before public deployment.
- Avoid exposing real customer, supplier, or transaction data in demo environments.

## 🎯 Intended Use

ERPBill is designed for businesses seeking a centralized solution for billing, sales, purchasing, inventory monitoring, and transaction reporting.

The public demo allows recruiters, developers, and prospective customers to evaluate the available basic functionality. Additional features and customization options are available separately through the complete commercial version.

## 📩 Interested in the Complete Version?

This repository contains a limited demo version of ERPBill. The complete commercial version offers additional business modules and functionalities that are not included in this public repository.

For the full version, pricing, customization, or business-specific requirements, please get in touch.

**Developer:** Kamlesh Patel

- **GitHub Profile:** https://github.com/KamleshPatel98
- **Project Repository:** https://github.com/KamleshPatel98/ERPBill

## 👨‍💻 About the Developer

**Kamlesh Patel – Laravel Developer**

This project demonstrates Laravel application development using authentication, CRUD operations, database-driven modules, invoice workflows, ledgers, and reports.

## 📄 License

Refer to the license file included in this repository for the applicable usage and distribution terms.
