## Installation

Clone this repo

```bash
git clone https://github.com/diurvan/employee_schedule.git
```

Go to backend folder and create .env file:

```bash
cp .env.example .env
nano .env
```

Install backend dependencies, build app, run migrations and seeds:

```bash
composer install
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
php artisan db:seed --class=ScheduleUserSeeder
php artisan db:seed --class=ScheduleUserBookingSeeder
```

Start backend:

```bash
php artisan serve
```

## Access Data

User: admin@admin.com
Password: P@ssw0rd

## Api Excel download

http://localhost:8000/api/searchexcel/2024-10-01/10:00:00