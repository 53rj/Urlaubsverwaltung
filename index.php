<?php
include "include/meta.html";
include "f_function.php";
?>

<main>
    <div class="maincontent">
        <section id="utage">
            <h2>Nicht verplante Urlaubstage</h2>
            <p><?php nichtVerplanteUrlaubstage(); ?></p>
        </section>

        <section id="ustatus_1">
            <h2>Genehmigter Urlaub</h2>
            <table border='1'>
                <tr>
                    <?php 
                    $wert = 'genehmigt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_2">
            <h2>Nicht genehmigter Urlaub</h2>
            <table border='1'>
                <tr>
                    <?php 
                    $wert = 'abgelehnt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_3">
            <h2>Nicht bearbeitete Anfrage</h2>
            <table border='1'>
                <tr>
                    <?php 
                    $wert = 'beantragt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>
    </div>
    </main>
<?php
include "include/footer.html";
?>