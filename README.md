# 🗓️ Reminder Calendar (PHP MVC Project)

A lightweight MVC-based PHP web application for managing personal events with automated email reminders.  
Includes login & registration, event CRUD, reminder scheduling, and a manual Cron execution system.

---

## 🚀 Features

- User registration & login (session-based authentication)  
- Event management: Create, edit, delete  
- **Validation rules:**
  - `reminder_time ≥ current datetime`
  - `event_date ≥ tomorrow’s date`
- Email notifications via PHPMailer  
- MySQL Event for auto-filling the reminder queue  
- Manual Cron execution for sending reminders  
- Clean, responsive interface (Bootstrap)  
- Secure PDO-based database access  

---

## 📂 Project Structure (with description)

```
erinnerungskalender/
│
├── app/                           # Main application logic (MVC)
│   ├── controllers/               # Handles user actions (login, events, cron)
│   │   ├── AuthController.php     # Registration & authentication
│   │   ├── EventController.php    # CRUD operations for events
│   │   ├── HomeController.php     # Dashboard view after login
│   │   └── ReminderQueueController.php  # Manages reminder queue & cron execution
│   │
│   ├── core/                      # Core system (Router, DB, Model)
│   │   ├── Controller.php         # Base class for all controllers
│   │   ├── Database.php           # PDO connection to MySQL
│   │   ├── Model.php              # Base model class
│   │   └── Router.php             # Simple routing (URL → Controller/Action)
│   │
│   ├── cron/                      # Scheduled background processes
│   │   ├── cron.log               # Log file for reminder sending
│   │   └── cronReminder.php       # Script for sending email reminders
│   │
│   ├── libs/PHPMailer/            # PHPMailer library (email sending)
│   │   ├── Exception.php
│   │   ├── PHPMailer.php
│   │   └── SMTP.php
│   │
│   ├── models/                    # Data models
│   │   ├── Event.php              # Event entity
│   │   └── User.php               # User entity
│   │
│   ├── repositories/              # Database operations (CRUD)
│   │   ├── EventRepository.php
│   │   ├── ReminderQueueRepository.php
│   │   └── UserRepository.php
│   │
│   └── services/                  # Business logic & helper services
│       ├── EventService.php       # Event handling logic
│       ├── MailService.php        # PHPMailer setup & sending
│       ├── ReminderQueueService.php # Queue management
│       ├── UserService.php        # User management
│       └── ValidationService.php  # Validation (dates, inputs)
│
├── config/                        # Configuration files
│   ├── env.php                    # Loads environment variables
│   └── paths.php                  # Global paths and constants
│
├── database/                      # Database schema
│   └── database.sql               # SQL structure for tables
│
├── public/                        # Public web directory (entry point)
│   ├── ajax/                      # AJAX endpoints for async actions
│   │   └── ajax_events.php
│   ├── css/                       # Stylesheets (Bootstrap + custom)
│   │   └── style.css
│   ├── images/                    # Logos and UI images
│   │   ├── logo.png
│   │   └── welcome.jpg
│   ├── js/                        # JavaScript files
│   │   └── main.js
│   ├── .htaccess                  # Rewrite all requests to index.php
│   └── index.php                  # Front Controller (Router entry)
│
├── uploads/                       # Reserved folder for user uploads
│
├── views/                         # HTML/PHP templates (View layer)
│   ├── auth/                      # Login & registration pages
│   │   ├── login.php
│   │   └── register.php
│   ├── events/                    # CRUD pages for events
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── list.php
│   ├── home/                      # Dashboard (after login)
│   │   └── index.php
│   ├── includes/                  # Reusable UI components
│   │   ├── footer.php
│   │   ├── header.php
│   │   └── navbar.php
│   ├── layouts/                   # Main layout structure
│   │   └── main.php
│   └── reminders/                 # Reminder queue view
│       └── index.php
│
├── .env                           # Environment variables (DB, Mail)
├── .gitignore                     # Git ignore rules
└── README.md                      # Project documentation
```

---

## ⚙️ Installation

### 1. Place the project  
Example (Laragon/XAMPP):
```
C:\laragon\www\erinnerungskalender\
```

### 2. Create database and import schema  
- Create DB (e.g., `erinnerungskalender_db`)  
- Import `database/database.sql`

### 3. Configure `.env`
APP_ENV=development
DB_HOST=127.0.0.1
DB_NAME=erinnerungskalender_db
DB_USER=root
DB_PASS=

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_16_char_app_password
MAIL_FROM_NAME=Reminder Calendar


```

### 4. Run the app  
Open in browser:
```
http://localhost/erinnerungskalender/public/
```

---

## 🕒 Cron & Reminder Queue

### MySQL Event (auto-fills the reminder_queue)

```sql
DROP EVENT IF EXISTS ev_fill_reminder_queue;
DELIMITER $$
CREATE EVENT ev_fill_reminder_queue
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
  
  INSERT INTO reminder_queue (event_id, user_id, scheduled_at)
  SELECT e.id, e.user_id, e.reminder_time
  FROM events e
  WHERE e.reminder_time IS NOT NULL
    AND e.reminder_time <= NOW()
    AND e.notified = 0
    AND NOT EXISTS (
      SELECT 1 FROM reminder_queue q WHERE q.event_id = e.id
    );
END$$
DELIMITER ;
```

### Manual Cron Execution
You can manually trigger reminder sending via:
```
http://localhost/erinnerungskalender/public/run-cron
```

It processes all pending reminders and logs results in  
`app/cron/cron.log`.

> **Note:**  
> In a real production environment, the `cronReminder.php` script would normally be executed automatically by the operating system (e.g., via a Cron Job or Task Scheduler) at regular intervals to send reminder emails.  
> However, for demonstration and testing purposes, this project includes a **“Run-Cron”** menu item to manually trigger the process.

---

## ✅ Validation Logic
- `reminder_time` → must be **today or later**, not in the past.  
- `event_date` → must be **tomorrow or later** (date only).  
Both validations use the `Europe/Vienna` timezone.

---

## 🔒 Security
- Uses **PDO prepared statements**  
- Escapes all user output via `htmlspecialchars()`  
- `.env` excluded from Git via `.gitignore`  
- Optional CSRF protection can be added for AJAX  

---

## 🧠 Technologies
- PHP 8.x  
- MySQL / MariaDB  
- PHPMailer  
- Bootstrap 5  
- JavaScript (AJAX)

---

## 📧 Test Account (optional)
You can register manually or create a test user directly in the database.
