## Production

You can try here: [https://furniture-shop.up.railway.app/](https://furniture-shop.up.railway.app/)

## Getting Started

### Step 1

1. Install Composer
2. Install Xampp (PHP version >= 8.2.0)

### Step 2

1. **Clone the repository:**

    ```bash
    git clone https://github.com/lequanphat/furniture_shop.git
    ```

2. **Change to the project directory:**

    ```bash
    cd furniture_shop
    ```

3. **Install Composer dependencies:**

    ```bash
    composer install
    ```

4. **Create database:**

    Create MySQL Database with name: furniture_shop

### Step 3

1. **Run database migrations:**

    ```bash
    php artisan migrate
    ```

2. **Run database seeders:**

    ```bash
    php artisan db:seed
    ```

3. **Link storage directory to public:**

    ```bash
    php artisan storage:link
    ```

4. **Run the application:**

    ```bash
    php artisan serve
    ```

Navigate to the specified URL in your browser to access the application.
