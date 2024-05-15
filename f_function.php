<?php

// function val_pw($passwort){
//     $min_len = 8;

//     if (strlen($passwort) < $min_len) {
//         echo "Das Passwort muss mindestens $min_len Zeichen lang sein.";
//     }

//     if (!preg_match("/\d/", $passwort)) {
//         echo "Das Passwort muss mindestens eine Zahl beinhalten.";
//     }

//     if (!preg_match("/[a-z]/", $passwort)) {
//         echo "Das Passwort muss mindestens einen Kleinbuchstaben beinhalten.";
//     }

//     if (!preg_match("/[A-Z]/", $passwort)) {
//         echo "Das Passwort muss mindestens einen Großbuchstaben beinhalten.";
//     }

//     if (!preg_match("/\W/", $passwort)) {
//         echo "Das Passwort muss mindestens ein Sonderzeichen beinhalten.";
//     }

//     return "Das Passwort ist gültig";
// }


function addUser($pdo, $vorname, $nachname, $status, $passwort)
{
    $statement = $pdo->prepare("INSERT INTO personal (vorname, nachname, status, passwort, urlaubstage, resturlaub) VALUES (?, ?, ?, ?, 30, 30)");
    $statement->execute([$vorname, $nachname, $status, $passwort]);
    $pid = $pdo->lastInsertId();
    if ($pid) {
        echo "Registrierung des Users mit der ID: $pid erfolgreich ausgeführt.";
    } else {
        echo "Es gab ein Problem bei der Registrierung des Users.";
    }
}




function connServer()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Verbindung fehlgeschlagen: " . $e->getMessage());
        return null;
    }
}

