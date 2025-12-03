<?php
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Photo Gallery</h1>
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span>Gallery</span>
        </div>
    </div>
</div>

<section class="section gallery-page-section">
    <div class="container">
        <div class="gallery-tabs">
            <button class="gallery-tab active" data-filter="all">All</button>
            <button class="gallery-tab" data-filter="food">Food</button>
            <button class="gallery-tab" data-filter="restaurant">Restaurant</button>
            <button class="gallery-tab" data-filter="events">Events</button>
        </div>
        
        <div class="gallery-masonry">
            <div class="gallery-item large" data-category="food">
                <img src="/assets/images/gallery/pepperoni_pizza_product_shot.png" alt="Pepperoni Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="food">
                <img src="/assets/images/gallery/farmhouse_veggie_pizza_shot.png" alt="Farmhouse Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="restaurant">
                <img src="/assets/images/gallery/restaurant_interior_ambiance.png" alt="Restaurant Interior">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="food">
                <img src="/assets/images/gallery/penne_alfredo_pasta_dish.png" alt="Pasta Dish">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item large" data-category="restaurant">
                <img src="/assets/images/gallery/pizza_chef_action_shot.png" alt="Pizza Chef">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="food">
                <img src="/assets/images/gallery/chocolate_brownie_dessert.png" alt="Dessert">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="events">
                <img src="/assets/images/gallery/bbq_chicken_pizza_shot.png" alt="BBQ Chicken Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item" data-category="food">
                <img src="/assets/images/gallery/garlic_bread_appetizer.png" alt="Garlic Bread">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
        </div>
    </div>
</section>

<style>
.gallery-page-section {
    background: var(--darker);
}
.gallery-tabs {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 50px;
    flex-wrap: wrap;
}
.gallery-tab {
    padding: 12px 30px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--glass-border);
    border-radius: 50px;
    color: var(--white);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
}
.gallery-tab:hover,
.gallery-tab.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
}
.gallery-masonry {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.gallery-masonry .gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    aspect-ratio: 1;
    transition: var(--transition);
}
.gallery-masonry .gallery-item.large {
    grid-column: span 2;
    grid-row: span 2;
}
.gallery-masonry .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}
.gallery-masonry .gallery-item:hover img {
    transform: scale(1.1);
}
.gallery-masonry .gallery-item.hidden {
    display: none;
}

@media (max-width: 992px) {
    .gallery-masonry {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .gallery-masonry {
        grid-template-columns: repeat(2, 1fr);
    }
    .gallery-masonry .gallery-item.large {
        grid-column: span 2;
        grid-row: span 1;
    }
}
</style>

<script>
document.querySelectorAll('.gallery-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.gallery-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        
        document.querySelectorAll('.gallery-masonry .gallery-item').forEach(item => {
            if (filter === 'all' || item.dataset.category === filter) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
