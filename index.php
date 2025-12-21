<?php
$title = 'Главная';
include("include/header.php");
// include("include/functions.php");
// include("include/database.php");
// $goida_array = GetAllProducts($conn);
// var_dump($goida_array);
session_start();
require_once "include/database.php";

$sql = "SELECT * FROM goods ORDER BY category";
$result = $mysqli->query($sql);

$goodsByCategory = [
    'kombo' => [],
    'pizza' => [],
    'snacks' => [],
    'drinks' => [],
    'desserts' => []
];

while ($row = $result->fetch_assoc()) {
    $goodsByCategory[$row['category']][] = $row;
}
?>

<section>
    <div class="cart-stock">
        <div>
            <img src="assets/image/мамакоин.png" alt="" style="width: 50% !important;">
            <p>Мамакоины</p>
        </div>
        <div>
            <img src="assets/image/price.png" alt="">
            <p>Призы</p>
        </div>
        <div>
            <img src="assets/image/new.png" alt="">
            <p>Новинки</p>
        </div>
        <div>
            <img src="assets/image/draw.png" alt="">
            <p>Розыгрышы</p>
        </div>
        <div>
            <img src="assets/image/job.png" alt="">
            <p>Работа</p>
        </div>
    </div>
</section>

<section id="menuLinks">
    <div class="navbar-1" id="top-bar">
        <img src="assets/image/логотип.png">
        <a class="nav-button" href="#">Комбо</a>
        <a class="nav-button" href="#">Пиццы</a>
        <a class="nav-button" href="#">Закуски</a>
        <a class="nav-button" href="#">Напитки</a>
        <a class="nav-button" href="#">Десерты</a>
        <div class="nav-btn">
            <a href="" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                aria-controls="staticBackdrop" id="openCart">Корзина</a>
        </div>
    </div>
</section>

<div id="cartOffcanvas" class="offcanvas">
    <div class="offcanvas-overlay" id="closeCartOverlay"></div>
    <button class="offcanvas-external-close" id="closeCartBtnExtern">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2.5">
            <path d="M18 6L6 18M6 6l12 12" />
        </svg>
    </button>

    <div class="offcanvas-content">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title-main"><span id="offcanvasCartCount">1</span> товар на сумму <span
                    id="offcanvasCartTotal">1 039 ₽</span></h2>
        </div>

        <div class="offcanvas-body">
            <div class="cart-card">
                <div class="cart-card-main">
                    <img src="img/pizzas.png" alt="пиццы" class="cart-card-img">
                    <div class="cart-card-info">
                        <div class="cart-card-header">
                            <h3>2 пиццы</h3>
                            <button class="remove-item">✕</button>
                        </div>
                        <p class="cart-card-desc">Пепперони фреш<br>30 см, традиционное тесто 30, 520 г</p>
                        <p class="cart-card-desc">Сырная<br>30 см, традиционное тесто 30, 520 г</p>

                        <div class="cart-card-footer">
                            <div class="cart-card-prices">
                                <span class="price-actual">1319 ₽</span>
                                <span class="price-old">1468 ₽</span>
                            </div>
                            <div class="cart-card-controls">
                                <button class="change-btn">Изменить</button>
                                <div class="quantity-pill">
                                    <button class="q-minus">−</button>
                                    <span class="q-num">1</span>
                                    <button class="q-plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-more-section">
                <h3>Добавить к заказу?</h3>
                <div class="add-more-grid">
                    <div class="add-card">
                        <img src="img/sauce.png" alt="">
                        <span>Соусы</span>
                    </div>
                    <div class="add-card add-card-wide">
                        <img src="img/cola.png" alt="">
                        <div class="add-card-text">
                            <span>Злой кола</span>
                            <small>от 150 ₽</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="offcanvas-footer">
            <div class="promo-input-wrapper">
                <input type="text" placeholder="Промокод" class="promo-field">
            </div>

            <div class="summary-details">
                <div class="summary-line">
                    <span>1 товар</span>
                    <span>1 039 ₽</span>
                </div>
                <div class="summary-line coins-line">
                    <span>Начислим Мамакоинов <i class="info-icon">i</i></span>
                    <span class="coins-val">+ 52 <img src="img/coin.png" alt=""></span>
                </div>
            </div>

            <div class="final-sum">
                <span>Сумма заказа</span>
                <span>1 039 ₽</span>
            </div>

            <button class="checkout-btn">
                К оформлению заказа <span class="arrow">›</span>
            </button>
        </div>
    </div>
</div>

