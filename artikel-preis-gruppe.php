<?php
require_once "include/include_db.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel-Preis-GruppenSuche</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="bg-secondary">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12">
                <h1 class="fw-lighter text-warning">ARTIKEL PREIS GRUPPEN SUCHE</h1>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <h3 class="fw-lighter text-light">SUCHE</h3>
                <form method="post">
                    <div class="alert alert-light col-auto" role="alert">
                        <label for="gruppe">Gruppe</label>
                        <select class="form-select" aria-label="Gruppe" name="gruppe">

                            <?php
                            $sql = "SELECT DISTINCT artikelGruppe 
                                FROM artikel
                                ORDER BY artikelGruppe ASC";
                            $stmt = $db->query($sql);

                            $selected = "";

                            while ($selectItem =  $stmt->fetch()) {
                                if ($selectItem["artikelGruppe"] == "Kleidung") {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option  $selected value='" . $selectItem["artikelGruppe"] . "'>" . $selectItem["artikelGruppe"] . "</option>";
                            }

                            ?>

                        </select>
                        <br />
                        <label for="vonPreis">Von Preis</label>
                        <input type="number" class="form-control" id="vonPreis" name="vonPreis" value="0">
                        <br />

                        <label for="bisPreis">Bis Preis</label>
                        <input type="number" class="form-control" id="bisPreis" name="bisPreis" value="100000">
                        <br />

                        <button type="submit" name="suchen" class="btn btn-primary mb-3">Suchen</button>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
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
                        $von = 0;
                        $bis = 100000;
                        $gruppe = "Kleidung";
                        if (isset($_POST["suchen"])) {
                            $von = (int)$_POST["vonPreis"];
                            $bis = (int)$_POST["bisPreis"];
                            $gruppe = $_POST["gruppe"];
                        }

                        $sql = "SELECT artikelName, artikelGruppe, artikelPreis
                            FROM artikel 
                            WHERE artikelGruppe = :gruppe
                            AND artikelPreis BETWEEN :von AND :bis
                            ORDER BY artikelPreis ASC";

                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(":von", $von);
                        $stmt->bindParam(":bis", $bis);
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