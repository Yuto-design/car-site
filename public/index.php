<?php
    session_start();
    require_once(__DIR__ . '/../src/db_connect.php');

    if (isset($_POST['action_type']) && $_POST['action_type']) {
        if ($_POST['action_type'] === 'insert') {
            require(__DIR__ . '/../src/insert_car.php');
        } else if ($_POST['action_type'] ==='delete'){
            require(__DIR__ . '/../src/delete_car.php');
        }
    }

    require(__DIR__ . '/../src/session_values.php');

?>

<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex" />
        <title>Car Introduction</title>
        <link rel="stylesheet" href="./assets/main.css">
    </head>
    <body>
        <?php
            if (isset($_SESSION['success_message'])) {
                echo '<p style="color: green;">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['form_errors'])) {
                foreach ($_SESSION['form_errors'] as $error) {
                    echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
                }
                unset($_SESSION['form_errors']);
            }
        ?>

        <!-- Header -->
        <header>
            <a href="index.php">car introduction</a>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#brands">List of Brands</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main -->
        <div class="main-visual">
            <div>
                <h1>Car Introduction Site</h1>
            </div>
        </div>

        <!-- Home -->
        <section id="home">
            <h2>Home</h2>
            <div id="home-detail">
                <h3>【 車選びの迷いを、確かな情報で解消 】</h3>
                <p>
                    新しい車を探すのはワクワクする一方で、「どれがいいんだろう？」と迷ってしまうことも多いです。<br>
                    当サイトは、そんなあなたの疑問や不安を解消するための自動車紹介サイトです。<br>
                    各メーカーの車種を徹底比較し、詳細なデータと分かりやすい解説で、あなたのライフスタイルにぴったりの一台を見つけるお手伝いをします。
                </p>
            </div>
        </section>

        <!-- -- List of Brands -- -->
        <section id="brands">
            <h2>List of Brands</h2>
            <div class="page-cover">
                <p class="page-title">New Vehicles Registration</p>
                <hr class="pagedivider">
                <form action="index.php" method="post">
                        <div class="form-input-title">Manufacture Name<small>(Required)</small></div>
                        <input
                            type="text"
                            name="manufactureName"
                            maxlength="100"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Model<small>(Required)</small></div>
                        <input
                            type="text"
                            name="carName"
                            maxlength="100"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Price (YEN)<small>(Required)</small></div>
                        <input
                            type="number"
                            name="price"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Size (Length×Width×Height) <small>(Required)</small></div>
                        <div class="size-input-group">
                            <input
                                type="number"
                                name="sizeLength"
                                step="0.01"
                                min="0"
                                class="input-size"
                            />
                            <span class="size-separator">×</span>
                            <input
                                type="number"
                                name="sizeWidth"
                                step="0.01"
                                min="0"
                                class="input-size"
                            />
                            <span class="size-separator">×</span>
                            <input
                                type="number"
                                name="sizeHeight"
                                step="0.01"
                                min="0"
                                class="input-size"
                            />
                        </div>

                        <div class="form-input-title">Engine Type</div>
                        <input
                            type="text"
                            name="engineType"
                            maxlength="50"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Displacement (L)</div>
                        <input
                            type="number"
                            name="displacement"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Fuel Economy (km/L)</div>
                        <input
                            type="number"
                            name="fuelEconomy"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Description</div>
                        <textarea name="description" class="input-message"></textarea>
                        <input type="hidden" name="action_type" value="insert" />

                        <div class="form-input-title">Official HP Link</div>
                        <input
                            type="url"
                            name="hp"
                            maxlength="255"
                            value=""
                            class="input-general"
                            placeholder="https://example.com"
                        />

                        <button type="submit" class="input-submit-button">登録する</button>
                    </form>
                </div>
            </div>
        </section>

        <hr class="page-divider" />

        <section id="car-info-list-section">
            <?php
                $sql = "SELECT * FROM cars ORDER BY id DESC";
                $stmt = $dbh->query($sql);
                $cars = [];
                if ($stmt) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $cars[] = $row;
                    }
                }
            ?>
            <div class="page-cover">
                <p class="page-title">List of Featured Vehicles</p>
                <hr class="page-divider" />
                <div class="car-info-grid"> <?php if (!empty($cars)): ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="car-info-details">
                            <h3><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['carName']); ?></h3>
                            <p><strong>Price：</strong> <?php echo number_format($car['price']); ?> YEN</p>
                            <p><strong>Size (Length×Width×Height)：</strong>
                                <?php
                                    echo number_format($car['sizeLength']) . '×' .
                                        number_format($car['sizeWidth']) . '×' .
                                        number_format($car['sizeHeight']);
                                ?>
                            </p>
                            <p><strong>Enginee Type：</strong> <?php echo htmlspecialchars($car['engineType'] ?? 'Not Clear'); ?></p>
                            <p><strong>displacement：</strong> <?php echo htmlspecialchars($car['displacement'] ?? 'Not Clear'); ?>L</p>
                            <p><strong>Fuel Economy：</strong> <?php echo htmlspecialchars($car['fuelEconomy'] ?? 'Not Clear'); ?>km/L</p>
                            <p><strong>Description：</strong><br> <?php echo htmlspecialchars($car['description'] ?? 'None'); ?></p>
                            <p><strong>Official HP：</strong>
                                <?php if (!empty($car['hp'])): ?>
                                    <a href="<?php echo htmlspecialchars($car['hp']); ?>" target="_blank" rel="noopener noreferrer">HP Link</a>
                                <?php else: ?>
                                    なし
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-cars-message">現在、掲載中の自動車はありません。</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p>&copy 2025 car collection y.s</p>
        </footer>
    </body>
</html>