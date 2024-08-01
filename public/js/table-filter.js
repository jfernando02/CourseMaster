(() => {
    
    document.getElementById('fileInput').addEventListener('change', function() {
        document.getElementById('uploadButton').disabled = !this.files.length;
    });

    document.addEventListener('DOMContentLoaded', function () {
        const filters = document.querySelectorAll('.filter-input');
        filters.forEach(filter => {
            filter.addEventListener('keyup', function () {
                const columnIndex = parseInt(this.getAttribute('data-column')); // Ensure you get the correct column index
                const query = this.value.toLowerCase();
                const rows = document.querySelector(".table tbody").rows;


                for (let row of rows) {
                    const cell = row.cells[columnIndex]; // Get the specific cell corresponding to the column
                    if (cell.textContent.toLowerCase().includes(query)) {
                        row.style.display = ''; // Show the row if the cell content includes the query
                    } else {
                        row.style.display = 'none'; // Hide the row if the cell content does not include the query
                    }
                }
            });
        });
    });
})()