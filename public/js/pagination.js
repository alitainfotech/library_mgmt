document.addEventListener("DOMContentLoaded", function () {
    loadPage(1);

    document.getElementById("pagination").addEventListener("click", function (e) {
        if (e.target.tagName.toLowerCase() === "a") {
            e.preventDefault();
            loadPage(e.target.getAttribute("data-page"));
        }
    });

    document.getElementById("content").addEventListener("click", function (e) {
        if (e.target.classList.contains("book-image")) {
            var imageUrl = e.target.src;
            showImageModal(imageUrl);
        }
    });
});

function loadPage(page) {
    // console.log(page);
    var url = "/get-books?page=" + page;

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            displayData(response.data);
            displayPagination(response.totalPages, response.currentPage);
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function displayData(data) {
    var contentDiv = document.getElementById("content");
    contentDiv.innerHTML = "";

    var rowDiv;

    for (var i = 0; i < data.length; i++) {
        if (i % 5 === 0) {
            rowDiv = document.createElement("div");
            rowDiv.classList.add("row");
            rowDiv.classList.add("justify-content-center");
            contentDiv.appendChild(rowDiv);
        }

        var book = data[i];
        var bookDiv = document.createElement("div");
        bookDiv.classList.add("book-item", "mb-4"); // Added margin-bottom for space

        // Set the width to 20% to display 5 books in one row
        bookDiv.style.width = "15%";
        bookDiv.style.display = "inline-block";
        bookDiv.style.margin = "0 10px";

        var image = document.createElement("img");
        image.src = book.image_url;
        image.classList.add("book-image", "img-fluid", "rounded"); // Added img-fluid and rounded for space
        bookDiv.appendChild(image);

        var name = document.createElement("h3");
        name.textContent = book.name;
        bookDiv.appendChild(name);

        var authors = document.createElement("p");
        authors.textContent = "Authors: " + book.author_names;
        bookDiv.appendChild(authors);

        var library = document.createElement("p");
        library.textContent = "Library: " + book.library_name;
        bookDiv.appendChild(library);

        rowDiv.appendChild(bookDiv);
    }
}




// function displayPagination(totalPages, currentPage) {
//     // console.log("Here");
//     console.log(totalPages,currentPage)
//     var paginationDiv = document.getElementById("pagination");
//     paginationDiv.innerHTML = "";

//     for (var i = 1; i <= totalPages; i++) {
//         var pageLink = document.createElement("a");
//         pageLink.href = "#";
//         pageLink.textContent = i;
//         pageLink.setAttribute("data-page", i);

//         // Add Bootstrap pagination classes
//         pageLink.classList.add("page-link");
//         if (i == currentPage) {
//             pageLink.classList.add("active");
//         }

//         paginationDiv.appendChild(pageLink);
//     }
// }

function displayPagination(totalPages, currentPage) {
    var paginationDiv = document.getElementById("pagination");
    paginationDiv.innerHTML = "";

    for (var i = 1; i <= totalPages; i++) {
        var pageLink = document.createElement("a");
        pageLink.href = "#";
        pageLink.textContent = i;
        pageLink.setAttribute("data-page", i);

        pageLink.classList.add("page-link");
        if (i == currentPage) {
            pageLink.classList.add("active");
        }

        pageLink.addEventListener("click", function (e) {
            e.preventDefault();
            var selectedPage = parseInt(this.getAttribute("data-page"));
            loadPage(selectedPage);
        });

        paginationDiv.appendChild(pageLink);
    }
}



function showImageModal(imageUrl) {
    var modalImage = document.getElementById("modalImage");
    modalImage.src = imageUrl;

    // Trigger Bootstrap modal
    $('#imageModal').modal('show');
}

loadPage(1);
