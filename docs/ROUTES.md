# Route Summary

## Public
- `GET /` home landing page.
- `GET /about`, `GET /how-it-works`, `GET /features`, `GET /pricing`, `GET /faq`.
- `GET /agencies` agency discovery and filtering.
- `GET /contact`, `POST /contact`.

## Auth
- Laravel Breeze auth routes in `routes/auth.php`.
- Email verification enabled.
- Role-aware redirect via `GET /dashboard` (`dashboard.redirect`).

## Shared Authenticated
- `GET /profile`, `PATCH /profile`, `DELETE /profile`.
- Conversations:
  - `GET /conversations`
  - `GET /conversations/{conversation}`
  - `POST /conversations/{conversation}/messages`
- Notifications:
  - `GET /notifications`
  - `POST /notifications/read-all`
  - `POST /notifications/{notification}/read`
- Reports:
  - `POST /reports`

## Company Area (`/company`, middleware: `auth`, `verified`, `role:company`)
- Dashboard:
  - `GET /company/dashboard`
- Profile:
  - `GET /company/profile`
  - `PUT /company/profile`
- Campaigns:
  - Resource routes `company/campaigns/*`
  - `PUT /company/campaigns/{campaign}/status`
- Proposals management:
  - `GET /company/campaigns/{campaign}/proposals`
  - `POST /company/proposals/{proposal}/shortlist`
  - `POST /company/proposals/{proposal}/accept`
  - `POST /company/proposals/{proposal}/reject`
- Reviews:
  - `GET /company/reviews`
  - `POST /company/campaigns/{campaign}/reviews`

## Agency Area (`/agency`, middleware: `auth`, `verified`, `role:agency`)
- Dashboard:
  - `GET /agency/dashboard`
- Profile:
  - `GET /agency/profile`
  - `PUT /agency/profile`
- Campaign browsing:
  - `GET /agency/campaigns`
  - `GET /agency/campaigns/{campaign}`
  - `POST /agency/campaigns/{campaign}/favorite`
  - `DELETE /agency/campaigns/{campaign}/favorite`
  - `GET /agency/favorites`
- Proposals:
  - `GET /agency/campaigns/{campaign}/proposals/create`
  - `POST /agency/campaigns/{campaign}/proposals`
  - `GET /agency/proposals`
  - `GET /agency/proposals/{proposal}`
  - `GET /agency/proposals/{proposal}/edit`
  - `PUT /agency/proposals/{proposal}`
  - `DELETE /agency/proposals/{proposal}`
- Projects:
  - `GET /agency/projects`
  - `GET /agency/projects/{proposal}`

## Admin Area (`/admin`, middleware: `auth`, `role:admin`)
- Dashboard:
  - `GET /admin/dashboard`
- User moderation:
  - `GET /admin/users`
  - `GET /admin/users/{user}/edit`
  - `PUT /admin/users/{user}`
- Campaign moderation:
  - `GET /admin/campaigns`
  - `GET /admin/campaigns/{campaign}`
  - `PUT /admin/campaigns/{campaign}/status`
- Proposal moderation:
  - `GET /admin/proposals`
  - `GET /admin/proposals/{proposal}`
  - `PUT /admin/proposals/{proposal}/status`
- Taxonomies:
  - Resource routes for `categories`, `services`, `industries`.
- Reports:
  - `GET /admin/reports`
  - `PUT /admin/reports/{report}/status`
- Settings:
  - `GET /admin/settings`
  - `PUT /admin/settings`
