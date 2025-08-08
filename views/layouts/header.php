<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Maquette Tp2</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../public/css/style.css" />
  </head>
  <body>
    <header class="header__container">
      <nav class="header__nav-secondaire">
        <ul class="header__nav-secondaire-list">
          <li>
            <form action="#" method="get">
              <label for="monnaie" class="masquer">Monnaie</label>
              <select name="monnaie" id="monnaie">
                <option value="CAD">CAD</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
              </select>
              <button type="submit" class="masquer">Changer</button>
            </form>
          </li>
          <li>
            <form action="#" method="get">
              <label for="langue" class="masquer">Langue</label>
              <select name="langue" id="langue">
                <option value="fr">Fr</option>
                <option value="en">En</option>
                <option value="es">Es</option>
              </select>
              <button type="submit" class="masquer">Changer</button>
            </form>
          </li>
          <li>
            <a href="#">Nous contactez</a>
          </li>
        </ul>
      </nav>
      <nav class="header__nav-principale">
        <picture class="header__logo-container">
          <a href="{{ base }}/">
            <img
              src="../public/images/logo-stampee.webp"
              alt="logo-stampee"
              class="header__logo"
            />
          </a>
        </picture>
        <picture class="header__menuHamburger-container">
          <img
            src="../public/images/menu-hamburger.webp"
            alt="menu-hamburger-icone"
          />
        </picture>
        <div class="header__recherche">
          <form class="recherche__formulaire">
            <label for="recherche" class="masquer">Recherche</label>
            <input
              type="text"
              class="recherche__champ"
              placeholder="Quel timbre cherchez-vous ?"
              id="recherche"
              name="recherche"
            />
            <button type="submit" class="recherche__bouton">
              <img
                src="../public/images/loupe.webp"
                alt="icone-loupe-recherche"
              />
            </button>
          </form>
        </div>
        {% if session.id_role != null %}
        <a href="{{ base }}/deconnexion" class="header__connexion">Déconnecté</a>
        {% else %}
        <a href="{{ base }}/connexion" class="header__connexion">Connecter</a>
        {% endif %}
        <a href="{{ base }}/inscription" class="header__connexion">S'inscrire</a>
        <picture class="header__alarme-container">
            <a href="{{ base }}/profil">
          <img
            src="../public/images/profilIcone.png"
            alt="Profil"
            class="header__alarme"
          />
          </a>
        </picture>
      </nav>
    </header>