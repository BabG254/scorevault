# LAMP Scoreboard – Software Engineering Internship Task

A lightweight web app built on the LAMP stack to manage judges, allow scoring of participants, and display a dynamic public scoreboard.

---

## 🔧 Tech Stack

- **Linux (Tested on Ubuntu + XAMPP)**
- **Apache**
- **MySQL**
- **PHP (v7+)**
- **HTML, CSS, JS (Vanilla + Bootstrap)**

---

## 📂 Features

1. **Admin Panel**  
   - Add judges with a unique ID and display name.

2. **Judge Portal**  
   - View list of participants.  
   - Assign or update scores between 1–100.  
   - Each score is tied to a judge and user.

3. **Public Scoreboard**  
   - Displays users ranked by total score.  
   - Sorted in descending order.  
   - Auto-updates or can be refreshed manually.

---
## 🛠️ Setup Instructions (Local XAMPP)

Follow the steps below to set up the ScoreVault project locally using **XAMPP**.

### 📦 Requirements
- PHP 7.0 or higher
- MySQL
- XAMPP (https://www.apachefriends.org/index.html)

---

### 🚀 Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/BabG254/scorevault.git
### Move to XAMPP Directory

Move the project folder into your htdocs directory:

bash
Copy
Edit
mv scorevault /path-to-xampp/htdocs/
### Start Apache & MySQL

Launch XAMPP Control Panel and start both Apache and MySQL.

### Create the Database

Go to http://localhost/phpmyadmin

Click on Databases

Create a new database named: scorevault

Click on the database name

Go to Import

Select the schema.sql file located in the root of the project folder

Click Go

### Configure Database Credentials

Open scorevault/config.php and update the values as follows:

php
Copy
Edit
<?php
$host = 'localhost';
$user = 'root';           // default XAMPP MySQL user
$pass = '';               // default XAMPP MySQL has no password
$dbname = 'scorevault';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
### Access the App

Admin Panel: http://localhost/scorevault/admin/

Judge Portal: http://localhost/scorevault/judge/

Public Scoreboard: http://localhost/scorevault/scoreboard/

##🔐 Assumptions
Users are pre-registered (hardcoded or inserted via SQL).

No authentication is implemented due to scope constraints.

Score updates are allowed by judges.

##💡 If I Had More Time...
Implement secure login/auth for both Admins and Judges.

Security: Add basic .htaccess auth for admin/judge directories.

Data Validation: Consider server-side sanitation for edge cases.

Mobile UI: Fine-tune Bootstrap responsiveness for smaller screens.

Deployment Automation: Use Git or FTP sync for easier updates.
