<?php
session_start();



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


<!-- 


<form action="post.php" method="post" enctype="multipart/form-data">
    <label>
        <textarea name="content" placeholder="What's new?" required></textarea>
    </label>
    <input type="file" name="image" accept="image/*">
    <button type="submit">post!</button>
</form>


<h2>Recent Posts</h2>


   
</body>
</html> /* ugigug*/

-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="headerSami">
        <div class="leftHeader">
            <li><a href="#"><i><img class="chirpifyLogo" src="Image/Chripify.png" alt=""></i> <h3>Hipirify</h3></a></li>
        </div>

        <div class="middleHeader">
            <button>For You</button>
            <button>Following</button>
        </div>

        <div class="rightHeader">
            <label>
                <input type="text" style="color: white;" placeholder="search">
            </label>
        </div>
    </div>


    <nav class="navBar">
        <ul>
            <li><a href="#"><i class="fa-solid fa-house"></i> <span>Home</span></a></li>
            <li><a href="#"><i class="fas fa-search"></i> <span>Search</span></a></li>
            <li><a href="#"><i class="fa-regular fa-compass"></i> <span>Explore</span></a></li>
            <li><a href="#"><i class="fa-regular fa-bell"></i> <span>Messages</span></a></li>
            <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>notification</span></a></li>
            <li><a href="#"><i class="fa-regular fa-square-plus"></i> <span>Create</span></a></li>
            <li><a href="#"><i class="fa-regular fa-user"></i> <span>Profile</span></a></li>
            
            <li class="down"><a href="#"><i class="fas fa-crown"></i><span>Premium</span></a></li>
            <li class="down"><a href="#"><i class="fa fa-bars"></i><span>More</span></a></li>
        </ul>
    </nav>


    <div class="body">
        <div class="happening">
            
            <img class = "profileImg" src="image/profileimg.png" alt="">
            
        <form class= "form" action="post.php" method="post" enctype="multipart/form-data">
                
            <label class = "happeningLabel">
            <textarea name="content" placeholder="What's Happening!?" required></textarea>
            
            </label>

            <input  type="file" name="image" accept="image/*" >
            <button type="submit">post!</button>
        </form>

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

        </div>
    </div>

    <div></div>
</body>
</html>




