Project Overview — ABS Portal

Purpose

The ABS Portal is a Laravel-based multi-role application for managing student project submissions and a partnership program between students, colleges, and a central ABS organization. It supports user registration, role-based workflows (student, college admin, reviewer, super admin), submission lifecycle, assignment of reviewers, feedback collection, and certificate issuance for shortlisted projects.

Audience

- Developers: need a clear map of controllers, models, routes and data flows.
- Admins / Super Admins: how to manage institutes, users and submissions.
- College Admins: how to approve students and review pending work.
- Reviewers: how to receive assigned submissions and provide feedback.

Contents

1. Roles & permissions
2. User onboarding
3. Dashboards and what each role can do
4. Submission lifecycle
5. Data model
6. Routes and controllers (mapping)
7. File storage & attachments
8. Seeders & initialization
9. Recommendations & next steps


## 1. Roles & permissions

- super_admin
  - Full access to manage colleges (institutes), users (create/edit/delete college_admins & reviewers), and submissions (list and assign reviewers).
  - Route group: `/superadmin/*` guarded by `role:super_admin` middleware.

- college_admin
  - Scoped to a single college via `college_id`.
  - Approves or rejects pending student registrations for their college.
  - Route group: `/college/*` guarded by `role:college_admin` middleware.

- reviewer
  - Assigned to submissions by super_admin. Reviews submissions and leaves feedback.
  - Reviewers are associated with the special college `ABS Soft Pvt. Ltd` in the current implementation.
  - Route group: `/reviewer/*` guarded by `role:reviewer` middleware.

- student
  - Registers for the portal, chooses a college, submits project ideas, and can download certificates if shortlisted.
  - Must be approved by their college admin (`is_approved` flag) before gaining full access.
  - Route group: `/student/*` guarded by `role:student` middleware.

## 2. User onboarding

- Public registration (students):
  - Route: `GET /register` shows a registration form (`auth.register` view) with a college dropdown.
  - On POST, `RegisteredUserController@store` validates input and creates a user with `role = student` and `is_approved = false`.
  - The user receives a status message and must wait for their college admin to approve the account.

- Admin-created users (super_admin):
  - Super admin creates `college_admin` or `reviewer` accounts via `SuperAdminController` UI.
  - Reviewers are automatically assigned to the ABS Soft institute (lookup by name). Created admins and reviewers are marked `is_approved = true` so they can sign in immediately.

- Initial setup:
  - Seeder `AbsSoftInstituteSeeder` ensures the `ABS Soft Pvt. Ltd` college exists.
  - Super admin account may be created via seeder or Tinker as part of deploy steps.

## 3. Dashboards and capabilities (end-user view)

- Super Admin Dashboard:
  - Views: `resources/views/superadmin/*` (institutes, users, submissions)
  - Capabilities:
    - Create/edit/delete colleges
    - Create/edit/delete users (college_admin, reviewer)
    - View submissions and assign reviewers

- College Admin Dashboard:
  - Views: `resources/views/college/*`
  - Capabilities:
    - View pending student registrations for their college
    - Approve or reject students
    - (Potential extension) Manage students or college-level reports

- Reviewer Dashboard:
  - Views: `resources/views/reviewer/*`
  - Capabilities:
    - See submissions assigned to them
    - Provide feedback on assigned submissions (via `ReviewerController`)

- Student Dashboard:
  - Views: `resources/views/student/dashboard.blade.php` and create form `student/submissions/create.blade.php`
  - Capabilities:
    - Submit new project ideas (title, problem statement, solution, tech stack, optional video link, file upload)
    - View their submissions timeline with status (Submitted -> Under Review -> Decision Made)
    - Download certificate if submission status is 'Shortlisted'

## 4. Submission lifecycle

- States tracked on the `submissions` table: `status` (defaults to 'Submitted'), `is_shortlisted_for_internship` (boolean), `reviewer_id` (nullable).
- Typical flow:
  1. Student creates submission: status 'Submitted'.
  2. Super admin assigns a reviewer: status updated to 'Under Review'.
  3. Reviewer reviews, submits feedback. Based on feedback or decision, super admin or reviewer sets status to 'Shortlisted' or 'Rejected' (or other statuses like 'Internship Offered').
  4. If 'Shortlisted', the student can download a certificate.

