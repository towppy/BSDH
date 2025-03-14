<?php
session_start();
ob_start();

include '../database.php'; // Database connection
include '../Pages/sidebar.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Unauthorized access. Please log in.");
}

// Fetch categories for dropdown
$categoryQuery = "SELECT DISTINCT category FROM medicines";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// Check for category and search filter
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

// Fetch medicines with filters
$query = "SELECT * FROM medicines WHERE 1=1";
if (!empty($selectedCategory)) {
    $query .= " AND category = '" . mysqli_real_escape_string($conn, $selectedCategory) . "'";
}
if (!empty($searchQuery)) {
    $query .= " AND name LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'";
}
$query .= " ORDER BY name ASC";
$result = mysqli_query($conn, $query);
$medicines = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Inventory</title>
    <link rel="stylesheet" href="../CSS/p_inventory.css">
</head>
<body>
    <div class="container">
        <h2>Pharmacy Inventory</h2>
        <button class="btn" onclick="openModal()">Add Medicine</button>

        <!-- Search and Filter Form -->
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Search Medicine..." value="<?= htmlspecialchars($searchQuery) ?>">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?= htmlspecialchars($cat['category']) ?>" <?= ($selectedCategory == $cat['category']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category']) ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" class="btn">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Expiration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $medicine) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medicine['name']); ?></td>
                        <td><?php echo htmlspecialchars($medicine['category']); ?></td>
                        <td>₱<?php echo number_format($medicine['price'], 2); ?></td>
                        <td><?php echo $medicine['stock']; ?></td>
                        <td><?php echo $medicine['expiration_date']; ?></td>
                        <td>
                            <a href="editp_inventory.php?id=<?php echo $medicine['medicine_id']; ?>">Edit</a> |
                            <a href="delete_medicine.php?id=<?php echo $medicine['medicine_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Medicine Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Add New Medicine</h2>
            <form id="addForm">
                <label>Name:</label>
                <input type="text" name="name" required>

                <label>Category:</label>
                <select name="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php foreach ($categories as $cat) { ?>
                        <option value="<?= htmlspecialchars($cat['category']) ?>"><?= htmlspecialchars($cat['category']) ?></option>
                    <?php } ?>
                </select>

                <label>Price:</label>
                <input type="number" step="0.01" name="price" required>

                <label>Stock:</label>
                <input type="number" name="stock" required>

                <label>Expiration Date:</label>
                <input type="date" name="expiration_date" required>

                <button type="submit" class="btn">Add Medicine</button>
            </form>
        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addModal');
    const addButton = document.querySelector('.btn'); // Make sure this is the correct class for the Add Medicine button

    // Open modal only when Add Medicine button is clicked
    if (addButton) {
        addButton.addEventListener('click', function() {
            modal.style.display = 'flex';
        });
    }

    // Close modal when close button is clicked
    document.querySelector('.close-btn').addEventListener('click', closeModal);

    // Handle form submission via AJAX
    document.getElementById('addForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('add_medicine_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                alert('Medicine added successfully!');
                closeModal();
                location.reload();
            } else {
                alert('Error adding medicine.');
            }
        });
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close modal function
    function closeModal() {
        modal.style.display = 'none';
    }
});

    </script>

    <style>
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        .btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</body>
</html>
