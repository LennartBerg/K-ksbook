function submitRating(rating, recipeID) {
    // Highlight stars up to the selected rating
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        star.classList.remove('selected');
        if (star.getAttribute('data-value') <= rating) {
            star.classList.add('selected');
        }
    });

    // Send AJAX request to update rating
    fetch('./AddRatingAjax.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({recipeID: recipeID, rating: rating})
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('averageRating').innerText = data.newAverageRating;
                document.getElementById('reviewCount').innerText = "(" + data.newReviewCount + ' reviews)';
                alert(data.message);
            } else {
                alert('Failed to update rating');
            }
        })
        .catch(error => console.error('Error:', error));
}
