# RBAC Demo – Laravel (Organization Based Access Control)

A Laravel application demonstrating **Role-Based Access Control (RBAC)** with **organization-wise data isolation**.
The system supports multiple user roles with strict access boundaries across organizations.

---

## 📦 Tech Stack

* Laravel 12
* PHP 8.4
* SQLite (for demo)
* Blade Templates
* Laravel Policies & Middleware
* Authentication via Laravel Auth

---

## 🚀 Setup Instructions

### 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/rbac-demo.git
cd rbac-demo
```

---

### 2️⃣ Install Dependencies

```bash
composer install
```

---

### 3️⃣ Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` if needed (default uses SQLite):

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Create database file:

```bash
touch database/database.sqlite
```

---

### 4️⃣ Run Migrations & Seeders

```bash
php artisan migrate --seed
```

---

### 5️⃣ Start Server

```bash
php artisan serve
```

App will be available at:

```
http://127.0.0.1:8000
```

---

## 🔐 Login Credentials (Seeded Users)

| Role        | Email                                     | Password |
| ----------- | ----------------------------------------- | -------- |
| Super Admin | super@admin.com | password |
| Org 1 Admin   | admin1@org.com  | password |
| Org 1 HR      | hr1@org.com         | password |
| Org 1 Sales   | sales1@org.com  | password |
| Org 2 Admin   | admin2@org.com   | password |
| Org 2 HR      | hr2@org.com      | password |
| Org 2 Sales   | sales2@org.com  | password |
---

## 🧑‍💼 Roles & Permissions Overview

### Roles

* **super_admin**
* **org_admin**
* **org_hr**
* **org_sales**

Each user (except super_admin) belongs to **one organization**.

---

## 🏢 Organization-Wise Isolation

* Each `employee` record contains `org_id`
* Non-super admins can **only access records belonging to their org**
* Super admin can access **all organizations**

### Enforcement Points

1. **Controller authorization**
2. **Eloquent relationships**
3. **Middleware (role based)**
4. **Blade conditional rendering**

---

## 🔒 Authorization Logic (Controller Level)

```php
private function authorizeOrg(Employee $employee)
{
    $user = auth()->user();

    if ($user->role !== 'super_admin' && $employee->org_id !== $user->org_id) {
        abort(403);
    }
}
```

This ensures:

* Cross-organization access is blocked
* Even if user manipulates URLs manually

---

## 🧩 Middleware Design

### Role Middleware

```bash
php artisan make:middleware RoleMiddleware
```

```php
public function handle($request, Closure $next, ...$roles)
{
    if (! auth()->check() || ! in_array(auth()->user()->role, $roles)) {
        abort(403);
    }

    return $next($request);
}
```

### Registration

```php
protected $routeMiddleware = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

---

## 🛣️ Routes & Access Matrix

### Web Routes

| Route                  | Method | Role Access                    |
| ---------------------- | ------ | ------------------------------ |
| `/dashboard`           | GET    | all                            |
| `/employees`           | GET    | super_admin, org_admin, org_hr |
| `/employees/create`    | GET    | org_admin, org_hr              |
| `/employees/store`     | POST   | org_admin, org_hr              |
| `/employees/{id}`      | GET    | authorized org users           |
| `/employees/{id}/edit` | GET    | org_admin                      |
| `/employees/{id}`      | DELETE | org_admin                      |

Example:

```php
Route::middleware(['auth', 'role:org_admin,org_hr'])->group(function () {
    Route::resource('employees', EmployeeController::class);
});
```

---

## 🔗 Eloquent Relationships

### Employee Model

```php
public function organization()
{
    return $this->belongsTo(Organization::class, 'org_id');
}
```

### User Model

```php
public function organization()
{
    return $this->belongsTo(Organization::class, 'org_id');
}
```

---

## 🖥 Blade Role Checks

```blade
@if(auth()->user()->role === 'super_admin')
<tr>
    <th>Organization</th>
    <td>{{ $employee->organization?->name ?? 'N/A' }}</td>
</tr>
@endif
```

Safe navigation (`?->`) prevents null reference crashes.

---

## 🚪 Logout Implementation

```blade
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
```

---

## 🧪 Common Errors Handled

### ❌ `NOT NULL constraint failed: employees.org_id`

**Fix:** Ensure `org_id` is assigned during employee creation:

```php
$data['org_id'] = auth()->user()->org_id;
```

---

### ❌ `Attempt to read property "name" on null`

**Fix:** Load relationship + safe access:

```php
$employee->load('organization');
```

```blade
{{ $employee->organization?->name }}
```

---

## 📁 Folder Structure

```
app/
 ├── Http/
 │   ├── Controllers/
 │   ├── Middleware/
 │   └── Requests/
 ├── Models/
resources/
 ├── views/
 └── layouts/
database/
 ├── migrations/
 └── seeders/
```

---

## ✅ Key Takeaways

* Clean RBAC design
* Organization-level isolation
* Secure controller-level checks
* Defensive Blade rendering
* Production-ready authorization flow
