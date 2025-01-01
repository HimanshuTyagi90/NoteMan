Notes Management System
A simple web application for managing notes with features like folder organization, note uploading, and a user-friendly interface. It allows users to create, manage, and view folders and notes in a hierarchical structure with search functionality. This system also allows the upload of various note types, such as PDFs and DOCX files, while providing mobile-friendly views and a modal-based UI for enhanced user experience.

Features
User Authentication:

Login and Signup functionality for secure access.
Folder Management:

Create folders and subfolders for better organization.
Search folders by name.
Notes Management:

Upload notes (PDF, DOCX, etc.) to specific folders.
View, download, and delete notes.

View-only mode for PDF files to restrict editing.
Dynamic Folder Navigation:

View and navigate through folders and subfolders.
Back navigation with preserved folder state.
Mobile-Friendly Interface:

Fully responsive using Bootstrap.

Modal dialogs for managing folders, uploading notes, and viewing content.
Installation and Setup

Prerequisites

PHP 7.4+
XAMPP (or a compatible local server with Apache and MySQL)
MySQL database
Steps to Set Up
Clone the repository:

bash
Copy code
git clone https://github.com/your-username/Notes-Management-System.git
Set up XAMPP:

Start Apache and MySQL services from the XAMPP control panel.
Set up the database:

Open phpMyAdmin and create a new database called NoteMan.
Import the NoteMan.sql file from the repository to create tables.
Configure database connection:

Update the database connection settings in the db_config.php file:
php
Copy code

<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'NoteMan';
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
?>

Launch the app:

Access the application by visiting http://localhost/Notes-Management-System.

Project Structure
graphql
Copy code



Notes-Management-System/
│
├── css/
│   └── styles.css          # Custom styles for the app
│
├── js/
│   └── scripts.js          # JavaScript for managing UI interactions
│
├── views/
│   ├── homepage.php        # Main dashboard for managing folders and notes
│   ├── signupform.php      # Signup form
│   ├── loginform.php       # Login form
│
├── controllers/
│   ├── folder_controller.php  # Backend logic for managing folders
│   ├── auth_controller.php    # Backend logic for user authentication
│
├── db/
│   ├── db_config.php       # Database configuration file
│   ├── setup.sql           # SQL script for setting up the database and tables
│
├── README.md               # Project documentation
└── index.php               # Entry point for the app
Usage
Sign Up:

Create a new account by filling out the signup form.
Login:

Use your credentials to log in and access your dashboard.
Folder Management:

Create new folders and subfolders to organize your notes.
Search for folders by name using the search functionality.
Upload Notes:

Upload notes (PDF, DOCX, etc.) directly to specific folders.
View Folders:

Click on any folder to view its contents. Navigate through subfolders and notes with modal dialogs.
Use the "Back" button to return to the previous state.
Contributing
We welcome contributions to the project! Here’s how you can help:

Fork the repository.

Create a feature branch:

bash
Copy code
git checkout -b feature-name
Commit your changes:
bash
Copy code
git commit -m "Add meaningful commit message"
Push to the branch:
bash
Copy code
git push origin feature-name
Open a pull request.
License
This project is licensed under the MIT License. See the LICENSE file for more details.

Author
Created by Himanshu Tyagi.
Feel free to reach out for any questions or suggestions at [thimanshu937@gmail.com , himanshu5608@outlook.com].

Acknowledgments
Bootstrap: For the responsive design.
PHP: For server-side functionality.
MySQL: For database management.
