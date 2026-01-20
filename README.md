# LMS NCST

A Learning Management System built with Laravel 12, Filament 5, and Livewire 4.

## Requirements

- PHP 8.3.20 or higher
- MySQL Database
- Composer
- Node.js & NPM

## Tech Stack

- **Laravel Framework:** 12.47.0
- **Filament Admin Panel:** 5.0.0
- **Livewire:** 4.0.1
- **Tailwind CSS:** 4.1.18
- **Pest Testing Framework:** 4.3.1

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd lms-ncst
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update the `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lms_ncst
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

## Development

### Running the application

1. **Start the development server**
   ```bash
   php artisan serve
   ```

2. **Run Vite for asset compilation** (in a separate terminal)
   ```bash
   npm run dev
   ```

   Or use the Composer script:
   ```bash
   composer run dev
   ```

3. **Access the application**
   - Frontend: http://localhost:8000
   - Filament Admin: http://localhost:8000/admin

### Code Quality

**Format code with Laravel Pint**
```bash
vendor/bin/pint
```

**Format only modified files**
```bash
vendor/bin/pint --dirty
```

### Testing

**Run all tests**
```bash
php artisan test --compact
```

**Run specific test file**
```bash
php artisan test --compact tests/Feature/ExampleTest.php
```

**Filter tests by name**
```bash
php artisan test --compact --filter=testName
```

## Project Structure

- `app/Models/` - Eloquent models (User, Student, Teacher, Course, Department)
- `app/Filament/` - Filament admin resources
- `app/Http/Controllers/` - Application controllers
- `database/migrations/` - Database migrations
- `database/factories/` - Model factories
- `resources/views/` - Blade templates
- `routes/` - Application routes
- `tests/` - Pest test files

## License

This project is proprietary software.

