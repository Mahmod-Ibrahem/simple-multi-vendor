# Letters Archiving System - Quick Setup Guide

## 📦 What's Been Created

This is a complete, production-ready Laravel backend for a Letters Archiving System.

### File Structure

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── LetterController.php
│   │   ├── CategoryController.php
│   │   ├── SubjectController.php
│   │   └── AssignmentController.php
│   ├── Requests/
│   │   ├── LetterRequest.php
│   │   ├── CategoryRequest.php
│   │   ├── SubjectRequest.php
│   │   └── AssignmentRequest.php
│   └── Resources/
│       ├── LetterResource.php
│       ├── LetterCollection.php
│       ├── CategoryResource.php
│       ├── SubjectResource.php
│       └── AssignmentResource.php
├── Models/
│   ├── Letter.php
│   ├── Category.php
│   ├── Subject.php
│   └── Assignment.php
├── Services/
│   ├── LetterService.php
│   ├── CategoryService.php
│   ├── SubjectService.php
│   └── AssignmentService.php
└── Traits/
    └── HasModelHelpers.php

database/migrations/
├── 2026_02_04_000001_create_categories_table.php
├── 2026_02_04_000002_create_subjects_table.php
├── 2026_02_04_000003_create_assignments_table.php
└── 2026_02_04_000004_create_letters_table.php

routes/
└── api_letters.php
```

---

## 🚀 Setup Instructions

### Step 1: Add Routes to Your Application

Add this line to your main `routes/api.php` file:

```php
require __DIR__.'/api_letters.php';
```

Or manually copy the routes from `routes/api_letters.php` into your `routes/api.php`.

### Step 2: Run Migrations

```bash
php artisan migrate
```

### Step 3: Test the Setup

Start your development server:

```bash
php artisan serve
```

### Step 4: Create Sample Data (Optional)

```bash
php artisan tinker
```

```php
// Create sample categories
$admin = \App\Models\Category::create(['title' => 'Administrative']);
$hr = \App\Models\Category::create(['title' => 'Human Resources']);
$finance = \App\Models\Category::create(['title' => 'Finance']);

// Create sample subjects
$budget = \App\Models\Subject::create([
    'title' => 'Budget Approval',
    'description' => 'Annual budget planning and approval'
]);
$hiring = \App\Models\Subject::create([
    'title' => 'Employee Hiring',
    'description' => 'New employee recruitment and onboarding'
]);

// Create sample assignments
$financeDept = \App\Models\Assignment::create([
    'title' => 'Finance Department',
    'description' => 'Financial operations and budgeting'
]);
$hrDept = \App\Models\Assignment::create([
    'title' => 'HR Department',
    'description' => 'Human resources and personnel management'
]);

// Create sample letters
\App\Models\Letter::create([
    'category_id' => $admin->id,
    'subject_id' => $budget->id,
    'assignment_id' => $financeDept->id,
    'letter_number' => 1001,
    'date' => now()->subDays(10),
    'export' => true,
    'outgoing_number' => 5001,
    'outgoing_date' => now()->subDays(9),
]);

\App\Models\Letter::create([
    'category_id' => $hr->id,
    'subject_id' => $hiring->id,
    'assignment_id' => $hrDept->id,
    'letter_number' => 1002,
    'date' => now()->subDays(5),
    'export' => false,
]);
```

### Step 5: Test the API

```bash
# Get all letters
curl http://localhost:8000/api/letters

# Get letters with filters
curl "http://localhost:8000/api/letters?category_id=1&export=true"

# Get a single letter
curl http://localhost:8000/api/letters/1

# Get all categories
curl http://localhost:8000/api/categories

