# Letters Archiving System - Complete API Documentation

## 📋 Table of Contents

1. [ERD & Relationship Summary](#erd--relationship-summary)
2. [Database Migrations](#database-migrations)
3. [Models & Trait](#models--trait)
4. [Form Requests](#form-requests)
5. [Services](#services)
6. [Controllers](#controllers)
7. [API Resources](#api-resources)
8. [API Routes](#api-routes)
9. [API Examples](#api-examples)

---

## 1. ERD & Relationship Summary

### Database Structure

```
┌─────────────┐         ┌──────────┐
│ categories  │◄────┐   │ letters  │
└─────────────┘     │   └──────────┘
  - id (PK)         │     - id (PK)
  - title           ├─────- category_id (FK)
  - timestamps      │     - subject_id (FK)
                    │     - assignment_id (FK)
┌─────────────┐     │     - letter_number (unique)
│  subjects   │◄────┤     - date
└─────────────┘     │     - export (boolean)
  - id (PK)         │     - outgoing_number
  - title           │     - outgoing_date
  - description     │     - timestamps
  - timestamps      │     - deleted_at (soft delete)
                    │
┌─────────────┐     │
│ assignments │◄────┘
└─────────────┘
  - id (PK)
   - title
  - description
  - timestamps
```

### Relationships

- **Category** `hasMany` **Letters**
- **Letter** `belongsTo` **Category**
- **Letter** `belongsTo` **Subject**
- **Letter** `belongsTo` **Assignment**
- **Subject** `hasMany` **Letters**
- **Assignment** `hasMany` **Letters**

### Design Decisions

1. **letter_number** is globally unique (not per category) - archiving systems typically need globally unique identifiers for tracking
2. **export** is boolean - represents whether letter was exported/sent (yes/no flag)
3. **outgoing_date** must be >= **date** - logical constraint
4. **outgoing_number** requires **outgoing_date** - data integrity
5. Foreign keys use `restrict` on delete - prevents orphaned letters

---

## 2. Database Migrations

All migrations are located in `database/migrations/`:

- `2026_02_04_000001_create_categories_table.php`
- `2026_02_04_000002_create_subjects_table.php`
- `2026_02_04_000003_create_assignments_table.php`
- `2026_02_04_000004_create_letters_table.php`

### Key Features

- ✅ Foreign keys with constraints
- ✅ Indexes on frequently searched fields
- ✅ Soft deletes for letters
- ✅ Proper data types (integer for numbers, date for dates, boolean for export)

---

## 3. Models & Trait

### HasModelHelpers Trait

Located at: `app/Traits/HasModelHelpers.php`

**Features:**

- `applyFilters()` - Smart filtering with support for date ranges, IDs, booleans, partial matches
- `filtered($filters)` - Static method to get filtered query builder
- `withDefaultRelations()` - Eager load default relations
- `findOrFailWithRelations($id)` - Find with relations or fail
- `paginateWithFilters($filters, $perPage)` - Complete paginated filtering

**Usage Examples:**

```php
// Static filtering
$letters = Letter::filtered(['category_id' => 1])->get();

// Scope filtering
$letters = Letter::query()->applyFilters($filters)->paginate(15);

// Find with relations
$letter = Letter::findOrFailWithRelations($id);

// Paginate with filters
$letters = Letter::paginateWithFilters($filters, 20);
```

### Models

All models located in `app/Models/`:

- `Category.php`
- `Subject.php`
- `Assignment.php`
- `Letter.php`

All models use:

- ✅ HasModelHelpers trait
- ✅ Proper fillable attributes
- ✅ Type casting
- ✅ Relationship definitions
- ✅ Default relations configuration

---

## 4. Form Requests

Located in `app/Http/Requests/`:

- `LetterRequest.php` - Comprehensive validation with conditional rules
- `CategoryRequest.php` - Unique title validation
- `SubjectRequest.php` - Title and description validation
- `AssignmentRequest.php` - Title and description validation

### LetterRequest Key Validations

```php
- category_id: required, exists
- subject_id: required, exists
- assignment_id: required, exists
- letter_number: required, unique, integer
- date: required, date, before_or_equal:today
- export: boolean (optional)
- outgoing_number: nullable, integer
- outgoing_date: nullable, required_with:outgoing_number, after_or_equal:date
```

---

## 5. Services

Located in `app/Services/`:

- `LetterService.php` - Full CRUD + filtering + statistics
- `CategoryService.php` - CRUD with validation
- `SubjectService.php` - CRUD with validation
- `AssignmentService.php` - CRUD with validation

### LetterService Features

- ✅ Transaction support
- ✅ Error logging
- ✅ Filter building
- ✅ Statistics generation
- ✅ Relation eager loading
- ✅ Exception handling

---

## 6. Controllers

Located in `app/Http/Controllers/Api/`:

- `LetterController.php`
- `CategoryController.php`
- `SubjectController.php`
- `AssignmentController.php`

All controllers:

- ✅ Thin (delegate to services)
- ✅ Type-hinted parameters
- ✅ Constructor injection
- ✅ Consistent JSON responses
- ✅ Proper HTTP status codes

---

## 7. API Resources

Located in `app/Http/Resources/`:

- `LetterResource.php` - Single letter with nested relations
- `LetterCollection.php` - Paginated letters with meta
- `CategoryResource.php`
- `SubjectResource.php`
- `AssignmentResource.php`

---

## 8. API Routes

Add to `routes/api.php`:

```php
use App\Http\Controllers\Api\{
    LetterController,
    CategoryController,
    SubjectController,
    AssignmentController
};

// Letters
Route::apiResource('letters', LetterController::class);
Route::get('letters/statistics', [LetterController::class, 'statistics']);

// Categories
Route::apiResource('categories', CategoryController::class);

// Subjects
Route::apiResource('subjects', SubjectController::class);

// Assignments
Route::apiResource('assignments', AssignmentController::class);
```

---

## 9. API Examples

### Letter Endpoints

#### 1. GET /api/letters (Index with filters)

**Query Parameters:**

```
category_id=1
subject_id=2
assignment_id=3
letter_number=123
date_from=2024-01-01
date_to=2024-12-31
outgoing_number=456
outgoing_date_from=2024-01-01
outgoing_date_to=2024-12-31
export=true
per_page=20
```

**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/letters?category_id=1&date_from=2024-01-01&export=true&per_page=20"
```

**Response (200 OK):**

```json
{
    "data": [
        {
            "id": 1,
            "category": {
                "id": 1,
                "title": "Administrative"
            },
            "subject": {
                "id": 2,
                "title": "Budget Approval"
            },
            "assignment": {
                "id": 3,
                "title": "Finance Department"
            },
            "letter_number": 1001,
            "date": "2024-10-15",
            "export": true,
            "outgoing_number": 5001,
            "outgoing_date": "2024-10-16",
            "created_at": "2024-10-15 09:00:00",
            "updated_at": "2024-10-15 09:00:00"
        }
    ],
    "meta": {
        "total": 50,
        "current_page": 1,
        "last_page": 3,
        "per_page": 20,
        "from": 1,
        "to": 20
    }
}
```

#### 2. GET /api/letters/{id} (Show)

**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/letters/1"
```

**Response (200 OK):**

```json
{
    "id": 1,
    "category": {
        "id": 1,
        "title": "Administrative"
    },
    "subject": {
        "id": 2,
        "title": "Budget Approval"
    },
    "assignment": {
        "id": 3,
        "title": "Finance Department"
    },
    "letter_number": 1001,
    "date": "2024-10-15",
    "export": true,
    "outgoing_number": 5001,
    "outgoing_date": "2024-10-16",
    "created_at": "2024-10-15 09:00:00",
    "updated_at": "2024-10-15 09:00:00"
}
```

#### 3. POST /api/letters (Store)

**Example Request:**

```bash
curl -X POST "http://localhost:8000/api/letters" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "subject_id": 2,
    "assignment_id": 3,
    "letter_number": 1002,
    "date": "2024-11-01",
    "export": false,
    "outgoing_number": null,
    "outgoing_date": null
  }'
```

**Response (201 Created):**

```json
{
    "message": "Letter created successfully",
    "data": {
        "id": 2,
        "category": {
            "id": 1,
            "title": "Administrative"
        },
        "subject": {
            "id": 2,
            "title": "Budget Approval"
        },
        "assignment": {
            "id": 3,
            "title": "Finance Department"
        },
        "letter_number": 1002,
        "date": "2024-11-01",
        "export": false,
        "outgoing_number": null,
        "outgoing_date": null,
        "created_at": "2024-11-01 10:30:00",
        "updated_at": "2024-11-01 10:30:00"
    }
}
```

#### 4. PUT/PATCH /api/letters/{id} (Update)

**Example Request:**

```bash
curl -X PUT "http://localhost:8000/api/letters/2" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "subject_id": 2,
    "assignment_id": 3,
    "letter_number": 1002,
    "date": "2024-11-01",
    "export": true,
    "outgoing_number": 5002,
    "outgoing_date": "2024-11-02"
  }'
```

**Response (200 OK):**

```json
{
    "message": "Letter updated successfully",
    "data": {
        "id": 2,
        "category": {
            "id": 1,
            "title": "Administrative"
        },
        "subject": {
            "id": 2,
            "title": "Budget Approval"
        },
        "assignment": {
            "id": 3,
            "title": "Finance Department"
        },
        "letter_number": 1002,
        "date": "2024-11-01",
        "export": true,
        "outgoing_number": 5002,
        "outgoing_date": "2024-11-02",
        "created_at": "2024-11-01 10:30:00",
        "updated_at": "2024-11-02 14:15:00"
    }
}
```

#### 5. DELETE /api/letters/{id} (Destroy - Soft Delete)

**Example Request:**

```bash
curl -X DELETE "http://localhost:8000/api/letters/2"
```

**Response (200 OK):**

```json
{
    "message": "Letter deleted successfully"
}
```

#### 6. GET /api/letters/statistics (Statistics)

**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/letters/statistics"
```

**Response (200 OK):**

```json
{
    "data": {
        "total_letters": 150,
        "exported_letters": 120,
        "letters_by_category": [
            {
                "category": "Administrative",
                "total": 50
            },
            {
                "category": "HR",
                "total": 30
            },
            {
                "category": "Finance",
                "total": 70
            }
        ]
    }
}
```

### Category Endpoints

#### 1. GET /api/categories

**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/categories?paginate=false"
```

**Response (200 OK):**

```json
{
    "data": [
        {
            "id": 1,
            "title": "Administrative",
            "created_at": "2024-01-01 08:00:00",
            "updated_at": "2024-01-01 08:00:00"
        },
        {
            "id": 2,
            "title": "HR",
            "created_at": "2024-01-01 08:00:00",
            "updated_at": "2024-01-01 08:00:00"
        }
    ]
}
```

#### 2. POST /api/categories

**Example Request:**

```bash
curl -X POST "http://localhost:8000/api/categories" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Legal"
  }'
```

**Response (201 Created):**

```json
{
    "message": "Category created successfully",
    "data": {
        "id": 3,
        "title": "Legal",
        "created_at": "2024-11-01 10:00:00",
        "updated_at": "2024-11-01 10:00:00"
    }
}
```

### Subject Endpoints

#### POST /api/subjects

**Example Request:**

```bash
curl -X POST "http://localhost:8000/api/subjects" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Budget Planning",
    "description": "Annual budget planning and approval process"
  }'
```

**Response (201 Created):**

```json
{
    "message": "Subject created successfully",
    "data": {
        "id": 1,
        "title": "Budget Planning",
        "description": "Annual budget planning and approval process",
        "created_at": "2024-11-01 09:00:00",
        "updated_at": "2024-11-01 09:00:00"
    }
}
```

### Assignment Endpoints

#### POST /api/assignments

**Example Request:**

```bash
curl -X POST "http://localhost:8000/api/assignments" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Finance Department",
    "description": "Responsible for financial operations and budgeting"
  }'
```

**Response (201 Created):**

```json
{
    "message": "Assignment created successfully",
    "data": {
        "id": 1,
        "title": "Finance Department",
        "description": "Responsible for financial operations and budgeting",
        "created_at": "2024-11-01 09:00:00",
        "updated_at": "2024-11-01 09:00:00"
    }
}
```

---

## Installation & Usage

### 1. Run Migrations

```bash
php artisan migrate
```

### 2. Seed Sample Data (Optional)

Create seeders or manually insert test data:

```bash
php artisan tinker
```

```php
// Create categories
$admin = \App\Models\Category::create(['title' => 'Administrative']);
$hr = \App\Models\Category::create(['title' => 'HR']);

// Create subjects
$budget = \App\Models\Subject::create([
    'title' => 'Budget Approval',
    'description' => 'Annual budget approvals'
]);

// Create assignments
$finance = \App\Models\Assignment::create([
    'title' => 'Finance Department',
    'description' => 'Financial operations'
]);

// Create a letter
\App\Models\Letter::create([
    'category_id' => $admin->id,
    'subject_id' => $budget->id,
    'assignment_id' => $finance->id,
    'letter_number' => 1001,
    'date' => '2024-10-15',
    'export' => true,
    'outgoing_number' => 5001,
    'outgoing_date' => '2024-10-16',
]);
```

### 3. Test the API

```bash
php artisan serve
```

Then use the example requests above to test your endpoints.

---

## Architecture Highlights

### ✅ Thin Controllers

Controllers only handle HTTP concerns and delegate to services

### ✅ Service Layer

Business logic isolated in services for testability

### ✅ Reusable Trait

`HasModelHelpers` provides filtering and query helpers for all models

### ✅ Type Safety

All methods use type hints for parameters and return types

### ✅ Consistent Validation

Form Requests handle all validation with clear rules

### ✅ Transaction Support

Services wrap operations in DB transactions

### ✅ Error Logging

All service operations log errors for debugging

### ✅ API Resources

Consistent JSON structure across all endpoints

### ✅ Relationship Eager Loading

Avoids N+1 queries with default relations

### ✅ Soft Deletes

Letters can be restored if deleted accidentally

---

## Next Steps

1. Add authentication (Laravel Sanctum/Passport)
2. Add authorization (Policies/Gates)
3. Add API rate limiting
4. Add comprehensive tests (Feature/Unit)
5. Add API documentation (Swagger/OpenAPI)
6. Add file upload for letter attachments
7. Add audit trail logging
8. Add export functionality (PDF/Excel)

---

**Production-Ready Backend Scaffold Complete! 🚀**
