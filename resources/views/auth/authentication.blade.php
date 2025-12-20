<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
 <link rel="shortcut icon" href="{{ asset('images/favico.png') }}" type="image/x-icon">
 
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
@if (session('success'))
    <script>
        alertify.success("{{ session('success') }}");
    </script>
@endif

@if (session('error'))
    <script>
        alertify.error("{{ session('error') }}");
    </script>
@endif

<div class="wrapper">
  
      <div class="title-text">
        <div class="title login">Login </div>
        <div class="title signup">Signup </div>
      </div>
      <div class="form-container">
        <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Login</label>
          <label for="signup" class="slide signup">Signup</label>
          <div class="slider-tab"></div>
        </div>
        <div class="form-inner">
          <form action="{{ route('login'); }}" method="post" class="login">
            @csrf
            <div class="field">
              <input type="text" name="email" placeholder="Email Address" required>
            </div>
            <div class="field">
              <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="pass-link"><a href="#">Forgot password?</a></div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
            <div class="signup-link">Not a member? <a href="">Signup now</a></div>
          </form>
                  <form action="{{ route('register'); }}" method="POST" class="signup">
                    @csrf
            <div class="field">
              <input type="text" placeholder="Full Name" name="name" required>
            </div>
          <div class="field phone-field">
            <span class="country-code">
              🇳🇬 +234
            </span>
            <input type="tel" name="phone" placeholder="Phone number" maxlength="10" required>
          </div>

            <div class="field">
              <input type="email" placeholder="Email Address" name="email" required>
            </div>
           <div class="field password-field">
              <input id="password" type="password" placeholder="Password" name="password" required>
              <span>
                  <img id="togglePassword" src="{{ asset('images/eye-close.png') }}" alt="">
              </span>
            </div>
         <div class="field password-field">
            <input type="password" placeholder="Confirm password" name="password_confirmation" id="rpass" required>
            <span>
              <img id="togglePassword2" src="{{ asset('images/eye-close.png') }}" alt="">
            </span>
        </div>

            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Signup">
            </div>
          </form>
        </div>
      </div>
    </div>
<script>
     const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
        signupBtn.click();
        return false;
      });

// First password
document.getElementById('togglePassword').addEventListener('click', function () {
   const passwordField = document.getElementById('password');
   const passwordIcon  = document.getElementById('togglePassword');

   if (passwordField.type === 'password') {
      passwordField.type = 'text';
      passwordIcon.src   = "{{ asset('images/eye-open.png') }}";
   } else {
      passwordField.type = 'password';
      passwordIcon.src   = "{{ asset('images/eye-close.png') }}";
   }
});

// Confirm password
document.getElementById('togglePassword2').addEventListener('click', function () {
   const passwordField = document.getElementById('rpass');
   const passwordIcon  = document.getElementById('togglePassword2');   // <- use togglePassword2 here

   if (passwordField.type === 'password') {
      passwordField.type = 'text';
      passwordIcon.src   = "{{ asset('images/eye-open.png') }}";
   } else {
      passwordField.type = 'password';
      passwordIcon.src   = "{{ asset('images/eye-close.png') }}";
   }
});

</script>
