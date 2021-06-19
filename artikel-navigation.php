<?php
require_once "include/include_db.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel-Navigation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="bg-primary">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12">
                <h1 class="fw-lighter text-warning">ARTIKEL NAVIGATION</h1>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3 text-light">
                <h3 class="fw-lighter text-light">NAVIGATION</h3>
                <ul class="lh-lg">
                    <?php
                    $sql = "SELECT DISTINCT artikelGruppe 
                                FROM artikel
                                ORDER BY artikelGruppe ASC";
                    $stmt = $db->query($sql);

                    $artikelGruppen = [''];

                    while ($selectItem =  $stmt->fetch()) {
                        array_push($artikelGruppen, $selectItem["artikelGruppe"]);
                        echo "<li><a class='text-light text-uppercase text-decoration-none' href='?gruppe=" . $selectItem["artikelGruppe"] . "'>" . $selectItem["artikelGruppe"] . "</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-9">
                <h3 class="fw-lighter text-light">ARTIKEL</h3>
                <table class="table table-light table-striped table-hover fs-4">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Gruppe</th>
                            <th scope="col">Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $gruppe = "Kleidung";

                        if (isset($_GET["gruppe"])) {
                            if (array_search($_GET["gruppe"], $artikelGruppen)) {
                                $gruppe = $_GET["gruppe"];
                            } else {
                                $gruppe = "Kleidung";
                            }
                        }

                        $sql = "SELECT artikelName, artikelGruppe, artikelPreis
                            FROM artikel 
                            WHERE artikelGruppe = :gruppe
                            ORDER BY artikelPreis ASC";

                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(":gruppe", $gruppe);
                        $stmt->execute();

                        while ($row =  $stmt->fetch()) {
                            $preis = str_replace('.', ',', $row["artikelPreis"]);
                            echo "<tr><td>" . $row["artikelName"] . "</td><td>" . $row["artikelGruppe"] . "</td><td>€ " . $preis . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>