<p align="center">
  <img src="/public/logo.png" alt="Mini Wallet Logo" height="100">
</p>

# Mini Wallet Laravel Application
💼 Mini Wallet — Laravel Application
Mini Wallet is a lightweight Laravel-based wallet system designed for simplicity, speed, and real-time financial interactions. It offers secure user-to-user transactions, live balance updates, and a clean dashboard experience — perfect for learning, prototyping, or building your own wallet solution.

# Features
✨ Key Features
- [x] 🔐 Secure User Authentication — Built-in Laravel auth for safe access

- [x] 💸 Real-Time Transactions — Live balance updates using Pusher

- [x] 📊 Transaction History — View sender/receiver logs with timestamps

- [x] 🖼️ Modern Landing Page — Clean and responsive UI with Tailwind CSS

- [x] 🐳 Docker-Ready Setup — Easy installation with Laravel Sail

- [x] 🌱 Seeded Demo Users — Preloaded users for instant testing

## 🏠 Landing Page
![](/images/landing-page.png)

## 🔄 Transaction Page
- [x] This show transaction history between Sender & Receiver.
- [x] Real-time Balance update using Pusher

![](/images/transaction-page.png)


## Installation Guide :

## With Docker:

```
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  laravelsail/php82-composer \
  composer install
  ```

  Start Docker:
  ```
  ./vendor/bin/sail up -d
  ```

  Migrate tables:
  ```
  ./vendor/bin/sail artisan migrate
  ```

  Seed Tables:
  ``` 
  ./vendor/bin/sail artisan db:seed --class=UserSeeder
  ```

  ## Without Docker:
  Install Dependencies:
  ```
  composer install
  ```

  Create database and then Migrate tables:
  ```
  php artisan migrate
  ```

  Seed tables:
  ```
  php artisan db:seed --class=UserSeeder
  ```
  Run Application:
  ```
  php artisan serve
  ```

  > [!NOTE]
  > Important: Please update Puhser in .env with your credentials!

  ## 👥 Application Users:
   Two users are created. 

   User 1:
   >**email:** `ali@gmail.com`   
   >**password:** `asd123456`

  User 2:
   >**email:** `bilal@gmail.com`   
   >**password:** `asd123456`

   When sending transaction using ***ali@gmail.com*** you can use receiver id 2.