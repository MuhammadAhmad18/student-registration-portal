Student Registration Portal — intentionally vulnerable (educational)

Purpose: a small, intentionally insecure PHP student portal you can run locally to learn about XSS and SQL injection.
Important: DO NOT deploy this on the public internet — test only in a local/isolated environment (e.g., XAMPP).

Table of contents
	•	Project overview
	•	Files in this repo
	•	Requirements
	•	Quick setup (XAMPP)
	•	Manual setup (LAMP / other)
	•	Database schema
	•	How to use
	•	Security note & remediation guidance
	•	Warnings & best practices
	•	License / attribution

Project overview

This is a deliberately insecure student registration portal written in PHP intended for learning and testing web vulnerabilities such as SQL injection and cross-site scripting (XSS). The code contains intentionally vulnerable files (for example login_sqli.php) — that is by design to demonstrate how attacks work and how to fix them.

Files in this repo
index.html
login.html
login.php
login_sqli.php    # intentionally vulnerable demo
signup.html
signup.php
student.php
admin.php
logout.php
DB.php
README.md         # (this file)

Requirements

•	Local web stack (XAMPP recommended) or any LAMP stack
•	PHP 7.4+ (PHP 8 recommended)
•	MySQL or MariaDB
•	Modern web browser

Quick setup (XAMPP)
1.	Start Apache and MySQL from the XAMPP control panel.
2.	Copy the project folder to your XAMPP htdocs directory, e.g.:
C:\xampp\htdocs\student-registration-portal (Windows)
3.	Create the database and table (see Database schema below). Use phpMyAdmin or the MySQL CLI.
4.	Update DB credentials in DB.php if needed (XAMPP defaults to root / empty password).
5.	Open the app in your browser: http://localhost/student-registration-portal/index.html

Manual setup (LAMP / other)
1.	Place the project in your web root (e.g., /var/www/html/student-registration-portal).
2.	Ensure PHP and MySQL/MariaDB are running.
3.	Create the DB / table (see below).
4.	Adjust DB.php to match your DB host / username / password / dbname.
5.	Visit http://<your-host>/student-registration-portal/index.html.

Database schema

CREATE DATABASE IF NOT EXISTS student_portal;
USE student_portal;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  father VARCHAR(150),
  roll VARCHAR(50) UNIQUE,
  subject VARCHAR(100),
  phone VARCHAR(30),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),    -- store hashed passwords in production
  gender ENUM('male','female','other'),
  role ENUM('student','admin'),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

How to use
•	index.html — landing page
•	signup.html / signup.php — register as a student (signup stores user in users)
•	login.html / login.php — normal login implementation
•	login_sqli.php — intentionally vulnerable login endpoint to demonstrate SQL injection (do not use in production)
•	student.php — student dashboard
•	admin.php — admin view (depends on role column)
•	logout.php — destroys session and logs out
•	DB.php — database connection configuration

Use this project to experiment locally, learn payloads in a safe environment, and practice fixing vulnerabilities by hardening the code.

Security note & remediation guidance (read before testing)

This repository intentionally includes insecure code for teaching purposes. Follow these hardening steps when you want to fix the app:

Do this in production:

•	Use prepared statements / parameterized queries (PDO or MySQLi prepared statements) to prevent SQL injection.
•	Use password_hash() when storing passwords and password_verify() on login. Never store plaintext passwords.
•	Sanitize and escape output with htmlspecialchars() or appropriate escaping to prevent XSS.
•	Implement proper session handling (regenerate session IDs after login, set secure cookie flags).
•	Validate and sanitize all input server-side, never trust client-side validation alone.
•	Protect forms with CSRF tokens.
•	Use HTTPS (TLS) in any non-local environment.
•	Apply least-privilege for DB users (don’t use root in production).
•	Set appropriate Content Security Policy (CSP) headers to reduce XSS impact.
•	Log and monitor authentication attempts and suspicious activity.

When learning/testing:
•	Use an isolated VM or local stack (XAMPP) — do not expose this repo to the internet.
•	Keep a copy of the original vulnerable code and create a fixed version to compare and learn.

Warnings & best practices

•	Do not deploy this code publicly — it contains explicit vulnerabilities.
•	Always test in a controlled, local environment.
•	If you copy code into your own projects for learning, make sure to implement the security recommendations above before using in production.

Further learning resources (recommended)
•	OWASP Top Ten — introduction to web application security issues.
•	PHP official docs — password_hash, PDO, and security best practices.
•	Tutorials on prepared statements, input validation, and XSS prevention.

License / Attribution

This project is for educational use only. No warranty — use at your own risk. If you want a specific license (MIT, GPL, etc.), add a LICENSE file.
