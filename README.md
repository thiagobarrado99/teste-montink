# 🚀 Montink Challenge

Build a **Mini ERP** to manage 🧾 Orders, 📦 Products, 🎟️ Coupons, and 🏷️ Inventory.

---

## 🧰 Requested Tech Stack

- 🗄️ DB: MySQL
- 🎨 Frontend: Bootstrap
- 🖥️ Backend: Plain PHP, CodeIgniter 3 or Laravel

---

## ⚙️ Used Tech Stack

- 🗄️ DB: MariaDB Server 11.8.2
- 🎨 Frontend: Bootstrap 5
- 🖥️ Backend: Laravel 12.20.0 (PHP 8.4.10)
- ➕ Additional: Node v20.19.3 with NPM v10.8.2  
  *(Node/NPM are optional — not required to run the project)*

---

## 📋 Required Features

- Database must have the following tables: **Orders**, **Products**, **Coupons**, and **Inventory**
- Admin dashboard to **CRUD** Products with:
  - **Name**
  - **Price**
  - **Variations**
  - **Inventory**
- Automatically create and link an **Inventory** instance when a Product is created (1:1 relationship)
- A separate page for purchasing products, with the 🛒 cart stored in the session (quantities + prices)
- 📦 **Shipping cost** calculation logic:

| Cart Price Range ($)    | Shipping Cost ($) |
|-------------------------|-------------------|
| Less than 52            | 20                |
| 52 to 166.59            | 15                |
| 166.60 to 200           | 20                |
| More than 200           | **0 (Free)**      |

- 🧾 Zip code validation using [ViaCEP API](https://viacep.com.br/)

---

## ✨ Bonus Features

- Product **variations**
- Full **Coupon CRUD** with:
  - Expiration date
  - Minimum cart price to apply
- 📧 Email notifications after order confirmation
- 🔄 REST API (referred to as "Webhook" in the original brief) to update order statuses

---

## 💡 Additional Features (Not Required but Added)

- Database fully managed by **migrations**
- Admin dashboard 🔒 protected by login/password
- 📈 Inventory history tracking
- Coupon system with:
  - Expiration date
  - Max usage limits
- Centralized logic for shipping cost rules

---

## 🧑‍💻 Developer Notes

- Since the challenge was relatively simple, I implemented a few **extra features** to improve the project.
- While I typically follow **strict SOLID** principles, I respected the request to **avoid overengineering**.
- MariaDB was chosen over MySQL due to its **open-source** nature and compatibility.
- Though **Node/NPM** aren't required, using them is a better local dev practice, especially for Laravel **queues**.
- Admin and frontend/cart pages were **separated** for better **security** and adherence to **standard design patterns**.

---

## 🛠️ Installation

_Make sure to use updated versions of both_ **PHP (8.4.x)** _and_ **Composer (2.8.x)**.

To install and configure the project locally:

1. Clone the repository
2. Run the following commands in the project root:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

3. Adjust the `.env` file to match your local environment

---

## 🗃️ Database

You have two options to set up the database:

### Option 1: Laravel Migrations

```bash
php artisan migrate --seed
```

> This will create all tables and seed them with default data.

### Option 2: SQL Import

Import the `setup.sql` file manually into your database to create and seed the tables.

---

## ▶️ Running the Project

Choose one of the following options to start the app locally:

### ✅ With Node/NPM (recommended):

```bash
composer run dev
```

### 🚫 Without Node/NPM:

```bash
php artisan serve
```

> Both commands will boot the system at **http://localhost:8000**

## 🔐 Access credentials

Use these default credentials for admin login:

User: **admin@montink.com**

Pass: **password**
