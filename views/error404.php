{{ include('layouts/header.php', { title: 'Error' }) }}

{% block content %}
<div class="infos-profil">
    <h1 style="font-size: 5rem; color: #ff5555;">404</h1>
    <h2>Page introuvable</h2>
    <p>Oups! La page que vous cherchez n'existe pas ou a été déplacée.</p>
    <a href="{{ base }}/" class="btn btn__modifier">Retour à l'accueil</a>
</div>
{% endblock %}

{{ include('layouts/footer.php', { title: 'Error' }) }}