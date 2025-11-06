# 🍽️ Cafeteria Online Ordering System

The **Cafeteria Online Ordering System** is a web-based platform designed to digitalize food ordering in campus cafeterias.  
Developed for **Polytechnic Ungku Omar (PUO)**, this system allows students to browse menus, place orders, and track their food preparation status — while cafeteria administrators can manage menus, update orders, and monitor customer feedback efficiently.

---

## 🧠 Project Overview

The system aims to solve common issues faced in manual food ordering such as **lost order slips, long queues, and slow service**.  
By enabling online ordering and automated updates, this project enhances both **efficiency and convenience** for students and cafeteria staff.

Developed under the **Department of Information & Communication Technology** for the **Diploma in Information Technology (Digital Technology)**, Session **June 2021**.

---

## ✨ Key Features

### 👨‍🎓 Student Features
- 🧾 Register and log in using student credentials  
- 🍱 Browse available food items and stalls  
- 🛒 Place orders online and view real-time order status  
- 💬 Submit feedback for cafeteria improvements  
- 🔐 Secure login and password reset functionality  

### 👩‍💼 Admin Features
- 📋 Manage menu items and stall details  
- ✏️ Update, add, or delete food listings  
- 📦 Manage student accounts and orders  
- 📊 Track daily transactions and feedback submissions  
- 🔒 Ensure data security through role-based access  

---

## 🏗️ System Architecture

The system follows the **Waterfall Model** development methodology, with structured phases:

| Layer | Description |
|--------|-------------|
| 🎨 **Frontend** | Developed using HTML, CSS, JavaScript |
| ⚙️ **Backend** | PHP and MySQL database integration |
| 🗄️ **Database** | Stores user, menu, order, and feedback data |
| 💻 **Server** | Hosted locally using XAMPP / InfinityFree |

---

## ⚙️ Tech Stack

| Component | Technology |
|------------|-------------|
| **Frontend** | HTML, CSS, JavaScript |
| **Backend** | PHP |
| **Database** | MySQL |
| **Tools Used** | Adobe Dreamweaver, phpMyAdmin, XAMPP |
| **Hosting** | InfinityFree Web Hosting |
| **Development Model** | Waterfall SDLC |

---

## 🧩 System Modules

| Module | Description |
|---------|-------------|
| 🧑‍💻 **Admin Login** | Grants administrative access to menu, stalls, and student data |
| 🍔 **Menu Management** | Admin can add, update, or delete food items |
| 🎓 **Student Registration & Login** | Allows users to sign up, sign in, and recover passwords |
| 🛒 **Order Management** | Enables students to place, view, and track food orders |
| 💬 **Feedback System** | Collects suggestions or complaints from students |
| 📦 **Order Status Update** | Admin updates order progress (In Progress / Completed) |

---

## 🧮 Database Design

| Table | Description |
|--------|-------------|
| `admin` | Stores administrator credentials |
| `student` | Holds student registration details |
| `stall` | Contains stall and menu identifiers |
| `menu` | Lists available food items, prices, and images |
| `orders` | Records all placed orders and their current status |
| `feedback` | Stores feedback messages submitted by users |

---

<h2 align="center">🍽️ Cafeteria Online Ordering System – Interface Preview</h2>

<p align="center">
  <img src="https://github.com/user-attachments/assets/6e3361da-21e0-4bc0-8cd7-c4cb9ba05ba2" width="70%">
  <img src="https://github.com/user-attachments/assets/a1cccd5f-0b96-420d-950a-4c1064e771a1" width="70%">
  <img src="https://github.com/user-attachments/assets/980c94f9-d7b7-4d89-b98b-a377081640b7" width="70%">
  <img src="https://github.com/user-attachments/assets/c56d1257-e2d5-42c6-8476-db33c76acab4" width="70%">
  <img src="https://github.com/user-attachments/assets/b26b10d4-09b8-4e5e-b039-657b0124a22a" width="70%">
  <img src="https://github.com/user-attachments/assets/02bbbbb4-ecf2-44c2-9903-448f493dc34e" width="70%">
  <img src="https://github.com/user-attachments/assets/8f53704e-fcf1-45b7-9617-f49d62e91ca9" width="70%">
  <img src="https://github.com/user-attachments/assets/84a31fbd-15a5-46e2-bb2b-91c3a7b3a356" width="70%">
  <img src="https://github.com/user-attachments/assets/ecaef08f-74e6-4d65-91b7-43e6f15f1752" width="70%">
  <img src="https://github.com/user-attachments/assets/ea3bb1a7-6172-45c4-b256-e9c168284eaf" width="70%">
  <img src="https://github.com/user-attachments/assets/b4aadb9b-e703-4cc7-b172-a80d41e87868" width="70%">
</p>

---

## 🚀 Installation & Setup

### Prerequisites
- XAMPP / WAMP Server (Apache + MySQL)
- Web Browser (Chrome / Edge)
- Code Editor (Visual Studio Code / Dreamweaver)

### Steps
```bash
# Clone this repository
git clone https://github.com/yourusername/CafeteriaOrderingSystem.git

# Move project to server directory
C:\xampp\htdocs\CafeteriaOrderingSystem

# Import database
1. Open phpMyAdmin
2. Create a new database named `cafeteria_db`
3. Import `cafeteria_db.sql` file from the project folder

# Run the system
http://localhost/CafeteriaOrderingSystem

**Planning → Analysis → Design → Development → Testing**

