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
                <form action="index.php" method="post">
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

                        <div class="form-input-title">詳細説明</div>
                        <textarea name="description" class="input-message"></textarea>
                        <input type="hidden" name="action_type" value="insert" />

                        <div class="form-input-title">公式ホームページリンク</div>
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
                <p class="page-title">掲載自動車一覧</p>
                <hr class="page-divider" />
                <div class="car-info-grid"> <?php if (!empty($cars)): ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="car-info-details">
                            <h3><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['carName']); ?></h3>
                            <p><strong>価格：</strong> <?php echo number_format($car['price'] ?? 0, 2); ?>万円</p>
                            <p><strong>エンジン：</strong> <?php echo htmlspecialchars($car['engineType'] ?? '不明'); ?></p>
                            <p><strong>排気量：</strong> <?php echo htmlspecialchars($car['displacement'] ?? '不明'); ?>L</p>
                            <p><strong>燃費：</strong> <?php echo htmlspecialchars($car['fuelEconomy'] ?? '不明'); ?>km/L</p>
                            <p><strong>説明：</strong> <?php echo htmlspecialchars($car['description'] ?? '詳細説明なし'); ?></p>
                            <p><strong>HP：</strong>
                                <?php if (!empty($car['hp'])): ?>
                                    <a href="<?php echo htmlspecialchars($car['hp']); ?>" target="_blank" rel="noopener noreferrer">公式ホームページリンク</a>
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