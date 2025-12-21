<?php
include("include/header.php");
// include("include/functions.php");
// include("include/database.php");
// $goida_array = GetAllProducts($conn);
// var_dump($goida_array);
?>
<?php
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
        <div class="nav-btn" >
            <a href="" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" id="openCart">Корзина</a>
        </div>
    </div>
</section>

    <div id="cartOffcanvas" class="offcanvas">
        <div class="offcanvas-overlay" id="closeCart"></div>
        <div class="offcanvas-content">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title">
                    <i class="fas fa-shopping-cart"></i> Корзина
                </h2>
                <button class="offcanvas-close" id="closeCartBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="offcanvas-body">
                <div class="cart-summary">
                    <div class="cart-items-count">
                        <span id="offcanvasCartCount">1</span> товар на сумму <span id="offcanvasCartTotal">1 039 ₽</span>
                    </div>
                    
                    <div class="cart-items-list">
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <h4>2 пиццы</h4>
                                <div class="cart-item-details">
                                    <div class="cart-item-name">Пепперони фреш</div>
                                    <div class="cart-item-description">30 см, традиционное тесто 30, 520 г</div>
                                    <div class="cart-item-name">Сырная</div>
                                    <div class="cart-item-description">30 см, традиционное тесто 30, 520 г</div>
                                </div>
                            </div>
                            <div class="cart-item-price">
                                <div class="price-old">1468 ₽</div>
                                <div class="price-current">1319 ₽</div>
                                <button class="change-item">Изменить</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add-to-order">
                        <h3><i class="fas fa-plus-circle"></i> Добавить к заказу?</h3>
                        <div class="addons">
                            <div class="addon-item">
                                <div class="addon-info">
                                    <h4>Соусы</h4>
                                    <p>Злой кола от 150 ₽</p>
                                </div>
                                <button class="add-addon">+</button>
                            </div>
                        </div>
                        
                        <div class="promo-code">
                            <h4><i class="fas fa-tag"></i> Промокод</h4>
                            <div class="promo-input">
                                <input type="text" placeholder="Введите промокод">
                                <button>Применить</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <span><span id="summaryItemsCount">1</span> товар</span>
                            <span id="summaryItemsPrice">1 039 ₽</span>
                        </div>
                        <div class="summary-row coins">
                            <span>Начислим Мамакоинов <i class="fas fa-coins"></i></span>
                            <span class="coins-amount">+ 52 <i class="fas fa-smile"></i></span>
                        </div>
                        <div class="summary-row total">
                            <span>Сумма заказа</span>
                            <span id="summaryTotalPrice">1 039 ₽</span>
                        </div>
                    </div>
                    
                    <button class="checkout-button">
                        К оформлению заказа <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
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
                        <button class="close" onclick="<?php echo $dialogModal; ?>.close()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <div class="modal-container">
                            <div class="modal-left">
                                <img class="modal-img" src="assets/image/<?php echo $row['img']; ?>"
                                    alt="<?php echo $row['name']; ?>">
                            </div>

                            <div class="modal-right">
                                <div class="modal-content">
                                    <h2 class="modal-title"><?php echo $row['name']; ?></h2>
                                    <div class="modal-description">
                                        <p class="card-text"><?php echo $row['description']; ?></p>
                                        <p class="pizza-info">30 см, традиционное тесто, 530 г</p>
                                    </div>

                                    <div class="modal-size-options">
                                        <h4>Размер пиццы:</h4>
                                        <div class="size-buttons">
                                            <button type="button" class="size-btn" data-size="20" data-price="379">20 см</button>
                                            <button type="button" class="size-btn" data-size="25" data-price="429">25 см</button>
                                            <button type="button" class="size-btn active" data-size="30" data-price="479">30
                                                см</button>
                                            <button type="button" class="size-btn" data-size="35" data-price="529">35 см</button>
                                        </div>
                                    </div>

                                    <div class="modal-dough-options">
                                        <h4>Тесто:</h4>
                                        <div class="dough-buttons">
                                            <button type="button" class="dough-btn active" data-dough="traditional"
                                                data-price-modifier="0">Традиционное</button>
                                            <button type="button" class="dough-btn" data-dough="thin"
                                                data-price-modifier="0">Тонкое</button>
                                        </div>
                                    </div>

                                    <div class="modal-extras">
                                        <h4>Добавить по вкусу:</h4>
                                        <div class="extras-grid">
                                            <div class="extra-item">
                                                <div class="extra-info">
                                                    <span class="extra-name">сырный бортик</span>
                                                    <span class="extra-price">205 ₽</span>
                                                </div>
                                                <button type="button" class="extra-add-btn" data-extra-price="205">+</button>
                                            </div>
                                            <div class="extra-item">
                                                <div class="extra-info">
                                                    <span class="extra-name">сырный бортик</span>
                                                    <span class="extra-price">205 ₽</span>
                                                </div>
                                                <button type="button" class="extra-add-btn" data-extra-price="205">+</button>
                                            </div>
                                            <div class="extra-item">
                                                <div class="extra-info">
                                                    <span class="extra-name">сырный бортик</span>
                                                    <span class="extra-price">205 ₽</span>
                                                </div>
                                                <button type="button" class="extra-add-btn" data-extra-price="205">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <form method="POST" action="cart.php" class="add-to-cart-form">
                                            <input type="hidden" name="action" value="add">
                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="size" id="selected-size" value="30">
                                            <input type="hidden" name="dough" id="selected-dough" value="traditional">
                                            <input type="hidden" name="extras" id="selected-extras" value="">

                                            <div class="quantity-price-wrapper">
                                                <div class="quantity-control">
                                                    <button type="button" class="quantity-btn minus">-</button>
                                                    <input type="number" name="quantity" value="1" min="1" class="quantity-input"
                                                        id="quantity-input">
                                                    <button type="button" class="quantity-btn plus">+</button>
                                                </div>
                                                <div class="price-wrapper">
                                                    <span class="total-price" id="total-price">479 ₽</span>
                                                </div>
                                            </div>

                                            <button type="submit" class="add-to-cart-btn">
                                                В корзину за <span class="cart-price" id="cart-price">479 ₽</span>
                                            </button>
                                        </form>
                                    </div>
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