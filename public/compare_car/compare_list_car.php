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
                    <th>項目</th>
                    <?php foreach ($compareCars as $car): ?>
                        <th><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['model']); ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>価格</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo number_format($car['price']); ?> YEN</td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>サイズ (L×W×H)</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td>
                            <?php echo number_format($car['sizeLength']) . '×' .
                                        number_format($car['sizeWidth']) . '×' .
                                        number_format($car['sizeHeight']); ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>エンジンタイプ</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo htmlspecialchars($car['engineType']); ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>排気量</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo htmlspecialchars($car['displacement']); ?> cc</td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>燃費</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo htmlspecialchars($car['fuelEconomy']); ?> km/L</td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>電費</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo htmlspecialchars($car['electrisityCost']); ?> km/L</td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>詳細</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td><?php echo nl2br(htmlspecialchars($car['description'])); ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>画像</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td>
                            <?php if (!empty($car['carImage'])): ?>
                                <img src="/uploads/<?php echo htmlspecialchars(basename($car['carImage'])); ?>" alt="Car Image" style="max-width: 300px;">
                            <?php else: ?>
                                なし
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>比較から削除</td>
                    <?php foreach ($compareCars as $car): ?>
                        <td>
                            <form method="post" action="remove_compare_car.php">
                                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        <?php else: ?>
            <p>No cars selected for comparison.</p>
        <?php endif; ?>

        <p><a href="/../index.php">Back to Top</a></p>
    </body>
</html>
