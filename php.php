<?php
include "function.php";

// alle
function eigenen_urlaub_anzeigen()
{
    $vorname = $personal->getVorname();
    $nachname = $personal->getNachname();
    $utage = $personal->getUtage();
    $resturlaub = $personal->getResturlaub();
    echo $vorname . $nachname . "<br>" . $utage . "<br>" . $resturlaub;
}

// Eigene Urlaubsübersicht -> Genehmigter Urlaub
function urlaub_anzeigen($pid)
{
    connServer();
    $sql = "SELECT u.uanfang, u.uende, u.utage, p.resturlaub FROM personal p, urlaubsantrag u WHERE u.ustatus = 'genehmigt' AND u.uende > GETDATE() AND pid = $pid";
    $urlaube = mysqli_query($sql);
    $anzeige = array();
    while ($row = mysqli_fetch_array($urlaube)) {
        $anzeige = $row;
    }
    foreach ($anzeige as $urlaub) {
        echo $urlaub;
    }
}

// personalleiter
function kommende_urlaube_anzeigen()
{
    $conn = connServer();
    $sql = "SELECT p.vorname, p.nachname, u.uanfang, u.uende 
            FROM personal p, urlaubsantrag u 
            WHERE u.pid = p.pid 
            AND u.ustatus = 'genehmigt' 
            AND u.uende > CURRENT_DATE();";
    $urlaube = $conn->query($sql);
    $anzeige = array();
    while ($row = $urlaube->fetch(PDO::FETCH_ASSOC)) {
        $anzeige = $row;
        echo "<tr>";
        foreach ($anzeige as $kommende_urlaube) {
            echo  "<td>" . $kommende_urlaube . "</td>";
        }
        echo '<td>
            <button type="button" class="btn-allow">Annehmen</button>
            <button type="button" class="btn-deny">Ablehnen</button>
            </td>';
        echo "</tr>";
    }
}

function antrag_anzeigen()
{
    $conn = connServer();
    $sql = "SELECT p.vorname, p.nachname, u.uanfang, u.uende 
            FROM personal p, urlaubsantrag u 
            WHERE u.pid = p.pid 
            AND u.ustatus = 'beantragt' 
            AND u.uende > CURRENT_DATE();";
    $urlaube = $conn->query($sql);
    $anzeige = array();
    while ($row = $urlaube->fetch(PDO::FETCH_ASSOC)) {
        $anzeige = $row;
        echo "<tr>";
        foreach ($anzeige as $kommende_urlaube) {
            echo  "<td>" . $kommende_urlaube . "</td>";
        }
        echo '<td>
            <button type="button" class="btn-allow">Annehmen</button>
            <button type="button" class="btn-deny">Ablehnen</button>
            </td>';
        echo "</tr>";
    }
}

//vorbereiung -> urlaubsantrag
$nachname = getNachname();
$vorname = getVorname();
$pid = "select pid from personal where nachname = $nachname and vorname = $vorname";

// mit dem commit wird der befehl executed
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
function urlaubsgenehmigung($pid, $uid)
{
    connServer();
    $stmt1 = $link->prepare("UPDATE urlaubsantrag SET ustatus = 'genehmigt' WHERE uid = $uid");
    $stmt2 = $link->prepare("UPDATE personal SET resturlaub = resturlaub - (SELECT ubeantragt FROM urlaubsantrag WHERE pid = $pid AND uid = $uid) WHERE pid = $pid");
    $stmt1->execute();
    $stmt2->execute();
}
function urlaubsablehnung($pid, $uid)
{
    connServer();
    $stmt1 = $link->prepare("UPDATE urlaubsantrag SET ustatus = 'abgelehnt' WHERE uid = $uid");
    $stmt1->execute();
}
