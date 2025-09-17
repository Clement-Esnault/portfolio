function addToCart(product) {
    // Récupère le panier actuel ou crée un tableau vide
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    // Cherche si le produit existe déjà
    console.log(document.querySelectorAll('.add-to-cart-btn'));

    const idx = cart.findIndex(item => item.id === product.id);
    if (idx !== -1) {
        cart[idx].qty += product.qty;
    } else {
        cart.push(product);
    }
    sessionStorage.setItem('cart', JSON.stringify(cart));
}

// Exemple d'utilisation (à adapter selon ton HTML)
console.log('Script cart.js chargé avec succès !');
console.log(document.querySelectorAll('.add-to-cart-btn'));
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const product = {
            id: this.id,
            qty: 1  
        };
        addToCart(product);
        alert('Produit ajouté au panier !');
    });
});