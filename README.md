# Cavendish API

This repository contains the Cavendish API, built using Laravel. The API provides endpoints for managing websites, including registering users, logging in, submitting websites, voting, and more.

## Prerequisites

- PHP 7.4 or higher
- Composer
- Laravel 8.x
- MySQL
- Postman (or any API testing tool)

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/cavendish-api.git
    cd cavendish-api
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Create a copy of your .env file**

    ```bash
    cp .env.example .env
    ```

4. **Generate an application key**

    ```bash
    php artisan key:generate
    ```

5. **Configure your database**

    Edit your `.env` file to match your database configuration:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

6. **Run the database migrations**

    ```bash
    php artisan migrate
    ```

7. **Seed the database**

    ```bash
    php artisan db:seed
    ```

8. **Start the development server**

    ```bash
    php artisan serve
    ```

## API Endpoints

### Register User

- **URL:** `/api/register`
- **Method:** `POST`
- **Body:**
    ```json
    {
      "name": "John Doe",
      "username": "john.doe",
      "email": "john.doe@example.com",
      "password": "securePassword1234"
    }
    ```

### Login

- **URL:** `/api/login`
- **Method:** `POST`
- **Body:**
    ```json
    {
      "email": "john.doe@example.com",
      "password": "securePassword1234"
    }
    ```

### Get All Websites

- **URL:** `/api/websites`
- **Method:** `GET`

### Search Websites

- **URL:** `/api/websites/search`
- **Method:** `POST`
- **Body:**
    ```json
    {
      "term": "weimann.com"
    }
    ```

### Submit Website

- **URL:** `/api/websites`
- **Method:** `POST`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`
- **Body:**
    ```json
    {
      "name": "schneiderss.com",
      "url": "http://www.kshlerin.com/quia-id-voluptas-repudiandae",
      "categories": [1, 3, 4]
    }
    ```

### Logout

- **URL:** `/api/logout`
- **Method:** `POST`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`

### Vote for a Website

- **URL:** `/api/websites/{id}/vote`
- **Method:** `POST`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`
- **Body:**
    ```json
    {
      "user_id": 4
    }
    ```

### Unvote a Website

- **URL:** `/api/websites/{id}/vote`
- **Method:** `DELETE`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`
- **Body:**
    ```json
    {
      "user_id": 11
    }
    ```

### Delete Website

- **URL:** `/api/websites/{id}`
- **Method:** `DELETE`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`

### Make Current User Admin

- **URL:** `/api/make-admin`
- **Method:** `POST`
- **Headers:**
    - `Accept: application/json`
    - `Authorization: Bearer {token}`

## Postman Collection

You can use the Postman collection to test the API endpoints. Follow these steps to import the Postman collection:

1. **Download the Postman collection file from the root folder (thunder-collection_Cavendish.json)**

2. **Open Postman**

3. **Import the collection**

    - Click on the `Import` button in the top-left corner.
    - Select the `Choose Files` tab.
    - Select the downloaded JSON file.

4. **Set environment variables**

    - Set the `base_url` variable to your local development server URL (e.g., `http://127.0.0.1:8000`).
    - Set the `token` variable to the Bearer token you receive after logging in.

## Contributing

If you would like to contribute to this project, please fork the repository and submit a pull request. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
