function confirmRegistration() {
    if (confirm('Ein Benutzer mit demselben Vor- und Nachnamen existiert bereits. Möchten Sie die Registrierung trotzdem fortsetzen?')) {
        window.location.href = 'register.php?confirm=yes';
    } else {
        alert('Registrierung abgebrochen.');
        window.location.href = 'register.php'; 
    }
}