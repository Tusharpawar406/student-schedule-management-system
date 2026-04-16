# Student Schedule Management System

## WHAT YOU NEED (Install these first)

1. XAMPP — download from https://www.apachefriends.org
   - This gives you Apache (web server) + PHP + MySQL all in one


## STEP 1 — Install XAMPP

1. Download XAMPP for Windows from https://www.apachefriends.org
2. Run the installer, click Next through everything
3. Once installed, open XAMPP Control Panel
4. Click Start next to Apache
5. Click Start next to MySQL
6. Both should show green. Done.



## STEP 2 — Copy project files

1. Open File Explorer
2. Go to: `C:\xampp\htdocs\`
3. Create a new folder called `ssms2`
4. Copy ALL files from this zip into that folder

Your structure should look like:

C:\xampp\htdocs\ssms\
    index.php
    database.sql
    css\
        style.css
    includes\
        db.php
        header.php
    pages\
        login.php
        register.php
        logout.php
        students.php
        schedules.php
        activities.php
        feedback.php




## STEP 3 — Set up the database

1. Open your browser and go to: http://localhost/phpmyadmin
2. Click SQL tab at the top
3. Open the file `database.sql` from this project in Notepad
4. Copy ALL the text from that file
5. Paste it into the SQL box in phpMyAdmin
6. Click Go
7. You should see "5 queries executed successfully" or similar
8. On the left sidebar you should now see a database called `ssms`


## STEP 4 — Check DB connection (if needed)

Open `includes/db.php` in Notepad. It should look like:

php
$host = "localhost";
$user = "root";
$pass = "";        // blank for XAMPP default
$db   = "ssms";


For XAMPP the default user is `root` and password is blank (empty).
If you set a MySQL password, put it in the `$pass = ""` line.



## STEP 5 — Open the website

1. Open your browser
2. Go to: **http://localhost/ssms**
3. You should see the home page


## STEP 6 — Use the website

### Login
- Go to http://localhost/ssms/pages/login.php
- Email: `admin@ssms.com`
- Password: `admin123`



## PROJECT STRUCTURE EXPLAINED


index.php           → Home page
database.sql        → Run this in phpMyAdmin to create tables

css/
  style.css         → All CSS styling for every page

includes/
  db.php            → Database connection (change password here if needed)
  header.php        → Top navigation bar (shared across all pages)

pages/
  login.php         → Login form + session start
  register.php      → Registration form
  logout.php        → Clears session, redirects home
  students.php      → Full CRUD for student table
  schedules.php     → Full CRUD for schedule table
  activities.php    → Full CRUD for activity table
  feedback.php      → Feedback/contact form


## COMMON PROBLEMS & FIXES

**"Connection failed"**
→ Make sure MySQL is running in XAMPP Control Panel

**Page shows PHP code instead of webpage**
→ Apache is not running. Start it in XAMPP Control Panel

**http://localhost/ssms shows "Not Found"**
→ Make sure files are in `C:\xampp\htdocs\ssms\`

**phpMyAdmin not opening**
→ Go to http://localhost/phpmyadmin (not https)
