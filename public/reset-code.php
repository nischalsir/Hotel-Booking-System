<?php require_once "../config/controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
    <title>Reset Code</title>
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
        <!-- Reset Code Form Container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-xl p-8 w-full">
            <!-- Form -->
            <div class="w-full">
                <h2 class="font-bold text-2xl text-[#002D74]">Reset Code Verification</h2>
                <p class="text-xs mt-4 text-[#002D74]">Please enter the 6-digit code sent to your email.</p>
                
                <!-- Success Message -->
                <?php 
                if(isset($_SESSION['info'])){
                    echo '<div class="alert alert-success text-center bg-green-100 text-green-800 p-4 rounded-xl mb-4">';
                    echo $_SESSION['info'];
                    echo '</div>';
                }
                ?>
                
                <!-- Error Messages -->
                <?php
                if(count($errors) > 0){
                    echo '<div class="alert alert-danger text-center bg-red-100 text-red-800 p-4 rounded-xl mb-4">';
                    foreach($errors as $showerror){
                        echo $showerror . '<br>';
                    }
                    echo '</div>';
                }
                ?>
                
                <form id="otp-form" action="reset-code.php" method="POST" autocomplete="off" class="flex flex-col gap-4">
                    <div class="flex gap-2 justify-center">
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                        <input
                            type="text"
                            maxlength="1"
                            name="otp[]"
                            class="shadow-xs w-[48px] h-[48px] text-center rounded-lg border border-stroke bg-white p-2 text-2xl font-medium text-gray-800 outline-none dark:border-gray-300 dark:bg-gray-50"
                            required
                        />
                    </div>
                    <button class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300" type="submit" name="check-reset-otp">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <?php include "./include/footer.php"; ?>
</body>
</html>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("otp-form");
    const inputs = [...form.querySelectorAll("input[type=text]")];

    inputs.forEach((input, index) => {
      input.addEventListener("input", (e) => {
        if (e.target.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !e.target.value && index > 0) {
          inputs[index - 1].focus();
        }
      });

      input.addEventListener("paste", (e) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData("text").slice(0, inputs.length);
        pastedData.split("").forEach((char, i) => {
          if (inputs[i]) inputs[i].value = char;
        });
      });
    });
  });
</script>