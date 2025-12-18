<?php
include("include/header.php");
// include("include/functions.php");
// include("include/database.php");
// $goida_array = GetAllProducts($conn);
// var_dump($goida_array);
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
    </div>
</section>

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
<?php
include("include/footer.php");
?>