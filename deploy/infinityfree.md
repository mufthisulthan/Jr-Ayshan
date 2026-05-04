InfinityFree Deployment Checklist

Prerequisites
- FTP or File Manager access to your InfinityFree account
- MySQL database credentials (see `database/jrmarketinginferinityfree.md`)
- PHP 8.0+ recommended

Steps
1. Export/import database
   - Export `database/schema.sql` (or use the SQL provided in repo) and import via phpMyAdmin into the new database (hostname: `sql113.infinityfree.com`).

2. Create database & user
   - Use InfinityFree control panel to create/confirm the database and credentials.
   - Note host, username, password and database name (update `config/database.php` accordingly).

3. Update `config/database.php`
   - Edit the file and set the connection values (example):

```php
return [
    'host' => 'sql113.infinityfree.com',
    'user' => 'if0_41824262',
    'pass' => 'rRlvYeMKMQmqO',
    'db'   => 'if0_41824262_jrmarketing'
];
```

4. Upload files
   - Upload all repo files to the `htdocs/` directory (root) of the site using FTP or the File Manager.
   - Ensure `index.php` is at the web root.

5. PHP settings
   - Set PHP version to 8.0 or 8.1 in the control panel.
   - Enable `mysqli` / `pdo_mysql` if selectable.
   - Avoid `php_value` directives in `.htaccess` if not supported — use control panel settings instead.

6. Place `.htaccess` (see example in `deploy/htaccess-example.txt`)
   - Copy the example into a file named `.htaccess` in the `htdocs/` root.

7. File permissions
   - Directories: `755`
   - Files: `644`
   - Ensure any upload or storage folders (e.g., `includes/storage` or `storage`) are writable by PHP.

8. Protect sensitive files
   - Confirm `.env`, `config/`, `includes/` and other non-public files are blocked by `.htaccess` rules (example included).

9. Test the site
   - Visit your site URL and confirm the login page appears.
   - Try login with seeded/admin credentials or create an admin user via SQL if needed.

Troubleshooting
- Blank pages: enable display_errors temporarily in control panel or check error logs.
- Database connection errors: double-check hostname and credentials.
- 500 errors from `.htaccess`: remove php_value lines and try again.

Notes
- `database/jrmarketinginferinityfree.md` contains the hosting DB credentials you supplied; keep this secure and remove from public repos if needed.
- If InfinityFree limits features (some extensions or cron jobs), consider upgrading or using another shared host for production.
