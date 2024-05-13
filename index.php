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
            <h2>Verfügbare Urlaubstage</h2>
            <p><?php nichtVerplanteUrlaubstage(); ?></p>
        </section>

        <section id="ustatus_1">
            <h2>Freigegebender Urlaub</h2>
            <table border='1'>
                <tr>
                    <?php
                    $wert = 'genehmigt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_3">
            <h2>Offene Urlaubsanfragen</h2>
            <table border='1'>
                <tr>
                    <?php
                    $wert = 'beantragt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

        <section id="ustatus_2">
            <h2>Abgelehnter Urlaub</h2>
            <table border='1'>
                <tr>
                    <?php
                    $wert = 'abgelehnt';
                    freigabenUrlaub($wert); ?>
                </tr>
            </table>
        </section>

    </div>
</main>
<?php
include "include/footer.html";
?>