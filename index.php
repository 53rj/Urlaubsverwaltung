<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./meta.html";
include_once './f_function.php';

checkStatus();

?>

<section id="utage">
            <h2>Nicht verplante Urlaubstage</h2>
            <table border='1'>
                <tr>
                    <th>Resturlaubstage</th>
                </tr>
                <tr>
                <td><?php nichtVerplanteUrlaubstage(); ?></td>
                </tr>
            </table>
        </section>

        <section id="ustatus_1">
            <h2>Genehmigter Urlaub</h2>
            <table border='1'>
                <th>Urlaubsanfang</th>
                <th>Urlaubsende</th>
                <th>Urlaubsdauer</th>
                <tr>
                    <?php
                    $wert = 'genehmigt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_3">
            <h2>Gestellte Urlaubsanträge</h2>
            <table border='1'>
                <th>Urlaubsanfang</th>
                <th>Urlaubsende</th>
                <th>Urlaubsdauer</th>
                <tr>
                    <?php
                    $wert = 'beantragt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_2">
            <h2>Nicht genehmigter Urlaub</h2>
            <table border='1'>
                <th>Urlaubsanfang</th>
                <th>Urlaubsende</th>
                <th>Urlaubsdauer</th>
                <tr>
                    <?php
                    $wert = 'abgelehnt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

