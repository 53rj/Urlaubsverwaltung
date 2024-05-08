<?php
include "includes.php";
function eigenen_urlaub_anzeigen()
{
    $vorname = $personal->getVorname();
    $nachname = $personal->getNachname();
    $utage = $personal->getUtage();
    $resturlaub = $personal->getResturlaub();
    echo $vorname . $nachname . "<br>" . $utage . "<br>" . $resturlaub;
}
function checkuser($abfrage)
{
    $conn = connServer();

    if ($abfrage == "angestellter") {
        echo "Ihr login als Angestellter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        //link für richtige seite 
    }

    if ($abfrage == "personalleiter") {
        echo "Ihr login als Personalleiter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        //link für richtige seite 
    }

    if ($abfrage == "admin") {
        echo "Ihr login als Admin war erfolgreich";
        //link für richtige seite 
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

function urlaubsantrag($pid, $urlaubsanfang, $urlaubsende)
{
    connServer();
    $stmt = $link->prepare("CREATE TEMPORARY TABLE IF NOT EXISTS TempUrlaub (uanfang DATE, uende DATE, tage INT);
    -- Berechnung und Einfügen der Urlaubstage unter Ausschluss der Wochenenden
    INSERT INTO TempUrlaub (uanfang, uende, tage)
    VALUES ($urlaubsanfang, $urlaubsende
            (DATEDIFF($urlaubsende, $urlaubsanfang) + 1
             - ((DATEDIFF($urlaubsende, $urlaubsanfang) + 1) / 7 * 2)
             + (CASE WHEN WEEKDAY($urlaubsanfang ) = 6 THEN 1 ELSE 0 END)
             + (CASE WHEN WEEKDAY($urlaubsende) = 5 THEN 1 ELSE 0 END)));
    -- Daten von der temporären Tabelle in die Haupttabelle übertragen
    INSERT INTO urlaubsantrag (pid, uanfang, uende, ubeantragt, ugesamt, ustatus)
    SELECT $pid, uanfang, uende, tage, 30, 'beantragt'
    FROM TempUrlaub;
    -- Lösche die temporäre Tabelle nach Gebrauch
    DROP TEMPORARY TABLE IF EXISTS TempUrlaub;");
    $stmt->execute();
}

// dein aktueller Code versucht mehrere SQL-Anweisungen in einem einzigen Aufruf von prepare auszuführen. 
// das wird von PDO, wenn es um MySQL geht, nicht unterstützt. 
// du musst jede Anweisung separat vorbereiten und ausführen

// ChadGPT - Lösung:
// $conn = connServer();
// $conn->exec("CREATE TEMPORARY TABLE IF NOT EXISTS TempUrlaub (uanfang DATE, uende DATE, tage INT);");

// $sql = "INSERT INTO TempUrlaub (uanfang, uende, tage)
//         VALUES (?, ?, DATEDIFF(?, ?) + 1 - (DATEDIFF(?, ?) + 1) / 7 * 2 + (CASE WHEN WEEKDAY(?) = 6 THEN 1 ELSE 0 END) + (CASE WHEN WEEKDAY(?) = 5 THEN 1 ELSE 0 END))";
// $stmt = $conn->prepare($sql);
// $stmt->execute([$urlaubsanfang, $urlaubsende, $urlaubsende, $urlaubsanfang, $urlaubsende, $urlaubsanfang, $urlaubsanfang, $urlaubsende]);

// $sql = "INSERT INTO urlaubsantrag (pid, uanfang, uende, ubeantragt, ugesamt, ustatus)
//         SELECT ?, uanfang, uende, tage, 30, 'beantragt'
//         FROM TempUrlaub";
// $stmt = $conn->prepare($sql);
// $stmt->execute([$pid]);

// $conn->exec("DROP TEMPORARY TABLE IF EXISTS TempUrlaub;");
