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
{% endif %}

{{ include('layouts/footer.php', { title: 'Profil' }) }}
