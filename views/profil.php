{{ include('layouts/header.php', { title: 'Profil' }) }}

{% if session.nom_utilisateur is defined %}
<h1 class="profil-h1">Profil de {{ utilisateur.nom_utilisateur }}</h1>
<h2 class="profil-h2">Informations personnelles</h2>

<div class="infos-profil">
    <div class="info-profil">
        <span class="label">Nom d'utilisateur :</span>
        <span class="value">{{ utilisateur.nom_utilisateur }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Prénom :</span>
        <span class="value">{{ utilisateur.prenom }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Nom :</span>
        <span class="value">{{ utilisateur.nom }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Courriel :</span>
        <span class="value">{{ utilisateur.courriel }}</span>
    </div>
    <div class="boutons">
        <a href="{{ base }}/supprimer?id={{ utilisateur.id_membre }}" class="btn btn__supprimer">Supprimer</a>
        <a href="{{ base }}/profil_edit?id={{ utilisateur.id_membre }}" class="btn btn__modifier">Modifier</a>
    </div>
</div>

{% if favoris is defined and favoris|length > 0 %}
<h2 class="profil-h2">Mes favoris</h2>

<section class="grille">
    {% for enchere in favoris %}
    <article class="carte">
        <img src="public/{{ enchere.image_principale }}" alt="{{ enchere.nom }}" class="carte__image">
        <div class="carte__contenu">
            <h2>{{ enchere.nom }}</h2>
            <ul class="carte__infos">
                <li><span class="carte__infos-titre">Prix actuel :</span> <span class="carte__infos-valeur">{{ enchere.currentBid }} $</span></li>
                <li><span class="carte__infos-titre">Début :</span> <span class="carte__infos-valeur">{{ enchere.date_debut|date('d/m/Y H:i') }}</span></li>
                <li><span class="carte__infos-titre">Fin :</span> <span class="carte__infos-valeur">{{ enchere.date_fin|date('d/m/Y H:i') }}</span></li>
            </ul>
            <div class="carte__footer">
    {% if enchere.coup_de_coeur_lord %}
        <span class="carte__infos-titre">Coup de cœur 💖</span><br>
    {% endif %}
    <a class="card__btn carte__infos-valeur" href="{{ base }}/enchere?id={{ enchere.id_enchere }}">Voir l'enchère</a>
</div>
        </div>
    </article>
    {% endfor %}
</section>
{% else %}
<p>Vous n'avez aucun favoris pour le moment.</p>
{% endif %}
{% endif %}

{{ include('layouts/footer.php', { title: 'Profil' }) }}
