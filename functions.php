<?php
// bookstore/functions.php

// Generate HTML form for adding a new book
function makeFormHtml(): string {
    $form = "<form action='' method='post'>";
    $form .= "<div class='form-group'><label for='title'>Title:</label>";
    $form .= "<input type='text' id='title' name='title' required></div>";
    $form .= "<br><br>";
    $form .= "<div class='form-group'><label for='author'>Author:</label>";
    $form .= "<input type='text' id='author' name='author' required></div>";
    $form .= "<br><br>";
    $form .= "<div class='form-group'><label for='genre'>Genre:</label>";
    $form .= "<input type='text' id='genre' name='genre' required></div>";
    $form .= "<br><br>";
    $form .= "<div class='form-group'><label for='price'>Price:</label>";
    $form .= "<input type='number' step='0.01' min='0' id='price' name='price' required></div>";
    $form .= "<br><br>";
    $form .= "<input type='submit' value='Submit'>";
    $form .= "</form>";
    return $form;
}

// Generate HTML table for book list
function makeListHtml(array|null $data): string {
    if (empty($data)) {
        return "<p>No books available.</p>";
    }
    $table = "<table class=inventory-table>";
    $table .= "<thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Price</th>
        </tr>
    </thead>";
    $table .= "<tbody>";
    foreach ($data as $value) {
        $table .= "<tr>
            <td>{$value['title']}</td>
            <td>{$value['author']}</td>
            <td>{$value['genre']}</td>
            <td>\${$value['price']}</td>
        </tr>";
    }
    $table .= "</tbody></table>";
    return $table;
}

function logViewerHtml(): string {
    $content = "";
    $logFile = __DIR__ . '/bookstore_log.txt';
    if (is_readable($logFile)) {
        $logContent = file_get_contents($logFile);
        if ($logContent === false || $logContent === '') {
            $content .= '<p class="info">Log is empty.</p>';
        } else {
            $content .= '<pre class="info" style="white-space:pre-wrap;">' . htmlspecialchars($logContent, ENT_QUOTES, 'UTF-8') . '</pre>';
        }
    } else {
        $content .= '<p class="info">Log file not found or not readable. Please create bookstore_log.txt and ensure read permissions.</p>';
    }
    return $content;
}