{{ include('layouts/header.php', { title: 'Connexion' }) }}

<div class="container">
    <div class="content">
        <form action="{{ base }}/connexion" method="POST">
            <h1 class="h1-inscription">Connexion</h1>

            {% if erreur %}
                    <div class="erreur">{{ erreur }}</div>
            {% endif %}

            <div class="form-group">
                <label for="nom_utilisateur">Nom d'utilisateur</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="form-btn-container">
                <input class="btn btn-primary" type="submit" value="Connexion">
            </div>

            {% if message %}
                <div class="message">{{ message }}</div>
            {% endif %}
        </form>
    </div>
</div>

{{ include('layouts/footer.php', { title: 'connexion' }) }}