<?php

$page_courante = basename($_SERVER['PHP_SELF']);
?>
<header class="header">
  <nav class="nav container">
    <a href="index.php" class="nav__logo">PAT<span class="accent">.</span></a>
    <ul class="nav__links">
      <li>
        <a href="index.php"
           class="nav__link <?php if ($page_courante === 'index.php') echo 'active'; ?>">
          Accueil
        </a>
      </li>
      <li>
        <a href="projets.php"
           class="nav__link <?php if ($page_courante === 'projets.php') echo 'active'; ?>">
          Projets
        </a>
      </li>
      <li>
        <a href="about.php"
           class="nav__link <?php if ($page_courante === 'about.php') echo 'active'; ?>">
          À propos
        </a>
      </li>
      <li>
        <a href="contact.php"
           class="nav__link <?php if ($page_courante === 'contact.php') echo 'active'; ?>">
          Contact
        </a>
      </li>
    </ul>
  </nav>
</header>
