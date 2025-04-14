# RavaelaBkod

Web application for medical check-ups and drug management.

## Installation Guide

1. Clone the repository:
```bash
git clone https://github.com/yourusername/RavaelaBkod.git
cd RavaelaBkod
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env` file and run migrations:
```bash
php artisan migrate --seed
```

6. Start development servers:
```bash
php artisan serve
npm run dev
```

## Route Documentation

### Authentication Routes
| Method | URI | Controller | Middleware | Description |
|--------|-----|------------|------------|-------------|
| GET | /register | AuthController@showRegisterForm | - | Show registration form |
| POST | /register | AuthController@register | - | Process registration |
| GET | /login | AuthController@showLoginForm | - | Show login form |
| POST | /login | AuthController@login | - | Process login |
| POST | /logout | AuthController@logout | auth | Process logout |

### Doctor Routes
| Method | URI | Controller | Middleware | Description |
|--------|-----|------------|------------|-------------|
| GET | /dokter/dashboard | - | auth, role:dokter | Doctor dashboard |
| GET | /dokter/obat | ObatController@index | auth, role:dokter | List medicines |
| GET | /dokter/obat/create | ObatController@create | auth, role:dokter | Create medicine form |
| POST | /dokter/obat | ObatController@store | auth, role:dokter | Store new medicine |
| GET | /dokter/obat/{id}/edit | ObatController@edit | auth, role:dokter | Edit medicine form |
| PUT | /dokter/obat/{id} | ObatController@update | auth, role:dokter | Update medicine |
| DELETE | /dokter/obat/{id} | ObatController@destroy | auth, role:dokter | Delete medicine |

### Patient Routes
| Method | URI | Controller | Middleware | Description |
|--------|-----|------------|------------|-------------|
| GET | /pasien/dashboard | - | auth, role:pasien | Patient dashboard |

## Role-Based Access Control (RBAC)

The application implements RBAC through:

1. User Roles
- Defined in users table migration:
```php
$table->enum('role', ['pasien', 'dokter'])->default('pasien');
```

2. Role Middleware
- Registered in `bootstrap/app.php`:
```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

3. Route Protection
- Doctor routes are protected with `role:dokter` middleware
- Patient routes are protected with `role:pasien` middleware
- Both require authentication via `auth` middleware

4. User Model Relations
```php
// Relationship for patient's medical checks
public function pasiens(): HasMany
{
    return $this->hasMany(Periksa::class, 'id_pasien');
}

// Relationship for doctor's medical checks
public function dokters(): HasMany
{
    return $this->hasMany(Periksa::class, 'id_dokter');
}
```

### Testing RBAC

You can verify RBAC functionality by:
1. Logging in as a doctor - Can access /dokter/* routes but not /pasien/* routes
2. Logging in as a patient - Can access /pasien/* routes but not /dokter/* routes
3. Unauthorized users - Redirected to login when accessing protected routes
