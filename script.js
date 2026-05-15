//SORT TABLE (frontend sorting based on table values)
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
