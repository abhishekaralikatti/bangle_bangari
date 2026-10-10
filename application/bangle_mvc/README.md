# 💍 Bangle Bangari – MVC Drop-in

Drop these files into your existing CodeIgniter 3 project.

## 📁 What's in this zip

```
controllers/  Shop.php, Admin.php
models/       Bangle_model.php, Category_model.php, Order_model.php, Admin_model.php
views/        layouts/, shop/, admin/
routes.php    → merge into application/config/routes.php
autoload.php  → merge into application/config/autoload.php
bangle_bangari.sql  → run once
```

## 🚀 Drop-in Steps

1. Run `bangle_bangari.sql` in phpMyAdmin / MySQL CLI
2. Copy `controllers/` → `application/controllers/`
3. Copy `models/` → `application/models/`
4. Copy `views/` → `application/views/`
5. Merge routes from `routes.php` into your `application/config/routes.php`
6. Ensure your autoload has: `database, session, form_validation, upload` (libraries) and `url, form, html, file, string, text` (helpers)
7. Create folder: `assets/uploads/bangles/` (chmod 755)

## Admin Login
- URL: `/admin/login`
- Email: `admin@banglestore.com`  Password: `password`
