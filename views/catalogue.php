{{ include('layouts/header.php', { title: 'Catalogue' }) }}

<h1 class="h1-accueil">Catalogue des enchères</h1>

<form method="get" action="" class="filter-form">
  <label for="filtre">Trier par :</label>
  <select name="filtre" id="filtre" onchange="this.form.submit()">
    <option value="">-- Choisir --</option>
    <option value="">Tous</option>
    <option value="coupdecoeur">Coup de cœur du Lord</option>
    <option value="prixasc">Prix croissant</option>
    <option value="prixdesc">Prix décroissant</option>
    <option value="date">Date d'enchère</option>
    <option value="favoris">Favoris</option>
  </select>
</form>

<section class="grille">
    {% for enchere in encheres %}
    <article class="carte">
        <img src="public/{{ enchere.image_principale }}" alt="{{ enchere.nom }}" class="carte__image">
        <div class="carte__contenu">
            <h2>{{ enchere.nom }}</h2>
            <ul class="carte__infos">
                <li><span class="carte__infos-titre">Prix de départ :</span> <span class="carte__infos-valeur">{{ enchere.prix_plancher }} $</span></li>
                <li><span class="carte__infos-titre">Début :</span> <span class="carte__infos-valeur">{{ enchere.date_debut|date('d/m/Y H:i') }}</span></li>
                <li><span class="carte__infos-titre">Fin :</span> <span class="carte__infos-valeur">{{ enchere.date_fin|date('d/m/Y H:i') }}</span></li>
            </ul>

            <div class="carte__footer">
                {% if enchere.coup_de_coeur_lord %}
                    <span class="carte__infos-titre"> Coup de cœur 💖</span>
                    <br>
                {% endif %}
                <a class="card__btn carte__infos-valeur" href="{{ base }}/enchere?id={{ enchere.id_enchere }}">Voir l'enchère</a>
            </div>
        </div>
    </article>
    {% endfor %}
</section>

{{ include('layouts/footer.php', { title: 'Catalogue' }) }}