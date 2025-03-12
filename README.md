# WeIntegral Website

## Installation Instructions

1. Clone the repository:
   git clone https://github.com/your-org/your-repo.git

2. Navigate to the project directory:
   cd your-repo

3. Install dependencies:
   composer install  # For Laravel projects
   npm install       # If using frontend dependencies

4. Set up environment variables:
    cp .env.example .env
    php artisan key:generate

5. Run database migrations:
   php artisan migrate --seed

6. Start the development server:
   php artisan serve
