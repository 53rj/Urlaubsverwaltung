<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "include/meta.html";
include "f_function.php";
checkStatus();

?>
<main>
    <div class="maincontent">
        <section id="utage">
            <h2>Nicht verplante Urlaubstage</h2>
            <p>Funktion zum Abrufen der verbliebenen Urlaubstage</p>
        </section>
        <section id="ustatus_1">
            <h2>Genehmigter Urlaub</h2>
            <p>Funktion zur Anzeige von Urlaubsanträgen, die bereits genehmigt wurden</p>
        </section>
        <section id="ustatus_2">
            <h2>Nicht genehmigter Urlaub</h2>
            <p>Funktion zur Anzeige von Urlaubsanträgen, die bereits abgelehnt wurden( Begründungsfeld einbauen?)</p>
        </section>
        <section id="ustatus_3">
            <h2>Gestellte Urlaubsanträge</h2>
            <p>Funktion zur Anzeige von Urlaubsanträgen, die noch zur Bearbeitung ausstehen</p>
        </section>
    </div>
    </main>
<?php
include "include/footer.html";
echo $_SESSION["status"];
var_dump($personal_data);
echo "PID: " . $pid;
?>