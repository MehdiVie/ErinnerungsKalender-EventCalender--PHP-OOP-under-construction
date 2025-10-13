-- ===============================================
--  DATABASE STRUCTURE FOR: erinnerungskalender_db
-- ===============================================

CREATE DATABASE IF NOT EXISTS erinnerungskalender_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE erinnerungskalender_db;

-- ===============================================
--  TABLE: users
-- ===============================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
--  TABLE: events
-- ===============================================
DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  event_date DATE NOT NULL,
  reminder_time DATETIME DEFAULT NULL,
  notified TINYINT(1) DEFAULT 0,
  notified_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (user_id),
  INDEX (reminder_time),
  INDEX (notified),
  CONSTRAINT fk_events_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
--  TABLE: reminder_queue
-- ===============================================
DROP TABLE IF EXISTS reminder_queue;
CREATE TABLE reminder_queue (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  event_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  scheduled_at DATETIME NOT NULL,
  status ENUM('pending','sent','failed') DEFAULT 'pending',
  attempts TINYINT UNSIGNED DEFAULT 0,
  last_error TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sent_at DATETIME DEFAULT NULL,
  UNIQUE KEY uq_event_once (event_id),
  INDEX ix_sched_status (scheduled_at),
  INDEX ix_status (status),
  INDEX fk_q_user (user_id),
  CONSTRAINT fk_queue_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
  CONSTRAINT fk_queue_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
--  EVENT (MySQL Scheduler)
-- ===============================================
DROP EVENT IF EXISTS ev_fill_reminder_queue;
DELIMITER $$
CREATE EVENT ev_fill_reminder_queue
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
  SET time_zone = 'Europe/Vienna';

  INSERT INTO reminder_queue (event_id, user_id, scheduled_at)
  SELECT e.id, e.user_id, e.reminder_time
  FROM events e
  WHERE e.reminder_time IS NOT NULL
    AND e.reminder_time <= NOW()
    AND e.notified = 0
    AND NOT EXISTS (
      SELECT 1
      FROM reminder_queue q
      WHERE q.event_id = e.id
    );
END$$
DELIMITER ;
