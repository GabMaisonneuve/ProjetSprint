{{ include('layouts/header.php', { title: 'Accueil' }) }}



<!-- {% if session is defined %}
    <p>Bienvenue {{ session.nom_utilisateur }} !</p>
{% else %}
    <p>Bienvenue invité !</p>
{% endif %} -->

{% if message %}
    <div class="message">{{ message }}</div>
{% endif %}

<section class="hero" style="background-image: url('{{ base }}/public/images/hero.jpg');">
  <div class="hero__overlay">
    <div class="hero__content">
      <h1>Bienvenue sur <span>Lord Reginald Stampee</span></h1>
      <p>
        Découvrez un univers unique dédié à la passion philatélique.  
        Explorez des timbres rares, enchérissez sur vos coups de cœur et partagez votre amour de la collection avec une communauté de passionnés.  
      </p>
      <p>
        Que vous soyez amateur ou collectionneur averti, chaque enchère est une occasion de trouver la pièce qui complétera votre collection.
      </p>
    </div>
  </div>
</section>

<h1 class="h1-accueil">Les Coups de cœurs du Lord</h1>
<section class="section__container">

  <div class="coups-coeur__contenu">
    <div class="coups-coeur__texte">
      <p>
        Découvrez la sélection exclusive des <strong>Coups de cœur du Lord</strong>, 
        soigneusement choisis pour leur rareté, leur beauté et leur valeur.  
        Chaque timbre mis en avant reflète une histoire unique et un caractère singulier.  
        Laissez-vous inspirer par ces trésors philatéliques.
      </p>
    </div>

    {% if coups_de_coeur|length > 0 %}
    <div class="carousel grille">
      {% for enchere in coups_de_coeur %}
      <div class="carousel-item carte">
        <img src="public/{{ enchere.image_principale }}" alt="{{ enchere.nom }}">
        <div class="carousel-caption carte__contenu">
          <ul class="carte__infos">
            <li><span class="carte__infos-titre">Titre :</span> <span class="carte__infos-valeur">{{ enchere.nom }}</span></li>
            <li><span class="carte__infos-titre">Prix Actuel :</span> <span class="carte__infos-valeur">{{ enchere.prix_actuel }} $</span></li>
          </ul>

          <div class="carte__footer">
            <a class="card__btn carte__infos-valeur" href="{{ base }}/enchere?id={{ enchere.id_enchere }}">Voir l'enchère</a>
          </div>
        </div>
      </div>
      {% endfor %}
    </div>
    {% else %}
    <p>Aucun coup de cœur pour le moment.</p>
    {% endif %}
  </div>
</section>



<script src="{{ base }}/public/js/carrousel.js"></script>
{{ include('layouts/footer.php', { title: 'Accueil' }) }}