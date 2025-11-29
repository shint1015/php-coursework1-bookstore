# Coursework 1 – Online Bookstore (Week 1 Final Assignment)

## Short description

A simple PHP bookstore using arrays for inventory, a discount function (10% off Science Fiction), POST form handling with validation, total price calculation, request info (time/IP/UA), and append-only logging to bookstore_log.txt. No database or JSON input is required.

## How to run:

1. Prerequisites: AMPPS (Apache/PHP) on macOS, or PHP 8+ with a web server.
2. Place the project at: /Applications/AMPPS/www/bookstore
3. Initialize the log (first time only):
    - cd /Applications/AMPPS/www/bookstore
    - touch bookstore_log.txt && chmod 664 bookstore_log.txt
4. Start Apache in AMPPS.
5. Open: http://localhost/bookstore/index.php
6. Use the form to add books; Science Fiction gets 10% off and additions are logged.

### Notes:

-   Inventory is in index.php (array; no DB/JSON persistence required).
-   Styling: style.css; Essay: nonrepudiation_essay.txt.
