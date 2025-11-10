This is Live Demo of this project   http://abhishek.is-great.net/?i=1

Portfolio with Contact Form (PHP + MySQL + PHPMailer)

This is a personal portfolio website with a working contact form that:
Stores messages in a MySQL database
Sends email notifications via Gmail SMTP (PHPMailer)
Shows SweetAlert2 popups for success/loading/error
Works perfectly on both desktop and mobile screens


1. Project Structure

portfolio/
│

├── index.html          # Frontend HTML (includes contact form)
├── send_mail.php       # Backend PHP script (handles mail + DB insert)
├── PHPMailer/
│   ├── src/
│   │   ├── PHPMailer.php
│   │   ├── SMTP.php
│   │   └── Exception.php
│   └── composer.json
│
└── db.sql              # SQL file to create the database and table


2. Database Setup

Open phpMyAdmin (default URL for XAMPP: http://localhost/phpmyadmin)

Click New → Create database
Name it: portfolio

Run this SQL command in the SQL tab:




-- Create table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert admin (password: admin123)
INSERT INTO users (username, password) VALUES ('admin', SHA2('admin123',256));


✅ This creates a table to store all contact form submissions


3. Gmail App Password Setup (Required for PHPMailer)

        Important: You can’t use your Gmail password directly for SMTP — you need an App Password.

Follow these steps carefully:

Go to https://myaccount.google.com/security

Enable 2-Step Verification if not already done.

Scroll down → Find App passwords

Generate a new app password:

        App name: Portfolio Mail
        Device: Select “Other (Custom name)”
        Copy the 16-character password shown (e.g., abcd efgh ijkl mnop)





db.php (Database Connection File)

file named db.php inside your project root and add this credintals

        <?php
        // Database configuration
        $servername = "localhost";  // Usually localhost for XAMPP
        $username = "root";         // Your MySQL username
        $password = "";             // Your MySQL password
        $dbname = "portfolio";      // Your database name

📌 Replace values when deploying online:

        $servername → your hosting SQL hostname (e.g. sql123.infinityfree.com)
        $username → your hosting database username
        $password → your hosting database password
        $dbname → your hosting database name

        

4. Configure the Backend (send_mail.php)
    In your send_mail.php, update the following section with your Gmail credentials:

$mail->Username   = "youremail@gmail.com";  
$mail->Password   = "your_app_password_here"; // App password from Gmail
$mail->setFrom("youremail@gmail.com", "Portfolio Contact Form");
$mail->addAddress("youremail@gmail.com", "Portfolio Owner");


Do not use your actual Gmail password — only the app password!



5. Localhost Setup (XAMPP / WAMP)

        Copy your entire project folder into:

C:\xampp\htdocs\portfolio\

Start Apache and MySQL in the XAMPP control panel.
Open your browser:

http://localhost/portfolio/

Fill the contact form → You should:
See “Sending...” → “Message Sent!” SweetAlert
Get an email in your inbox
See the entry in your contact_messages table


6. Deploying Online (Free Hosting via InfinityFree)

        If you want your contact form to work online:

Sign up at https://www.infinityfree.net/

Create a free hosting account and add a domain/subdomain
Go to Control Panel → MySQL Databases
Create a new database

Note:
DB name
DB username
DB password
Hostname (usually sqlXXX.infinityfree.com)
Update the DB details in your send_mail.php:

$servername = "sqlXXX.infinityfree.com";
$username   = "epf12345678"; 
$password   = "your_db_password";
$dbname     = "epf12345678_portfolio";


Upload your files (using File Manager or FileZilla) to the htdocs/ folder.
Test your live site URL:

https://yourdomain.infinityfreeapp.com/


✅ The contact form will now:
Save messages in your online MySQL database
Send you an email via Gmail SMTP
