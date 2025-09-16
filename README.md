# student-registration-portal
Intentionally vulnerable PHP student portal for learning XSS &amp; SQL injection (educational use only — do NOT deploy)

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
Requirements
	•	XAMPP (or any local LAMP stack)
	•	PHP 7.4+ (PHP 8 recommended)
	•	MySQL / MariaDB
	•	Browser

Quick setup (XAMPP)
	1.	Start Apache and MySQL from XAMPP control panel.
	2.	Copy the project folder to htdocs:
	•	Windows: C:\xampp\htdocs\student-registration-portal
	3.	Import the database (use phpMyAdmin or MySQL CLI) — see schema below.
	4.	Update DB credentials in DB.php if needed (default XAMPP uses root / empty password).
	5.	Open app: http://localhost/student-registration-portal/index.html
 Database (schema)

Create database student_portal and table users with these columns:
	•	id INT AUTO_INCREMENT PRIMARY KEY
	•	name VARCHAR(150)
	•	father VARCHAR(150)
	•	roll VARCHAR(50) UNIQUE
	•	subject VARCHAR(100)
	•	phone VARCHAR(30)
	•	email VARCHAR(150) UNIQUE
	•	password VARCHAR(255)  – store hashed passwords
	•	gender ENUM(‘male’,‘female’,‘other’)
	•	role ENUM(‘student’,‘admin’)
	•	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 Security note (read before testing)
	•	This repo intentionally includes insecure code (e.g., login_sqli.php) for educational purposes only.
	•	Do not expose this project to the public internet. Test only on local/isolated environments.
	•	Never store plaintext passwords — use password_hash() and password_verify() in production.
	•	Use prepared statements to prevent SQL injection and htmlspecialchars() to prevent XSS.