## 5. Data model (core tables)

- `users` (Laravel default) plus added fields:
  - `role` (string)
  - `college_id` (unsignedBigInteger, nullable)
  - `is_approved` (boolean)

- `colleges`:
  - `id`, `name`, `city`, `state`, `timestamps`

- `submissions`:
  - `id`, `user_id`, `reviewer_id` (nullable), `title`, `problem_statement`, `solution_description`, `technologies_used`, `video_link`, `file_path`, `status`, `is_shortlisted_for_internship`, `timestamps`

- `feedback` (exists as model relation, check `app/Models/Feedback.php` for details)

## 6. Routes & controllers (mapping)

- Public/Auth
  - `routes/auth.php` — registration and login handled by Laravel Breeze-styled auth scaffolding. Key controller: `RegisteredUserController`.

- Super Admin
  - Controller: `App\Http\Controllers\SuperAdminController`
  - Routes: `routes/web.php` group prefix `superadmin` with named routes like `superadmin.colleges.index`, `superadmin.users.index`, `superadmin.submissions.index`, `superadmin.submissions.assign`.

- College Admin
  - Controller: `App\Http\Controllers\CollegeAdminController`
  - Routes: `/college/students/pending`, `/college/students/{user}/approve`.

- Student
  - Controller: `App\Http\Controllers\StudentController`
  - Routes: `/student/submission/create` (GET), `/student/submission` (POST), `/student/submission/{submission}/certificate` (GET).

- Reviewer
  - Controller: `App\Http\Controllers\ReviewerController`
  - Routes: `/reviewer/submission/{submission}`, `/reviewer/submission/{submission}/feedback`.

- Certificate
  - Controller: `App\Http\Controllers\CertificateController` — handles rendering/downloading certificates for shortlisted students.

## 7. File storage & attachments

- Student uploads (supporting file) are stored on the `public` disk at `submissions/` via `$request->file('file')->store('submissions', 'public')`.
- Ensure `php artisan storage:link` is executed so files are accessible from the web at `/storage/submissions/...` if that's intended.
- Consider access control for files if files should be private.

## 8. Seeders & initialization

- `database/seeders/AbsSoftInstituteSeeder.php` creates the `ABS Soft Pvt. Ltd` college (if not present) via `firstOrCreate`.
- Database seeding should be part of the initial deploy process; add seeder calls in `DatabaseSeeder` if not present.
- Optionally add a seeder to create a default `super_admin` user for first access.

## 9. Recommendations & next steps

- Replace the `ABS Soft Pvt. Ltd` magic string with a configuration key.`config/abs.php` or `config/app.php` would be a good place.
- Add a seeder to create a default `super_admin` (one-time safe seeder that checks for existing email).
- Add feature tests for critical flows:
  - Student registration and approval by college admin.
  - Submission creation and file upload behavior.
  - Reviewer assignment and feedback flow.
- Add email notifications when submission status changes (Submitted -> Under Review -> Shortlisted/Rejected).
- Use DB transactions or filesystem cleanup logic in the submission creation flow to avoid orphaned files if DB write fails.
- Consider privacy for uploaded files: if they contain sensitive content, don't serve them directly from `public` disk; stream them through a controller that verifies access.


Appendix: quick links to code

- `app/Http/Controllers/SuperAdminController.php` — institute/user/submission management
- `app/Http/Controllers/StudentController.php` — submission creation
- `app/Http/Controllers/CollegeAdminController.php` — pending student approvals
- `app/Models/College.php`, `app/Models/User.php`, `app/Models/Submission.php`
- `resources/views/student/*`, `resources/views/superadmin/*`, `resources/views/reviewer/*`, `resources/views/college/*`
- `routes/web.php`, `routes/auth.php`


If you'd like, I can now:
- Convert this overview into a README section or a wiki page.
- Implement the config refactor for the ABS Soft magic string and update controllers.
- Add a `super_admin` seeder and/or a seed-safe super_admin creation.
- Add feature tests for the student submission flow (happy path + attachments).

Which of those should I do next?
