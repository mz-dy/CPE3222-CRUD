// DELETE CONFIRMATION
document.querySelectorAll(".delete-btn").forEach(button => {

    button.addEventListener("click", function(event) {

        if(confirm("Are you sure you want to delete this product?")){
            //this.parentElement.parentElement.remove();
            event.preventDefault();

            alert("Product deleted successfully!");
        }

    });

});

//SORT TABLE (no need backend, frontend sorting based on table values)
const sortSelect = document.getElementById("sortSelect");
if(sortSelect){
    sortSelect.addEventListener("change", function(){
    const tbody = document.getElementById("productTable");
    let rows = Array.from(tbody.querySelectorAll("tr"));
    const sortValue = this.value;
    rows.sort((a, b) => {
        let aValue;
        let bValue;

        // SORT BY ID ASCENDING
        if(sortValue === "id-asc"){

            aValue = parseInt(a.cells[0].textContent);
            bValue = parseInt(b.cells[0].textContent);

            return aValue - bValue;
        }
        
        // SORT BY ID DESCENDING
        else if(sortValue === "id-desc"){

            aValue = parseInt(a.cells[0].textContent);
            bValue = parseInt(b.cells[0].textContent);

            return bValue - aValue;
        }

        // SORT BY NAME ASCENDING
        else if(sortValue === "name-asc"){

            aValue = a.cells[1].textContent.toLowerCase();
            bValue = b.cells[1].textContent.toLowerCase();

            return aValue.localeCompare(bValue);
        }

        // SORT BY NAME DESCENDING
        else if(sortValue === "name-desc"){

            aValue = a.cells[1].textContent.toLowerCase();
            bValue = b.cells[1].textContent.toLowerCase();

            return bValue.localeCompare(aValue);
        }

        // SORT BY STOCK ASCENDING
        else if(sortValue === "stock-asc"){

            aValue = parseInt(a.cells[4].textContent);
            bValue = parseInt(b.cells[4].textContent);

            return aValue - bValue;
        }

        // SORT BY STOCK DESCENDING
        else if(sortValue === "stock-desc"){

            aValue = parseInt(a.cells[4].textContent);
            bValue = parseInt(b.cells[4].textContent);

            return bValue - aValue;
        }
    });
    // REWRITE TABLE
    tbody.innerHTML = "";
    rows.forEach(row => tbody.appendChild(row));
    });
}

// DUMMY FUNCTION TO SIMULATE EDIT BTN GETTING DATA FROM TABLE TO FORMS ======= CHANGE/REMOVE WHEN BACKEND IMPLEMENTATION
const params = new URLSearchParams(window.location.search);
if(params){
    function fillForm(input, value){

        const field = document.getElementById(input);

        if(field){
            field.value = params.get(value);
        }

    }

    fillForm("pnamef", "pname");
    fillForm("pcatf", "pcat");
    fillForm("ppricef", "pprice");
    fillForm("pstockf", "pstock");
}

//DUMMY FUNCTION TO SIMULATE SUBMIT ======= CHANGE/REMOVE WHEN BACKEND IMPLEMENTATION
const forms = document.querySelectorAll("form");
if(forms){
    forms.forEach(form => {

        form.addEventListener("submit", function(event){

            event.preventDefault();

            alert("Product saved successfully!");

        });

    });
}

// SEARCH FUNCTION (incase of implementation if have time)
/*document.getElementById("searchInput").addEventListener("keyup", function() {

    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#productTable tr");

    rows.forEach(row => {

        let productName = row.cells[1].textContent.toLowerCase();

        if(productName.includes(filter)){
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });

});*/