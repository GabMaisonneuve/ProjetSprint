{{ include('layouts/header.php', { title: 'Create Post' }) }}

<div class="container">
    <div class="content">
        <form action="{{ base }}/profil?id={{ utilisateur.id_membre }}" method="POST">
            <input type="hidden" name="id" value="{{ utilisateur.id_membre }}">
            <h1 class="profil-h1">Modifier Profil</h1>
            {% if erreur %}
                <div class="erreur">{{ erreur }}</div>
            {% endif %}

            <div class="form-group">
                <label for="nom_utilisateur">Nom utilisateur:</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="{{ utilisateur.nom_utilisateur }}" required>
            </div>
            <div class="form-group">
                <label for="courriel">Courriel:</label>
                <input type="text" id="courriel" name="courriel" value="{{ utilisateur.courriel }}" required>
            </div>
           <div class="form-group">
                <label for="mot_de_passe">Nouveau mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Laissez vide pour ne pas changer">
            </div>
             <div class="boutons">
            <a href="{{ base }}/profil?id={{ utilisateur.id_membre }}" class="btn btn__supprimer">Annuler</a>
            <input type="submit" value="Modifier" class="btn btn__modifier">
        </div>
        </form>

       
    </div>
</div>


{{ include('layouts/footer.php', { title: 'Create Post' }) }}