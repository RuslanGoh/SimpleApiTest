<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Statuses</title>
    <link rel="stylesheet" href="public/assets/styles.css">
</head>
<body>
    <div class="container list-container">
        <h1>Leads Statuses</h1>

        <form method="GET" action="list" class="filter-form">
            <div class="form-group">
                <label for="date_from">Date From</label>
                <input type="date" id="date_from" name="date_from" value="<?php echo htmlspecialchars($dateFrom); ?>">
            </div>
            <div class="form-group">
                <label for="date_to">Date To</label>
                <input type="date" id="date_to" name="date_to" value="<?php echo htmlspecialchars($dateTo); ?>">
            </div>
            <button type="submit">Filter</button>
            <a href="list" class="btn-reset">Reset</a>
        </form>


        <?php if ($error): ?>
            <p class="message error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if (!empty($leads)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>FTD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($lead['id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($lead['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($lead['status'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($lead['ftd'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($prevPageUrl): ?>
                    <a href="<?php echo $prevPageUrl; ?>" class="btn">Previous</a>
                <?php endif; ?>
                
                <span class="page-info">Page: <?php echo $page + 1; ?></span>

                <?php if ($nextPageUrl): ?>
                    <a href="<?php echo $nextPageUrl; ?>" class="btn">Next</a>
                <?php endif; ?>
            </div>
        <?php elseif (!$error): ?>
            <p>No leads found.</p>
        <?php endif; ?>

        <p><a href="form">Create New Lead</a></p>
    </div>
</body>
</html>
