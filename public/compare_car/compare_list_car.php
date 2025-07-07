<?php
    session_start();
    require_once(__DIR__ . '/../../src/db_connect.php');

    $compareCars = [];

    if (!empty($_SESSION['compare_list'])) {
        $placeholders = implode(',', array_fill(0, count($_SESSION['compare_list']), '?'));
        $sql = "SELECT * FROM cars WHERE id IN ($placeholders)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($_SESSION['compare_list']);
        $compareCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
    <head>
        <title>Compare Cars</title>
        <link rel="stylesheet" href="/../assets/compare_car.css">
    </head>
    <body>
        <h2>Compare Selected Cars</h2>

        <?php if (!empty($compareCars)): ?>
            <table border="1">
                <tr>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Size (L×W×H)</th>
                    <th>Engine</th>
                    <th>Displacement</th>
                    <th>Fuel Economy</th>
                    <th>Description</th>
                    <th>Remove</th>
                </tr>
                <?php foreach ($compareCars as $car): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['model']); ?></td>
                        <td><?php echo number_format($car['price']); ?> YEN</td>
                        <td>
                            <?php echo number_format($car['sizeLength']) . '×' .
                                number_format($car['sizeWidth']) . '×' .
                                number_format($car['sizeHeight']);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($car['engineType']); ?></td>
                        <td><?php echo htmlspecialchars($car['displacement']); ?> cc</td>
                        <td><?php echo htmlspecialchars($car['fuelEconomy']); ?> km/L</td>
                        <td><?php echo nl2br(htmlspecialchars($car['description'])); ?></td>
                        <td>
                            <form method="post" action="remove_compare_car.php">
                                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No cars selected for comparison.</p>
        <?php endif; ?>

        <p><a href="/../index.php">Back to Top</a></p>
    </body>
</html>
