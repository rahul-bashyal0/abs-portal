<<<<<<< HEAD
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
## Setup & local development
2. Install frontend dependencies

```bash
npm install
npm run dev   # or `npm run build` for production
```

3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
# Edit .env to set DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL, etc.
```

4. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

Note: `AbsSoftInstituteSeeder` is included and should (when run) create the ABS Soft institute used for reviewers.

5. Serve the app

```bash
php artisan serve
# and front-end dev server if needed:
npm run dev
```

6. Run tests

```bash
php artisan test
# or
vendor/bin/pest
```

## Default / seed data

- There is a seeder named `AbsSoftInstituteSeeder` which creates the ABS Soft institute. Run `php artisan db:seed` to populate initial data.

## Recommendations & next steps

1. Replace the magic string `ABS Soft Pvt. Ltd` with a config value (e.g., `config/abs.php`) and reference the config in controllers. This avoids duplication and makes it easier to change.
2. Add tests for reviewer creation and submission assignment to avoid regressions.
3. Add stronger validation or a seeder check so reviewer creation fails loudly if the ABS institute is missing.
4. Review cascade behavior on college deletion and decide whether to use `ON DELETE CASCADE` or `RESTRICT` based on business rules.

If you'd like, I can implement one of these now (config extraction, seed enforcement, or tests). Tell me which and I will implement it and run the relevant checks.

---
Generated on: October 15, 2025
>>>>>>> ce27dcc (Initial commit: project import)
