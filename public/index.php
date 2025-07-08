<?php
    session_start();
    require_once(__DIR__ . '/../src/db_connect.php');

    if (isset($_POST['action_type']) && $_POST['action_type']) {
        if ($_POST['action_type'] === 'insert') {
            require(__DIR__ . '/../src/insert_car.php');
        } else if ($_POST['action_type'] ==='delete'){
            require(__DIR__ . '/../src/delete_car.php');
        } else if ($_POST['action_type'] === 'update') {
            require(__DIR__ . '/../update_car.php');
    }
    }

    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
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

        <?php
            $stmtCounts = $dbh->query("SELECT manufactureName, COUNT(*) AS count FROM cars GROUP BY manufactureName");
            $manufacturerCounts = $stmtCounts->fetchAll(PDO::FETCH_ASSOC);

            $stmtTotal = $dbh->query("SELECT COUNT(*) AS total FROM cars");
            $totalCount = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
        ?>

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
                <h3>登録状況</h3>
                <div class="stats-container">
                    <div class="stats-left">
                        <?php foreach ($manufacturerCounts as $row): ?>
                            <div class="stat-box">
                                <p class="stat-label"><?php echo htmlspecialchars($row['manufactureName']); ?></p>
                                <p class="stat-number" data-target="<?php echo $row['count']; ?>">0</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="stats-right">
                        <div class="stat-box">
                            <p class="stat-label">総登録台数</p>
                            <p class="stat-number" data-target="<?php echo $totalCount; ?>">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const counters = document.querySelectorAll(".stat-number");
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute("data-target");
                        const current = +counter.innerText;
                        const increment = Math.max(1, Math.floor(target / 100));

                        if (current < target) {
                            counter.innerText = current + increment;
                            setTimeout(updateCount, 20);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCount();
                });
            });
        </script>

        <!-- -- List of Brands -- -->
        <section id="brands">
            <h2>List of Brands</h2>

            <div class="page-cover">
                <p class="page-title">New Vehicles Registration</p>
                <hr class="page-divider">
                <form action="/" method="post" enctype="multipart/form-data">
                    <div class="form-input-title">Manufacture Name<small> (Required)</small></div>
                    <input
                        type="text"
                        name="manufactureName"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($messages['input_pre_manufactureName'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_manufactureName'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_manufactureName']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Model<small> (Required)</small></div>
                    <input
                        type="text"
                        name="model"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($messages['input_pre_model'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_model'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_model']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Price 【YEN】<small> (Required)</small></div>
                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($messages['input_pre_price'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_price'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_price']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Size (Length×Width×Height) 【mm】<small> (Required)</small></div>
                    <div class="size-input-group">
                        <input
                            type="number"
                            name="sizeLength"
                            step="0.01"
                            min="0"
                            value="<?php echo htmlspecialchars($messages['input_pre_sizeLength'], ENT_QUOTES); ?>"
                            class="input-size"
                        />
                        <?php if ($messages['input_error_sizeLength'] !== '') { ?>
                            <div class="form-input-error">
                                <?php echo $messages['input_error_sizeLength']; ?>
                            </div>
                        <?php } ?>
                        <span class="size-separator">×</span>
                        <input
                            type="number"
                            name="sizeWidth"
                            step="0.01"
                            min="0"
                            value="<?php echo htmlspecialchars($messages['input_pre_sizeWidth'], ENT_QUOTES); ?>"
                            class="input-size"
                        />
                        <?php if ($messages['input_error_sizeWidth'] !== '') { ?>
                            <div class="form-input-error">
                                <?php echo $messages['input_error_sizeWidth']; ?>
                            </div>
                        <?php } ?>
                        <span class="size-separator">×</span>
                        <input
                            type="number"
                            name="sizeHeight"
                            step="0.01"
                            min="0"
                            value="<?php echo htmlspecialchars($messages['input_pre_sizeHeight'], ENT_QUOTES); ?>"
                            class="input-size"
                        />
                        <?php if ($messages['input_error_sizeHeight'] !== '') { ?>
                            <div class="form-input-error">
                                <?php echo $messages['input_error_sizeHeight']; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-input-title">Engine Type（エンジン）</div>
                    <input
                        type="text"
                        name="engineType"
                        maxlength="50"
                        value="<?php echo htmlspecialchars($messages['input_pre_engineType'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_engineType'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_engineType']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Displacement（排気量） 【cc】)</div>
                    <input
                        type="number"
                        name="displacement"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($messages['input_pre_displacement'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_displacement'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_displacement']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Fuel Economy（燃費） 【km/L】</div>
                    <input
                        type="number"
                        name="fuelEconomy"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($messages['input_pre_fuelEconomy'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_fuelEconomy'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_fuelEconomy']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Electricity Cost（電費）※Only EV 【km/kWh】</div>
                    <input
                        type="number"
                        name="electrisityCost"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars($messages['input_pre_electrisityCost'], ENT_QUOTES); ?>"
                        class="input-general"
                    />
                    <?php if ($messages['input_error_electrisityCost'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_electrisityCost']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Description（詳細）</div>
                    <textarea name="description" class="input-message"><?php echo htmlspecialchars($messages['input_pre_description'], ENT_QUOTES); ?></textarea>
                    <?php if ($messages['input_error_description'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_description']; ?>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="action_type" value="insert" />

                    <div class="form-input-title">Official HP Link</div>
                    <input
                        type="url"
                        name="hp"
                        maxlength="255"
                        value="<?php echo htmlspecialchars($messages['input_pre_hp'], ENT_QUOTES); ?>"
                        class="input-general"
                        placeholder="https://example.com"
                    />
                    <?php if ($messages['input_error_hp'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['input_error_hp']; ?>
                        </div>
                    <?php } ?>

                    <div class="form-input-title">Car Image</div>
                    <input
                        type="file"
                        name="carImage"
                        accept="image/*"
                        class="input-general"
                        id="carImage"
                        onchange="previewImage(event)"
                    />
                    <br>
                    <img id="imagePreview"/>
                    <button type="button" id="removeImageButton" onclick="removeImage()">Remove Image</button>

                    <button type="submit" class="input-submit-button">Registration</button>
                </form>
            </div>
        </section>

        <section id="car-info-list-section">
            <div class="page-cover">
                <button class="filter-toggle-btn" id="toggleFilterBtn">≡</button>

                <form method="GET" class="filter-form" id="filterForm">
                    <p><strong>メーカーを選択：</strong></p>
                    <div class="filter-form-check">
                        <?php
                            $selectedManufacturers = $_GET['manufacturer'] ?? [];
                            if (!is_array($selectedManufacturers)) {
                                $selectedManufacturers = [$selectedManufacturers];
                            }

                            $stmtMakers = $dbh->query("SELECT DISTINCT manufactureName FROM cars ORDER BY manufactureName ASC");
                            while ($row = $stmtMakers->fetch(PDO::FETCH_ASSOC)) {
                                $name = htmlspecialchars($row['manufactureName']);
                                $checked = in_array($row['manufactureName'], $selectedManufacturers) ? 'checked' : '';
                                echo "<label><input type='checkbox' name='manufacturer[]' value='$name' $checked> $name</label>";
                            }
                        ?>
                    </div>
                    <hr class="page-divider" />
                    <button type="submit">検索</button>
                </form>

                <?php
                    $selectedManufacturers = $_GET['manufacturer'] ?? [];

                    if (!is_array($selectedManufacturers)) {
                        $selectedManufacturers = [$selectedManufacturers];
                    }

                    if (!empty($selectedManufacturers)) {
                        $placeholders = implode(',', array_fill(0, count($selectedManufacturers), '?'));
                        $sql = "SELECT * FROM cars WHERE manufactureName IN ($placeholders) ORDER BY manufactureName ASC";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute($selectedManufacturers);
                    } else {
                        $sql = "SELECT * FROM cars ORDER BY manufactureName ASC";
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
                            <div class="car-info-details" style="background-image: url('<?php echo htmlspecialchars($car['carImage']); ?>');">
                                <h3 class="card-maintitle"><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['model']); ?></h3>
                                <div class="car-details">
                                    <p><strong>Price：</strong> <?php echo number_format($car['price']); ?> YEN</p>
                                    <p><strong>Size (L×W×H) 【mm】 ：</strong>
                                        <?php
                                            echo number_format($car['sizeLength']) . '×' .
                                            number_format($car['sizeWidth']) . '×' .
                                            number_format($car['sizeHeight']);
                                        ?>
                                    </p>
                                    <p><strong>Engine Type：</strong> <?php echo htmlspecialchars($car['engineType'] ?? 'Not Clear'); ?></p>
                                    <p><strong>Displacement：</strong> <?php echo htmlspecialchars($car['displacement'] ?? 'Not Clear'); ?> cc</p>
                                    <p><strong>Fuel Economy：</strong> <?php echo htmlspecialchars($car['fuelEconomy'] ?? 'Not Clear'); ?> km/L</p>
                                    <p><strong>Electrisity Cost：</strong> <?php echo htmlspecialchars($car['electrisityCost'] ?? 'Not Clear'); ?> km/kWh</p>
                                    <p><strong>Description：</strong><br> <?php echo nl2br(htmlspecialchars($car['description'] ?? 'None')); ?></p>
                                    <p><strong>Official HP：</strong>
                                        <?php if (!empty($car['hp'])): ?>
                                            <a href="<?php echo htmlspecialchars($car['hp']); ?>" target="_blank" rel="noopener noreferrer">HP Link</a>
                                        <?php else: ?>
                                            なし
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <div class="card-buttons">
                                    <form method="get" action="update_car.php">
                                        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                                        <button type="submit" class="edit-button">Edit</button>
                                    </form>

                                    <form method="post" onsubmit="return confirm('本当に削除しますか？');">
                                        <input type="hidden" name="action_type" value="delete">
                                        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                                        <button type="submit" class="delete-button">Remove</button>
                                    </form>

                                    <form method="post" action="favorite_car.php">
                                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                        <button type="submit" class="favorite-button">Favorite</button>
                                    </form>

                                    <form method="post" action="compare_car/compare_car.php">
                                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                        <button type="submit" class="compare-button">Compare</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-cars-message">現在、掲載中の自動車はありません。</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="page-cover">
                <?php
                    $favCars = [];
                    if (!empty($_SESSION['favorites'])) {
                        $placeholders = implode(',', array_fill(0, count($_SESSION['favorites']), '?'));
                        $sqlFavs = "SELECT * FROM cars WHERE id IN ($placeholders)";
                        $stmtFavs = $dbh->prepare($sqlFavs);
                        $stmtFavs->execute($_SESSION['favorites']);
                        $favCars = $stmtFavs->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?>

                <h2 class="page-title">Favorites List</h2>
                <hr class="page-divider" />
                <div class="car-info-grid">
                    <?php if (!empty($favCars)): ?>
                        <?php foreach ($favCars as $car): ?>
                            <div class="car-info-details" style="background-image: url('<?php echo htmlspecialchars($car['carImage']); ?>');">
                                <h3 class="card-maintitle"><?php echo htmlspecialchars($car['manufactureName'] . ' ' . $car['model']); ?></h3>
                                <div class="car-details">
                                    <p><strong>Price：</strong> <?php echo number_format($car['price']); ?> YEN</p>
                                    <p><strong>Size (L×W×H) 【mm】 ：</strong>
                                        <?php
                                            echo number_format($car['sizeLength']) . '×' .
                                            number_format($car['sizeWidth']) . '×' .
                                            number_format($car['sizeHeight']);
                                        ?>
                                    </p>
                                    <p><strong>Engine Type：</strong> <?php echo htmlspecialchars($car['engineType'] ?? 'Not Clear'); ?></p>
                                    <p><strong>Displacement：</strong> <?php echo htmlspecialchars($car['displacement'] ?? 'Not Clear'); ?> cc</p>
                                    <p><strong>Fuel Economy：</strong> <?php echo htmlspecialchars($car['fuelEconomy'] ?? 'Not Clear'); ?> km/L</p>
                                    <p><strong>Electrisity Cost：</strong> <?php echo htmlspecialchars($car['electrisityCost'] ?? 'Not Clear'); ?> km/kWh</p>
                                    <p><strong>Description：</strong><br> <?php echo nl2br(htmlspecialchars($car['description'] ?? 'None')); ?></p>
                                    <p><strong>Official HP：</strong>
                                        <?php if (!empty($car['hp'])): ?>
                                            <a href="<?php echo htmlspecialchars($car['hp']); ?>" target="_blank" rel="noopener noreferrer">HP Link</a>
                                        <?php else: ?>
                                            なし
                                        <?php endif; ?>
                                </div>

                                <div class="card-buttons">
                                    <form method="post" action="unfavorite_car.php">
                                        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                                        <button type="submit" class="unfavorite-button">Remove</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-cars-message">お気に入り登録された車両はありません。</p>
                    <?php endif; ?>
                </div>
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