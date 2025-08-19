{{ include('layouts/header.php', { title: 'Enchere' }) }}


<h1 class="enchere__titre">{{ enchere.nom }}</h1>

<article class="enchere">
  <div class="enchere__conteneur">
    <!-- Côté gauche, image principale -->
    <div class="enchere__gauche">
      <div class="enchere__image-container">
        <picture class="enchere__image">
          <img src="public/{{ enchere.image_principale }}" alt="{{ enchere.nom }}">
        </picture>
        {% if enchere.images_secondaires is defined %}
          <div class="enchere__thumbnails">
            {% for img in enchere.images_secondaires %}
              <img src="public/{{ img.url_image }}" alt="Détail {{ loop.index }}" class="enchere__thumbnail">
            {% endfor %}
          </div>
        {% endif %}
      </div>
    </div>

    <!-- Côté droit, mise  -->
    <div class="enchere__droit">
      <div class="enchere__detail">
        <p class="enchere__information">
          Prix de départ: 
          <span class="enchere__information--reponse">{{ enchere.prix_plancher }} $</span>
        </p>
        <p class="enchere__information">
          Début: 
          <span class="enchere__information--reponse">{{ enchere.date_debut|date('d/m/Y H:i') }}</span>
        </p>
        <p class="enchere__information">
          Fin: 
          <span class="enchere__information--reponse">{{ enchere.date_fin|date('d/m/Y H:i') }}</span>
        </p>
      </div>

      <div class="enchere__information__conteneur">
        <form action="{{ base }}/enchere/{{ enchere.id_enchere }}/miser" method="POST" class="enchere__form">
          <label for="montant" class="masquer">Encherir</label>
          <input type="number" name="montant" min="{{ enchere.prix_plancher }}" required id="montant">
          <button type="submit" class="card__btn">Placer une enchère</button>
        </form>
      </div>
    </div>
  </div>
</article>

{{ include('layouts/footer.php', { title: 'Enchere' }) }}