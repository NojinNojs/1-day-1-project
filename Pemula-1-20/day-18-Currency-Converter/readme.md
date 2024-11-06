# 💱 Currency Converter

Welcome to the **Currency Converter**! This sleek and user-friendly application, built with PHP and Bootstrap, allows you to effortlessly convert between multiple currencies using real-time exchange rates.

## ✨ Features

- 🔄 **Real-time Currency Conversion**: Get the latest exchange rates at your fingertips.
- 💾 **Efficient Caching System**: Minimize API usage with smart caching.
- 🌐 **Multi-Currency Support**: Convert between a wide range of currencies.
- 📊 **Common Conversions Display**: Quickly view popular currency conversions.
- 🎨 **Responsive Design**: Enjoy a seamless experience on any device with Bootstrap.

## 🚀 Quick Start

1. **Install Dependencies**:

   ```bash
   composer install
   ```

2. **Create a `.env` File**: In the root directory, add your API key:

   ```plaintext
   EXCHANGE_RATE_API_KEY=your_api_key_here
   ```

3. **Start Your Local Server**: Use PHP's built-in server:

   ```bash
   php -S localhost:8000
   ```

4. **Visit the Application**: Open your browser and go to `http://localhost:8000`.

## 🛠️ Technologies Used

- **PHP 7.4+**
- **Bootstrap 5**
- **[ExchangeRates API](https://exchangeratesapi.io/)**
- **Composer** for dependency management

## 📁 Project Structur

```bash
currency-converter/
├── assets/
│   └── css/
│       └── style.css
├── cache/
├── includes/
│   ├── api.php
│   ├── config.php
│   └── functions.php
├── vendor/
├── .env
├── .gitignore
├── composer.json
├── index.php
└── README.md
```

## 🔧 Configuration

The application uses a `.env` file for configuration. Make sure to set your API key:

```bash
EXCHANGE_RATE_API_KEY=your_api_key_here
```

## 🔄 Caching

Exchange rates are cached for 12 hours to minimize API calls. You can adjust the cache duration in `config.php`.

⭐️ Star this repo if you find it useful!
