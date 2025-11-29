<?php
include "functions.php";

ini_set("display_errors", 1);
$books = [
    ['title' => 'Dune', 'author' => 'Frank Herbert', 'genre' => 'Science Fiction', 'price' => 29.99],
    ['title' => 'Norwegian Wood', 'author' => 'Haruki Murakami', 'genre' => 'Literary Fiction', 'price' => 19.50],
    ['title' => 'Foundation', 'author' => 'Isaac Asimov', 'genre' => 'Science Fiction', 'price' => 24.00],
    ['title'=> 'Biology', 'author' => 'Unknown', 'genre' => 'Science', 'price'=> 15.00],
];


// Form processing (addition)
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title']  ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre  = trim($_POST['genre']  ?? '');
    $price  = $_POST['price'] ?? '';

    // validation
    if ($title === '' || $author === '' || $genre === '' || $price === '') {
        $errors[] = 'All fields are required.';
    }
    if (!is_numeric($price) || (float)$price < 0) {
        $errors[] = 'Price must be a non-negative number.';
    }

    if (!$errors) {
        $books[] = [
            'title'  => $title,
            'author' => $author,
            'genre'  => $genre,
            'price'  => round((float)$price, 2),
        ];

        // logging
        $ip  = $_SERVER['REMOTE_ADDR']     ?? '-';
        $ua  = $_SERVER['HTTP_USER_AGENT'] ?? '-';
        $ts  = date('Y-m-d H:i:s');
        $log = sprintf("[%s] IP: %s | UA: %s | Added book: \"%s\" (%s, %.2f)\n",
            $ts, $ip, $ua, $title, $genre, (float)$price
        );
        file_put_contents(__DIR__ . '/bookstore_log.txt', $log, FILE_APPEND | LOCK_EX);
    }
}



$discounts = [
    'Science Fiction' => 0.10, // 10%
    'Fantasy'         => 0.05, // 5%
];

// Total
$total = 0.0;
foreach ($books as $b) {
    $genre = $b['genre'] ?? '';
    $price = (float)($b['price'] ?? 0);
    $rate  = $discounts[$genre] ?? 0.0;
    $total += round($price * (1.0 - $rate), 2);
}

// Output
$now = date('Y-m-d H:i:s');
$ip  = $_SERVER['REMOTE_ADDR']     ?? '-';
$ua  = $_SERVER['HTTP_USER_AGENT'] ?? '-';



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($htmlContent["title"]); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
if ($errors) {
    echo '<ul style="color:red;">';
    foreach ($errors as $e) echo '<li>' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</li>';
    echo '</ul>';
}

echo makeFormHtml();
echo '<h2>Inventory</h2>';
echo makeListHtml($books);
echo '<p><strong>Total price after discounts:</strong> $' . number_format($total, 2) . '</p>';

echo '<h3>Request Info</h3>';
echo '<p>Request time: ' . htmlspecialchars($now, ENT_QUOTES, 'UTF-8') . '<br>';
echo 'IP: ' . htmlspecialchars($ip, ENT_QUOTES, 'UTF-8') . '<br>';
echo 'User agent: ' . htmlspecialchars($ua, ENT_QUOTES, 'UTF-8') . '</p>';

echo '<h3>Log Viewer</h3>';
echo logViewerHtml();
?>

</body>
</html>