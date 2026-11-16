<?php
require __DIR__ . '/../includes/admin_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    logout_admin();
    redirect('login.php');
}
redirect('index.php');
