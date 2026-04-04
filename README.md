🛒 Laravel E-Commerce (Paystack Integration)

A simple e-commerce web application built with Laravel, featuring product management, cart system, and secure payments via Paystack.

🚀 Features
Product listing & details
Add to cart
Checkout system
Paystack payment integration
Order management
Responsive UI
🛠️ Tech Stack
Laravel (PHP)
MySQL
Blade Templates
Bootstrap / CSS
JavaScript
⚙️ Setup
git clone https://github.com/your-username/your-project.git
cd your-project
composer install
cp .env.example .env
php artisan key:generate
🔧 Configure .env

Update your database and Paystack keys:

DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=

PAYSTACK_PUBLIC_KEY=your_public_key
PAYSTACK_SECRET_KEY=your_secret_key
🗄️ Run Project
php artisan migrate
php artisan serve

Visit:

http://127.0.0.1:8000
🔐 Important Notes
Do NOT upload .env to GitHub
Keep your Paystack keys secure
Use .env.example for sharing config
💳 Payment

Payments are processed securely using Paystack.

👨‍💻 Author

Your Name
