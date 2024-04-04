// navigation.js

document.addEventListener("DOMContentLoaded", function() {
    // Get the ul element with class "nav"
    var navList = document.querySelector(".nav");

    // Check if navList exists
    if (navList) {
        // Create an array of objects representing menu items
        var menuItems = [
            { text: "Ingredient", href: "index.php" },
            { text: "Category", href: "Category.php" },
            { text: "Sub Category", href: "SubsCategory.php" },
            { text: "Category&Subs", href: "SubsCategoryList.php" },
            { text: "Unit", href: "UnitMeasure.php" },
            { text: "Nutrient", href: "#", disabled: true }
        ];

        // Loop through the menu items and create corresponding list items and links
        menuItems.forEach(function(item) {
            var li = document.createElement("li");
            li.classList.add("nav-item");

            var a = document.createElement("a");
            a.classList.add("nav-link");
            a.textContent = item.text;
            a.href = item.href;

            if (item.disabled) {
                a.classList.add("disabled");
                a.setAttribute("aria-disabled", "true");
            }

            li.appendChild(a);
            navList.appendChild(li);
        });
    } else {
        console.error("Could not find .nav element.");
    }
});
