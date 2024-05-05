<?php
include "include/meta.html";
include "include/header.html";
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
            <!-- PHP: Hier wird die foreach-Schleife eingefügt um die Urlaubsanträge auszugeben -->
            <!-- Beispielhafter statischer Eintrag zur Demonstration -->
            <tr>
                <td>Max</td>
                <td>Mustermann</td>
                <td>2024-05-01</td>
                <td>2024-05-15</td>
                <td>
                    <button type="button" class="btn-allow">Annehmen</button>
                    <button type="button" class="btn-deny">Ablehnen</button>
                </td>
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
