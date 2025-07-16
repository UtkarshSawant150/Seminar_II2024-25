# 📚 My Bookstore

A complete PHP + MySQL bookstore web application inspired by Amazon India UI/UX.

This project lets users browse books, search, filter by category, add to cart, and checkout orders. It also includes a full admin panel to manage the catalog.

---

## 🚀 Features

✅ User registration and login  
✅ Admin login and dashboard  
✅ Add, edit, delete books  
✅ Category filtering and search  
✅ Shopping cart  
✅ Checkout and order records  
✅ Secure password hashing  
✅ Clean Bootstrap UI

---

## 🗂️ Project Structure

bookstore/
├── assets/
│ ├── css/ # Custom styles (style.css)
│ ├── js/ # Form validation scripts (main.js)
│ └── images/ # Logo and book images
├── config/
│ └── db.php # Database connection
├── includes/
│ ├── header.php # Navbar
│ └── footer.php # Footer
├── admin/
│ ├── dashboard.php # Admin dashboard
│ ├── add_book.php
│ ├── edit_book.php
│ ├── delete_book.php
│ └── view_books.php
├── user/
│ ├── login.php # User/admin login
│ ├── register.php # User registration
│ └── logout.php # Logout
├── index.php # Home page
├── book.php # Single book details
├── cart.php # Shopping cart
├── checkout.php # Checkout page
└── README.md

---

## ⚙️ Installation Guide

Follow these steps to set up locally on XAMPP:

1️⃣ **Copy Files**

Place the `bookstore` folder inside:

C:\xampp\htdocs\

2️⃣ **Start XAMPP**

Open XAMPP Control Panel:
- Start **Apache**
- Start **MySQL**

3️⃣ **Create Database**

Open your browser:

http://localhost/phpmyadmin

- Click **Databases**
- Create a database named:

bookstore

4️⃣ **Create Tables**

Select the `bookstore` database, click **SQL**, and paste:

```sql
-- USERS
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) DEFAULT 0
);

-- CATEGORIES
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- BOOKS
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255),
  price DECIMAL(10,2),
  image VARCHAR(255),
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- ORDERS
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10,2),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ORDER ITEMS
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  book_id INT,
  quantity INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Default categories
INSERT INTO categories (name) VALUES
('Fiction'),
('Non-Fiction'),
('Science'),
('Technology'),
('Children');

-- Admin user
INSERT INTO users (username, email, password, is_admin)
VALUES (
  'admin',
  'admin@example.com',
  '$2y$10$uAzAbjF0/74M/N6pTLv0JOejQSeZsJUqv1m3HzsmzH0S02KJ4MRxK',
  1
);
🔑 Default Admin Credentials
#Email: admin@example.com

#Password: admin123

🌐 How to Use
1️⃣ Open in Browser
http://localhost/bookstore/

2️⃣ Admin Login
Go to:
http://localhost/bookstore/user/login.php

Login with the admin credentials.

3️⃣ Manage Books
Use the dashboard to add, edit, delete books.

4️⃣ Register as a User
Create a customer account to test shopping features.

🛡️ Security Measures
✅ Passwords hashed with password_hash()
✅ Prepared statements to prevent SQL injection
✅ Session-based authentication
✅ Input validation

🎨 Customization
Logo: Replace assets/images/logo.png

Colors & Styles: Edit assets/css/style.css

Categories: Manage directly in the database

❤️ Credits
Developed with PHP, MySQL, and Bootstrap.

