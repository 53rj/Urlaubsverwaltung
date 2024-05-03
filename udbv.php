<?php
include "include/meta.html";
include "include/header.html";
include "function.php";
include "func.php";

$pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableChoice = $_GET['table'] ?? 1;  
$users = showAllData($pdo, $tableChoice);

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Benutzerdaten anzeigen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Registrierte Benutzer:</h1>

    <?php if (!empty($users)): ?>
    <table border='1'>
        <tr><th>Vorname</th><th>Nachname</th><th>Status</th></tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['vorname']); ?></td>
                <td><?= htmlspecialchars($user['nachname']); ?></td>
                <td><?= htmlspecialchars($user['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>Keine Daten gefunden.</p>
    <?php endif; ?>
</body>
</html>

<?php
include "include/footer.html";
?>
