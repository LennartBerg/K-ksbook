let offset = 3;
const limit = 3;

document.getElementById('loadButton').addEventListener('click', function () {
    fetch(`moreRecipes.php?offset=${offset}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById('loadButton').style.display = 'none';
                return;
            }

            const container = document.querySelector('.RecipePreviewLayout');
            data.forEach(recipe => {
                let toAdd = recipe.averageRating > 5 ? "-" : recipe.averageRating;


                const div = document.createElement('div');
                div.classList.add('RecipePreview');

                div.innerHTML = `
                    <div class="RecipePictureContainer">
                        <a href="viewRecipe.php?recipeID=${recipe.recipeID}">
                            <img class="RecipePicture" src="${recipe.picturePath}"
                                 alt="Picture of ${recipe.name}">
                        </a>
                    </div>
                    <h2>
                        <a href="viewRecipe.php?recipeID=${recipe.recipeID}">${recipe.name}</a>
                    </h2>
                    <span><a href="profil.php?userID=${recipe.userID}">${recipe.username}</a></span>
                    <br>
                    <div class="iconAndText">
                        <img src="./assets/icons/starIcon.ico" alt="StarIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/star/77949 -->
                        <span> ${toAdd}/5 (${recipe.ratings} reviews)</span>
                        <br>
                    </div>
                    <div class="iconAndText">
                        <img src="./assets/icons/clockIcon.ico" alt="ClockIcon" class="headerIcon">
                        <!-- quelle: https://icon-icons.com/icon/clock-time/4463 -->
                        <span>${recipe.workTime} minutes</span> <br>
                    </div>
               
                `;
                container.appendChild(div);
            });
            offset += limit;

            if (data.length < limit) {
                document.getElementById('loadButton').style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
});

// generated with the help of ChatGPT-4