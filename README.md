# Project Documentation

## Overview

This application is a RESTful API for managing a shopping cart system. It allows users to authenticate, add products to their cart, update cart items, remove products, and view their current cart. The application is built using Laravel and follows a service-repository pattern for better separation of concerns.

## Features

- User authentication using Laravel Sanctum.
- Operations for products.
- Cart management including adding, updating, and removing items.
- Pagination for product listings.
- Error handling and validation for API requests.

## Technologies Used

- **Laravel**: PHP framework for building the application.
- **Sanctum**: For API token authentication.
- **Eloquent ORM**: For database interactions.
- **Mockery**: For mocking dependencies in unit tests.
- **PHPUnit**: For running tests.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/your-repo.git
   cd your-repo
   ```

2. Install Laravel Sail:
   ```bash
   composer require laravel/sail --dev
   ```

3. Publish the Sail configuration:
   ```bash
   php artisan sail:install
   ```

4. Start the Sail environment:
   ```bash
   ./vendor/bin/sail up
   ```

5. Set up your environment:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate an application key:
     ```bash
     ./vendor/bin/sail artisan key:generate
     ```

6. Set up the database:
   - Create a new database and update the `.env` file with your database credentials.

7. Run migrations and seed the database:
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

## API Endpoints

### Authentication

- **Login**
  - `POST /api/login`
  - Request body: `{ "email": "user@example.com", "password": "password" }`
  - Response: `{ "status": "success", "token": "your_token" }`

### Products

- **List Products**
  - `GET /api/v1/products`
  - Response: `{ "status": "success", "data": [...] }`

- **Show a Product**
  - `GET /api/v1/products/{id}`
  - Response: `{ "status": "success", "data": { ... } }`

- **Create a Product**
  - `POST /api/v1/products`
  - Request body: `{ "name": "Product Name", "description": "Product Description", "price": 99.99 }`
  - Response: `{ "status": "success", "message": "Product created successfully", "data": { ... } }`

- **Update a Product**
  - `PUT /api/v1/products/{id}`
  - Request body: `{ "name": "Updated Name", "description": "Updated Description", "price": 149.99 }`
  - Response: `{ "status": "success", "message": "Product updated successfully", "data": { ... } }`

- **Delete a Product**
  - `DELETE /api/v1/products/{id}`
  - Response: `{ "status": "success", "message": "Product deleted successfully" }`

### Cart Management

- **Add to Cart**
  - `POST /api/v1/cart/add`
  - Request body: `{ "product_id": 1, "quantity": 1 }`
  - Response: `{ "status": "success", "message": "Product added to cart" }`

- **Update Cart Item**
  - `PUT /api/v1/cart/update`
  - Request body: `{ "product_id": 1, "quantity": 2 }`
  - Response: `{ "status": "success", "message": "Cart item updated" }`

- **Remove from Cart**
  - `DELETE /api/v1/cart/remove`
  - Request body: `{ "product_id": 1 }`
  - Response: `{ "status": "success", "message": "Product removed from cart" }`

- **Get Cart**
  - `GET /api/v1/cart`
  - Response: `{ "status": "success", "data": { ... } }`

### Checkout

- **Checkout**
  - `POST /api/checkout`
  - Request body: `{ "payment_method": "credit_card", "address": "123 Main St" }` (example fields)
  - Response: `{ "status": "success", "message": "Checkout successful", "order_id": 1 }`

### Orders

- **List Orders**
  - `GET /api/orders`
  - Response: `{ "status": "success", "data": [{ ... }, { ... }] }` (list of user's orders)

## Testing

To run the tests, use the following command:

```bash
./vendor/bin/sail artisan test
```

### Unit Tests

Unit tests are located in the `tests/Unit` directory. They cover various functionalities of the application, including authentication, product management. With more time, I would add more tests to cover the cart, checkout and order functionalities.