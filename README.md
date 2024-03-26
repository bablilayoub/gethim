# Get him - A simple short link platform with tracking

## Screenshots
![screenshot](/public/screenshot.png)

## Description
This is a simple short link platform with tracking. It allows you to create short links that redirect to a specified URL. You can also track the number of clicks on each link, as well as the location of the users who clicked on the link.

## Features
- Lightweight
- Easy to use
- Fast
- Secure
- Customizable
- Responsive
- Tracking
- Location

## Installation & Setup
You are going to need to have [PHP](https://www.php.net/) 8.0 or higher installed on your machine.

1. Clone the repository
```bash
git clone https://github.com/bablilayoub/gethim
```

2. Install the dependencies
```bash
composer install
```

3. Create a new database
```bash
mysql -u root -p
```
```sql
CREATE DATABASE shortlink;
```

4. Create a new `.env` file
```bash
cp .env.example .env
```

5. Update the `.env` file with your database credentials
```bash
APP_URL=http://localhost:8000
DEFAULT_DOMAIN_FOR_LINKS=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=shortlink
DB_USERNAME=
DB_PASSWORD=
```

6. Run the migrations
```bash
php artisan migrate
```

7. Start the server
```bash
php artisan serve
```

8. Open your browser and navigate to `http://localhost:8000`
9. You can now create short links and track the number of clicks on each link.
10. Enjoy!


## Usage
It is very easy to use the short link platform. You can create a new short link by entering the URL you want to shorten and clicking the "Shorten" button. You can then copy the short link and share it with others. You can also track the number of clicks on each link by going to the "Manage Links" page.


## Acknowledgments
I would like to thank the creators of the [Laravel](https://laravel.com/) framework for making it easy to create web applications.

also, I would like to thank the creators of tailwindcss & daisyui for making it easy to create a beautiful and responsive web page.

## Contributing
If you would like to contribute to this project, please feel free to submit a pull request. I would be happy to review it and merge it into the project.

## Support
If you have any questions or need help with the web server, please feel free to contact me. I would be happy to help you.

## Project Status
This project is currently in the beta stage. I am still working on adding new features and fixing bugs. If you have any suggestions or feedback, please feel free to let me know.

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Author
This project was created by Ayoub Bablil - you can find me on [GitHub](https://github.com/bablilayoub).
