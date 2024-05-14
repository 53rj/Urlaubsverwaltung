<?php
session_start();
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}
include $_SERVER['DOCUMENT_ROOT'] . '/php/Urlaubsverwaltung/f_function.php';
$conn = connServer();
?>
<h1>Registrierte AU-Fälle:</h1>

<?php if (!empty($krankheiten)) : ?>
    <table border='1'>
        <tr>
            <th>kid</th>
            <th>pid</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>Gesamt</th>
        </tr>
        <?php foreach ($krankheiten as $krankheit) : ?>
            <tr>
                <td><?= htmlspecialchars($krankheit['kid']); ?></td>
                <td><?= htmlspecialchars($krankheit['pid']); ?></td>
                <td><?= htmlspecialchars($krankheit['kanfang']); ?></td>
                <td><?= htmlspecialchars($krankheit['kende']); ?></td>
                <td><?= htmlspecialchars($krankheit['kgesamt']); ?></td>
                <td>
                    <form action="./tabellenanzeigen/edit_krankheit.php" method="post" style="display: inline;">
                        <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                        <input type="submit" value="Bearbeiten">
                    </form>
                    <form action="./tabellenanzeigen/delete_eintrag.php" method="post" style="display: inline;">
                        <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                        <input type="submit" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Krankheitseintag möchten?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Keine Daten gefunden.</p>
<?php endif; ?>