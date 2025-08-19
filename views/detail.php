{{ include('layouts/header.php', { title: 'Detail' }) }}

 <main class="detail-container">
        <div class="detail-gauche">
            <div class="image-container">
                <div class="zoom-controls">
                    <button class="zoom-btn" id="zoom-in">+</button>
                    <button class="zoom-btn" id="zoom-out">−</button>
                </div>
                <img src="public/{{ timbre.image_principale }}" 
                    alt="{{ timbre.nom }}" 
                    class="image-principale"
                    id="main-image">
            </div>

            {% if timbre.images_secondaires %}
            <div class="thumbnails">
                <img src="public/{{ timbre.image_principale }}" 
                    alt="Vue principale" 
                    class="thumbnail active" 
                    data-full="{{ base }}{{ timbre.image_principale }}">
                {% for image in timbre.images_secondaires %}
                    <img src="public/{{ image.url }}" 
                        alt="Vue {{ loop.index }}" 
                        class="thumbnail" 
                        data-full="public/{{ image.url }}">
                {% endfor %}
            </div>
            {% endif %}
        </div>

        <div class="detail-droit">
            <div class="info-section">
                <h1 class="info-title">{{ timbre.nom }}</h1>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Année de création:</span>
                        <span class="info-value">{{ timbre.date_creation }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Pays d'origine:</span>
                        <span class="info-value">{{ timbre.nom_pays }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Couleur:</span>
                        <span class="info-value">{{ timbre.nom_couleur }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Condition:</span>
                        <span class="info-value">{{ timbre.nom_condition }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Tirage:</span>
                        <span class="info-value">{{ timbre.tirage|number_format }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Dimensions:</span>
                        <span class="info-value">{{ timbre.dimensions }}</span>
                    </div>
                </div>
                
                {% if timbre.certifie %}
                <div class="info-item" style="grid-column: 1 / -1; background: #d4edda; padding: 10px; border-radius: 6px; margin-top: 1rem;">
                    <span style="color: #155724; font-weight: bold;">✓ Timbre certifié authentique</span>
                </div>
                {% endif %}
            </div>

            <div class="actions-section">
                <h3>Actions</h3>
                
                {% if session.id_membre == timbre.id_membre %}
                    <a href="{{ base }}/timbre/{{ timbre.id_timbre }}/modifier" class="btn btn-primary">
                        Modifier
                    </a>
                    <button class="btn btn-secondary" onclick="deleteTimbre('{{ timbre.id_timbre }}')">
                        Supprimer
                    </button>
                {% else %}
                    <button class="btn btn-success favorite-btn" id="favorite-btn" data-timbre-id="{{ timbre.id_timbre }}">
                        <span id="favorite-text">Ajouter aux favoris</span>
                    </button>
                {% endif %} 
            </div>
        </div>
    </main>

    <!-- Modal pour zoom -->
    <div class="modal" id="image-modal">
        <div class="modal-content">
            <span class="modal-close" id="modal-close">&times;</span>
            <img src="" alt="" id="modal-image">
        </div>
    </div>

       <script>
        // Configuration globale
        const TIMBRE_ID = '{{ timbre.id_timbre }}';
        const USER_ID = '{{ session.id_membre }}';
        const BASE_URL = '{{ base }}';

        class TimbreDetailManager {
            constructor() {
                this.currentZoom = 1;
                this.favorites = this.loadFavorites();
                this.init();
            }

            init() {
                this.setupImageZoom();
                this.setupThumbnails();
                this.setupFavorites();
                this.setupModal();
            }

            setupImageZoom() {
                const mainImage = document.getElementById('main-image');
                const zoomIn = document.getElementById('zoom-in');
                const zoomOut = document.getElementById('zoom-out');

                // Zoom avec boutons
                zoomIn.addEventListener('click', () => {
                    this.currentZoom = Math.min(this.currentZoom + 0.5, 3);
                    mainImage.style.transform = `scale(${this.currentZoom})`;
                });

                zoomOut.addEventListener('click', () => {
                    this.currentZoom = Math.max(this.currentZoom - 0.5, 1);
                    mainImage.style.transform = `scale(${this.currentZoom})`;
                });

                // Zoom au clic
                mainImage.addEventListener('click', () => {
                    if (this.currentZoom === 1) {
                        this.showModal(mainImage.src);
                    } else {
                        this.currentZoom = 1;
                        mainImage.style.transform = 'scale(1)';
                    }
                });
            }

            setupThumbnails() {
                const thumbnails = document.querySelectorAll('.thumbnail');
                const mainImage = document.getElementById('main-image');

                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', () => {
                        // Retirer classe active
                        document.querySelector('.thumbnail.active')?.classList.remove('active');
                        
                        // Ajouter à la nouvelle
                        thumb.classList.add('active');
                        
                        // Changer l'image principale
                        mainImage.src = thumb.dataset.full;
                        
                        // Reset zoom
                        this.currentZoom = 1;
                        mainImage.style.transform = 'scale(1)';
                    });
                });
            }

            setupFavorites() {
                const favoriteBtn = document.getElementById('favorite-btn');
                if (!favoriteBtn) return;

                const isFavorited = this.favorites.includes(TIMBRE_ID);
                this.updateFavoriteButton(isFavorited);

                favoriteBtn.addEventListener('click', () => {
                    this.toggleFavorite();
                });
            }

            setupModal() {
                const modal = document.getElementById('image-modal');
                const modalClose = document.getElementById('modal-close');

                modalClose.addEventListener('click', () => {
                    modal.classList.remove('show');
                });

                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                    }
                });
            }

            showModal(imageSrc) {
                const modal = document.getElementById('image-modal');
                const modalImage = document.getElementById('modal-image');
                
                modalImage.src = imageSrc;
                modal.classList.add('show');
            }

            loadFavorites() {
                const stored = localStorage.getItem('timbre_favorites');
                return stored ? JSON.parse(stored) : [];
            }

            saveFavorites() {
                localStorage.setItem('timbre_favorites', JSON.stringify(this.favorites));
            }

            toggleFavorite() {
                const index = this.favorites.indexOf(TIMBRE_ID);
                
                if (index > -1) {
                    this.favorites.splice(index, 1);
                    this.updateFavoriteButton(false);
                    this.showNotification('Retiré des favoris', 'info');
                } else {
                    this.favorites.push(TIMBRE_ID);
                    this.updateFavoriteButton(true);
                    this.showNotification('Ajouté aux favoris', 'success');
                }

                this.saveFavorites();
            }

            updateFavoriteButton(isFavorited) {
                const btn = document.getElementById('favorite-btn');
                const text = document.getElementById('favorite-text');
                
                if (isFavorited) {
                    btn.classList.add('favorited');
                    text.textContent = 'Retirer des favoris';
                } else {
                    btn.classList.remove('favorited');
                    text.textContent = 'Ajouter aux favoris';
                }
            }

            
        }

        // Fonctions globales
        function deleteTimbre(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce timbre ?')) {
                fetch(`${BASE_URL}/api/timbre/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = `${BASE_URL}/mes-timbres`;
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }
      

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            new TimbreDetailManager();
        });
    </script>



{{ include('layouts/footer.php', { title: 'Detail' }) }}