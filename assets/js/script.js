    // Получаем элемент навигационной панели
    const navbar = document.getElementById('top-bar');
    
    // Порог прокрутки для фиксации (можно настроить)
    const scrollThreshold = 100;
    
    // Функция для обработки прокрутки
    function handleScroll() {
        if (window.pageYOffset > scrollThreshold) {
            // Добавляем класс fixed при прокрутке
            navbar.classList.add('fixed');
        } else {
            // Убираем класс fixed когда вверху страницы
            navbar.classList.remove('fixed');
        }
    }
    
    // Вешаем обработчик события прокрутки
    window.addEventListener('scroll', handleScroll);
    
    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        handleScroll();
    });