# Get statistics
curl http://localhost:8000/api/letters/statistics
```

---

## 🎯 Key Features Implemented

### ✅ Database Layer

- [x] Complete migrations with foreign keys
- [x] Indexes on frequently searched fields
- [x] Soft deletes for letters
- [x] Proper constraints (restrict on delete)

### ✅ Model Layer

- [x] Eloquent relationships
- [x] Type casting
- [x] Fillable attributes
- [x] **Reusable HasModelHelpers trait**
    - Static filtering: `Letter::filtered($filters)`
    - Scope filtering: `Letter::query()->applyFilters($filters)`
    - Find with relations: `Letter::findOrFailWithRelations($id)`
    - Paginate with filters: `Letter::paginateWithFilters($filters, 20)`

### ✅ Validation Layer

- [x] Form Requests for all models
- [x] Comprehensive validation rules
- [x] Conditional validation
- [x] Custom error messages
- [x] Letter number uniqueness (global)

### ✅ Service Layer

- [x] Business logic separation
- [x] Database transactions
- [x] Error logging
- [x] Exception handling
- [x] Filter building
- [x] Statistics generation

### ✅ Controller Layer

- [x] Thin controllers (delegate to services)
- [x] Constructor dependency injection
- [x] Type-hinted parameters
- [x] Consistent JSON responses
- [x] Proper HTTP status codes

### ✅ API Resource Layer

- [x] Consistent JSON structure
- [x] Resource transformations
- [x] Collection with meta data
- [x] Nested relations in responses

### ✅ Filtering & Search

Supports filtering by:

- [x] category_id
- [x] subject_id
- [x] assignment_id
- [x] letter_number (partial match)
- [x] date_from / date_to
- [x] outgoing_number (partial match)
- [x] outgoing_date_from / outgoing_date_to
- [x] export (boolean)

---

## 📊 API Endpoints

### Letters

- `GET /api/letters` - List all letters with filters and pagination
- `GET /api/letters/{id}` - Get a single letter
- `POST /api/letters` - Create a new letter
- `PUT/PATCH /api/letters/{id}` - Update a letter
- `DELETE /api/letters/{id}` - Delete a letter (soft delete)
- `GET /api/letters/statistics` - Get letter statistics

### Categories

- `GET /api/categories` - List all categories
- `GET /api/categories/{id}` - Get a single category
- `POST /api/categories` - Create a new category
- `PUT/PATCH /api/categories/{id}` - Update a category
- `DELETE /api/categories/{id}` - Delete a category

### Subjects

- `GET /api/subjects` - List all subjects
- `GET /api/subjects/{id}` - Get a single subject
- `POST /api/subjects` - Create a new subject
- `PUT/PATCH /api/subjects/{id}` - Update a subject
- `DELETE /api/subjects/{id}` - Delete a subject

### Assignments

- `GET /api/assignments` - List all assignments
- `GET /api/assignments/{id}` - Get a single assignment
- `POST /api/assignments` - Create a new assignment
- `PUT/PATCH /api/assignments/{id}` - Update an assignment
- `DELETE /api/assignments/{id}` - Delete an assignment

---

## 🔧 Trait Usage Examples

The `HasModelHelpers` trait provides powerful filtering capabilities:

```php
// Example 1: Static filtering
$letters = Letter::filtered([
    'category_id' => 1,
    'date_from' => '2024-01-01',
    'export' => true
])->get();

// Example 2: Scope filtering
$query = Letter::query();
$query->applyFilters($request->all());
$letters = $query->paginate(15);

// Example 3: Find with relations
$letter = Letter::findOrFailWithRelations($id);

// Example 4: Complete pagination with filters
$letters = Letter::paginateWithFilters($request->all(), 20);

// Example 5: Custom query with filters
$letters = Letter::query()
    ->where('export', true)
    ->applyFilters(['category_id' => 1])
    ->latest()
    ->get();
```

---

## 💡 Design Decisions Explained

### 1. Letter Number Uniqueness

**Decision:** Global uniqueness (not per category)

**Justification:** Archiving systems require globally unique identifiers for tracking and referencing. This prevents confusion and ensures each letter has a unique identifier across the entire system.

### 2. Export Field Type

**Decision:** Boolean

**Justification:** The export field represents a yes/no state (whether a letter was exported/sent). A boolean is the most appropriate and performant type for this.

### 3. Foreign Key Constraints

**Decision:** `onDelete('restrict')`

**Justification:** Prevents accidental deletion of categories, subjects, or assignments that have associated letters. This maintains data integrity.

### 4. Outgoing Date Validation

**Decision:** Must be >= letter date

**Justification:** Logically, a letter cannot be sent out before it was created/dated.

### 5. Service Layer Pattern

**Decision:** Separate service classes for business logic

**Justification:** Keeps controllers thin and focused on HTTP concerns. Makes business logic testable and reusable.

---

## 📚 Full Documentation

For complete API documentation with examples, see:

- **LETTERS_ARCHIVING_API.md** - Complete API reference

---

## 🧪 Testing Suggestions

### Unit Tests

- Test HasModelHelpers trait filtering
- Test validation rules in Form Requests
- Test service methods in isolation

### Feature Tests

- Test API endpoints (CRUD operations)
- Test filtering functionality
- Test validation errors
- Test relationships
- Test soft deletes

### Example Test (Feature):

```php
public function test_can_create_letter()
{
    $category = Category::factory()->create();
    $subject = Subject::factory()->create();
    $assignment = Assignment::factory()->create();

    $response = $this->postJson('/api/letters', [
        'category_id' => $category->id,
        'subject_id' => $subject->id,
        'assignment_id' => $assignment->id,
        'letter_number' => 1001,
        'date' => '2024-11-01',
        'export' => false,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'category',
                'subject',
                'assignment',
                'letter_number',
                'date',
                'export',
            ]
        ]);
}
```

---

## 🔐 Security Recommendations

1. **Add Authentication:**

    ```php
    Route::middleware('auth:sanctum')->group(function () {
        // Protected routes
    });
    ```

2. **Add Authorization:**
   Create policies:

    ```bash
    php artisan make:policy LetterPolicy --model=Letter
    ```

3. **Add Rate Limiting:**

    ```php
    Route::middleware('throttle:60,1')->group(function () {
        // Rate-limited routes
    });
    ```

4. **Validate User Permissions:**
   Use Gates or Policies in controllers

---

## 🎉 Next Steps

1. **Add authentication** (Laravel Sanctum recommended)
2. **Add authorization** (Policies for CRUD permissions)
3. **Create factories & seeders** for testing
4. **Write comprehensive tests**
5. **Add file attachments** to letters
6. **Add audit logging** for changes
7. **Add export functionality** (PDF/Excel)
8. **Add API documentation** (Laravel Scribe or Swagger)

---

**Your production-ready Letters Archiving System backend is complete! 🎊**
