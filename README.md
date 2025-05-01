Mecwintech - Employee Management System
Mecwintech is a backend employee management system built using the PHP MVC framework. It provides features for managing employee records, tracking attendance with punch in/out functionality, and generating payslips. This system is designed to streamline HR processes for businesses.
Features

Employee Management: Create, update, and manage employee profiles with detailed records.
Attendance Tracking: Record employee punch in and punch out times for accurate attendance monitoring.
Payslip Generation: Generate payslips for employees based on attendance and salary details.
MVC Architecture: Organized codebase following the Model-View-Controller pattern for scalability and maintainability.
Secure Backend: Built with PHP for robust backend processing and data management.

Prerequisites
Before setting up the project, ensure you have the following installed:

PHP >= 7.4
MySQL or MariaDB
Apache or Nginx (e.g., via XAMPP, WAMP, or LAMP stack)
Composer (for dependency management)
Git

Installation

Clone the Repository:
git clone https://github.com/ravirajladha/mecwintech.git
cd mecwintech


Install Dependencies:Run Composer to install PHP dependencies:
composer install


Set Up the Database:

Create a MySQL database (e.g., mecwintech_db).
Import the database schema from database.sql (if provided) or set up tables manually.
Update the database configuration in config/database.php with your database credentials:define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'mecwintech_db');




Configure the Environment:

Copy .env.example to .env (if applicable) and update settings like base URL or other environment-specific variables.
Ensure the public/uploads/ directory is writable for storing uploaded files (e.g., employee photos).


Run the Application:

If using XAMPP, place the project in htdocs/mecwintech.
Access the application via http://localhost/mecwintech/public in your browser.



Usage

Admin Dashboard: Log in to manage employees, view attendance records, and generate payslips.
Employee Records: Add or edit employee details, including personal information and salary data.
Attendance: Use the punch in/out feature to track employee work hours.
Payslips: Generate and download payslips for employees based on attendance and payroll data.

Directory Structure

app/ - Core MVC components (Models, Views, Controllers).
config/ - Configuration files (e.g., database settings).
public/ - Publicly accessible files (e.g., CSS, JS, uploads).
public/uploads/ - Directory for storing uploaded files (e.g., employee photos).
vendor/ - Composer dependencies (excluded in .gitignore).

Contributing
Contributions are welcome! To contribute:

Fork the repository.
Create a feature branch (git checkout -b feature/your-feature).
Commit your changes (git commit -m "Add your feature").
Push to the branch (git push origin feature/your-feature).
Open a pull request.

License
This project is licensed under the MIT License. See the LICENSE file for details.
Contact
For questions or support, contact the maintainer at:

GitHub: ravirajladha