function showAllData($pdo, $zahl)
{
    try {
        $tableMap = [
            1 => "personal",
            2 => "urlaubsantrag",
            3 => "krankheit"
        ];

        if (array_key_exists($zahl, $tableMap)) {
            $sql = "SELECT * FROM " . $tableMap[$zahl];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    } catch (PDOException $e) {
        error_log("Datenbankfehler: " . $e->getMessage());
        return [];
    }
}

function login()
{

    session_start();
    $pid = $_POST["pid"];
    $passwort = $_POST["passwort"];

    $conn = connServer();
    $_SESSION["status"] = "SELECT personal.status FROM personal WHERE pid = $pid AND passwort = $passwort";

    if ($_SESSION["status"] == "Angestellter") {
        $_SESSION['logged_in'] = true;
        include_once "./angestellterheader.html";
    }

    if ($_SESSION["status"] == "Abteilungsleiter") {
        $_SESSION['logged_in'] = true;
        include_once "./abteilungsleiterheader.html";
    }

    if ($_SESSION["status"] == "Admin") {
        $_SESSION['logged_in'] = true;
        include_once "./adminheader.html";
    }
}

function checkStatus()
{
    if (isset($_SESSION['status'])) {
        switch ($_SESSION['status']) {
            case "Angestellter":
                include_once "./angestellterheader.html";
                break;
            case "Abteilungsleiter":
                include_once "./abteilungsleiterheader.html";
                break;
            case "Admin":
                include_once "./adminheader.html";
                break;
        }
    } else {
        if (!isset($_SESSION['attempted_redirect'])) {
            $_SESSION['attempted_redirect'] = true;
            header("Location: ./login.php");
            exit;
        } else {
            session_unset();
            session_destroy();
            header("Location: ./login.php");
            exit;
        }
    }
}


function nichtVerplanteUrlaubstage()
{
    $pid = $_SESSION['personal_id'];
    $conn = connServer();
    $sql = "SELECT p.resturlaub
            FROM personal p 
            WHERE p.pid = $pid";
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch als assoziatives Array
    $resturlaub = $result['resturlaub']; // Zugriff auf das spezifische Feld
    echo "<p>" . $resturlaub . "</p>";
}

function freigabenUrlaub($wert)
{
    $pid = $_SESSION['personal_id'];
    $conn = connServer();
    $sql = "SELECT u.uanfang, u.uende, u.ubeantragt
            FROM personal p, urlaubsantrag u 
            WHERE p.pid = $pid 
            AND u.pid = p.pid
            AND u.ustatus = '$wert'";
    $genehmigteUrlaube = $conn->query($sql);
    $anzeige = array();
    while ($row = $genehmigteUrlaube->fetch(PDO::FETCH_ASSOC)) {
        $anzeige = $row;
        echo "<tr>";
        foreach ($anzeige as $kommende_urlaube) {
            echo  "<td>" . $kommende_urlaube . "</td>";
        }
        echo "</tr>";
    }
}

function urlaubsantrag($pid, $urlaubsanfang, $urlaubsende)
{
    if ($urlaubsanfang < $urlaubsende) {

        $pdo = connServer();
        $stmt = $pdo->prepare("CREATE TEMPORARY TABLE IF NOT EXISTS TempUrlaub (uanfang DATE, uende DATE, tage INT);
        -- Berechnung und Einfügen der Urlaubstage unter Ausschluss der Wochenenden
        INSERT INTO TempUrlaub (uanfang, uende, tage)
        VALUES (:uanfang, :uende,
                (DATEDIFF(:uende, :uanfang) + 1
                - ((DATEDIFF(:uende, :uanfang) + 1) / 7 * 2)
                + (CASE WHEN WEEKDAY(:uanfang ) = 6 THEN 1 ELSE 0 END)
                + (CASE WHEN WEEKDAY(:uende) = 5 THEN 1 ELSE 0 END)));
        -- Daten von der temporären Tabelle in die Haupttabelle übertragen
        INSERT INTO urlaubsantrag (pid, uanfang, uende, ubeantragt, ugesamt, ustatus)
        SELECT :pid, uanfang, uende, tage, 30, 'beantragt'
        FROM TempUrlaub;
        -- Lösche die temporäre Tabelle nach Gebrauch
        DROP TEMPORARY TABLE IF EXISTS TempUrlaub;");
        $stmt->bindParam(":pid", $pid);
        $stmt->bindParam(":uanfang", $urlaubsanfang);
        $stmt->bindParam(":uende", $urlaubsende);
        $stmt->execute();

        echo "<br>";
        echo "<br>";
        echo "Urlaubsantrag erfolgreich eingetragen!";
    } else {
        echo "<br>";
        echo "<br>";
        echo "Der Urlaubsantrag konnte nicht eingetragen werden.";
    }
}

function krankheitseintrag($pid, $krankheitsanfang, $krankheitsende)
{
    if ($krankheitsanfang < $krankheitsende) {

        $pdo = connServer();
        $stmt = $pdo->prepare("CREATE TEMPORARY TABLE IF NOT EXISTS TempAU (kanfang DATE, kende DATE, tage INT);
        -- Berechnung und Einfügen der Krankheitstage unter Ausschluss der Wochenenden
        INSERT INTO TempAU (kanfang, kende, tage)
        VALUES (:kanfang, :kende,
                (DATEDIFF(:kende, :kanfang) + 1
                - ((DATEDIFF(:kende, :kanfang) + 1) / 7 * 2)
                + (CASE WHEN WEEKDAY(:kanfang ) = 6 THEN 1 ELSE 0 END)
                + (CASE WHEN WEEKDAY(:kende) = 5 THEN 1 ELSE 0 END)));
        -- Daten von der temporären Tabelle in die Haupttabelle übertragen
        INSERT INTO krankheit (pid, kanfang, kende, kgesamt)
        SELECT :pid, kanfang, kende, tage
        FROM TempAU;
        -- Erstattet die Krankheitstage dem Resturlaub wieder gut
        UPDATE personal 
        SET resturlaub = resturlaub + (
        SELECT SUM(DATEDIFF(LEAST(k.kende, u.uende), GREATEST(k.kanfang, u.uanfang)) + 1)
        FROM krankheit k
        JOIN urlaubsantrag u ON k.pid = u.pid
        WHERE k.kanfang <= u.uende
        AND k.kende >= u.uanfang
        AND k.pid = :pid)
        WHERE pid = :pid;
        -- Lösche die temporäre Tabelle nach Gebrauch
        DROP TEMPORARY TABLE IF EXISTS TempAU;");
        $stmt->bindParam(":pid", $pid);
        $stmt->bindParam(":kanfang", $krankheitsanfang);
        $stmt->bindParam(":kende", $krankheitsende);
        $stmt->execute();

        echo "<br>";
        echo "<br>";
        echo "Krankheitsantrag erfolgreich eingetragen!";
    } else {
        echo "<br>";
        echo "<br>";
        echo "Der Krankheitseintrag konnte nicht eingetragen werden.";
    }
}

function urlaubsgenehmigung($pid, $uid)
{
    $pdo = connServer();
    $stmt1 = $pdo->prepare(
        "UPDATE urlaubsantrag SET ustatus = 'genehmigt' WHERE uid = :uid;
        UPDATE personal SET resturlaub = resturlaub - (SELECT ubeantragt FROM urlaubsantrag WHERE pid = :pid AND uid = :uid) 
        WHERE pid = :pid"
    );
    $stmt1->bindParam(":pid", $pid);
    $stmt1->bindParam(":uid", $uid);
    $stmt1->execute();
}
function urlaubsablehnung($uid)
{
    $pdo = connServer();
    $stmt1 = $pdo->prepare("UPDATE urlaubsantrag SET ustatus = 'abgelehnt' WHERE uid = :uid");
    $stmt1->bindParam(":uid", $uid);
    $stmt1->execute();
}

function kommende_urlaube_anzeigen()
{
    $conn = connServer();
    $sql = "SELECT u.uid, p.vorname, p.nachname, u.uanfang, u.uende 
            FROM personal p
            JOIN urlaubsantrag u ON u.pid = p.pid 
            WHERE u.ustatus = 'beantragt' AND u.uende > CURRENT_DATE()";
    $urlaube = $conn->prepare($sql);
    $urlaube->execute();

    while ($row = $urlaube->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            if ($key != 'uid') {
                echo "<td>" . $value . "</td>";
            }
        }


        echo '<td>
                <form method="POST">
                <input type="hidden" name="uid" value="' . ($row['uid']) . '">
                <button type="submit" class="btn-allow" name="uannehmen">Annehmen</button>
                <button type="submit" class="btn-deny" name="uablehnen">Ablehnen</button>
              </form>
             </td>';
        echo "</tr>";
    }
}