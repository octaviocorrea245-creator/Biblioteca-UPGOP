<?php
\ = new mysqli('127.0.0.1', 'root', '', 'mysql');

if (\->connect_error) {
    echo 'Connection error: ' . \->connect_error;
    exit;
}

\ = "CREATE USER IF NOT EXISTS 'biblioteca'@'127.0.0.1' IDENTIFIED BY 'Biblioteca2024!';
CREATE USER IF NOT EXISTS 'biblioteca'@'localhost' IDENTIFIED BY 'Biblioteca2024!';
GRANT ALL PRIVILEGES ON \iblioteca_upgop\.* TO 'biblioteca'@'127.0.0.1';
GRANT ALL PRIVILEGES ON \iblioteca_upgop\.* TO 'biblioteca'@'localhost';
FLUSH PRIVILEGES;";

if (\->multi_query(\)) {
    echo 'Users created successfully';
    while (\->next_result()) {}
} else {
    echo 'Error: ' . \->error;
}

\->close();
?>
