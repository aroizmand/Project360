<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="card mb-3">
    <div class="card-body">
        <p class="card-text"><?php echo $comment_content; ?></p>
        <p class="card-text"><small class="text-muted">Posted by <?php echo $comment_user_id; ?> on <?php echo $comment_created_at; ?></small></p>
    </div>
</div>
</body>
<html>
