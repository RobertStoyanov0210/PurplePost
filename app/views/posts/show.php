<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT ?>/posts"><i class="fas fa-arrow-left fa-lg"></i></a>
<h1 class="text-center"><?php echo $data['post']->title ?></h1>
<div class="bg-primary text-white w-75 mx-auto p-2">
  <?php echo $data['post']->body ?>
</div>
<p class="bg-secondary text-white py-2 mb-3 w-50 mx-auto text-center">
  Written by <?php echo $data['user']->name ?> on <?php echo $data['post']->created_at ?>
</p>
<?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>
  <hr>
  <a href="<?php echo URLROOT ?>/posts/edit/<?php echo $data['post']->id ?>" class="btn btn-dark">Edit</a>
  <form action="<?php echo URLROOT ?>/posts/delete/<?php echo $data['post']->id ?>" method="POST" class="float-right">
    <input type="submit" value="Delete" class="btn btn-danger">
  </form>
<?php endif ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>