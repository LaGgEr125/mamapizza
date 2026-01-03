<?php
$title = "Аккаунт";
include("include/header.php");
?>
<main class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, rgba(255,137,4,0.06) 0%, rgba(255,137,4,0.02) 50%, rgba(255,137,4,0.01) 100%);">
  <div class="w-full max-w-md mx-4">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
      <div class="h-2" style="background: linear-gradient(90deg, rgba(255,137,4,1), rgba(255,137,4,0.85));"></div>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Вход / Регистрация</h1>

        <div id="authError" class="hidden text-sm text-red-600 mb-4"></div>

        <div class="flex gap-2 mb-6">
          <button id="showLogin" class="flex-1 py-2 rounded-md bg-brand text-black font-semibold">Войти</button>
          <button id="showRegister" class="flex-1 py-2 rounded-md border border-gray-200 text-gray-700">Зарегистрироваться</button>
        </div>

        <form id="loginForm" class="space-y-4">
          <input name="phone" type="text" placeholder="Телефон" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
          <input name="password" type="password" placeholder="Пароль" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
          <div class="flex items-center justify-between">
            <button type="submit" class="bg-brand text-black px-4 py-2 rounded-md font-semibold">Войти</button>
            <a href="#" id="toRegister" class="text-sm text-brand">Нет аккаунта?</a>
          </div>
        </form>

        <form id="registerForm" class="hidden space-y-4">
          <input name="phone" type="text" placeholder="Телефон" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
          <input name="password" type="password" placeholder="Пароль" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
          <input name="email" type="email" placeholder="Email (опционально)" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
          <div class="flex items-center justify-end">
            <button type="submit" class="bg-brand text-black px-4 py-2 rounded-md font-semibold">Создать аккаунт</button>
          </div>
        </form>

      </div>
      <div class="p-4 bg-gray-50 text-center text-sm text-gray-600">
        Нажимая "Создать аккаунт" вы соглашаетесь с условиями.
      </div>
    </div>
  </div>
</main>

<script>
(function(){
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const showLogin = document.getElementById('showLogin');
  const showRegister = document.getElementById('showRegister');
  const toRegister = document.getElementById('toRegister');
  const authError = document.getElementById('authError');

  function show(form){
    if(form==='login'){ loginForm.classList.remove('hidden'); registerForm.classList.add('hidden'); }
    else { loginForm.classList.add('hidden'); registerForm.classList.remove('hidden'); }
  }

  showLogin.addEventListener('click', ()=> show('login'));
  showRegister.addEventListener('click', ()=> show('register'));
  toRegister.addEventListener('click', (e)=>{ e.preventDefault(); show('register'); });

  function showError(msg){
    authError.textContent = msg;
    authError.classList.remove('hidden');
  }

  async function postJSON(url, formData){
    const res = await fetch(url, { method: 'POST', body: formData });
    return res.json();
  }

  loginForm.addEventListener('submit', async function(e){
    e.preventDefault();
    authError.classList.add('hidden');
    const fd = new FormData(this);
    fd.append('action','login');
    try {
      const j = await postJSON('./api/auth.php', fd);
      if (j.success) window.location.href = './index.php';
      else showError(j.message || 'Ошибка входа');
    } catch (err) { showError('Ошибка сети'); }
  });

  registerForm.addEventListener('submit', async function(e){
    e.preventDefault();
    authError.classList.add('hidden');
    const fd = new FormData(this);
    fd.append('action','register');
    try {
      const j = await postJSON('./api/auth.php', fd);
      if (j.success) window.location.href = './index.php';
      else showError(j.message || 'Ошибка регистрации');
    } catch (err) { showError('Ошибка сети'); }
  });
})();
</script>

<?php include("include/footer.php"); ?>