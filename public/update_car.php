<?php
    require_once(__DIR__ . '/../src/db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';
        $manufactureName = $_POST['manufactureName'] ?? '';
        $carName = $_POST['carName'] ?? '';
        $price = $_POST['price'] ?? 0;
        $sizeLength = $_POST['sizeLength'] ?? 0;
        $sizeWidth = $_POST['sizeWidth'] ?? 0;
        $sizeHeight = $_POST['sizeHeight'] ?? 0;
        $engineType = $_POST['engineType'] ?? '';
        $displacement = $_POST['displacement'] ?? 0;
        $fuelEconomy = $_POST['fuelEconomy'] ?? 0;
        $description = $_POST['description'] ?? '';
        $hp = $_POST['hp'] ?? '';
        $carImagePath = null;
        if (isset($_FILES['carImage']) && $_FILES['carImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $tmpName = $_FILES['carImage']['tmp_name'];
            $fileName = basename($_FILES['carImage']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $carImagePath = 'uploads/' . $fileName;
            }
        }

        if ($carImagePath) {
            $stmt = $dbh->prepare("UPDATE cars SET manufactureName = ?, carName = ?, price = ?, sizeLength = ?, sizeWidth = ?, sizeHeight = ?, engineType = ?, displacement = ?, fuelEconomy = ?, description = ?, hp = ?, carImage = ? WHERE id = ?");
            $stmt->execute([
                $manufactureName, $carName, $price, $sizeLength, $sizeWidth, $sizeHeight,
                $engineType, $displacement, $fuelEconomy, $description, $hp, $carImagePath, $id
            ]);
        } else {
            $stmt = $dbh->prepare("UPDATE cars SET manufactureName = ?, carName = ?, price = ?, sizeLength = ?, sizeWidth = ?, sizeHeight = ?, engineType = ?, displacement = ?, fuelEconomy = ?, description = ?, hp = ? WHERE id = ?");
            $stmt->execute([
                $manufactureName, $carName, $price, $sizeLength, $sizeWidth, $sizeHeight,
                $engineType, $displacement, $fuelEconomy, $description, $hp, $id
            ]);
        }

        $_SESSION['success_message'] = "編集が完了しました";
        header("Location: index.php");
        exit();

    } else {
        $id = $_GET['car_id'] ?? '';
        $stmt = $dbh->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$car) {
            die("データが存在しません");
        }
?>

<!DOCTYPE html>
    <head>
        <meta charset="UTF-8" />
        <title>Edit Vehicle Information</title>
        <link rel="stylesheet" href="assets/main.css" />
    </head>
    <body>
        <section id="brands">
            <div class="page-cover">
                <p class="page-title">Edit Vehicle Information</p>
                <hr class="page-divider">
                <form action="update_car.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>">

                    <div class="form-input-title">Manufacture Name <small>(Required)</small></div>
                    <input
                        type="text"
                        name="manufactureName"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($car['manufactureName']); ?>"
                        class="input-general"
                        required
                    />

                    <div class="form-input-title">Model <small>(Required)</small></div>
                    <input
                        type="text"
                        name="carName"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($car['carName']); ?>"
                        class="input-general"
                        required
                    />

                    <div class="form-input-title">Price (YEN) <small>(Required)</small></div>
                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($car['price']); ?>"
                        class="input-general"
                        required
                    />

                    <div class="form-input-title">Size (Length×Width×Height) <small>(Required)</small></div>
                    <div class="size-input-group">
                        <input
                            type="number"
                            name="sizeLength"
                            step="0.01"
                            min="0"
                            class="input-size"
                            value="<?php echo htmlspecialchars($car['sizeLength']); ?>"
                            required
                        />
                        <span class="size-separator">×</span>
                        <input
                            type="number"
                            name="sizeWidth"
                            step="0.01"
                            min="0"
                            class="input-size"
                            value="<?php echo htmlspecialchars($car['sizeWidth']); ?>"
                            required
                        />
                        <span class="size-separator">×</span>
                        <input
                            type="number"
                            name="sizeHeight"
                            step="0.01"
                            min="0"
                            class="input-size"
                            value="<?php echo htmlspecialchars($car['sizeHeight']); ?>"
                            required
                        />
                    </div>

                    <div class="form-input-title">Engine Type（エンジン）</div>
                    <input
                        type="text"
                        name="engineType"
                        maxlength="50"
                        value="<?php echo htmlspecialchars($car['engineType']); ?>"
                        class="input-general"
                    />

                    <div class="form-input-title">Displacement（排気量）【cc】</div>
                    <input
                        type="number"
                        name="displacement"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($car['displacement']); ?>"
                        class="input-general"
                    />

                    <div class="form-input-title">Fuel Economy（燃費）【km/L】</div>
                    <input
                        type="number"
                        name="fuelEconomy"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($car['fuelEconomy']); ?>"
                        class="input-general"
                    />

                    <div class="form-input-title">Description（詳細）</div>
                    <textarea
                        name="description"
                        class="input-message"
                        rows="5"
                    ><?php echo htmlspecialchars($car['description']); ?></textarea>

                    <div class="form-input-title">Official HP Link</div>
                    <input
                        type="url"
                        name="hp"
                        maxlength="255"
                        value="<?php echo htmlspecialchars($car['hp']); ?>"
                        class="input-general"
                        placeholder="https://example.com"
                    />

                    <div class="form-input-title">Car Image</div>
                    <input
                        type="file"
                        name="carImage"
                        accept="image/*"
                        class="input-general"
                        id="carImage"
                        onchange="previewImage(event)"
                    />
                    <?php if (!empty($car['carImage'])): ?>
                        <img src="<?php echo htmlspecialchars($car['carImage']); ?>" id="imagePreview" alt="Car Image">
                        <button type="button" id="removeImageButton" onclick="removeImage()">Remove Image</button>
                    <?php endif; ?>

                    <button type="submit" class="input-submit-button">Update</button>
                </form>
            </div>
        </section>

        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                const removeBtn = document.getElementById('removeImageButton');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        removeBtn.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function removeImage() {
                const input = document.getElementById('carImage');
                const preview = document.getElementById('imagePreview');
                const removeBtn = document.getElementById('removeImageButton');

                input.value = '';
                preview.src = '';
                preview.style.display = 'none';
                removeBtn.style.display = 'none';
            }
        </script>
    </body>
</html>
<?php } ?>