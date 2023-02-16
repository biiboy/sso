# ORALIT APP

## Installation

1. Clone the repository
    ```bash
    git clone https://github.com/harisfi/oralit-app.git
    ```

2. Use the package manager [composer](https://getcomposer.org/download/) to install vendor.
    ```bash
    composer install
    ```

3. Configure .env files, => copy .env.example and rename it to .env
    ```bash
    cp .env.example .env
    ```

4. Set your database configuration in .env file

5. Generate APP_KEY
    ```bash
    php artisan key:generate
    ```

6. Generate symlink to storage
    ```bash
    php artisan storage:link
    ```

7. Run Laravel server
    ```bash
    php artisan serve
    ```

### Configuring Email Queue Job

1. Run Migration
    ```bash
    php artisan migrate --path=/database/migrations/2022_12_07_020244_create_jobs_table.php
    
    php artisan migrate --path=/database/migrations/2022_12_07_025415_create_failed_jobs_table.php
    ```

2. Run Queue Worker
    ```bash
    php artisan queue:work
    ```
