# 📚 Digital Library Management System (DLMS)

## 🔹 Overview

The Digital Library Management System (DLMS) is a web-based application designed to automate and streamline library operations such as book management, issuing, returning, and user tracking.

This system replaces traditional manual processes with a fast, secure, and user-friendly digital solution.

---

## 🔹 Features

### 👤 User Features

* User Registration & Login
* Search Books
* Request Book Issue
* Submit Return Requests
* View Issued Books & History
* Submit Feedback

### 🔑 Admin Features

* Add / Update / Delete Books
* Manage Library Inventory
* Approve / Reject Return Requests
* View User Activity
* Dashboard Overview

---

## 🔹 Technologies Used

* **Frontend:** HTML, CSS, Bootstrap
* **Backend:** PHP
* **Database:** MySQL
* **Server:** XAMPP (Apache)

---

## 🔹 System Architecture

* Three-Tier Architecture:

  * Presentation Layer (UI)
  * Application Layer (PHP)
  * Database Layer (MySQL)

---

## 🔹 Database

The system uses the following tables:

* users
* books
* transactions
* return_requests
* feedback

---

## 🔹 How to Run the Project

1. Install XAMPP
2. Start Apache and MySQL
3. Copy project folder into `htdocs`
4. Import the database file (`database.sql`) into phpMyAdmin
5. Open browser and run:
   http://localhost/dlib

---

## 🔹 Future Enhancements

* Fine calculation for overdue books
* Email/SMS notifications
* Book reservation system
* Analytics dashboard

---

