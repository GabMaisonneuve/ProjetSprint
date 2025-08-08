{{ include('layouts/header.php', { title: 'Create Post' }) }}

{% if session %}
    <p>Bienvenue {{ session.nom_utilisateur }} !</p>
{% else %}
    <p>Bienvenue invité !</p>
{% endif %}

{% if message %}
    <div class="message">{{ message }}</div>
{% endif %}

{{ include('layouts/footer.php', { title: 'Create Post' }) }}