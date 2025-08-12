{{ include('layouts/header.php', { title: 'Create Post' }) }}

{% if session is defined %}
<h1 class="profil-h1">Profil de {{ session.nom_utilisateur }}</h1>
<h2 class="profil-h2">Informations personnelles</h2>

<div class="infos-profil">
    <div class="info-profil">
        <span class="label">Nom d'utilisateur :</span>
        <span class="value">{{ session.nom_utilisateur }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Prénom :</span>
        <span class="value">{{ session.prenom }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Nom :</span>
        <span class="value">{{ session.nom }}</span>
    </div>
    <div class="info-profil">
        <span class="label">Courriel :</span>
        <span class="value">{{ session.courriel }}</span>
    </div>
    <div class="boutons">
        <a href="{{ base }}/supprimer?id={{ session.id_membre }}" class="btn btn__supprimer">Supprimer</a>
        <a href="{{ base }}/profil_edit?id={{ session.id_membre }}" class="btn btn__modifier">Modifier</a>
    </div>
</div>
{% endif %}

{{ include('layouts/footer.php', { title: 'Create Post' }) }}
