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

2. **Database Setup:**
   - Create a MySQL database named `mylaundry`.
   - The application connects to `localhost` with the username `root` and an empty password by default. Update the database credentials in `public/includes/dbcon.php` if your local setup differs.
   - *(Note: Ensure the required tables `users`, `articles`, `orders`, and `order_details` are created according to the schema expected by the application).*

3. **Install PHP Dependencies:**
   Ensure you have [Composer](https://getcomposer.org/) installed.
   ```bash
   composer install
   ```

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
