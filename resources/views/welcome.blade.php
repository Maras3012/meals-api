<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .meal {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 1.2em;
            font-weight: bold;
        }
        .description {
            color: #555;
        }
        .status-created {
            color: green;
            font-weight: bold;
        }
        .status-deleted {
            color: red;
            font-weight: bold;
        }
        .category {
            margin-top: 10px;
        }
        .tag {
            margin-top: 5px;
        }
        .ingredient {
            margin-top: 5px;
        }
    </style>
</head>
<body>

<h1>Meal Data</h1>

<div id="meals">
    <!-- Meals will be dynamically added here using JavaScript -->
</div>

<script>
    // Assuming 'data' is your JSON data
    const data = {
        "meta": {
            "currentPage": 2,
            "totalItems": 8,
            "itemsPerPage": 5,
            "totalPages": 2
        },
        "data": [
            {
                "id": 1,
                "title": "Meal 1 en",
                "description": "Description for Meal 1 en",
                "status": "created",
                "category": {
                    "id": 2,
                    "title": "Category 1 - en",
                    "slug": "category-1"
                },
                "tags": [
                    {
                        "id": 1,
                        "title": "Tag 1 - en",
                        "slug": "tag-1"
                    },
                    {
                        "id": 2,
                        "title": "Tag 2 - en",
                        "slug": "tag-2"
                    }
                ],
                "ingredients": [
                    {
                        "id": 1,
                        "title": "Ingredient 1 - en",
                        "slug": "ingredient-1"
                    },
                    {
                        "id": 2,
                        "title": "Ingredient 2 - en",
                        "slug": "ingredient-2"
                    }
                ]
            },
            {
                "id": 2,
                "title": "Meal 2 en",
                "description": "Description for Meal 2 en",
                "status": "created",
                "category": null,
                "tags": [
                    {
                        "id": 2,
                        "title": "Tag 2 - en",
                        "slug": "tag-2"
                    }
                ],
                "ingredients": [
                    {
                        "id": 3,
                        "title": "Ingredient 3 - en",
                        "slug": "ingredient-3"
                    },
                    {
                        "id": 4,
                        "title": "Ingredient 4 - en",
                        "slug": "ingredient-4"
                    }
                ]
            },
            {
                "id": 3,
                "title": "Meal 3 en",
                "description": "Description for Meal 3 en",
                "status": "deleted",
                "category": {
                    "id": 1,
                    "title": "Category 3 - en",
                    "slug": "category-3"
                },
                "tags": [
                    {
                        "id": 5,
                        "title": "Tag 5 - en",
                        "slug": "tag-5"
                    }
                ],
                "ingredients": [
                    {
                        "id": 6,
                        "title": "Ingredient 6 - en",
                        "slug": "ingredient-6"
                    },
                    {
                        "id": 7,
                        "title": "Ingredient 7 - en",
                        "slug": "ingredient-7"
                    }
                ]
            }
        ],
        "links": {
            "prev": "http://localhost/meals?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&page=1",
            "next": null,
            "self": "http://localhost/meals?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&page=2"
        }
    };

    const mealsContainer = document.getElementById('meals');

    // Loop through each meal and create a card
    data.data.forEach(meal => {
        const mealCard = document.createElement('div');
        mealCard.classList.add('meal');

        // Display title and description
        const titleElement = document.createElement('div');
        titleElement.classList.add('title');
        titleElement.textContent = meal.title;
        mealCard.appendChild(titleElement);

        const descriptionElement = document.createElement('div');
        descriptionElement.classList.add('description');
        descriptionElement.textContent = meal.description;
        mealCard.appendChild(descriptionElement);

        // Display status
        const statusElement = document.createElement('div');
        statusElement.classList.add(meal.status === 'deleted' ? 'status-deleted' : 'status-created');
        statusElement.textContent = meal.status;
        mealCard.appendChild(statusElement);

        // Display category
        if (meal.category) {
            const categoryElement = document.createElement('div');
            categoryElement.classList.add('category');
            categoryElement.textContent = `Category: ${meal.category.title}`;
            mealCard.appendChild(categoryElement);
        }

        // Display tags
        if (meal.tags.length > 0) {
            const tagsElement = document.createElement('div');
            tagsElement.classList.add('tag');
            tagsElement.textContent = `Tags: ${meal.tags.map(tag => tag.title).join(', ')}`;
            mealCard.appendChild(tagsElement);
        }

        // Display ingredients
        if (meal.ingredients.length > 0) {
            const ingredientsElement = document.createElement('div');
            ingredientsElement.classList.add('ingredient');
            ingredientsElement.textContent = `Ingredients: ${meal.ingredients.map(ingredient => ingredient.title).join(', ')}`;
            mealCard.appendChild(ingredientsElement);
        }

        mealsContainer.appendChild(mealCard);
    });
</script>

</body>
</html>
