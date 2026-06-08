# Product Requirements Document (PRD)

# Baitul Muttaqin Youth Management System (BMYMS)

Version: 1.0

Status: Draft

Owner: Masjid Baitul Muttaqin

---

# 1. Executive Summary

Baitul Muttaqin Youth Management System (BMYMS) adalah platform manajemen kegiatan remaja Masjid Baitul Muttaqin yang bertujuan membantu pengurus mengelola kegiatan, peserta, komunikasi, dan transparansi keuangan.

Fokus fase pertama adalah Klub Panahan Remaja.

Sistem harus mendukung:

- Pendaftaran peserta
- Manajemen anggota
- Pengelolaan infak mingguan
- Transparansi laporan keuangan
- Broadcast WhatsApp
- Dashboard administrasi

Platform dirancang agar mudah dikembangkan untuk program remaja lainnya di masa depan seperti:

- Tahfidz
- Futsal
- Kajian Remaja
- Camping
- Leadership Camp
- Outbound
- Kegiatan Sosial

---

# 2. Product Vision

Membangun platform digital yang membantu masjid mengelola aktivitas remaja secara profesional, transparan, dan berkelanjutan.

---

# 3. Goals

## Goal Bisnis

- Meningkatkan partisipasi remaja masjid
- Mempermudah administrasi klub panahan
- Menjaga transparansi keuangan
- Mempermudah komunikasi dengan orang tua

## Goal Operasional

- Mengurangi pencatatan manual
- Mengurangi kesalahan administrasi
- Mengotomatisasi reminder infak
- Menyediakan laporan real-time

---

# 4. Technology Stack

Backend:

- Laravel 13

Frontend:

- Livewire 4
- TailwindCSS 4

Admin Panel:

- FilamentPHP 5

Database:

- PostgreSQL

Queue:

- Laravel Queue

Scheduler:

- Laravel Scheduler

Authorization:

- Spatie Laravel Permission

Testing:

- PestPHP
- PHPUnit

Code Quality:

- Laravel Pint
- PHPStan

Storage:

- Local Storage

Notification:

- Database Notification
- Email Notification
- WhatsApp Notification

---

# 5. User Roles

## Super Admin

Hak akses penuh.

### Permissions

- manage_users
- manage_roles
- manage_settings
- manage_participants
- manage_finance
- manage_broadcast
- view_reports

---

## Ketua Klub

### Permissions

- view_participants
- view_finance
- view_reports

---

## Bendahara

### Permissions

- manage_income
- manage_expense
- view_reports

---

## Admin

### Permissions

- manage_participants
- manage_broadcast

---

## Public User

### Permissions

- register_participant
- view_public_reports

---

# 6. Core Modules

## Module 1: Landing Page

### Public URL

/

### Features

Hero Section

About Section

Training Schedule

Statistics

Financial Summary

Contact

### CTA

Daftar Sekarang

Lihat Jadwal

---

## Module 2: Archery Registration

### URL

/pendaftaran-panahan

### Parent Information

- Parent Name
- WhatsApp Number
- Address

### Child Information

- Child Name
- Age
- School
- Grade

### Permission

- Allowed
- Not Allowed

### Weekly Contribution

Options:

- 5000
- 10000
- 15000
- Custom Amount

### Equipment Option

- Buy Personally
- Provided By Committee
- Shared Contribution

### Suggestion

Textarea

### Registration Status

Default:

Pending Verification

---

# 7. Participant Management

## Resource

ArcheryParticipantResource

### Fields

- Membership Number
- Parent Name
- Parent WhatsApp
- Address
- Child Name
- Child Age
- School
- Grade
- Weekly Contribution
- Equipment Preference
- Status
- Registration Date

### Status

- Pending
- Active
- Inactive
- Resigned

### Features

- Search
- Filter
- Export
- Import
- Detail View

---

# 8. Weekly Donation Module

Purpose:

Generate weekly donation obligations.

### Weekly Process

Every Monday 07:00

Generate donation records.

Status:

- Unpaid
- Paid

### Reminder

Send WhatsApp reminder automatically.

---

# 9. Finance Module

## Income

Fields:

- Date
- Category
- Source
- Amount
- Description

Categories:

- Archery Donation
- General Donation
- Sponsorship
- Others

---

## Expense

Fields:

- Date
- Category
- Amount
- Description

Categories:

- Equipment
- Transportation
- Food
- Operational
- Others

---

# 10. Public Financial Transparency

### URL

/laporan-keuangan

### Display

Financial Summary

Monthly Income

Monthly Expense

Current Balance

Transaction History

Charts

Monthly Cash Flow

---

# 11. WhatsApp Broadcast

Purpose:

Send announcements to parents.

### Features

Create Broadcast

Schedule Broadcast

Immediate Send

Delivery Logs

### Targets

All Participants

Active Participants

Inactive Participants

### Architecture

Use abstraction:

WhatsappGatewayInterface

Implementations:

- MockWhatsappGateway
- FonnteGateway
- WablasGateway
- MetaWhatsappGateway

---

# 12. Dashboard

## Statistics Widgets

