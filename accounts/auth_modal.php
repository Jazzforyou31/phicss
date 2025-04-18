<!-- auth_modal.php -->
<style>
  .modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .modal {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  }

  .modal h2 {
    margin-bottom: 20px;
  }

  .modal button {
    margin: 10px 0;
    padding: 10px 20px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    width: 100%;
  }

  .login-btn {
    background-color: #007BFF;
    color: white;
  }

  .signup-btn {
    background-color: #28A745;
    color: white;
  }

  .not-now-btn {
    background-color: #6C757D;
    color: white;
  }
</style>

<div class="modal-overlay" id="authModal">
  <div class="modal">
    <h2>Welcome!</h2>
    <button class="login-btn" onclick="location.href='login.php'">Login</button>
    <button class="signup-btn" onclick="location.href='signup.php'">Sign Up</button>
    <button class="not-now-btn" onclick="closeModal()">Not Now</button>
  </div>
</div>

<script>
  function closeModal() {
    const modal = document.getElementById('authModal');
    if (modal) {
      modal.style.display = 'none';
    }
  }
</script>
