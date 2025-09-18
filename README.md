<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Booking System API (Laravel Challenge)

A RESTful API for managing appointment bookings between Clients and Specialists, built with Laravel.

## Requirements
 PHP ^8.1
 Composer
 Laravel ^10
 MySQL
Laravel Sanctum (for Authentication)

## Setup Instructions
  # Clone the project:
   git clone (https://github.com/username/booking-system.git](https://github.com/fatmaelkassaby2003/booking.git)
   cd booking-system

  # Install dependencies:
    composer install

 # Run migrations with seeders:
    php artisan migrate --seed
    
## Start the development server:
  php artisan serve

## Authentication
 The system uses Laravel Sanctum.
  User types:
         Client → makes bookings.
         Specialist → provides services and receives bookings.

  # Register
   POST /api/sign
   
  {"name": "Ali",
  "email": "ali@example.com",
  "password": "123456",
  "role": "client"}

 # Login
  POST /api/login
  
  {"email": "ali@example.com",
  "password": "123456"}

##  Bookings API
 # Create a New Booking
POST /api/bookings


  {"service_id": 1,
  "specialist_id": 2,
  "time": "2025-09-20 15:00:00"}

# Update a Booking
  PUT /api/bookings/{id}
  
  {"time": "2025-09-21 18:00:00"}

# Cancel a Booking
  DELETE /api/bookings/{id}

# View Client Bookings
  GET /api/my-bookings

# View Specialist Bookings
  GET /api/specialist/bookings

## Services API
  # Add a Service
   POST /api/services
   
  {"name": "Consultation",
  "price": 200}

 # Update a Service
  PUT /api/services/{id}

# Delete a Service
DELETE /api/services/{id}

# Get All Services
GET /api/services

## Business Rules
A Specialist cannot be booked for two appointments at the same time (Conflict Check).
Booking time must be in the future.
A Service must be linked to a valid Specialist.

## Seed Data
Users (Clients + Specialists).
Services linked to Specialists.
Can be used to test the API directly after running:
php artisan migrate --seed

## Project Goals
Test the ability to analyze requirements and convert them into a proper database schema with relationships.
Apply Laravel Best Practices.
Ensure correct implementation of Business Logic, Validation, and Authentication.

## Security Vulnerabilities
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