- Total Participants
- Active Participants
- Monthly Income
- Monthly Expense
- Current Balance

## Charts

Participant Growth

Cash Flow Trend

## Alerts

Pending Donations

Scheduled Broadcasts

---

# 13. Database Design

Core Tables:

users

roles

permissions

participant_registrations

participants

weekly_donations

income_categories

expense_categories

incomes

expenses

broadcasts

broadcast_logs

training_schedules

settings

notifications

activity_logs

---

# 14. Settings

System Configuration

### Mosque Information

- Mosque Name
- Address
- WhatsApp
- Email
- Instagram
- Google Maps URL

### Club Information

- Club Name
- Logo

### Finance

- Default Weekly Donation

### Communication

- WhatsApp Gateway

---

# 15. Notifications

Supported Channels

## Database

Internal notification.

## Email

System generated email.

## WhatsApp

Broadcast and reminders.

All notifications must use queues.

---

# 16. Security Requirements

Mandatory:

- Authentication
- Authorization
- Policy Based Access
- CSRF Protection
- Rate Limiting
- Validation Rules
- Activity Logging

---

# 17. Performance Requirements

Target:

- < 2 second average page load
- Queue-based notifications
- Lazy loaded reports
- Optimized database indexes

---

# 18. Reporting Requirements

### Financial Reports

Daily

Weekly

Monthly

Yearly

### Participant Reports

Active Members

Inactive Members

Contribution Status

Growth Statistics

Export:

- PDF
- Excel

---

# 19. Future Roadmap

Phase 2

- Attendance Tracking
- Equipment Inventory
- QR Check-in
- Parent Portal

Phase 3

- Multi Program Support
- Tahfidz Module
- Event Management
- Volunteer Management

Phase 4

- Mobile Application
- Android
- iOS
- Push Notification

---

# 20. Definition of Done

A feature is considered complete when:

- Migration created
- Model created
- Filament Resource completed
- Validation implemented
- Authorization implemented
- Unit Test passed
- Feature Test passed
- UI responsive
- No PHPStan errors
- No Pint violations
- Documentation updated

---

# 21. Coding Standards

Must Follow:

- SOLID Principles
- Service Layer Pattern
- Repository Pattern when required
- DTO for complex operations
- Action Classes for business logic
- Queue for long-running tasks
- Event Driven Architecture where appropriate

All code must be production-ready and maintainable.

---

# 22. Deployment & Hosting Strategy

## Infrastructure

- **Server:** VPS / Cloud Instance (e.g., DigitalOcean, AWS EC2, or Linode)
- **OS:** Ubuntu 24.04 LTS
- **Web Server:** Nginx
- **PHP Version:** PHP 8.3+
- **Database Server:** PostgreSQL 16+

## CI/CD Pipeline

- Automated testing via GitHub Actions / GitLab CI (Pest/PHPUnit).
- Automated code style checks using Laravel Pint and PHPStan.
- Automated deployment to staging and production environments using tools like Laravel Envoyer or Deployer.

---

# 23. UI/UX Guidelines

## Design Principles

- **Clean and Minimalist:** Focus on usability and clarity, avoiding clutter.
- **Mobile-First Approach:** Ensure the public landing page and registration forms are fully responsive and optimized for mobile devices, as most parents will access them via smartphones.
- **Accessibility:** Use appropriate contrast ratios, readable font sizes, and ARIA labels for screen readers.

## Color Palette

- Primary: Islamic Green / Teal (reflecting the mosque's identity)
- Secondary: Gold / Yellow (for highlights and accents)
- Neutral: Whites, Grays, and Dark Slate (for text and backgrounds)

---

# 24. Error Handling & Logging

- **Application Logs:** Centralized logging using Laravel's built-in logging mechanism (daily channels).
- **Activity Logs:** Use `spatie/laravel-activitylog` to track user actions, especially for financial transactions and configuration changes.
- **Error Tracking:** Integration with tools like Sentry or Flare to monitor exceptions and application crashes in real-time.

---

# 25. Assumptions & Constraints

## Assumptions

- The mosque has a dedicated admin/operator to manage the system.
- Parents/Participants have access to WhatsApp and can receive broadcast messages.
- The club has an existing bank account or digital wallet (e.g., QRIS) to receive weekly donations.

## Constraints

- Budget constraints may limit the use of premium third-party services (e.g., expensive WhatsApp Official APIs), requiring the use of cost-effective gateways initially.
- The system must be usable by operators with varying levels of technical expertise.

---

# 26. Milestones & Timeline

### Phase 1: MVP (Klub Panahan Remaja)

- **Week 1-2:** Requirement gathering, database design, and UI/UX wireframing.
- **Week 3-4:** Core architecture setup, Authentication, and Landing Page development.
- **Week 5-6:** Participant Management and Archery Registration modules.
- **Week 7-8:** Finance Module, Weekly Donation, and Public Transparency features.
- **Week 9:** WhatsApp Broadcast integration and Dashboard analytics.
- **Week 10:** UAT (User Acceptance Testing), bug fixing, and production deployment.

### Phase 2: Future Expansion

- To be scheduled post-MVP evaluation (approx. 3-6 months after initial launch).