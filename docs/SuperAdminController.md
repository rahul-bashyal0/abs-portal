SuperAdminController — Summary and Documentation

Purpose

This controller centralizes "super admin" functionality for the application: managing institutes (colleges), managing users (college admins and reviewers), and overseeing submissions by students (assigning reviewers).

Main responsibilities

- Institute (College) management
  - listColleges: paginated listing of colleges, ordered by name
  - createInstitute / storeInstitute: show form and save a new institute
  - editInstitute / updateInstitute: show edit form and persist changes
  - destroyInstitute: delete an institute

- User management
  - listUsers: paginated list of users (excluding super_admin)
  - createUser / storeUser: show form and create college_admin or reviewer
  - editUser / updateUser: edit users and change role/college/password
  - destroyUser: remove a user

  Implementation detail (reviewers): when creating/updating a user with role `reviewer`, the controller now assigns the reviewer to the special college named "ABS Soft Pvt. Ltd" (if it exists). College admins must be tied to a specific college (college_id required).

- Submission management
  - listSubmissions: paginated list of submissions with student and reviewer relations
  - assignReviewer: validates selected user, ensures role is `reviewer`, assigns reviewer_id and sets status to `Under Review`.

Routes (in `routes/web.php` within `superadmin` group)

- GET /superadmin/colleges -> listColleges (named `superadmin.colleges.index`)
- GET /superadmin/colleges/create -> createInstitute (named `superadmin.colleges.create`)
- POST /superadmin/colleges -> storeInstitute (named `superadmin.colleges.store`)
- GET /superadmin/colleges/{institute}/edit -> editInstitute (named `superadmin.colleges.edit`)
- PUT /superadmin/colleges/{institute} -> updateInstitute (named `superadmin.colleges.update`)
- DELETE /superadmin/colleges/{institute} -> destroyInstitute (named `superadmin.colleges.destroy`)

- GET /superadmin/users -> listUsers (named `superadmin.users.index`)
- GET /superadmin/users/create -> createUser (named `superadmin.users.create`)
- POST /superadmin/users -> storeUser (named `superadmin.users.store`)
- GET /superadmin/users/{user}/edit -> editUser (named `superadmin.users.edit`)
- PUT /superadmin/users/{user} -> updateUser (named `superadmin.users.update`)
- DELETE /superadmin/users/{user} -> destroyUser (named `superadmin.users.destroy`)

- GET /superadmin/submissions -> listSubmissions (named `superadmin.submissions.index`)
- PATCH /superadmin/submissions/{submission}/assign -> assignReviewer (named `superadmin.submissions.assign`)

Models and schema

- College (table `colleges`)
  - id, name, city, state, timestamps
  - fillable: name, city, state
  - relations:
    - students(): hasMany(User) scoped to role `student`
    - collegeAdmin(): hasOne(User) scoped to role `college_admin`

- User (table `users`) — additions via `add_custom_fields_to_users_table` migration:
  - role (string, default `student`)
  - college_id (unsignedBigInteger, nullable)
  - is_approved (boolean, default false)
  - fillable includes: name, email, password, role, college_id, is_approved
  - relations:
    - college(): belongsTo(College)
    - submissions(): hasMany(Submission)

- Submission (table `submissions`)
  - id, user_id (student), reviewer_id (nullable), title, problem_statement, solution_description, technologies_used, video_link, file_path, status (default 'Submitted'), is_shortlisted_for_internship (bool), timestamps
  - guarded = []
  - relations:
    - student(): belongsTo(User, 'user_id')
    - reviewer(): belongsTo(User, 'reviewer_id')
    - feedback(): hasMany(Feedback)

Notable code changes / fixes

- When creating/updating a user with role `reviewer`, the controller assigns their `college_id` to the college record with name "ABS Soft Pvt. Ltd" if it exists. There's a comment in `storeUser` noting "THE FIX: Find the ABS Soft institute and get its ID." This addresses previous issues where reviewers either had no college or were incorrectly tied to other colleges.

Validation and error handling

- Requests are validated with Laravel's `$request->validate(...)` in each handler. Typical validations include required strings, max lengths, uniqueness, and exists checks for foreign keys.
- `assignReviewer` checks the selected user has `role === 'reviewer'` and returns back with an error flash message if not.
- There is no explicit try/catch; controller relies on framework exception handling and redirects with flash messages for common flows.

Inputs/Outputs and contracts

- Inputs: standard form data for create/update. Key fields per action:
  - Institute create/update: name, city, state
  - User create/update: name, email, password (+confirmation), role (college_admin|reviewer), college_id (required for college_admin)
  - Assign reviewer: reviewer_id
- Outputs: HTML views for forms and listings (blade views under `resources/views/superadmin/...`) and redirects with session flash messages on success/failure.

Views referenced (expected)

Look for views under `resources/views/superadmin`:
- institutes/index.blade.php
- institutes/create.blade.php
- institutes/edit.blade.php
- users/index.blade.php
- users/create.blade.php
- users/edit.blade.php
- submissions/index.blade.php

Notes and recommended improvements

- The "ABS Soft Pvt. Ltd" magic string is used in multiple places; consider extracting to a config value or seeding a constant (e.g., `config('app.abs_college_name')`) and/or ensuring the seeded college exists. Add a database seed check or foreign constraint if reviewers must always have a college.
- When deleting a college, there is no cascade handling for attached users besides database behavior — ensure this is intentional. Consider adding onDelete behavior in migration if needed.
- Add more explicit error handling for missing ABS Soft college when creating reviewers; currently the code silently leaves `college_id` null if ABS college is not found.
- Tests: add feature tests for creating reviewers, assigning reviewers, and institute CRUD to prevent regressions.

Files read while preparing this doc

- app/Http/Controllers/SuperAdminController.php
- app/Models/College.php
- app/Models/User.php
- app/Models/Submission.php
- database/migrations/2025_06_21_071756_create_colleges_table.php
- database/migrations/2025_06_21_070031_add_custom_fields_to_users_table.php
- database/migrations/2025_06_21_093856_create_submissions_table.php
- routes/web.php

If you'd like, I can:
- Create the suggested tests (Pest or PHPUnit) for the critical flows.
- Replace the ABS Soft magic string with a config value and add a seed check.
- Generate the missing blade views or wire up more robust error messages.

