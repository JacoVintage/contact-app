# contact-app

Contact App — PHP + Tailwind + Docker

A lightweight PHP application that captures Name, Email, South African Phone, and Message,
validates input, saves entries to a MySQL database, and lists them cleanly with Tailwind styling.

Built without frameworks — PHP 8 + TailwindCSS 4.

⸻

Features
	•	Form validation (name, email, phone, message)
	•	PDO prepared statements (SQL-injection safe)
	•	CSRF + honeypot protection
	•	Flash messages (success / error)
	•	Entries list (/list.php)
	•	Tailwind v4 with @apply classes
	•	Docker-ready setup (PHP + MySQL)

    Requirements
	•	Docker & Docker Compose

Setup

1.	Clone this repo
2.  git clone https://github.com/JacoVintage/contact-app
3.  cd contact-app

Start Docker
docker compose up -d

Initialize the database
docker exec -i contact-db mysql -uroot -proot < database/schema.sql

Open the app
	•	Form: http://localhost:8080/￼
	•	Entries: http://localhost:8080/list.php￼

