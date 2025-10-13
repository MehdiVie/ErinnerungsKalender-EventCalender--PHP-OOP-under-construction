# README_FA

# 📘 پروژه: Erinnerungskalender (تقویم یادآور)

این پروژه یک سیستم وب‌محور برای ایجاد و مدیریت رویدادهای شخصی است که در زمان تعیین‌شده به‌صورت خودکار ایمیل یادآوری ارسال می‌کند.

---

## 🧩 ویژگی‌ها

- ثبت‌نام و ورود کاربران (Login / Register)
- ایجاد، ویرایش و حذف رویدادها
- تعیین زمان یادآوری برای هر رویداد
- ارسال ایمیل خودکار با **PHPMailer**
- مشاهده‌ی وضعیت صف یادآوری (**reminder_queue**)
- اجرای دستی Cron از طریق منوی **Run Cron**
- طراحی واکنش‌گرا با **Bootstrap**
- اعتبارسنجی کامل داده‌ها در سمت سرور (PHP)

---

## ⚙️ ساختار پروژه

```
erinnerungskalender/
│
├── app/
│   ├── controllers/
│   ├── core/
│   ├── cron/
│   ├── repositories/
│   ├── services/
│   └── views/
│
├── config/
│   ├── env.php
│
├── database/
│   └── database.sql
│
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── css, js, images
│
└── README.md
```

---

## 💾 پایگاه داده (Database)

برای ساخت دیتابیس، محتوای فایل زیر را اجرا کنید:

```
database/database.sql
```

### جدول‌ها

- **users:** اطلاعات کاربران
- **events:** اطلاعات رویدادها
- **reminder_queue:** صف ارسال ایمیل‌ها

---

## ⏰ MySQL Event و Cron

### 1️⃣ MySQL Event

رویداد زیر جدول **reminder_queue** را هر دقیقه با داده‌های آماده‌ی ارسال پر می‌کند:

```sql
CREATE EVENT ev_fill_reminder_queue
ON SCHEDULE EVERY 1 MINUTEDO
BEGIN  INSERT INTO reminder_queue (event_id, user_id, scheduled_at)
  SELECT e.id, e.user_id, e.reminder_time
  FROM events e
  WHERE e.reminder_time IS NOT NULL    AND e.reminder_time <= NOW()
    AND e.notified = 0    AND NOT EXISTS (
      SELECT 1 FROM reminder_queue q WHERE q.event_id = e.id    );
END;
```

### 2️⃣ cronReminder.php

در مسیر `app/cron/cronReminder.php` قرار دارد و وظیفه‌ی ارسال ایمیل‌ها را دارد.

لاگ اجرا در `app/cron/cron.log` ذخیره می‌شود.

در محیط واقعی باید با **Task Scheduler** اجرا شود، اما در این پروژه برای تست راحت‌تر، از طریق منوی **Run Cron** قابل اجراست.

---

## 📧 تنظیمات ایمیل

در فایل `config/env.php` مقادیر زیر را وارد کنید:

```php
$_ENV['MAIL_HOST'] = 'smtp.gmail.com';$_ENV['MAIL_PORT'] = 587;$_ENV['MAIL_USERNAME'] = 'your.email@gmail.com';$_ENV['MAIL_PASSWORD'] = 'your_16_digit_app_password';$_ENV['MAIL_FROM_NAME'] = 'Erinnerungskalender';
```

> ⚠️ توجه: برای استفاده از Gmail باید در تنظیمات امنیتی خود App Password ایجاد کنید.
> 

---

## 🚀 اجرای پروژه

### پیش‌نیازها

- PHP ≥ 8.1
- MySQL ≥ 5.7
- Apache (Laragon / XAMPP)
- افزونه‌های فعال PHP:
    - pdo_mysql
    - mbstring
    - intl

### مراحل نصب

1. پروژه را در مسیر زیر قرار دهید:
    
    ```
    C:\laragon\www\erinnerungskalender
    ```
    
2. دیتابیس را بسازید و فایل `database.sql` را اجرا کنید.
3. تنظیمات ایمیل را در `config/env.php` وارد کنید.
4. Apache را اجرا کنید.

### اجرای پروژه

```
http://localhost/erinnerungskalender/public/
```

### اجرای دستی Cron

در منو روی **Run Cron** کلیک کنید تا فایل `cronReminder.php` اجرا شود.

---

## 🧪 وضعیت پروژه

- ساختار MVC کامل ✅
- ارسال ایمیل تست‌شده ✅
- رویداد MySQL فعال ✅
- اعتبارسنجی تاریخ‌ها اصلاح شده ✅
- تست نهایی و خروجی PDF باقی‌مانده ⚙️