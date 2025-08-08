{{ include('layouts/header.php', { title: 'Inscription' }) }}

<div class="container">
    <div class="content">
        <form action="{{ base }}/inscription" method="POST">

            <h1 class="h1-inscription">Inscription</h1>

            {% if erreur %}
                <ul class="erreur">
                    {% for erreur in erreurs %}
                        <li>{{ error }}</li>
                    {% endfor %}
                </ul>
            {% endif %}
            <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="nom_utilisateur">Nom d'utilisateur:</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
            </div>

            <div class="form-group">
                <label for="courriel">Email:</label>
                <input type="email" id="courriel" name="courriel" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="form-btn-container">
                <input class="btn btn-primary" type="submit" value="S'inscrire">
            </div>

            {% if message %}
                <div class="message">{{ message }}</div>
            {% endif %}
        </form>
    </div>
</div>

{{ include('layouts/footer.php', { title: 'Inscription' }) }}

