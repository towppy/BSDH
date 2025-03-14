<?php
include '../database.php'; // Include session handling and database connection
include '../Pages/sidebar.php';

// Fetch equipment and assigned doctors
$query = "SELECT equipment.equipment_id AS id, 
                 equipment.name, 
                 equipment.type AS category, 
                 equipment.status, 
                 COALESCE(CONCAT(doctors.doctor_id, ' (', doctors.specialization, ')'), 'Unassigned') AS full_name 
          FROM equipment 
          LEFT JOIN doctors ON equipment.assigned_doctor_id = doctors.doctor_id";

$result = mysqli_query($conn, $query);

// Store the fetched data in an array so it can be reused
$equipmentData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $equipmentData[] = $row;
}

// Fetch categories for dropdown search
$categoryListQuery = "SELECT category_id, category_name FROM categories";
$categoryListResult = mysqli_query($conn, $categoryListQuery);

// Store category data in an array
$categoryList = [];
while ($row = mysqli_fetch_assoc($categoryListResult)) {
    $categoryList[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Equipment Inventory</title>
    <link rel="stylesheet" href="../CSS/inventory.css"> <!-- Link to your CSS file -->
    <style>
        .btn-edit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="inventory-section">
    <h2>Medical Equipment Inventory</h2>

    <a href="add_equipment.php" class="btn-add">Add Equipment</a> <!-- Add Equipment Button -->

    <label for="equipment-search">Search Equipment:</label>
    <input type="text" id="equipment-search" placeholder="Search by Equipment Name...">

    <label for="category-search">Filter by Category:</label>
    <select id="category-search">
        <option value="">Select Category</option>
        <?php foreach ($categoryList as $row) { ?>
            <option value="<?php echo htmlspecialchars($row['category_name']); ?>">
                <?php echo htmlspecialchars($row['category_name']); ?>
            </option>
        <?php } ?>
    </select>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Assigned Doctor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipmentData as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td>
                        <a href="edit_equipment.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <form action="delete_equipment.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this equipment?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    const searchInput = document.getElementById('equipment-search');
    const categoryDropdown = document.getElementById('category-search');
    const rows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const categoryValue = categoryDropdown.value.toLowerCase();

        rows.forEach(row => {
            const equipmentName = row.children[1].textContent.toLowerCase(); // Name column
            const category = row.children[2].textContent.toLowerCase(); // Category column

            const nameMatches = equipmentName.includes(searchValue);
            const categoryMatches = category.includes(categoryValue) || categoryValue === '';

            // Show row only if both search and category match
            row.style.display = nameMatches && categoryMatches ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    categoryDropdown.addEventListener('change', filterTable);
</script>

<style>
    .inventory-section {
        margin-left: 100px; /* Adjust the value as needed */
    }

    .btn-add {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 12px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .btn-add:hover {
        background-color: #218838;
    }
</style>

<style>
    .btn-add {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 12px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .btn-add:hover {
        background-color: #218838;
    }
</style>


    <script>
       document.getElementById('category-search').addEventListener('change', function() {
    let selectedCategory = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let category = row.children[2].textContent.toLowerCase(); // Assuming category is the 3rd column
        row.style.display = category.includes(selectedCategory) || selectedCategory === '' ? '' : 'none';
    });
});

    </script>
</body>
</html>
