# Cronjob: Notify Admin on Popular Users

## Overview

This cronjob checks if any user has been liked by **more than 50 people** and sends a notification email to the admin.
It helps the admin monitor highly engaged users.

---

## File Location

The cronjob is defined in:

```text
api/routes/console.php
```

---

## How It Works

1. Queries the database for users with `likes_count > 50`.
2. Sends an email notification to the admin email (`admin@example.com` by default).
3. Can be triggered manually via Artisan command or scheduled via OS cron.

---

## Running the Cronjob

### Manual

Run the command manually:

```bash
cd api
php artisan notify:popular-users
```

### Automatic via OS Cron

Add this line to your server's crontab (adjust path as needed):

```cron
* * * * * cd /path/to/your/project/api && php artisan notify:popular-users >> /dev/null 2>&1
```

* Runs every minute (`* * * * *`) — adjust as needed.
* Logs are discarded (`>> /dev/null 2>&1`) — can change to a log file if needed.

---

## Example Output

```text
Email sent to admin@example.com
Subject: User Popularity Alert
Body: User John Doe has been liked by 53 people
```

---

## Configuration

* **Admin Email**: Set in `.env`:

```env
ADMIN_EMAIL=admin@example.com
```

* **Like Threshold**: Default is 50, can be changed in the command definition in `routes/console.php`.

---

## Testing

Run manually:

```bash
php artisan notify:popular-users
```

Check email inbox or logs (if using `log` mail driver).

---

## Notes

* Configure mail driver in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

* For local development, you can set:

```env
MAIL_MAILER=log
```

to log emails instead of sending.
