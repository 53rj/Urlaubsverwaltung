<?php
session_start();
include "f_function.php";
checkStatus();

if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}
$conn = connServer();
if (!$conn) {
    die("Datenbankverbindung konnte nicht hergestellt werden.");
}
?>
<h1>Urlaubstabelle</h1>

<?php if (!empty($antraege)) : ?>
    <table border='1'>
        <tr>
            <th>UID</th>
            <th>PID</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>Tage beantragt</th>
            <th>Gesamturlaubstage</th>
            <th>Status</th>
        </tr>
        <?php foreach ($antraege as $antrag) : ?>
            <tr>
                <td><?= htmlspecialchars($antrag['uid']); ?></td>
                <td><?= htmlspecialchars($antrag['pid']); ?></td>
                <td><?= htmlspecialchars($antrag['uanfang']); ?></td>
                <td><?= htmlspecialchars($antrag['uende']); ?></td>
                <td><?= htmlspecialchars($antrag['ubeantragt']); ?></td>
                <td><?= htmlspecialchars($antrag['ugesamt']); ?></td>
                <td><?= htmlspecialchars($antrag['ustatus']); ?></td>
                <td>
                    <form action="edit_urlaubsantrag.php" method="post" style="display: inline;">
                        <input type="hidden" name="uid" value="<?= $antrag['uid']; ?>">
                        <input type="submit" value="Bearbeiten">
                    </form>
                    <form action="delete_urlaubsantrag.php" method="post" style="display: inline;">
                        <input type="hidden" name="uid" value="<?= $antrag['uid']; ?>">
                        <input type="submit" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Urlaubsantrag löschen möchten?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Keine Daten gefunden.</p>
<?php endif; ?>