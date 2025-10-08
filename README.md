# CodeIgniter4 Starter Kit

A modular and maintainable starter kit built with CodeIgniter 4 and PHP 8.1+. Designed for real-world projects, mentoring workflows, and scalable system development.

## ✨ Features

- ✅ CodeIgniter 4.x with PHP 8.1+
- 🔐 Shield authentication: login, logout, registration, and page protection
- ⚙️ CI4 Settings module for dynamic configuration
- 🌍 GeoIP2 integration for location detection
- 🎨 AdminLTE 3.2 dashboard template
- 📄 Preconfigured pages:
  - Auth: login, magic link form, magic link massage 
  - User: profile, user list, user login
  - Setting: general, cache, optimization

## 🧱 Modular Structure

This starter kit is built for clarity and extensibility:
- Active device session (laravel jetstream inspiration)
- Modular helpers for device, brand, and model parsing
- Cache-aware configuration separating DB and cache logic
- Maintainable frontend with AJAX workflows and script loader
- Region-aware logic for multi-location systems

## 📦 Dependencies

- codeigniter4/framework
- codeigniter4/settings
- codeigniter4/shield
- geoip2/geoip2

## 🚀 Getting Started

1. Clone the repository:
```bash
git clone https://github.com/amdnet/codeigniter4-starter-kit.git
cd codeigniter4-starter-kit
```

2. Install dependencies:
```bash
composer install
```

Set up .env and configure your database
```bash
php spark serve
```

## 🤝 Contributions & Sponsorship
This project welcomes contributions and sponsorship. If you're interested in:
- Adding new features.
- Improving structure or documentation.
- Supporting long-term development.
Feel free to open an issue or submit a pull request. Sponsorships are appreciated to support community mentoring and development.

## 📚 Documentation & Learning
Documentation is being expanded to help maintainers and interns understand:
- Practical applications of DRY, SRP, and SoC.
- Auditing and refactoring modules.
- Edge case simulation and benchmarking.

## 📄 License
This project is licensed under the MIT License.