# ERD Overview

## Core Identity
- `users`:
  - Stores authentication data and role (`admin`, `company`, `agency`).
  - Stores account status (`active`, `suspended`, `pending`).
- `company_profiles`:
  - `user_id` (unique, FK to `users`).
  - Company details and branding.
- `agency_profiles`:
  - `user_id` (unique, FK to `users`).
  - Agency details, portfolio, pricing baseline.

## Taxonomies
- `categories`: campaign categories.
- `industries`: market sectors.
- `services`: agency service catalog.
- `agency_service` (pivot):
  - many-to-many between `agency_profiles` and `services`.
- `agency_industry` (pivot):
  - many-to-many between `agency_profiles` and `industries`.

## Campaign Marketplace
- `campaigns`:
  - `company_id` (FK to `users`).
  - `category_id`, `industry_id` (FKs).
  - lifecycle status (`draft`, `published`, `receiving_proposals`, `under_review`, `awarded`, `in_progress`, `completed`, `cancelled`).
- `campaign_channels`:
  - One-to-many with `campaigns`.
  - Stores required channels (Instagram, TikTok, etc.).
- `campaign_attachments`:
  - One-to-many with `campaigns`.
  - File metadata for briefs and documents.

## Proposal System
- `proposals`:
  - `campaign_id` (FK to `campaigns`), `agency_id` (FK to `users`).
  - Unique `(campaign_id, agency_id)` constraint (one active proposal per agency/campaign record).
  - status (`submitted`, `shortlisted`, `accepted`, `rejected`, `withdrawn`).
- `proposal_attachments`:
  - One-to-many with `proposals`.

## Communication and Notifications
- `conversations`:
  - Scoped by `campaign_id`, optional `proposal_id`.
  - Participants: `company_id` + `agency_id`.
  - Unique `(campaign_id, company_id, agency_id)` constraint.
- `messages`:
  - One-to-many with `conversations`.
  - Tracks sender, body, attachment, read state.
- `notifications`:
  - Laravel polymorphic database notifications.

## Quality and Moderation
- `reviews`:
  - Company-to-agency rating after completion.
  - Unique review per company/agency/campaign.
- `reports`:
  - Complaints/moderation entries.
  - Optional links to user/campaign/proposal.
- `settings`:
  - Key-value runtime configuration for admin.

## Relationship Highlights
- One `company` user -> many `campaigns`.
- One `campaign` -> many `proposals`.
- One `campaign` -> many `conversations`, each conversation -> many `messages`.
- One accepted proposal per campaign is enforced at business logic level.
