<?php
    session_start();
    require_once(__DIR__ . '/../src/db_connect.php');

    if (isset($_POST['action_type']) && $_POST['action_type']) {
        if ($_POST['action_type'] === 'insert') {
            require(__DIR__ . '/../src/insert_car.php');
        }
    }
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
                <form action="add_car.php" method="post">
                        <div class="form-input-title">メーカー名 <small>(必須)</small></div>
                        <input
                            type="text"
                            name="manufacture_name"
                            maxlength="100"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-title">車種名 <small>(必須)</small></div>
                        <input
                            type="text"
                            name="model"
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
                            name="engine_type"
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
                            name="fuel_economy"
                            step="0.01"
                            min="0"
                            value=""
                            class="input-general"
                        />

                        <div class="form-input-error"></div>
                            <div class="form-input-title">詳細説明</div>
                                <textarea name="message" class="input-message"></textarea>
                            <div class="form-input-error"></div>
                            <input type="hidden" name="action_type" value="insert" />
                            <button type="submit" class="input-submit-button">登録する</button>
                    </form>
                </div>
                <hr class="page-divider" />
                <div class="message-list-cover">
                    </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p>&copy 2025 tech y.s</p>
        </footer>
    </body>
</html>