# S2_Project Documentation

## Table of Contents
- Introduction
- [Project Structure](#project-structure)
- Installation
- Usage
- Scripts
- Database
- Contributing
- License

## Introduction
The `S2_Project` is a web application designed to manage student populations, courses, and attendance. It includes features for user authentication, data visualization, and CRUD operations on student and course data.

## Project Structure
```
S2_Project/
├── .gitignore
├── css/
│   ├── grade.css
│   ├── index_style.css
│   ├── population.css
│   └── welcome_style.css
├── database/
│   └── s2.sql
├── delete_student.php
├── edit_student.php
├── examples/
│   └── index.html
├── grade.php
├── index_action.php
├── index.php
├── js/
│   ├── attendance_chart.js
│   ├── buttons.js
│   ├── footer.js
│   └── population_chart.js
├── ManageData.php
├── population.php
├── project_documentation/
│   ├── desktop.ini
│   ├── semester2-project 1.docx
│   └── semester2-project.drawio
├── README.md
├── sql_scripts/
│   ├── active_population.sql
│   ├── courses_table.sql
│   ├── overall_attendance.sql
│   └── ...
├── User.php
├── welcome_action.php
└── welcome.php
```

## Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/S2_Project.git
    ```
2. Navigate to the project directory:
    ```sh
    cd S2_Project
    ```
3. Set up the database:
    - Import the SQL script from the [`database/s2.sql`]( "c:\xampp\htdocs\UNI\S2\S2_Project\database\s2.sql") file into your MySQL database.

## Usage
1. Start your local server (e.g., XAMPP, WAMP).
2. Open the project in your browser:
    ```sh
    http://localhost/S2_Project/index.php
    ```

## Scripts
- **JavaScript Files**:
  - [`js/attendance_chart.js`]("c:\xampp\htdocs\UNI\S2\S2_Project\js\attendance_chart.js"): Handles the rendering of attendance charts.
  - [`js/buttons.js`]("c:\xampp\htdocs\UNI\S2\S2_Project\js\buttons.js"): Contains functions for button actions.
  - [`js/footer.js`]("c:\xampp\htdocs\UNI\S2\S2_Project\js\footer.js"): Updates the footer with the current date.
  - [`js/population_chart.js`]( "c:\xampp\htdocs\UNI\S2\S2_Project\js\population_chart.js"): Handles the rendering of population charts.

## Database
- **Database Configuration**:
  - The database connection is managed in [`ManageData.php`]("c:\xampp\htdocs\UNI\S2\S2_Project\ManageData.php").
  - Update the database credentials in the `ManageData` class if necessary.

- **SQL Scripts**:
  - [`sql_scripts/active_population.sql`]("c:\xampp\htdocs\UNI\S2\S2_Project\sql_scripts\active_population.sql"): Script to create and populate the active population table.
  - [`sql_scripts/courses_table.sql`]("c:\xampp\htdocs\UNI\S2\S2_Project\sql_scripts\courses_table.sql"): Script to create and populate the courses table.
  - [`sql_scripts/overall_attendance.sql`]("c:\xampp\htdocs\UNI\S2\S2_Project\sql_scripts\overall_attendance.sql"): Script to create and populate the overall attendance table.
  - [`database/s2.sql`]("c:\xampp\htdocs\UNI\S2\S2_Project\database\s2.sql"): Script to set up the entire database.

## Contributing
1. Fork the repository.
2. Create a new branch:
    ```sh
    git checkout -b feature-branch
    ```
3. Make your changes and commit them:
    ```sh
    git commit -m "Description of changes"
    ```
4. Push to the branch:
    ```sh
    git push origin feature-branch
    ```
5. Open a pull request.