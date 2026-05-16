# Shift Manager

A Laravel-based shift management system for managing companies, staff, assigned shifts, rota hours, and basic earnings calculations.

## Features

### Companies
- Add, edit, and search companies.
- Store company contact details including:
  - Company name
  - Email
  - Phone number
  - Day rate
  - Night rate
  - Weekend rate

### Company Hours
- View company hours within a selected date range.
- Filter company records by date.
- Display total hours worked and total billable amount per company.

### Staff Hours
- View staff hours within a selected date range.
- Search staff by name or email.
- Display:
  - Completed hours
  - Cancelled hours
  - Gross earnings
- Prompt staff to confirm hours.

### Staff Rota
- View individual staff rota.
- Display weekly hours and gross earnings.
- Staff shifts can be confirmed or disputed.

### Shift Assignment
- Assign shifts to individual staff members.
- Select company and shift type.
- Set start and end date/time.
- Add hourly rate and break duration.
- Assign the same shift across selected days of the week.
- Automatically calculate planned hours and estimated gross earnings.

## Shift Types

The system supports shift types such as:

- Day
- Night
- Late

## Tech Stack

- Laravel
- PHP
- MySQL
- Blade / Livewire
- Tailwind CSS

## Installation
Clone repo then install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create your environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure your database details in the `.env` file:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Run the migrations and seeders:

```bash
php artisan migrate --seed
```

Compile the frontend assets:

```bash
npm run dev
```

Start the local development server:

```bash
php artisan serve
```

The application should now be available at:

```bash
http://127.0.0.1:8000
```

 ## Author

Built by Panashe Makanza.