<h1>Registrierte Benutzer:</h1>

<?php if (!empty($users)): ?>
<table border='1'>
    <tr><th>PID</th><th>Vorname</th><th>Nachname</th><th>Status</th><th>Resturlaub</th><th>Urlaubstage</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['pid']); ?></td>
            <td><?= htmlspecialchars($user['vorname']); ?></td>
            <td><?= htmlspecialchars($user['nachname']); ?></td>
            <td><?= htmlspecialchars($user['status']); ?></td>
            <td><?= htmlspecialchars($user['resturlaub']); ?></td>
            <td><?= htmlspecialchars($user['urlaubstage']); ?></td>
            <td>
            <form action="edit_user.php" method="post" style="display: inline;"> <!-- Brauche den code für user-bearbeitung -->
                <input type="hidden" name="user_id" value="<?= $user['pid']; ?>">
                <input type="submit" value="Bearbeiten">
            </form>
            <form action="delete_user.php" method="post" style="display: inline;"> <!-- Brauche den code für user-entfernung -->
                <input type="hidden" name="user_id" value="<?= $user['pid']; ?>">
                <input type="submit" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Benutzer löschen möchten?');">
            </form>
        </td>
        </tr>   
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Keine Daten gefunden.</p>
<?php endif; ?>