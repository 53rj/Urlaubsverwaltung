<?php
include "include/meta.html";
include "include/header.html";
?>
<div class="container">
        <h1>Urlaubsverwaltung</h1>
        <div class="alert alert-info" role="alert">
            Nicht bearbeitete Urlaubsanträge:
        </div>

        <!-- nicht bearbeitete Anträge -->
        <table class="table">
            <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Name</th>
                    <th>Beginn</th>
                    <th>Ende</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody id="pending-requests">
                <!-- for each schleife mit allen anträgen? -->
                        <!-- Vielleicht eine Funktion einbauen, die Urlaubsdaten, die sich überschneiden outlined und in einer anderen Farbe anzeigt?-->
                        <button type="button" class="btn-allow" onclick="acceptRequest('123')">Annehmen</button>  <!-- Funktion fürs annehmen und eintragen in die Datenbank muss eingefügt werden-->
                        <button type="button" class="btn-deny" onclick="rejectRequest('123')">Ablehnen</button>   <!-- Funktion fürs ablehnen und weiterverarbeitung in der Datenbank muss eingefügt werden-->
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- PHP-Platzhalter für das Laden und die Verarbeitung der Anträge -->
        <?php
            // PHP-Code für das Laden der Anträge
        ?>

        <!-- Anträge annehmen / ablehnen -->
        <?php

                // PHP-Code zum Akzeptieren von Anträgen


                // PHP-Code zum Ablehnen von Anträgen hzier rein

            ?>
    </div>
    <?php
include "include/footer.html";
?>