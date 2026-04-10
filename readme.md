# MediCare Plus - Healthcare Web Application

MediCare Plus is a web-based healthcare management system that allows patients, doctors, and administrators to interact through a centralized platform.

## 🚀 Features

- User Authentication (Admin, Doctor, Patient)
- Patient Registration & Login
- Doctor Listing with Search & Filters
- Appointment Booking System
- Doctor Rating & Feedback System
- Real-time Messaging (Doctor ↔ Patient)
- Admin Dashboard (Manage Doctors, Patients, Services)
- Health Tips & Articles
- Responsive UI Design

## 🛠️ Technologies Used

- Frontend: HTML, CSS, JavaScript  
- Backend: PHP  
- Database: MySQL  
- Environment: XAMPP / Apache  

## 📁 Project Structure
medicare-plus/
│
├── frontend/
│ ├── index.html
│ ├── login.html
│ ├── register.html
│ ├── doctors.html
│ ├── patient.html
│ ├── messages.html
│ ├── css/
│ ├── js/
│ └── assets/
│
├── backend/
│ ├── db.php
│ ├── login.php
│ ├── register.php
│ ├── get_doctors.php
│ ├── book_appointment.php
│ ├── send_message.php
│ └── ...
│
└── database.sql

## ⚙️ Setup Instructions

1. Install XAMPP and start Apache & MySQL  
2. Place project in: C:\xampp\htdocs\medicare-plus
3. Import `database.sql` into phpMyAdmin  
4. Update `backend/db.php` with your DB credentials  
5. Open in browser:http://localhost/medicare-plus/frontend/


## 👤 User Roles

- **Patient**: Register, book appointments, message doctors, give feedback  
- **Doctor**: View appointments, communicate with patients  
- **Admin**: Manage users, doctors, services, and appointments  

## 📌 Notes

- Only patients can register via the public registration page  
- Email must be unique (duplicate registrations are blocked)  
- Messaging system includes unread indicators  

## 📄 License

This project is for academic purposes only.
