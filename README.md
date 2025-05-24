# ProManage

## Setup Development Environment

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18 or higher
- MySQL 8.0

### Installation Steps

1. Clone the repository

```bash
git clone <repository-url>
cd ProManage
```

2. Install PHP dependencies

```bash
composer install
```

3. Install Node.js dependencies

```bash
npm install
```

4. Configure your environment

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

5. Database Setup

```bash
# Create a new MySQL database
mysql -u root -p
CREATE DATABASE promanage;
exit

# Update .env with your database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promanage
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Optional: Seed the database with sample data
php artisan db:seed
```

6. Start the development server

```bash
npm run dev
php artisan serve
```

### Running Tests Locally

1. Create a test database

```bash
mysql -u root -p
CREATE DATABASE promanage_testing;
exit
```

2. Create `.env.testing` file (do not commit this file)

```bash
cp .env .env.testing
```

3. Update `.env.testing` with your test database

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promanage_testing
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. Run tests

```bash
php artisan test
```

## CI/CD

The project includes GitHub Actions workflow that:

- Runs on Ubuntu latest
- Sets up PHP 8.2
- Sets up Node.js 18
- Creates a temporary MySQL database for testing
- Runs all tests in parallel

No external database is required for CI/CD as it uses a temporary MySQL instance.
