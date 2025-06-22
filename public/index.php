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
        <!-- Header -->
        <header>
            <a href="index.php">car introduction</a>
            <nav>
                <ul>
                    <li>Home</li>
                    <li>List of Brands</li>
                    <li>Contact</li>
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
                <p class="page-title">New Car Registration</p>
                <hr class="pagedivider">
                <form action="/" method="post">
                        <div class="form-input-title">メーカー名 <small>(必須)</small></div>
                        <input
                            type="text"
                            name="manufactureName"
                            maxlength="100"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">車種名 <small>(必須)</small></div>
                        <input
                            type="text"
                            name="carName"
                            maxlength="100"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">価格 (万円) <small>(必須)</small></div>
                        <input
                            type="number"
                            name="price"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">エンジンタイプ</div>
                        <input
                            type="text"
                            name="engineType"
                            maxlength="50"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">排気量 (L)</div>
                        <input
                            type="number"
                            name="displacement"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">燃費 (km/L)</div>
                        <input
                            type="number"
                            name="fuelEconomy"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-error"></div>
                            <div class="form-input-title">詳細説明</div>
                            <textarea name="description" class="input-message"></textarea>
                            <div class="form-input-error"></div>
                            <input type="hidden" name="action_type" value="insert" />
                            <button type="submit" class="input-submit-button">登録する</button>
                    </form>
                </div>
            </div>
        </section>

        <hr class="page-divider" />

        <section id="brand-list-section" class="brand-list-section">
            <h2>ブランドから探す</h2>
            <div class="brand-grid">
                <?php
                $brands = [];
                $sql_brands = "SELECT DISTINCT make FROM cars ORDER BY make ASC";
                $result_brands = $conn->query($sql_brands);

                if ($result_brands && $result_brands->num_rows > 0) {
                    while($row = $result_brands->fetch_assoc()) {
                        $brands[] = $row['make'];
                    }
                }
                ?>
                <?php if (!empty($brands)): ?>
                    <?php foreach ($brands as $brand): ?>
                        <a href="brand_cars.php?brand=<?php echo urlencode($brand); ?>" class="brand-item">
                            <?php
                            $logo_path = 'images/logo_' . strtolower(str_replace(' ', '_', $brand)) . '.png';
                            $display_logo = file_exists(__DIR__ . '/public/' . $logo_path) ? htmlspecialchars($logo_path) : 'images/default_logo.png';
                            ?>
                            <img src="<?php echo $display_logo; ?>" alt="<?php echo htmlspecialchars($brand); ?> Logo">
                            <h3><?php echo htmlspecialchars($brand); ?></h3>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>現在、登録されているブランドはありません。</p>
                <?php endif; ?>
            </div>
        </section>

        <hr class="page-divider" />

        <section id="car-info-list-section">
            <div class="page-cover">
                <p class="page-title">掲載自動車一覧</p>
                <hr class="page-divider" />
                <div class="car-info-grid"> <?php if (!empty($cars)): ?>
                        <?php foreach ($cars as $car): ?>
                            <h2><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h2>
                            <div class="car-info-details">
                                <h3><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h3>
                                <p><strong>価格:</strong> <?php echo number_format($car['price'] ?? 0, 2); ?>万円</p>
                                <p><strong>エンジン:</strong> <?php echo htmlspecialchars($car['engine_type'] ?? '不明'); ?></p>
                                <p><strong>排気量:</strong> <?php echo htmlspecialchars($car['displacement'] ?? '不明'); ?>L</p>
                                <p><strong>燃費:</strong> <?php echo htmlspecialchars($car['fuel_economy'] ?? '不明'); ?>km/L</p>
                                <p><strong>説明:</strong> <?php echo htmlspecialchars($car['description'] ?? '詳細説明なし'); ?></p>
                                <a href="car_detail.php?id=<?php echo htmlspecialchars($car['id']); ?>" class="btn-detail">詳細を見る</a>
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