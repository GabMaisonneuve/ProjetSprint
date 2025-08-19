{{ include('layouts/header.php', { title: 'Ajouter un timbre' }) }}



{% if app.request.get('succes') %}
<p class="success">Timbre ajouté avec succès.</p>
{% endif %}

<div class="container">
    <div class="content">

        <form action="{{ base }}/ajouter" method="POST" enctype="multipart/form-data" class="form-timbre">
            <h1 class="h1-inscription">Ajouter un timbre</h1>

            {% if erreurs %}
            <div class="erreur">
                <ul>
                    {% for e in erreurs %}

                        <li>{{ e }}</li>
                    {% endfor %}
                </ul>
            </div>
            {% endif %}

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old.nom|default('') }}" required>
            {% if erreurs.nom %}<small class="err">{{ erreurs.nom }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="date_creation">Année de création</label>
           <input type="number" 
                id="date_creation" 
                name="date_creation" 
                min="1901" 
                max="{{ ('now'|date('Y') + 1)|number_format(0, '', '') }}" 
                value="{{ old.date_creation|default('') }}" 
                required>
            {% if erreurs.date_creation %}<small class="err">{{ erreurs.date_creation }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="id_pays">Pays d'origine</label>
            <select id="id_pays" name="id_pays" required>
            <option value="">— Sélectionner —</option>
            {% for p in pays %}
                <option value="{{ p.id_pays }}" {{ old.id_pays is defined and old.id_pays == p.id_pays ? 'selected' : '' }}>
                {{ p.nom_pays }}
                </option>
            {% endfor %}
            </select>
            {% if erreurs.id_pays %}<small class="err">{{ erreurs.id_pays }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="id_couleur">Couleur</label>
            <select id="id_couleur" name="id_couleur" required>
            <option value="">— Sélectionner —</option>
            {% for c in couleurs %}
                <option value="{{ c.id_couleur }}" {{ old.id_couleur is defined and old.id_couleur == c.id_couleur ? 'selected' : '' }}>
                {{ c.nom_couleur }}
                </option>
            {% endfor %}
            </select>
            {% if erreurs.id_couleur %}<small class="err">{{ erreurs.id_couleur }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="id_condition">Condition</label>
            <select id="id_condition" name="id_condition" required>
            <option value="">— Sélectionner —</option>
            {% for cond in conditions %}
                <option value="{{ cond.id_condition }}" {{ old.id_condition is defined and old.id_condition == cond.id_condition ? 'selected' : '' }}>
                {{ cond.nom_condition }}
                </option>
            {% endfor %}
            </select>
            {% if erreurs.id_condition %}<small class="err">{{ erreurs.id_condition }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="tirage">Tirage (ex. 500000)</label>
            <input type="number" id="tirage" name="tirage" min="0" value="{{ old.tirage|default('') }}" required>
            {% if erreurs.tirage %}<small class="err">{{ erreurs.tirage }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="dimensions">Dimensions (ex. 30x40 mm)</label>
            <input type="text" id="dimensions" name="dimensions" value="{{ old.dimensions|default('') }}" required>
            {% if erreurs.dimensions %}<small class="err">{{ erreurs.dimensions }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="certifie" value="1" {{ old.certifie|default(false) ? 'checked' : '' }}> Certifié</label>
        </div>

        <div class="form-group">
            <label for="image">Image principale</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            {% if erreurs.image %}<small class="err">{{ erreurs.image }}</small>{% endif %}
        </div>

        <div class="form-group">
            <label for="images">Images secondaires (max 4)</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
            <small>Vous pouvez en sélectionner jusqu’à 4.</small>
            {% if erreurs.images %}<small class="err">{{ erreurs.images }}</small>{% endif %}
        </div>

        <button type="submit" class="btn btn__modifier">Ajouter</button>
        </form>
    </div>
</div>

{{ include('layouts/footer.php') }}
