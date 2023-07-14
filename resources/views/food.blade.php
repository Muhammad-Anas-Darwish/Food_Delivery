<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/api/foods/" method="post" enctype="multipart/form-data">
        <input type="hidden" name="title" value="pizz">
        <input type="hidden" name="price" value="1">
        <input type="hidden" name="description" value="description">
        <input type="hidden" name="category_id" value="1">
        <input type="hidden" name="is_active" value="1">
        <input type="file" name="image" required>
        <input type="submit" value="submit">
    </form>
</body>
</html>
