# 💍 Bangle Bangari – Online Bangle Store

A mobile-first bangle e-commerce store built with **CodeIgniter 3**, **Bootstrap 5**, and **MySQL**.

---

## 📁 Project Structure

```
bangle_bangari/
├── application/
│   ├── config/
│   │   ├── config.php          ← Set base_url here
│   │   ├── database.php        ← Set DB credentials here
│   │   ├── routes.php
│   │   └── autoload.php
│   ├── controllers/
│   │   ├── Shop.php            ← Public shop (home, product, cart, checkout)
│   │   └── Admin.php           ← Admin panel (login, bangles, orders, categories)
│   ├── models/
│   │   ├── Bangle_model.php
│   │   ├── Category_model.php
│   │   ├── Order_model.php
│   │   └── Admin_model.php
│   └── views/
│       ├── layouts/            ← header.php, footer.php
│       ├── shop/               ← home, product, cart, checkout, order_success
│       └── admin/              ← login, dashboard, bangles, bangle_form, orders, categories
├── assets/
│   └── uploads/bangles/        ← product images uploaded here (auto-created)
├── sql/
│   └── bangle_bangari.sql        ← Run this first!
├── .htaccess
└── README.md
```

---

## 🚀 Setup Steps

### 1. Install CodeIgniter 3

Download CodeIgniter 3.x from https://codeigniter.com/download  
Extract it and copy **all its files** into the `bangle_bangari/` folder.  
Your folder should then contain: `application/`, `system/`, `index.php`, etc.

> The files in this project go into the `application/` folder and root — they **replace/merge** with the CodeIgniter defaults.

### 2. Create the Database

Open phpMyAdmin or MySQL CLI and run:

```sql
-- From the sql/ folder:
SOURCE /path/to/bangle_bangari/sql/bangle_bangari.sql;
```

### 3. Configure Database

Edit `application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'your_mysql_username',
'password' => 'your_mysql_password',
'database' => 'bangle_bangari',
```

### 4. Set Base URL

Edit `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/bangle_bangari/';
// or for a domain: 'https://yourdomain.com/'
```

### 5. Enable mod_rewrite (Apache)

Make sure `mod_rewrite` is enabled in Apache.  
The `.htaccess` file handles clean URLs automatically.

If clean URLs don't work, in `config.php` set:
```php
$config['index_page'] = 'index.php';
```

### 6. Uploads Folder Permissions

```bash
chmod 755 assets/uploads/bangles/
```

### 7. Visit the Store

| URL | What |
|-----|------|
| `http://localhost/bangle_bangari/` | Shop homepage |
| `http://localhost/bangle_bangari/admin/login` | Admin login |

**Default admin credentials:**
- Email: `admin@banglestore.com`
- Password: `password`

> ⚠️ Change the password after first login!  
> Generate hash: `password_hash('your_new_password', PASSWORD_DEFAULT)`  
> Update in the `admin_users` table.

---

## ✨ Features

### Shop (Customer Side)
- 📱 Mobile-first responsive design
- 🏠 Homepage with featured bangles and category filters
- 💍 Product detail pages with images, specs, stock status
- 🛒 Cart with quantity updates and remove
- 📦 Checkout with delivery details form
- ✅ Order confirmation page

### Admin Panel
- 🔐 Secure login with password hashing
- 📊 Dashboard with stats (products, orders, revenue, low stock alerts)
- ➕ Add / Edit / Delete bangles with image upload
- ⭐ Mark as featured, toggle live/hidden
- 🏷️ Manage categories
- 📋 View and manage orders, update order status

---

## 🎨 Design

- **Color palette:** Deep rose `#b5206e`, petal pink, gold accent
- **Typography:** Playfair Display (headings) + Nunito (body)
- **Mobile-first:** Optimized for phone shoppers (2-column product grid on mobile)

---

## 📝 Notes

- No payment gateway is integrated — orders use COD/UPI/Bank Transfer with manual confirmation
- To add a payment gateway (Razorpay, PayU), integrate in `Shop::checkout()` before `Order_model::create()`
- Images are stored as files in `assets/uploads/bangles/`
