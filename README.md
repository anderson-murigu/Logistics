# Zenara Group

Modern logistics website for `www.zenaragroup.co.ke`, built for PHP/MySQL hosting on ServerByt.

## Structure

- `index.php` - public company website and enquiry form
- `portal/index.php` - employee portal sign-in for the portal subdomain
- `config.php` - database connection and site settings
- `database/schema.sql` - MySQL tables and starter admin account instructions
- `assets/` - responsive styles and small interaction script

## ServerByt setup

1. Upload the project files into the public web directory for the main domain.
2. Create a MySQL database and import `database/schema.sql` in phpMyAdmin.
3. Update the database values in `config.php`. Keep this file outside public access if ServerByt supports a private directory; otherwise the included `.htaccess` blocks direct access.
4. Point `www.zenaragroup.co.ke` to the public directory.
5. Create a subdomain such as `portal.zenaragroup.co.ke` and point it to the `portal/` directory.
6. Enable HTTPS in the ServerByt control panel before collecting enquiries or using the portal.

The starter portal account should be created with a real password hash. Generate one with:

```bash
php -r "echo password_hash('replace-with-a-strong-password', PASSWORD_DEFAULT), PHP_EOL;"
```

Then insert the resulting hash into the `employees` table. The portal is intentionally small and ready for adding authenticated staff workflows.
