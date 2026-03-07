# Media Bridge (Graduation Project MVP)

Digital intermediary platform connecting companies/brands with digital marketing agencies through a structured campaign marketplace.

## Project Overview
This Laravel 11 application replaces ad-hoc communication channels with a transparent workflow:
- Companies create campaign requests with budget, scope, timeline, and attachments.
- Agencies browse and filter campaigns, then submit proposals.
- Companies compare proposals, shortlist, accept one, and track execution.
- Both sides communicate via internal messaging and notifications.
- Admin moderates users, campaigns, proposals, categories, reports, and settings.

## Tech Stack
- Backend: PHP 8.x, Laravel 11
- Frontend: Blade, Bootstrap 5 (RTL), HTML/CSS/JS
- Database: MySQL / MariaDB (SQLite also works for local quick test)
- Auth: Laravel Breeze (Blade)
- Authorization: Laravel middleware + policies + gates
- Notifications: Laravel database notifications
- Tests: PHPUnit feature tests

## Main Features
- Role-based access: `guest`, `company`, `agency`, `admin`
- Registration with role selection (`company` or `agency`)
- Email verification flow
- Company profile + agency profile modules
- Campaign lifecycle management with status tracking
- Proposal submission/update/withdraw with business constraints
- Proposal comparison and accept/reject/shortlist workflow
- Internal conversation threads and unread tracking
- In-app notifications (campaign, proposal, message, status updates)
- Post-completion reviews/ratings
- Admin moderation dashboards for users/campaigns/proposals/reports
- Search and filters for campaign discovery and agency directory
- Agency saved campaigns (favorites)
- Agency verification badge managed by admin
- Arabic-first RTL UI

## Business Rules Implemented
- Only authenticated `company` users can create campaigns.
- Only authenticated `agency` users can submit proposals.
- One proposal record per agency per campaign (revision only when allowed).
- Company can accept only one proposal per campaign.
- Accepting a proposal updates campaign state and rejects competing proposals.
- Closed campaigns do not accept new proposals.
- Private dashboards and content are role-restricted.
- Messaging is scoped to relevant campaign/company/agency participants.
- Reviews are allowed after campaign completion only.

## Database and ERD
- Full migration set implemented for:
  - `users`, `company_profiles`, `agency_profiles`
  - `categories`, `industries`, `services`
  - `campaigns`, `campaign_channels`, `campaign_attachments`
  - `proposals`, `proposal_attachments`
  - `conversations`, `messages`
  - `notifications`
  - `reviews`, `reports`, `settings`
  - pivots: `agency_service`, `agency_industry`

See detailed ERD description: [docs/ERD.md](docs/ERD.md)

## Route Summary
See grouped web route summary: [docs/ROUTES.md](docs/ROUTES.md)

## Installation
1. Clone project and enter folder.
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy env file:
   ```bash
   cp .env.example .env
   ```
4. Configure `.env` database credentials.
5. Generate key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations and seed demo data:
   ```bash
   php artisan migrate:fresh --seed
   ```
7. Link storage for uploads:
   ```bash
   php artisan storage:link
   ```
8. Run app:
   ```bash
   php artisan serve
   ```
9. Open `http://127.0.0.1:8000`.

## Demo Credentials
- Admin:
  - Email: `admin@mediabridge.test`
  - Password: `admin12345`
- Company demo:
  - Email: `company1@mediabridge.test`
  - Password: `company12345`
- Agency demo:
  - Email: `agency1@mediabridge.test`
  - Password: `agency12345`

Seed data also creates:
- 5 companies total
- 10 agencies total
- 15 campaigns
- 30 proposals
- conversations, messages, notifications, reviews, reports

## Running Tests
```bash
php artisan test
```

Critical flows covered:
- registration/login
- company campaign creation
- agency proposal submission
- company proposal acceptance and auto-rejection of others
- role access restrictions
- agency favorites flow
- admin verification flow

## Key Project Structure
- `app/Http/Controllers`:
  - `Company/*`, `Agency/*`, `Admin/*`, shared controllers
- `app/Http/Requests`: validation Form Requests
- `app/Policies`: campaign/proposal/conversation/review authorization
- `app/Models`: normalized domain models + relationships + casts
- `app/Notifications`: in-app database notifications
- `database/migrations`: relational schema
- `database/factories` + `database/seeders`: realistic demo data
- `resources/views`: Bootstrap RTL Blade screens by role/module

## Environment Variables (Important)
From `.env.example`:
- `APP_LOCALE=ar`
- `DB_CONNECTION=mysql`
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `FILESYSTEM_DISK=public`
- `QUEUE_CONNECTION=database`

## Deployment Notes (Shared Hosting / VPS)
1. Set `APP_ENV=production`, `APP_DEBUG=false`.
2. Run:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Ensure writable permissions for:
   - `storage/`
   - `bootstrap/cache/`
4. Run `php artisan storage:link`.
5. Use queue worker if notifications/jobs are queued in future:
   ```bash
   php artisan queue:work
   ```

## Screenshots (Placeholders)
- Public landing page
- Company dashboard
- Agency dashboard
- Proposal comparison screen
- Admin dashboard

## Assumptions
- File uploads use public disk in MVP mode.
- Email notifications are optional and default mailer is log/local.
- Proposal uniqueness is enforced by `(campaign_id, agency_id)` DB constraint.

## Future Improvements
- PDF campaign brief export
- Calendar and reminders
- Advanced analytics/charts
- Activity log audit trail
- Multi-language toggler (AR/EN UI switch)
