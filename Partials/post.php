<?php
session_start();
include "header.php";


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $image_path = "";
    if (!empty($_FILES['image']['name'])) {
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }
    $_SESSION['posts'][] = [
        'user' => $_SESSION['user'],
        'content' => $content,
        'image' => $image_path,
        'likes' => 0,
        'reposts' => 0
    ];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>
</head>
<body>
<h1>Create a Post</h1>
<form action="post.php" method="post" enctype="multipart/form-data">
    <label>
        <textarea name="content" placeholder="What's new?" required></textarea>
    </label>
    <input type="file" name="image" accept="image/*">
    <button type="submit">post!</button>
</form>
<h2>Recent Posts</h2>
<?php if (!empty($_SESSION['posts'])): ?>
<?php foreach (array_reverse($_SESSION['posts']) as $index => $post): ?>
<div class="post">
    <p><?php echo htmlspecialchars($post['user']); ?>:</p>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <?php if (!empty($post['image'])): ?>
        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 300px;">
    <?php endif; ?>
    <p>
        <button onclick="likePost (<?php echo $index; ?>)" >Like (<?php echo $post['likes']; ?>)</button>
        <button onclick="repost(<?php echo $index; ?>)">Repost (<?php echo $post['reposts']; ?>)</button>
    </p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No posts yet.</p>
<?php endif; ?>
</body>
</html>
