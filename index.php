<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>To Do List</title>
</head>
<body>
    <div class="container-sm mt-5">
        <h1 class="text-center mb-4">To Do List</h1>
        <form action="add.php" method="POST" class="form-inline justify-content-center mb-4">
            <input type="text" name="content" class="form-control mr-2" placeholder="Add a new task" required>
            <br>
            <input type="date" name="deadline" class="form-control mr-2" required>
            <br>
            <button type="submit" class="btn btn-dark">Add</button>
        </form>

        <?php
        // Pagination logic
        $limit = 10; // Number of entries to show in a page.
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        } else {
            $page = 1;
        };
        $start_from = ($page - 1) * $limit;

        // Fetch tasks from database
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC LIMIT $start_from, $limit";
        $result = $conn->query($sql);
        ?>

        <ul class="list-group mb-4">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="pe-5"><?php echo $row['content']; ?></span>
                        <span class="px-5"><?php echo $row['deadline']; ?></span>
                    </div>
                    <div>
                        <form action="edit.php" method="GET" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-dark">Edit</button>
                        </form>
                        <form action="delete.php" method="GET" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <?php
        $result_db = $conn->query("SELECT COUNT(id) FROM tasks");
        $row_db = $result_db->fetch_row();
        $total_records = $row_db[0];
        $total_pages = ceil($total_records / $limit);
        ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</body>
</html>
