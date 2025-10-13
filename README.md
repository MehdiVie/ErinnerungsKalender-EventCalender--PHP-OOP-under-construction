# 📘 Project: Erinnerungskalender (Reminder Calendar)

A PHP-based web application for creating and managing events with automatic reminder emails via PHPMailer.

---

## 🧩 Features

- User registration and login  
- Create, edit, and delete events  
- Set reminder date/time  
- Automatic email reminders  
- View reminder queue  
- Manual Cron run from the menu (Run Cron)  
- Responsive Bootstrap design  
- Full backend validation

---

## 💾 Database

Run:
```
database/database.sql
```

Tables:
- users  
- events  
- reminder_queue  

---

## ⏰ MySQL Event and Cron

**MySQL Event:** automatically fills the reminder_queue every minute.  
**cronReminder.php:** sends reminder emails and logs results.  

In production, use a Task Scheduler to run the script automatically.  
For testing, use the menu item **Run Cron**.

---

## 📧 Email Configuration

Edit `config/env.php`:

```php
$_ENV['MAIL_HOST'] = 'smtp.gmail.com';
$_ENV['MAIL_PORT'] = 587;
$_ENV['MAIL_USERNAME'] = 'your.email@gmail.com';
$_ENV['MAIL_PASSWORD'] = 'your_16_digit_app_password';
$_ENV['MAIL_FROM_NAME'] = 'Erinnerungskalender';
```

---

## 🚀 How to Run

### Requirements
- PHP ≥ 8.1  
- MySQL ≥ 5.7  
- Apache (Laragon / XAMPP)

### Steps
1. Copy the project to:
   ```
   C:\laragon\www\erinnerungskalender
   ```
2. Import `database.sql` into MySQL.  
3. Update `config/env.php` with your email credentials.  
4. Start Apache.

### Access
With VirtualHost:
```
http://erinnerungskalender.test
```
Without VirtualHost:
```
http://localhost/erinnerungskalender/public/
```

### Run Cron Manually
Click **Run Cron** from the menu.

---

## ✅ Status
- MVC structure complete  
- Email sending tested  
- MySQL Event active  
- Final tests pending  
