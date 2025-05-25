# 🛡️🎲 Osadnicy: PHP Browser Game Login Page 🇵🇱
_A PHP-based login page for the "Osadnicy" browser game, featuring session checks, form submission to `zaloguj.php`, and error message display, with Polish UI text._

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP](https://img.shields.io/badge/PHP-Backend%20Processing-777BB4.svg?logo=php)](https://www.php.net/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26.svg?logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)

## 📋 Table of Contents
1.  [Overview](#-overview)
2.  [Key Features](#-key-features)
3.  [Screenshots (Conceptual)](#-screenshots-conceptual)
4.  [System & Backend Requirements](#-system--backend-requirements)
5.  [Local Setup & Viewing](#️-local-setup--viewing)
6.  [Page Usage & Interaction](#️-page-usage--interaction)
7.  [File Structure (Expected)](#-file-structure-expected)
8.  [Important Notes & Considerations](#-important-notes--considerations)
9.  [Contributing](#-contributing)
10. [License](#-license)
11. [Contact](#-contact)

## 📄 Overview

**Osadnicy: PHP Browser Game Login Page**, developed by Adrian Lesniak, serves as the entry point for a PHP-based browser game titled "Osadnicy" (Settlers). This `index.php` page first checks if a user is already logged in by examining the `$_SESSION['zalogowany']` variable. If the user is authenticated, they are immediately redirected to the main game page (`gra.php`). Otherwise, a simple login form is presented, allowing users to enter their `login` (username) and `haslo` (password). Upon submission, the credentials are sent via POST to `zaloguj.php` for authentication. The page is also designed to display any login error messages passed back from `zaloguj.php` via `$_SESSION['blad']`. It features a philosophical quote by Plato and minimal HTML styling, with all UI text in Polish.

## ✨ Key Features

*   🔑 **Session-Based Authentication Check**:
    *   On page load, it checks `$_SESSION['zalogowany']`.
    *   If `true`, the user is automatically redirected to `gra.php` (the main game page).
*   📝 **Login Form**:
    *   Provides input fields for `login` (username) and `haslo` (password).
    *   Submits credentials to `zaloguj.php` using the HTTP `POST` method.
*   💬 **Error Message Display**:
    *   If `$_SESSION['blad']` (error) is set (presumably by `zaloguj.php` after a failed login attempt), its content is displayed to the user, typically below the login form.
    *   It's crucial that `zaloguj.php` or this page unsets `$_SESSION['blad']` after displaying it to prevent the error from persisting across unrelated page views.
*   📜 **Philosophical Quote**:
    *   Features a quote by Plato: "Tylko martwi ujrzeli koniec wojny." (Only the dead have seen the end of war.) displayed at the top of the page.
*   🏛️ **Minimalist HTML Design**:
    *   Basic HTML structure with no external CSS stylesheet linked. Styling relies on default browser rendering.
*   🇵🇱 **Polish Language Interface**:
    *   All user-facing text, including form labels, button text ("Zaloguj sie" - Log in), and the quote, is in Polish. The HTML document is marked with `lang="pl"`.

## 🖼️ Screenshots (Conceptual)

**Coming soon!**

_This section would ideally show screenshots of: the login form with the Plato quote, and an example of how an error message from `$_SESSION['blad']` might be displayed._

## 🛠️ System & Backend Requirements

### Frontend (This `index.php` Page):
*   **Web Browser**: Any modern web browser (e.g., Google Chrome, Mozilla Firefox, Safari, Microsoft Edge).

### Backend & Environment (Handled by the server and related PHP scripts):
*   **Web Server with PHP**: A web server capable of executing PHP scripts and managing sessions (e.g., Apache with `mod_php`, Nginx with PHP-FPM, or PHP's built-in development server).
*   **PHP Session Support**: PHP sessions must be correctly configured and enabled on the server for `$_SESSION` variables to work. `session_start()` must be called at the beginning of scripts that use sessions.
*   **Related PHP Files (NOT INCLUDED WITH `index.php` ITSELF, but essential for functionality)**:
    *   **`zaloguj.php`**: This script is responsible for:
        *   Receiving the `login` and `haslo` via POST.
        *   Authenticating the user (e.g., by checking credentials against a database or other user store).
        *   Setting `$_SESSION['zalogowany'] = true;` and other session variables (like username) upon successful login.
        *   Setting `$_SESSION['blad']` with an error message upon failed login.
        *   Redirecting to `gra.php` (on success) or back to `index.php` (on failure).
    *   **`gra.php`**: The main game page that users are redirected to after a successful login. This page would typically also check `$_SESSION['zalogowany']` to ensure only authenticated users can access it.

## ⚙️ Local Setup & Viewing

1.  **Clone or Download the Repository/Files**:
    ```bash
    git clone <repository-url>
    cd <repository-directory>
    ```
    *(Replace `<repository-url>` and `<repository-directory>` if applicable, or simply download/create `index.php`, `zaloguj.php`, and `gra.php` in a local folder).*

2.  **Ensure Related PHP Files are Present**:
    *   Place `index.php`, `zaloguj.php`, and `gra.php` in the same directory or ensure paths are correctly referenced (e.g., in form actions or redirects).

3.  **Set Up Backend Logic**:
    *   Implement the authentication logic within `zaloguj.php` (e.g., database connection, user lookup, password verification).
    *   Develop the content and logic for `gra.php`.

4.  **Host on a PHP-Enabled Web Server**:
    *   Place the project files in your web server's document root (e.g., `htdocs` for XAMPP/Apache).
    *   Access `index.php` through your web browser via the server (e.g., `http://localhost/your-folder/index.php`).
    *   Alternatively, for quick testing, navigate to the directory in your terminal and run PHP's built-in server:
        ```bash
        php -S localhost:8000
        ```
        Then access `http://localhost:8000` (or `http://localhost:8000/index.php`) in your browser.

## 💡 Page Usage & Interaction

1.  Open `index.php` in your web browser (served via a PHP-enabled web server).
2.  **Initial Check**:
    *   If you are already logged in (i.e., `$_SESSION['zalogowany']` is true), you will be automatically redirected to `gra.php`.
3.  **Interface (if not logged in)**:
    *   The Plato quote will be displayed at the top.
    *   A login form will be visible with fields for "Login:" (username) and "Hasło:" (password).
    *   A submit button labeled "Zaloguj sie".
    *   If a previous login attempt failed, an error message from `$_SESSION['blad']` will be shown below the form.
4.  **Actions**:
    *   Enter your username in the "Login" field.
    *   Enter your password in the "Hasło" field.
    *   Click the "Zaloguj sie" button.
5.  **Submission & Backend Processing**:
    *   The form data is sent to `zaloguj.php`.
    *   `zaloguj.php` attempts to authenticate the user.
        *   **Success**: `zaloguj.php` sets `$_SESSION['zalogowany'] = true;` and redirects to `gra.php`.
        *   **Failure**: `zaloguj.php` sets `$_SESSION['blad']` with an error message and redirects back to `index.php`, where the error will be displayed.
    *   No client-side validation is performed on `index.php`; all validation and authentication logic resides in `zaloguj.php`.

## 🗂️ File Structure (Expected)

For this login system component:

*   `index.php`: The PHP file containing the login page HTML, session check, form, and error display logic.
*   `zaloguj.php`: (**External but required**) The backend PHP script that handles user authentication.
*   `gra.php`: (**External but required**) The main PHP page for the game, accessible after successful login.
*   `README.md`: This documentation file.

## 📝 Important Notes & Considerations

*   **Polish Language**: The primary language of the user interface is Polish (`lang="pl"`).
*   **Session Management**: Correct PHP session configuration on the server is vital. `session_start();` must be called at the very beginning of `index.php`, `zaloguj.php`, and `gra.php` (any script that accesses `$_SESSION` variables).
*   **Security - Input Validation & Authentication**:
    *   `index.php` performs no client-side validation.
    *   It is **critically important** that `zaloguj.php` performs robust server-side validation of all inputs and uses secure methods for password storage (e.g., `password_hash()` and `password_verify()`) and user authentication to prevent vulnerabilities like SQL injection, XSS, and brute-force attacks.
*   **Error Message Handling (`$_SESSION['blad']`)**: Ensure that `$_SESSION['blad']` is `unset()` or cleared after it has been displayed on `index.php` to prevent the same error message from showing up on subsequent, unrelated visits to the login page.
*   **Styling (CSS)**: No external CSS is used. The page will have a very basic appearance. Adding CSS would significantly improve the user experience.
*   **Database Connections (in `zaloguj.php`)**: The note about `zaloguj.php` needing to close database connections (especially if `exit()` or `die()` is used) is important for resource management, although modern PHP and PDO often handle connection cleanup reasonably well on script termination.
*   **Complexity Note**: The comment "temat jest na tyle złożony, że warto do niego wrócić" (the topic is complex enough that it's worth revisiting) suggests the author recognizes the depth involved in secure authentication and session management.

## 🤝 Contributing

Contributions to the **Osadnicy Login Page** or the broader game project are welcome! If you have ideas for:

*   Adding client-side validation to `index.php`.
*   Improving the styling with CSS.
*   Enhancing the security of `zaloguj.php` (though this is external to `index.php`).
*   Better error handling and user feedback mechanisms.

1.  Fork the repository.
2.  Create a new branch for your feature (`git checkout -b feature/LoginEnhancements`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Feature: Add client-side validation to login'`).
5.  Push to the branch (`git push origin feature/LoginEnhancements`).
6.  Open a Pull Request.

## 📃 License

This project is licensed under the **MIT License**.
(If you have a `LICENSE` file in your repository, refer to it: `See the LICENSE file for details.`)

## 📧 Contact

Project developed by **Adrian Lesniak**.
For questions or feedback, please open an issue on the GitHub repository or contact the repository owner.

---
🎮 _Securing the gates to the world of Osadnicy!_
