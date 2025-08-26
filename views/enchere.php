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
          Enchère actuelle: 
          <span class="enchere__information--reponse">{{ currentBid }} $</span>
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
        <form action="{{ base }}/enchere?id={{ enchere.id_enchere }}" method="POST" class="enchere__form">
          <label for="montant" class="masquer">Encherir</label>
          <input type="number" name="montant" min="{{ enchere.prix_plancher }}" required id="montant">
          <button type="submit" class="card__btn">Placer une enchère</button>
        </form>
        {% if erreurs %}
        <div class="errors">
          {% for erreur in erreurs %}
            <p>{{ erreur }}</p>
          {% endfor %}
        </div>
        {% endif %}

        {% if success %}
        <div class="success">
          <p>{{ success }}</p>
        </div>
        {% endif %}

        <a class="btn btn-primary" 
          href="{{ base }}/detail?id={{ enchere.id_timbre }}&id_enchere={{ enchere.id_enchere }}">
          Voir les détails du timbre
        </a>



   {% if session.id_membre %}
  <button id="favorite-btn" class="btn btn-primary">
    <span id="favorite-text">
      {% if enchere.id_enchere in favoris_ids %}
        Retirer des favoris
      {% else %}
        Ajouter aux favoris
      {% endif %}
    </span>
  </button>
{% endif %}

      </div>
    </div>
  </div>
</article>

<script>
const ENCHERE_ID = '{{ enchere.id_enchere }}';
const USER_ID = '{{ session.id_membre }}';
const BASE_URL = '{{ base }}';

document.addEventListener('DOMContentLoaded', () => {
    const favoriteBtn = document.getElementById('favorite-btn');
    const favoriteText = document.getElementById('favorite-text');

    if (!favoriteBtn) return;

    favoriteBtn.addEventListener('click', () => {
        fetch(`${BASE_URL}/favoris/toggle?id=${ENCHERE_ID}`, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (data.added) {
                    favoriteBtn.classList.add('favorited');
                    favoriteText.textContent = 'Retirer des favoris';
                } else if (data.removed) {
                    favoriteBtn.classList.remove('favorited');
                    favoriteText.textContent = 'Ajouter aux favoris';
                }
            })
            .catch(err => console.error(err));
    });
});
</script>

{{ include('layouts/footer.php', { title: 'Enchere' }) }}