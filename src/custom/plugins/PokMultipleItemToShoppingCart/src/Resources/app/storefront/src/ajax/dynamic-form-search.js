console.log("Ajax was be correct registrated!");
document.getElementById('productSearch').addEventListener('keyup', function () {
    let query = this.value;
    if (query.length >= 2) {  // Start searching after 2 characters
        fetch(`/product/search?term=${query}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            let suggestions = '';
            data.forEach(product => {
                suggestions += `<div class="suggestion-item" data-id="${product.id}">${product.name}</div>`;
            });
            document.getElementById('productSuggestion').innerHTML = suggestions;
        });
    } else {
        document.getElementById('productSuggestion').innerHTML = '';
    }
});

// Handle product selection from suggestions
document.getElementById('productSuggestion').addEventListener('click', function (event) {
    if (event.target.classList.contains('suggestion-item')) {
        const productName = event.target.textContent;
        const productId = event.target.dataset.id;
        
        document.getElementById('productSearch').value = productName;
        document.getElementById('productId').value = productId;
        
        // Clear the suggestions
        document.getElementById('productSuggestion').innerHTML = '';
    }
});

