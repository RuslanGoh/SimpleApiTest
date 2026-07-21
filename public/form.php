<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead</title>
    <link rel="stylesheet" href="public/assets/styles.css">
    <script src="public/assets/js.js"></script>
</head>
<body>
    <div class="container">
        <h1>New Lead</h1>
        <form id="leadForm">
            <div class="form-group">
                <label for="firstName">Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Send</button>
        </form>
        <div id="message" class="message"></div>
        <p><a href="list">Leads Statuses</a></p>
    </div>
</body>
</html>
