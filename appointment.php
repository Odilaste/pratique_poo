<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST["doctor_id"];
    $date = $_POST["date"];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
    if ($stmt->execute([$_SESSION["user_id"], $doctor_id, $date])) {
        $success = "Rendez-vous enregistré avec succès.";
    } else {
        $error = "Erreur lors de l'enregistrement.";
    }
}

$doctors = $pdo->query("SELECT * FROM users WHERE role='doctor'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre un Rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow">
            <h3 class="text-center">Prendre un rendez-vous</h3>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Choisir un médecin</label>
                    <select name="doctor_id" class="form-select">
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date et Heure</label>
                    <input type="datetime-local" name="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Confirmer</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
