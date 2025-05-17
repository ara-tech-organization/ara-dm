document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector("#contactForm")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      let isValid = true;
      const submitBtn = document.getElementById("submitBtn");
      const loader = document.getElementById("loader");
      loader.style.display = "flex";

      document.getElementById("nameError").textContent = "";
      document.getElementById("emailError").textContent = "";
      document.getElementById("phoneError").textContent = "";
      document.getElementById("messageError").textContent = "";

      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = document.getElementById("phone").value.trim();
      const message = document.getElementById("message").value.trim();

      if (name.length < 3) {
        document.getElementById("nameError").textContent =
          "Name must be at least 3 characters long.";
        isValid = false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent =
          "Please enter a valid email address.";
        isValid = false;
      }

      const phonePattern = /^[0-9]{10}$/;
      if (!phonePattern.test(phone)) {
        document.getElementById("phoneError").textContent =
          "Phone number must be 10 digits.";
        isValid = false;
      }

      if (message.length < 10) {
        document.getElementById("messageError").textContent =
          "Message must be at least 10 characters long.";
        isValid = false;
      }

      if (!isValid) {
        loader.style.display = "none";
        return;
      }

      const data = { name, email, phone, message };

      try {
        const response = await fetch(
          "https://schoolcommunication-gmdtekepd3g3ffb9.canadacentral-01.azurewebsites.net/api/postGroGloForm/AraBusiness",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Authorization: "Bearer 123",
            },
            body: JSON.stringify(data),
          }
        );

        if (response.ok) {
          const successModal = new bootstrap.Modal(
            document.getElementById("successModal")
          );
          successModal.show();
          setTimeout(() => {
            successModal.hide();
            document.getElementById("contactForm").reset();
          }, 3000);
        } else {
          alert("Failed to send email. Please try again.");
        }
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred. Please try again later.");
      }
      loader.style.display = "none";
    });
});
