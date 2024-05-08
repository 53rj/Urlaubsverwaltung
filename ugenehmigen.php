<?php
session_start();
include "include/meta.html";
include "f_function.php";
checkStatus();
?>
<h1>Nicht bearbeitete Urlaubsanträge:</h1>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Beginn</th>
                <th>Ende</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody id="pending-requests">
            <tr>
                <?php kommende_urlaube_anzeigen(); ?>
            </tr>
            <!-- PHP: Ende der foreach-Schleife -->
        </tbody>
    </table>
    <!-- PHP: Platzhalter für das Laden der Anträge -->
    <!-- PHP: Funktionen für das Annehmen/Ablehnen der Anträge hier implementieren -->
</div>
<?php
include "include/footer.html";
?>