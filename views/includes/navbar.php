<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="sidebar">
    <table>
        <tr>
            <td>
                <a href="<?= BASE_URL ?>/">Home</a>
            </td>    
        </tr>
        <tr>
            <td>
                <a href="<?= BASE_URL ?>/events/create"> Neuer Termin</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?= BASE_URL ?>/login">Login</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?= BASE_URL ?>/register"> Register</a>
            </td>
        </tr>
        <?php if (isset($_SESSION['user_name'])): ?>
        <tr>
            <td> 
                <a href="<?= BASE_URL ?>/logout"> Logout</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?= BASE_URL ?>/run-cron" >
                    Cron Reminder ausführen
                </a>
            </td>
        </tr>

        <?php endif; ?>
    </table>
    

</nav>
