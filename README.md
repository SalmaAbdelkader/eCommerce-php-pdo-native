# eCommerce Platform (PHP & MySQL PDO)

## 📌 Introduction
This is a simple yet powerful eCommerce platform built using native PHP and MySQL with PDO. The project provides essential features such as product management, shopping cart, user authentication, and order processing.

## 🚀 Features
- User authentication (Register/Login/Logout)
- Product catalog with categories
- Shopping cart functionality
- Secure checkout process
- Admin dashboard for managing products, orders, and users
- PDO for secure database interactions
- Responsive UI using Bootstrap

## 🛠️ Technologies Used
- PHP (Native)
- MySQL (with PDO for database interaction)
- HTML, CSS, JavaScript
- Bootstrap for UI
- Font Awesome for icons

## 🔧 Installation
### Prerequisites:
- Apache server (XAMPP, WAMP, or LAMP)
- PHP 7.4 or higher
- MySQL database

### Steps to Install:
1. Clone this repository:
   ```sh
   git clone https://github.com/yourusername/ecommerce-php-pdo.git
   ```
2. Move the project folder to your web server root directory (e.g., `htdocs` in XAMPP).
3. Create a database in MySQL and import the `database.sql` file from the project.
4. Configure database connection in `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_database_user');
   define('DB_PASS', '');
   ```
5. Start Apache and MySQL from your local server.
6. Access the project via `http://localhost/ecommerce-php-pdo`

## 📂 Project Structure
```
/ecommerce-php-pdo
│── /config          # Database configuration
│── /assets          # CSS, JS, and images
│── /admin           # Admin panel
│── /includes        # Reusable components
│── /pages           # Main pages (home, product, cart, etc.)
│── index.php        # Homepage
│── cart.php         # Shopping cart
│── checkout.php     # Checkout process
│── login.php        # User authentication
│── register.php     # New user registration
```

## 🏗️ How to Contribute
1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch`
3. Commit your changes: `git commit -m 'Add new feature'`
4. Push to the branch: `git push origin feature-branch`
5. Open a pull request.

## 🛡️ Security & Best Practices
- Use prepared statements with PDO to prevent SQL injection.
- Sanitize user input to avoid XSS attacks.
- Store passwords securely using `password_hash()`.
- Restrict admin access with proper authentication.

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).

## 📞 Contact
For any queries or contributions, feel free to reach out:
- GitHub: [https://github.com/SalmaAbdelkader]
- Email: salmaabdelkader2019@gmail.com

