<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<a href="index.php"><button type="button">Accueil</button></a>

<?php
include("db.php");

$sql = "SELECT * FROM fingerprint";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$raws = $stmt->fetchAll();

if ($raws != null) {
    echo "<table><thead><th>Identifiant</th><th>Fingerprint brut</th><th>Fingerprint hashé</th><th>Première visite sur le site</th><th>Dernière visite sur le site</th><th>Nombre total de visites de l'utilisateur</th></thead><tbody>";

    foreach ($raws as $row)
    {
        $id = $row["user_id"];
        $raw = $row["fingerprint_raw"];
        $hash = $row["fingerprint_hash"];
        $first = $row["first_visit"];
        $latest = $row["latest_visit"];
        $nb = $row["visits_count"];
        echo "<tr><td>$id</td><td>$raw</td><td>$hash</td><td>$first</td><td>$latest</td><td>$nb</td></tr>";
    }

    echo "</tbody></table>";

} else {
    echo "0 résultats";
}