# Simple Multi-Vendor System (أركان الأسرة)

A comprehensive digital platform designed to support productive families by providing a modern marketplace to showcase and sell their products directly to customers.

## 🚀 Key Features

### 🛍️ Product & Vendor Management

- **Vendor Stores:** Dedicated profile pages for each vendor (productive family) displaying their unique products, logo, and brief description.
- **Product Catalog:** Easily manage products with multiple images, detailed descriptions, categories, and pricing.
- **Direct Communication:** Seamless WhatsApp integration allowing customers to contact vendors directly for purchases or inquiries.
- **Engagement Tracking:** Automatically track product page views and WhatsApp engagement clicks.

### 🌐 Customer Experience

- **Responsive Design:** A fully responsive, premium user interface built with Blade featuring Arabic (RTL) support.
- **Marketplace Browsing:** Easy navigation through product categories and individual vendor stores.
- **Detailed Product Views:** Comprehensive product pages featuring image galleries, pricing, and related vendor information.

### ⚙️ Administration

- **Role-Based Access Control (RBAC):** Secure access for System Administrators and Vendors using Spatie Permissions.
- **Dashboard:** Centralized control panel for managing users, products, categories, roles, and system settings.
- **Profile Management:** Vendors can update their details, logos, and business descriptions seamlessly.

## 🛠️ Tech Stack

### Application Stack

- **Framework**: [Laravel 12.x](https://laravel.com)
- **Features**: Spatie Permission (RBAC), Authentication, Image Uploads, Arabic Localization (RTL).
- **Frontend Engine**: Laravel Blade, Custom CSS, JavaScript.

## 📦 Getting Started

### Quick Setup

```bash
# Application Setup
composer install
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Run Migrations & Seeders (to populate Roles, Admins, etc.)
php artisan migrate --seed

# Create storage link for images
php artisan storage:link

# Start the application
php artisan serve
```
