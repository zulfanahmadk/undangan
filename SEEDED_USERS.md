# Seeded Users & Credentials

This document lists all the test users that are created by the database seeders.

## How to Run Seeders

### First Time Setup
```bash
php artisan migrate
php artisan db:seed
```

### Or Use the Setup Route
Visit: `http://localhost:8000/setup/migrate`

This will automatically run all migrations and seeders.

---

## Available Test Users

### Admin Users (Full Access)

#### Option 1: Test Admin
- **Email**: `test@example.com`
- **Password**: `password`
- **Role**: Admin (👑)
- **Access**: Full system access, can manage users, guests, and everything

#### Option 2: Admin User
- **Email**: `admin@example.com`
- **Password**: `admin123`
- **Role**: Admin (👑)
- **Access**: Full system access, can manage users, guests, and everything

### Regular User (Limited Access)

#### Test User
- **Email**: `user@example.com`
- **Password**: `password`
- **Role**: User (👤)
- **Access**: Can view dashboard and guests, **cannot** create/edit/delete users

---

## Login Process

1. Navigate to `/login`
2. Enter email and password from above
3. Click "Masuk" button
4. You'll be redirected to `/admin/dashboard`

---

## User Roles Explained

### 👑 Admin Role
- ✅ Create new users
- ✅ Edit users (name, email, password, role)
- ✅ Delete users
- ✅ View all users
- ✅ Change user roles
- ✅ Access all admin features

### 👤 User Role
- ✅ View dashboard
- ✅ View guest list
- ✅ View user list (read-only)
- ❌ Cannot create users
- ❌ Cannot edit users
- ❌ Cannot delete users
- ❌ Cannot access user management features

---

## Creating Additional Users

### Via Web Interface
1. Login with admin account
2. Go to **Admin User** menu
3. Click **Tambah Admin User**
4. Fill in the form:
   - Nama (Name)
   - Email
   - Role (select Admin or User)
   - Password
   - Konfirmasi Password
5. Click "Tambahkan User"

### Via Artisan Command
```bash
php artisan user:create-admin
```

This will prompt you interactively to create a new user.

---

## Troubleshooting

### Can't Login
1. Make sure you've run migrations: `php artisan migrate`
2. Make sure you've run seeders: `php artisan db:seed`
3. Check the database to verify users exist: `php artisan tinker`
   ```php
   App\Models\User::all(); // Should show the seeded users
   ```
4. Try using the correct credentials from above

### Invalid Email Format Error
- Make sure you're using valid email format: `name@example.com`

### Password Too Short
- Passwords must be at least 6 characters

### Email Already Registered
- Each user needs a unique email address

---

## Reset Seeded Data

To reset and reseed the database:

```bash
php artisan migrate:fresh --seed
```

⚠️ **Warning**: This will delete all data and recreate it!

---

## Next Steps

After seeding and logging in:

1. **Manage Guests** - Add and manage wedding invitation guests
2. **Manage Users** - Create admin accounts for your team (admin only)
3. **Dashboard** - View statistics and recent activity
4. **View Invitation** - Check the public invitation page
