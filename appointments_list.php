<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["role"];

if ($user_role == "patient") {
    $stmt = $pdo->prepare("SELECT a.id, u.name AS doctor_name, a.appointment_date 
                           FROM appointments a 
                           JOIN users u ON a.doctor_id = u.id 
                           WHERE a.patient_id = ?");
} else {
    $stmt = $pdo->prepare("SELECT a.id, u.name AS patient_name, a.appointment_date 
                           FROM appointments a 
                           JOIN users u ON a.patient_id = u.id 
                           WHERE a.doctor_id = ?");
}

$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Rendez-vous Médicaux</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="appointment.php">Prendre un rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Mes Rendez-vous</h2>

        <?php if (count($appointments) == 0): ?>
            <div class="alert alert-info text-center">Aucun rendez-vous enregistré.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th><?= $user_role == "patient" ? "Médecin" : "Patient" ?></th>
                            <th>Date et Heure</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $index => $appointment): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($appointment["doctor_name"] ?? $appointment["patient_name"]) ?></td>
                                <td><?= htmlspecialchars($appointment["appointment_date"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
