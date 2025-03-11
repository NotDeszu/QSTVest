# Firebase to MariaDB Data Saving System

This system allows you to save data from a Firebase Realtime Database to a MariaDB database table.

## Features

- Manual data saving through a button on the graph page
- Automatic data saving through cron jobs
- Error logging for troubleshooting
- Support for different Firebase paths

## Files

- `graficaChalecos.html` - The page displaying the Firebase data graph with a save button
- `addFiredata.php` - The PHP script that fetches data from Firebase and saves it to MariaDB

## How to Use

### Manual Saving

1. Navigate to the graph page
2. View the real-time data from Firebase
3. Click the "Guardar datos en la base de datos" button to save the current data to MariaDB

### Automatic Saving (Cron Job)

To set up automatic saving, create a cron job that calls the `addFiredata.php` script with the `cron=1` parameter:

```
# Example cron job to save data every 15 minutes
*/15 * * * * /usr/bin/php /path/to/your/htdocs/Sitio\ Web/Front/ogani/addFIredata.php?cron=1
```

Or using curl:

```
*/15 * * * * curl "http://your-website.com/Front/ogani/addFIredata.php?cron=1"
```

### Custom Firebase Path

You can specify a custom Firebase path by adding the `path` parameter:

```
http://your-website.com/Front/ogani/addFIredata.php?path=your/firebase/path
```

## Database Structure

<!-- The script creates a table called `firebasedb` with the following structure:

```sql
CREATE TABLE IF NOT EXISTS firebasedb (
    id INT AUTO_INCREMENT PRIMARY KEY,
     FLOAT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
``` -->

## Troubleshooting

If you encounter any issues, check the `firebase_log.txt` file in the same directory as the `addFiredata.php` script for error messages. 