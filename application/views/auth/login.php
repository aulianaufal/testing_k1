<div class="container" id="container">
  <div class="container" id="container">
    <?php 
    // Tampilkan flashdata error jika ada
    if ($this->session->flashdata('login_error')) {
        echo $this->session->flashdata('login_error');
    }
    
    // Tampilkan form validation errors
    echo validation_errors('<div class="alert alert-danger">', '</div>');
    ?>

    <!-- Sign In -->
    <div class="form-container sign-in-container">
      <?= form_open('', ['class' => 'user']); ?>
        <h1>Login</h1>
        <input autofocus="autofocus" autocomplete="off" value="<?= set_value('username'); ?>" type="text" name="username" placeholder="Username" required />
        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
        <input type="password" name="password" placeholder="Password" required />
        <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
        <div class="button-group">
          <button type="submit">Login</button>
        </div>
      <?= form_close(); ?>
    </div>
    
    <!-- Overlay Container -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel">
                <h1>Selamat Datang Cuy</h1>
                <p>Silakan login dengan akun yang sudah terdaftar</p>
            </div>
        </div>
    </div>
</div>