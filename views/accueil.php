{{ include('layouts/header.php', { title: 'Accueil' }) }}


{% if session is defined %}
    <p>Bienvenue {{ session.nom_utilisateur }} !</p>
{% else %}
    <p>Bienvenue invité !</p>
{% endif %}

{% if message %}
    <div class="message">{{ message }}</div>
{% endif %}


<a href="{{ base }}/detail?id=11">Voir timbre #1</a>

{{ include('layouts/footer.php', { title: 'Accueil' }) }}