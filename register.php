<?php  
session_start();

include "include/meta.html";
include "include/header.html";
include "func.php";
include "include/register.html";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <script src="registration.js"></script>
</head>
<body>
<?php  
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['vorname'], $_POST['nachname'], $_POST['status'], $_POST['passwort'])) {
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $passwort = $_POST['passwort'];
            $status = $_POST['status'];

            if (isset($_SESSION['confirm']) && $_SESSION['confirm'] === true && $_SESSION['vorname'] === $vorname && $_SESSION['nachname'] === $nachname) {
                $_SESSION['confirm'] = false;
                addUser($pdo, $vorname, $nachname, $status, $passwort);
                unset($_SESSION['vorname'], $_SESSION['nachname'], $_SESSION['status'], $_SESSION['passwort']);
            } else {
                $usercheck = $pdo->prepare("SELECT * FROM personal WHERE vorname = ? AND nachname = ?");
                $usercheck->execute([$vorname, $nachname]);
                $existingUser = $usercheck->fetch();

                if ($existingUser) {
                    $_SESSION['vorname'] = $vorname;
                    $_SESSION['nachname'] = $nachname;
                    $_SESSION['passwort'] = $passwort;
                    $_SESSION['status'] = $status;
                    $_SESSION['confirm'] = true;
                    
                    echo "<script>confirmRegistration();</script>";
                    exit;
                } else {
                    addUser($pdo, $vorname, $nachname, $status, $passwort);
                }
            }
        } else {
            echo "Bitte füllen Sie alle erforderlichen Felder aus.";
        }
    } catch (PDOException $e) {
        echo "Fehler bei der Registrierung: " . $e->getMessage();
    }
}
?>
</body>
</html>

<?php
include "include/footer.html";
?>
