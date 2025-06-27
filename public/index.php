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
            <a href="index.php">Car Introduction</a>
            <nav>
                <ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="#brands">List of Brands</a></li>
                    <li><a href="#car-info-list-section">List of Featured Vehicles</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main -->
        <div class="main-visual">
            <div>
                <h1>Car Introduction Site</h1>
            </div>
        </div>

        <!-- About -->
        <section id="about">
            <h2>About</h2>
            <div id="about-detail">
                <h3>【 車選びの迷いを、確かな情報で解消 】</h3>
                <h4>
                    新しい車を探すのはワクワクする一方で、「どれがいいんだろう？」と迷ってしまうことも多いです。<br>
                    当サイトは、そんなあなたの疑問や不安を解消するための自動車紹介サイトです。<br>
                    各メーカーの車種を徹底比較し、詳細なデータと分かりやすい解説で、あなたのライフスタイルにぴったりの一台を見つけるお手伝いをします。
                </h4>
            </div>
        </section>

        <!-- -- List of Brands -- -->
        <section id="brands">
            <h2>List of Brands</h2>
            <div class="page-cover">
                <p class="page-title">New Vehicles Registration</p>
                <hr class="page-divider">
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

                        <div class="form-input-title">Engine Type（エンジン）</div>
                        <input
                            type="text"
                            name="engineType"
                            maxlength="50"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Displacement（排気量）【cc】)</div>
                        <input
                            type="number"
                            name="displacement"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Fuel Economy（燃費）【km/L】</div>
                        <input
                            type="number"
                            name="fuelEconomy"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">Description（詳細）</div>
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

        <section id="car-info-list-section">
            <div class="page-cover">
                <button class="filter-toggle-btn" id="toggleFilterBtn">≡</button>

                <form method="GET" class="filter-form" id="filterForm">
                    <p><strong>メーカーを選択：</strong></p>
                    <?php
                        $selectedManufacturers = $_GET['manufacturer'] ?? [];
                        if (!is_array($selectedManufacturers)) {
                            $selectedManufacturers = [$selectedManufacturers];
                        }

                        $stmtMakers = $dbh->query("SELECT DISTINCT manufactureName FROM cars ORDER BY manufactureName");
                        while ($row = $stmtMakers->fetch(PDO::FETCH_ASSOC)) {
                            $name = htmlspecialchars($row['manufactureName']);
                            $checked = in_array($row['manufactureName'], $selectedManufacturers) ? 'checked' : '';
                            echo "<label><input type='checkbox' name='manufacturer[]' value='$name' $checked> $name</label><br>";
                        }
                    ?>
                    <button type="submit">検索</button>
                </form>

                <?php
                    $selectedManufacturers = $_GET['manufacturer'] ?? [];

                    if (!is_array($selectedManufacturers)) {
                        $selectedManufacturers = [$selectedManufacturers];
                    }

                    if (!empty($selectedManufacturers)) {
                        $placeholders = implode(',', array_fill(0, count($selectedManufacturers), '?'));
                        $sql = "SELECT * FROM cars WHERE manufactureName IN ($placeholders) ORDER BY id DESC";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute($selectedManufacturers);
                    } else {
                        $sql = "SELECT * FROM cars ORDER BY id DESC";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    }

                    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <h2 class="page-title">
                    <?php
                        if (!empty($selectedManufacturers)) {
                            echo implode(' / ', array_map('htmlspecialchars', $selectedManufacturers)) . " Car List";
                        } else {
                            echo "List of Featured Vehicles";
                        }
                    ?>
                </h2>

                <hr class="page-divider" />

                <div class="car-info-grid">
                    <?php if (!empty($cars)): ?>
                        <?php foreach ($cars as $car): ?>
                            <div class="car-info-details">
                                <h3 class="card-maintitle"><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['carName']); ?></h3>
                                <div class="car-details">
                                    <p><strong>Price：</strong> <?php echo number_format($car['price']); ?> YEN</p>
                                    <p><strong>Size (L×W×H)：</strong>
                                        <?php
                                            echo number_format($car['sizeLength']) . '×' .
                                            number_format($car['sizeWidth']) . '×' .
                                            number_format($car['sizeHeight']);
                                        ?>
                                    </p>
                                    <p><strong>Engine Type：</strong> <?php echo htmlspecialchars($car['engineType'] ?? 'Not Clear'); ?></p>
                                    <p><strong>Displacement：</strong> <?php echo htmlspecialchars($car['displacement'] ?? 'Not Clear'); ?> cc</p>
                                    <p><strong>Fuel Economy：</strong> <?php echo htmlspecialchars($car['fuelEconomy'] ?? 'Not Clear'); ?> km/L</p>
                                    <p><strong>Description：</strong><br> <?php echo nl2br(htmlspecialchars($car['description'] ?? 'None')); ?></p>
                                    <p><strong>Official HP：</strong>
                                        <?php if (!empty($car['hp'])): ?>
                                            <a href="<?php echo htmlspecialchars($car['hp']); ?>" target="_blank" rel="noopener noreferrer">HP Link</a>
                                        <?php else: ?>
                                            なし
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-cars-message">現在、掲載中の自動車はありません。</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <script>
            document.getElementById('toggleFilterBtn').addEventListener('click', function () {
                const form = document.getElementById('filterForm');
                form.style.display = (form.style.display === 'block') ? 'none' : 'block';
            });
        </script>

        <!-- Contact -->
        <section id="contact">
            <h2>Contact</h2>
            <div class="page-cover">
                <form action="https://docs.google.com/forms/u/3/d/e/1WhwINsGNqnYubRXL1-BJZzyUvBBLGca8nLNWlmnCf8I/formResponse" target="_self" method="POST" id="mG61Hd">
                    <dl>
                        <dt>お名前</dt>
                        <dd><input name="entry.2005620554" type="text" required="required" id="textfield" class="g_form"></dd>
                        <dt>メールアドレス</dt>
                        <dd><input name="entry.1045781291" type="text" class="g_form" id="textfield2"></dd>
                        <dt>問い合わせ内容</dt>
                        <dd><textarea name="entry.839337160" required class="g_form_text" id="entry.839337160"></textarea></dd>
                    </dl>
                    <div class="button"><input type="submit" class="btbt"></div>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p>&copy 2025 car collection y.s</p>
        </footer>
    </body>
</html>