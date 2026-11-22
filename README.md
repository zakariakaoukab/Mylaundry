# MyLaundry - Laundry System Management

## Overview
MyLaundry is a comprehensive web-based laundry management system designed to streamline the operations of a laundry service. It provides a user-friendly interface for clients to place and track orders, and a robust admin dashboard for managing users, articles (laundry items), and orders.

## Features

### Client Features
- **User Authentication:** Secure login, registration, password reset, and email verification.
- **Order Placement:** Clients can view available laundry items (articles), add them to their cart, and select pickup and delivery dates.
- **Order Tracking:** Real-time tracking of order status.
- **Payment Integration:** Secure checkout using the PayPal SDK.
- **Currency Conversion:** Dynamic conversion from MAD (Moroccan Dirham) to USD using the Exchangeratesapi via GuzzleHTTP.
- **Profile Management:** Update personal information and view order history.

### Admin Features
- **Dashboard Overview:** Quick statistics on total clients, today's orders, and total income.
- **User Management:** View, create, update, delete, ban, and permit users.
- **Order Management:** View all client orders and update their statuses (e.g., Pending, Processing, Delivered).
- **Article Management:** Manage the catalog of laundry items including names, descriptions, and pricing.

## Tech Stack
- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, Tailwind CSS (with Flowbite components), and Bootstrap (for the landing page).
- **PHP Dependencies (Composer):** 
  - `phpmailer/phpmailer`: For sending transactional emails (email verification, password reset).
  - `guzzlehttp/guzzle`: For making external API requests (fetching live currency exchange rates).
- **Node.js Dependencies (npm):** 
  - `tailwindcss`, `@tailwindcss/forms`, `flowbite`: For modern, responsive UI styling.

## Project Structure
- `home.html`: Main landing page for unauthenticated visitors highlighting services.
- `public/`: Contains all the main PHP application files.
  - `public/Admin/`: Admin dashboard and management scripts (Users, Orders, Articles).
  - `public/client/`: Client-side scripts for browsing options, placing orders, and tracking.
  - `public/includes/`: Shared scripts like database connection (`dbcon.php`).
- `src/`: Source CSS files for Tailwind compilation.
- `config/`: Configuration files (e.g., `config_mail.php` for SMTP settings).
- `assets/` & `public/img/`: Static assets such as images and custom CSS used across the application.

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd MyLaundry
   ```

## Database Setup

1. Create a MySQL database named `mylaundry` and update `public/includes/dbcon.php` if your credentials differ from `root` (empty password) on `localhost`.
2. Run the SQL below to create the required tables (`users`, `articles`, `orders`, `order_details`, `event_trace`):

```sql
CREATE DATABASE IF NOT EXISTS mylaundry CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mylaundry;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(55) NOT NULL,
  `lname` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `role` varchar(25) NOT NULL DEFAULT 'client',
  `verify_token` varchar(100) NOT NULL,
  `verify_status` varchar(25) NOT NULL DEFAULT '0',
  `zip` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `articles` (
  `id_article` int(255) NOT NULL AUTO_INCREMENT,
  `article_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(16,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `orders` (
  `order_id` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` decimal(16,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pickupDate` datetime NOT NULL,
  `deliveryDate` datetime NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) NOT NULL,
  `article_id` int(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(16,2) NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `fk_order_details_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `fk_order_details_article` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `event_trace` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `DateEvent` timestamp NOT NULL DEFAULT current_timestamp(),
  `IP_admin` varchar(100) DEFAULT NULL,
  `Comment` varchar(100) NOT NULL,
  `TypeEvent` varchar(50) NOT NULL,
  `AdminId` int(11) NOT NULL,
  `AdminName` varchar(55) NOT NULL,
  PRIMARY KEY (`idEvent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```


3. **Install PHP Dependencies:**
   Ensure you have [Composer](https://getcomposer.org/) installed.
   ```bash
   composer install

4. **Install Node.js Dependencies & Build CSS:**
   Ensure you have [Node.js and npm](https://nodejs.org/) installed.
   ```bash
   npm install
   npm run build
   ```

## ⚠️ Important Post-Installation Steps: Update Credentials

Before deploying or using this application in production, you **MUST** replace the default credentials in the codebase with your own:

1. **Email Configuration (SMTP):**
   - **File:** `config/config_mail.php`
   - **Action:** Replace the `username` (email address) and `password` (app password) with your own SMTP server details. This is required for user registration and password resets to function.

2. **Exchange Rates API Key:**
   - **Files:** 
     - `public/client/save_order.php` (lines 36 and 52)
     - `public/client/t.php` (lines 17 and 33)
   - **Action:** The application uses `api.exchangeratesapi.io` to dynamically convert MAD to USD. You must replace the `access_key` placeholder with your own valid API key.

3. **PayPal SDK Client ID:**
   - **File:** `public/client/finish.php` (line 72)
   - **Action:** Locate the PayPal script tag in the `<head>` section and replace the `client-id=...` parameter with your own PayPal Live/Sandbox Client ID.

## Usage
- Start your local web server (e.g., XAMPP, WAMP) and ensure the MySQL service is running.
- Access the landing page via: `http://localhost/MyLaundry/home.html`
- Access the application login via: `http://localhost/MyLaundry/public/signin.php`
