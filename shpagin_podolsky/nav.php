<ul class="nav nav-pills">
    <?php $current_page = $current_page ?? ''?>
    <li class="nav-item"><a href="/shpagin_podolsky/dictonary/view.php" class="nav-link <?= $current_page == "dictonary" ? "active" : "off" ?>">Справочники</a></li>
    <li class="nav-item"><a href="/shpagin_podolsky/sheta/view.php" class="nav-link <?= $current_page == "sheta" ? "active" : "off" ?>">Счета</a></li>
    <li class="nav-item"><a href="/shpagin_podolsky/klient/view.php" class="nav-link <?= $current_page == "klient" ? "active" : "off" ?>">Клиенты</a></li>
    <li class="nav-item"><a href="/shpagin_podolsky/oper_klient/view.php" class="nav-link <?= $current_page == "oper_klient" ? "active" : "off" ?>">Операции</a></li>
    <li class="nav-item"><a href="/shpagin_podolsky/admin/administration.php" class="nav-link <?= $current_page == "administration" ? "active" : "off" ?>">Админ панель</a></li>
</ul>