<section>
    <p class="orders">Часто заказывают</p>
    <div class="cart-orders">
        <div class="cart-order">
            <div>
                <img src="assets/image/peperone.png" alt="">
            </div>
            <div>
                <p class="cart-order-name">Пеперони фреш</p>
                <p class="cart-order-price">от 289 ₽</p>
            </div>
        </div>
        <div class="cart-order">
            <div>
                <img src="assets/image/sous.png" alt="">
            </div>
            <div>
                <p class="cart-order-name">2 соуса</p>
                <p class="cart-order-price">от 75 ₽</p>
            </div>
        </div>
    </div>
</section>

<section>
    <?php
    $categoryTitles = [
        'kombo' => 'Комбо',
        'pizza' => 'Пицца',
        'snacks' => 'Закуски',
        'drinks' => 'Напитки',
        'desserts' => 'Десерты'
    ];

    foreach ($goodsByCategory as $category => $items):
        if (!empty($items)):
            ?>
            <h2 class="category"><?php echo $categoryTitles[$category]; ?></h2>
            <hr class="category-hr">
            <div class="con">
                <?php foreach ($items as $row):
                    $dialogModal = $row['name'] . $row['id'];
                    $dialogModal = str_replace(' ', '', $dialogModal);
                    ?>
                    <div class="card">
                        <?php if (!empty($row['special_tag'])): ?>
                            <div class="card-badge"><?php echo $row['special_tag']; ?></div>
                        <?php endif; ?>
                        <div class="card-img">
                            <img src="assets/image/<?php echo $row['img']; ?>" class="card-img-top"
                                alt="<?php echo $row['name']; ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>

                            <div class="card-bottom">
                                <h3 class="card-price">от <?php echo $row['price']; ?> ₽</h3>
                                <button class="card-button" onclick="<?php echo $dialogModal; ?>.showModal()">Выбрать</button>
                            </div>
                        </div>
                    </div>

                    <dialog class="dialog-wrapper" id="<?php echo $dialogModal; ?>">
                        <button class="modal-close-btn" onclick="<?php echo $dialogModal; ?>.close()">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="modal-container">
                            <div class="modal-left">
                                <img class="modal-img" src="assets/image/<?php echo $row['img']; ?>"
                                    alt="<?php echo $row['name']; ?>">
                            </div>

                            <div class="modal-right">
                                <div class="modal-scrollable-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title"><?php echo $row['name']; ?> <span class="spicy-icon">🌶️</span></h2>
                                        <p class="modal-info">30 см, традиционное тесто 30, 530 г</p>
                                        <p class="modal-description"><?php echo $row['description']; ?></p>
                                    </div>

                                    <div class="modal-options-block">
                                        <div class="pill-switch-group">
                                            <button type="button" class="pill-btn" data-size="20" data-price="379">20 см</button>
                                            <button type="button" class="pill-btn" data-size="25" data-price="429">25 см</button>
                                            <button type="button" class="pill-btn active" data-size="30" data-price="479">30
                                                см</button>
                                            <button type="button" class="pill-btn" data-size="35" data-price="529">35 см</button>
                                        </div>
                                        <div class="pill-switch-group mt-3">
                                            <button type="button" class="pill-btn active"
                                                data-dough="traditional">Традиционное</button>
                                            <button type="button" class="pill-btn" data-dough="thin">Тонкое</button>
                                        </div>
                                    </div>

                                    <div class="modal-extras-block">
                                        <h4 class="extras-title">Добавить по вкусу</h4>
                                        <div class="extras-grid">
                                            <div class="extra-card">
                                                <img src="assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-fixed">
                                    <form method="POST" action="cart.php" class="add-to-cart-form">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="size" class="selected-size-input" value="30">
                                        <input type="hidden" name="dough" class="selected-dough-input" value="traditional">
                                        <input type="hidden" name="extras" class="selected-extras-input" value="">

                                        <button type="submit" class="add-to-cart-main-btn">
                                            В корзину за <span class="total-price-display">479 ₽</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </dialog>
                <?php endforeach; ?>
            </div>
            <?php
        endif;
    endforeach;
    ?>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('top-bar');
        const menuLinksSection = document.getElementById('menuLinks');

        function handleScroll() {
            const scrollPosition = window.scrollY;
            const menuLinksOffset = menuLinksSection.offsetTop;

            if (scrollPosition > menuLinksOffset) {
                navbar.classList.add('fixed', 'scrolled');
            } else {
                navbar.classList.remove('fixed', 'scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll);

        handleScroll();
    });
</script>
<?php
include("include/footer.php");
?>