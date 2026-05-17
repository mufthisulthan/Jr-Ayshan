# JR Marketing â€” Prototype Website
## Laravel + Livewire Setup

This project has been converted into a Laravel + Livewire application while keeping the original HTML files as reference.

1. Start Apache and MySQL in XAMPP.
2. Create the database if it does not exist:
   ```bash
   C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS jr_ayshan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```
3. Install PHP dependencies:
   ```bash
   composer install
   ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Serve locally:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```
6. Open `http://127.0.0.1:8000`.

**POS, ERP, Stock Management & Invoicing Application**  
Sri Lanka | JR Marketing

---

## ðŸ“ Project Structure

```
Jr-Marketing-Prototype/
â”‚
â”œâ”€â”€ index.html               â† Login Page (main entry)
â”œâ”€â”€ dashboard.html           â† Dashboard (post-login)
â”œâ”€â”€ forgot-password.html     â† Forgot Password page
â”‚
â”œâ”€â”€ components/              â† Reusable HTML components
â”‚   â”œâ”€â”€ login-logo.html      â† Logo + tagline block
â”‚   â”œâ”€â”€ login-form.html      â† Login form markup
â”‚   â””â”€â”€ login-footer.html    â† Copyright footer
â”‚
â””â”€â”€ assets/
    â”œâ”€â”€ css/
    â”‚   â”œâ”€â”€ variables.css    â† CSS custom properties / design tokens
    â”‚   â”œâ”€â”€ base.css         â† Reset + utility classes
    â”‚   â”œâ”€â”€ components.css   â† Buttons, inputs, cards, alerts, badges
    â”‚   â””â”€â”€ login.css        â† Login page-specific styles
    â”‚
    â””â”€â”€ js/
        â”œâ”€â”€ utils.js         â† General utilities (date, currency LKR, storage)
        â”œâ”€â”€ auth.js          â† Auth module (login, session, guard)
        â”œâ”€â”€ toast.js         â† Toast notification component
        â”œâ”€â”€ component-loader.js â† Loads HTML components dynamically
        â””â”€â”€ login.js         â† Login page controller
```

---

## ðŸš€ How to Run

> **Important:** Because components are loaded via `fetch()`, you need a local HTTP server.

### Option 1 â€” VS Code Live Server (recommended)
1. Install the **Live Server** extension in VS Code.
2. Right-click `index.html` â†’ **Open with Live Server**.

### Option 2 â€” Python
```bash
python -m http.server 5500
```
Then open `http://localhost:5500`

### Option 3 â€” Node.js
```bash
npx serve .
```

---

## ðŸ”‘ Demo Login Credentials

| Username  | Password    | Role          |
|-----------|-------------|---------------|
| admin     | admin123    | Administrator |
| manager   | manager123  | Manager       |
| cashier   | cashier123  | Cashier       |
| demo      | demo        | Demo User     |

---

## ðŸ§© Component System

Components live in `/components/` as standalone HTML fragments.  
They are loaded dynamically by `ComponentLoader.load()`:

```js
ComponentLoader.load('#target-selector', 'components/my-component.html', callback);
```

This keeps pages clean and components reusable across the site.

---

## ðŸŽ¨ Design System

All colors, fonts, spacing, and radii are defined as CSS variables in `variables.css`.  
Modify them once to update the entire site's appearance.

---

## ðŸ‡±ðŸ‡° Sri Lanka Localisation

- Currency formatted as **LKR (Rs.)** via `Utils.formatCurrency()`
- Date formatted in `en-LK` locale via `Utils.formatDate()`
- Phone validation for Sri Lanka numbers: `Utils.isValidSLPhone()`

---

*JR Marketing â€” V6.3 | Â© 2025 JR Marketing*

