# Osadnicy - Browser Game Login Page

## Overview
Osadnicy is a PHP-based browser game login page. It checks if a user is logged in via session (`zalogowany`) and redirects to `gra.php` if true. Features a simple login form and displays error messages from `zaloguj.php`. Includes a Plato quote and minimal styling.

## Features
- **Session Check**: Redirects to `gra.php` if `$_SESSION['zalogowany']` is set and true.
- **Login Form**: Submits `login` and `haslo` (password) to `zaloguj.php` via POST.
- **Error Handling**: Displays login error messages stored in `$_SESSION['blad']`.
- **Quote**: Features a Plato quote: "Tylko martwi ujrzeli koniec wojny."
- **Minimal Styling**: Basic HTML with no external CSS.

## Requirements
- Web server with PHP (e.g., Apache with PHP module)
- Browser (e.g., Chrome, Firefox)
- PHP session support enabled
- Related files:
  - `zaloguj.php`: Handles login authentication
  - `gra.php`: Main game page (post-login)
- No local assets required

## Setup
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```
2. Ensure related files are in place:
   - `zaloguj.php`: Script to process login form.
   - `gra.php`: Game page for logged-in users.
3. Host the site on a PHP-enabled web server:
   ```bash
   php -S localhost:8000
   ```
   Or configure Apache/Nginx to serve the directory.
4. Access the page at `http://localhost:8000`.

## Usage
1. Open the page in a browser to view the login form.
2. **Interface**:
   - **Quote**: Displays Plato’s quote at the top.
   - **Form**: Enter login and password, then click "Zaloguj sie" to submit to `zaloguj.php`.
   - **Error Message**: Shows error (if any) from `$_SESSION['blad']` below the form.
3. **Actions**:
   - If already logged in, redirects to `gra.php`.
   - Submit valid credentials to log in; invalid credentials display an error.
   - No validation on the client side; relies on `zaloguj.php`.

## File Structure
- `index.php`: Login page with session check and form.
- `zaloguj.php`: Authentication script (not included).
- `gra.php`: Game page (not included).
- `README.md`: This file, providing project documentation.

## Notes
- The page uses Polish (`lang="pl"`) for content (e.g., "Zaloguj sie").
- Session management requires `session_start()` and a configured PHP environment.
- No input validation; add checks in `zaloguj.php` to prevent security issues.
- The `$_SESSION['blad']` error is only shown if set; unset after display to avoid persistence.
- No CSS; consider adding styles for better UX.
- Ensure `zaloguj.php` closes database connections after processing to avoid issues with `exit()`.
- The commented note suggests the topic is complex and worth revisiting.

## Contributing
Contributions are welcome! To contribute:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make changes and commit (`git commit -m "Add feature"`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact
For questions or feedback, open an issue on GitHub or contact the repository owner.