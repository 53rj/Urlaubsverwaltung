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

function rueckerstattung($pid, $krankheitsanfang, $krankheitsende) {
    $stmt = $link->prepare("CREATE TEMPORARY TABLE IF NOT EXISTS TempUrlaub (kanfang DATE, kende DATE, kgesamt INT);
    -- Berechnung und Einfügen der Urlaubstage unter Ausschluss der Wochenenden    
    INSERT INTO TempKrankheit ($krankheitsanfang, $krankheitsende, 
            (DATEDIFF($krankheitsende, $krankheitsanfang) + 1
             - ((DATEDIFF($krankheitsende, $krankheitsanfang) + 1) / 7 * 2)
             + (CASE WHEN WEEKDAY($krankheitsanfang) = 6 THEN 1 ELSE 0 END)
             + (CASE WHEN WEEKDAY($krankheitsende) = 5 THEN 1 ELSE 0 END)));
    -- Daten von der temporären Tabelle in die Haupttabelle übertragen
    INSERT INTO krankheit (pid, kanfang, kende, kgesamt)
    SELECT $pid, kanfang, kende, kgesamt
    FROM TempKrankheit;
    -- Erstattet die Krankheitstage dem Resturlaub wieder gut
    UPDATE personal 
    SET resturlaub = resturlaub + (
    SELECT SUM(DATEDIFF(LEAST(k.kende, u.uende), GREATEST(k.kanfang, u.uanfang)) + 1)
    FROM krankheit k
    JOIN urlaubsantrag u ON k.pid = u.pid
    WHERE k.kanfang <= u.uende
    AND k.kende >= u.uanfang
    AND k.pid = $pid
    WHERE pid = $pid;
    -- Lösche die temporäre Tabelle nach Gebrauch
    DROP TEMPORARY TABLE IF EXISTS TempUrlaub;");
    $stmt->execute();
}


function UserBearbeiten($pid, $vorname, $nachname, $passwort, $status, $resturlaub) {
    connServer();
    $stmt = $link->prepare("UPDATE personal 
    SET vorname = $vorname, nachname = $nachname, passwort = $passwort, personal.status = $status, urlaubstage = 30, resturlaub = $resturlaub
    WHERE pid = $pid");
    $stmt->execute();
}

function DeleteBearbeiten($pid) {
    connServer();
    $stmt = $link->prepare("DELETE FROM personal WHERE pid = $pid");
    $stmt->execute();
}