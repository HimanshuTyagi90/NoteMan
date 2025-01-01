<!-- _navBar.php -->
 <?php
  session_start();?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">NoteMan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
     data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!isset($_SESSION['user_id']) ): ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/NoteMan/views/index.php">Home</a>
          </li>
        <?php endif; ?>

        <?php if (!isset($_SESSION['user_id']) ): ?>
          <li class="nav-item">
            <a class="nav-link" href="/NoteMan/views/signUpForm.php">SignUp</a>
          </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="../_partials/_logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
