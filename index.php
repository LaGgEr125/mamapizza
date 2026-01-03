<?php
session_start();
require_once "include/database.php";

$title = 'Главная';
include("include/header.php");

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
            <img src="./assets/image/мамакоин.png" alt="" style="width: 50% !important;">
            <p>Мамакоины</p>
        </div>
        <div>
            <img src="./assets/image/price.png" alt="">
            <p>Призы</p>
        </div>
        <div>
            <img src="./assets/image/new.png" alt="">
            <p>Новинки</p>
        </div>
        <div>
            <img src="./assets/image/draw.png" alt="">
            <p>Розыгрышы</p>
        </div>
        <div>
            <img src="./assets/image/job.png" alt="">
            <p>Работа</p>
        </div>
    </div>
</section>

<section id="menuLinks">
    <div class="navbar-1" id="top-bar">
        <img src="./assets/image/логотип.png" class="navbar-logo">
        <div class="navbar-links">
            <a class="nav-button" href="#">Комбо</a>
            <a class="nav-button" href="#">Пиццы</a>
            <a class="nav-button" href="#">Закуски</a>
            <a class="nav-button" href="#">Напитки</a>
            <a class="nav-button" href="#">Десерты</a>
        </div>
        <div class="navbar-cart">
            <a href="javascript:void(0)" id="openCart" class="nav-cart-btn">Корзина</a>
        </div>
    </div>
</section>

<style>
    .navbar-1 {
        display: flex !important;
        align-items: center !important;
        gap: 20px !important;
        justify-content: space-between !important;
        padding: 15px 20px !important;
        background-color: rgba(255, 255, 255, 1) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        box-sizing: border-box !important;
    }

    .navbar-logo {
        height: 40px !important;
        flex-shrink: 0 !important;
    }

    .navbar-links {
        display: flex !important;
        gap: 15px !important;
        flex: 1 !important;
        justify-content: center !important;
    }

    .nav-button {
        text-decoration: none !important;
        color: #333 !important;
        font-weight: 500 !important;
        font-size: 16px !important;
        padding: 8px 12px !important;
        border-radius: 4px !important;
        transition: color 0.3s ease !important;
    }

    .nav-button:hover {
        color: #FF8904 !important;
    }

    .navbar-cart {
        flex-shrink: 0 !important;
    }

    .nav-cart-btn {
        display: inline-block !important;
        padding: 0.5rem 1.5rem !important;
        border-radius: 25px !important;
        background: #FF8904 !important;
        color: white !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
    }

    .nav-cart-btn:hover {
        background: #E67E00 !important;
        transform: translateY(-2px) !important;
    }

    @media (max-width: 768px) {
        .navbar-1 {
            flex-wrap: wrap !important;
            gap: 10px !important;
        }

        .navbar-links {
            width: 100% !important;
            order: 3 !important;
            justify-content: flex-start !important;
        }

        .navbar-logo {
            order: 1 !important;
        }

        .navbar-cart {
            order: 2 !important;
        }
    }
</style>

<div id="cartOffcanvas" class="offcanvas">
    <div class="offcanvas-overlay" id="closeCartOverlay"></div>
    <button class="offcanvas-external-close" id="closeCartBtnExtern">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2.5">
            <path d="M18 6L6 18M6 6l12 12" />
        </svg>
    </button>

    <div class="offcanvas-content">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title-main"><span id="offcanvasCartCount">0</span> товар(ов) на сумму <span
                    id="offcanvasCartTotal">0 ₽</span></h2>
        </div>

        <div class="offcanvas-body">
            <!-- Контент корзины заполняется JS через API -->
            <div id="offcanvasItemsPlaceholder" style="padding:20px;color:#666;">Загрузка...</div>
        </div>

        <div class="offcanvas-footer">
            <div class="promo-input-wrapper">
                <input type="text" placeholder="Промокод" class="promo-field">
            </div>

            <div class="summary-details">
                <div class="summary-line">
                    <span id="summaryCount">0 товаров</span>
                    <span id="summaryTotal">0 ₽</span>
                </div>
                <div class="summary-line coins-line">
                    <span>Начислим Мамакоинов <i class="info-icon">i</i></span>
                    <span class="coins-val">+ <span id="summaryCoins">0</span> <img src="./assets/image/мамакоин.png" alt="" style="width:20px"></span>
                </div>
            </div>

            <div class="final-sum">
                <span>Сумма заказа</span>
                <span id="finalSum">0 ₽</span>
            </div>

            <button class="checkout-btn" id="openCheckoutBtn">
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
                <img src="./assets/image/peperone.png" alt="">
            </div>
            <div>
                <p class="cart-order-name">Пеперони фреш</p>
                <p class="cart-order-price">от 289 ₽</p>
            </div>
        </div>
        <div class="cart-order">
            <div>
                <img src="./assets/image/sous.png" alt="">
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
                            <img src="./assets/image/<?php echo $row['img']; ?>" class="card-img-top"
                                alt="<?php echo $row['name']; ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>

                            <div class="card-bottom">
                                <h3 class="text-lg font-bold text-black/60">от <?php echo $row['price']; ?> ₽</h3>
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
                                <img class="modal-img" src="./assets/image/<?php echo $row['img']; ?>"
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
                                                <img src="./assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="./assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="./assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                            <div class="extra-card">
                                                <img src="./assets/image/cheese-border.png" alt="сырный бортик">
                                                <span class="extra-name">сырный бортик</span>
                                                <span class="extra-price">205 ₽</span>
                                                <button type="button" class="extra-add-btn" data-extra-price="205"></button>
                                                <div class="extra-check-icon"><i class="fas fa-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-fixed">
                                    <form method="POST" action="./api/cart.php?action=add" class="add-to-cart-form" data-close-modal="1">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="size" class="selected-size-input" value="30">
                                        <input type="hidden" name="dough" class="selected-dough-input" value="traditional">
                                        <input type="hidden" name="extras" class="selected-extras-input" value="">
                                        <input type="hidden" name="quantity" value="1">
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
    document.addEventListener('DOMContentLoaded', function() {
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
<?php include("include/footer.php"); ?>