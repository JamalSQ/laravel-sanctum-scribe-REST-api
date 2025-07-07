Here's an updated version of your README file, formatted properly for GitHub and with the **"Contribution"**, **"Contact"**, and **"your name/email"** sections removed as requested:

````markdown
# Laravel Sanctum RESTful API with Scribe Documentation

This repository contains a **Laravel 12** project that implements a **RESTful API** secured with **Laravel Sanctum** for authentication and uses **Scribe** for automated API documentation generation.

---

## Features

- **RESTful API** endpoints for managing resources (e.g., Companies, Users)
- **Sanctum**-based token authentication for secure API access
- **Scribe**-powered API documentation generated from PHPDoc annotations
- Proper validation and error handling following REST API best practices
- Structured and clear API responses using Laravel Resources
- Detailed API documentation with request parameters, responses, and status codes

---

## Technologies Used

| Technology         | Purpose                                    |
|--------------------|--------------------------------------------|
| Laravel 12         | PHP framework for building the API         |
| Laravel Sanctum    | API token authentication                   |
| Scribe             | Automatic API documentation generator      |
| PHPDoc Annotations | Documenting API endpoints and parameters   |

---

## Getting Started

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/laravel-sanctum-scribe-api.git
   cd laravel-sanctum-scribe-api
````

2. Install dependencies:

   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env` and configure your database and Sanctum settings.

4. Run database migrations:

   ```bash
   php artisan migrate
   ```

5. Generate API documentation:

   ```bash
   php artisan scribe:generate
   ```

6. Serve the application:

   ```bash
   php artisan serve
   ```

7. View the API documentation in your browser:

   ```
   http://localhost:8000/docs
   ```

---

## API Documentation

* API endpoints are documented using **Scribe** annotations in controller PHPDoc blocks.
* Documentation includes:

  * Endpoint descriptions and grouping
  * Request parameters (`@bodyParam`, `@urlParam`)
  * Example responses with proper HTTP status codes
  * Authentication requirements
* The generated documentation is available in Blade/HTML format and viewable while the app is running.

### Exporting Documentation as PDF

* Scribe does not natively support PDF export.
* Alternatives:

  * Use your browser's "Print to PDF" feature (may have formatting issues)
  * Export the OpenAPI spec and convert it using third-party tools like `swagger2pdf` or `RapiPDF`

---

## API Endpoints Overview

### CompanyController

* `GET /companies` - List all companies
* `POST /companies` - Create a new company
* `GET /companies/{company}` - Retrieve a specific company
* `PUT /companies/{company}` - Update a company
* `DELETE /companies/{company}` - Delete a company

### AuthController

* `POST /login` - User login, returns API token
* `POST /register` - User registration

---

## Best Practices Followed

* Proper use of HTTP status codes:

  * `200 OK` – Successful retrieval and updates
  * `201 Created` – Resource creation
  * `422 Unprocessable Entity` – Validation errors
  * `401 Unauthorized` – Authentication failures
  * `404 Not Found` – Missing resources
* Secure password handling with hashing
* Clear and consistent JSON responses
* Use of Laravel Form Requests for validation
* Valid and example-rich JSON responses in documentation

---

## License

This project is open-source and available under the MIT License.

---

*Generated using Laravel Sanctum, Scribe, and industry best practices as of July 2025.*

```

Let me know if you'd like to add badges (e.g., Laravel version, license, or build status) or improve any section further!
```
