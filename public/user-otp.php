<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>HBS - OTP Verification</title>
  </head>
<body>
  <nav>
    <div class="logo">HBS</div>
    <ul class="nav-links">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="book.php">Rooms</a></li>
      <li class="nav-link"><a href="facilities.php">Facilities</a></li>
      <li class="nav-link"><a href="contact.php">Contact</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
    </ul>
  </nav>

  <section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-lg p-8 w-full">
      <div class="w-full">
        <h2 class="font-bold text-2xl text-[#002D74]">OTP Verification</h2>
        <p class="text-xs mt-4 text-[#002D74]">
          <?php 
          if(isset($_SESSION['info'])){
            echo '<div class="alert alert-success text-center">'.$_SESSION['info'].'</div>';
          }
          if(count($errors) > 0){
            echo '<div class="alert alert-danger text-center">';
            foreach($errors as $showerror){
              echo $showerror;
            }
            echo '</div>';
          }
          ?>
        </p>

        <!-- OTP Input Fields -->
        <form id="otp-form" action="signup-user.php" method="POST" autocomplete="off" class="flex flex-col gap-6">
          <div class="flex gap-2 justify-center">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
            <input type="text" name="otp[]" maxlength="1" class="shadow-xs w-[48px] text-center text-2xl border border-gray-300 rounded-lg p-2">
          </div>
          <button class="bg-[#002D74] rounded-xl text-white py-3 hover:scale-105 duration-300 mt-4 w-full" type="submit" name="check" value="Submit">Submit</button>
        </form>
      </div>
    </div>
  </section>

  <?php include "./include/footer.php"; ?>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const form = document.getElementById("otp-form");
      const inputs = [...form.querySelectorAll("input[type=text]")];

      const handleKeyDown = (e) => {
        if (!/^[0-9]{1}$/.test(e.key) && e.key !== "Backspace" && e.key !== "Tab") {
          e.preventDefault();
        }
        if (e.key === "Backspace" || e.key === "Delete") {
          const index = inputs.indexOf(e.target);
          if (index > 0) {
            inputs[index - 1].value = "";
            inputs[index - 1].focus();
          }
        }
      };

      const handleInput = (e) => {
        const index = inputs.indexOf(e.target);
        if (e.target.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      };

      const handlePaste = (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData("text");
        if (!/^\d{6}$/.test(text)) return;
        text.split("").forEach((char, idx) => {
          if (inputs[idx]) inputs[idx].value = char;
        });
      };

      inputs.forEach((input) => {
        input.addEventListener("keydown", handleKeyDown);
        input.addEventListener("input", handleInput);
        input.addEventListener("paste", handlePaste);
      });
    });
  </script>
</body>
</html>