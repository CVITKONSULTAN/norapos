<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>siMUDA - SD MUHAMMADIYAH 2 PONTIANAK (Privacy Policy)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .error{
        color: red;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <!-- Header -->
  <header class="bg-blue-600 text-white py-4">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold">Privacy Policy</h1>
      <p class="text-sm">Effective Date: January 16, 2025</p>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8 bg-white shadow-md rounded-lg mt-6">
    <section>
      <h2 class="text-xl font-bold mb-4">Introduction</h2>
      <p class="mb-4">
        Welcome to <strong>siMUDA - SD MUHAMMADIYAH 2 PONTIANAK</strong>. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and disclose your information when you use our app.
      </p>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">Information We Collect</h2>
      <ul class="list-disc pl-6 mb-4">
        <li>
          <strong>Personal Information:</strong> We may collect your name, email address, phone number, and other personal details when you sign up or use the app.
        </li>
        <li>
          <strong>Usage Data:</strong> We collect information about how you interact with the app, such as features accessed, session duration, and crash reports.
        </li>
        <li>
          <strong>Device Information:</strong> We may collect data about your device, such as the operating system, device model, and unique identifiers.
        </li>
      </ul>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">How We Use Your Information</h2>
      <p class="mb-4">
        We use the information we collect for the following purposes:
      </p>
      <ul class="list-disc pl-6 mb-4">
        <li>To provide and improve our app's features and functionality.</li>
        <li>To communicate with you regarding updates or support inquiries.</li>
        <li>To ensure compliance with legal and regulatory requirements.</li>
      </ul>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">Sharing Your Information</h2>
      <p class="mb-4">
        We do not share your personal information with third parties, except in the following cases:
      </p>
      <ul class="list-disc pl-6 mb-4">
        <li>When required by law or legal proceedings.</li>
        <li>To protect our rights, users, and property.</li>
        <li>With service providers who assist in operating our app, under strict confidentiality agreements.</li>
      </ul>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">Your Rights</h2>
      <p class="mb-4">
        You have the right to access, update, or delete your personal information. If you wish to exercise these rights, please contact us at <a href="mailto:admin@itkonsultan.co.id" class="text-blue-600">admin@itkonsultan.co.id</a>.
      </p>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">Support Form</h2>
      <p class="mb-4">If you need assistance or have any questions, please use the form below or contact us directly:</p>
      <ul class="list-disc pl-6 mb-4">
        <li>Email: <a href="mailto:admin@itkonsultan.co.id" class="text-blue-600">admin@itkonsultan.co.id</a></li>
        <li>Phone: <a href="tel:+6282255985321" class="text-blue-600">+62 822-5598-5321</a></li>
      </ul>
      <form id="form" action="{{route('form.store')}}" method="POST" class="bg-gray-100 p-4 rounded shadow-md">
        @csrf
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Your Name" required>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Your Email" required>
        </div>
        <div class="mb-4">
          <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
          <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
      </form>
    </section>

    <section>
      <h2 class="text-xl font-bold mb-4">Contact Us</h2>
      <p>
        If you have any questions about this Privacy Policy, please contact us at:
      </p>
      <address class="mt-2">
        <p>Email: <a href="mailto:admin@itkonsultan.co.id" class="text-blue-600">admin@itkonsultan.co.id</a></p>
        <p>Phone: <a href="tel:+6282255985321" class="text-blue-600">+62 822-5598-5321</a></p>
      </address>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-200 text-gray-600 text-center py-4 mt-8">
    <p>&copy; 2025 siMUDA - SD MUHAMMADIYAH 2 PONTIANAK. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script>
    $(document).ready(function() {
        $("#form").validate({
            submitHandler: function(form) {
                $.ajax({
                    url:form.action,
                    type:form.method,
                    data:$(form).serialize(),
                    success:function(response) {
                        const status = response.status ? 'success' : 'error';
                        Swal.fire({
                            icon: status,
                            title: status,
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        form.reset();
                    },
                })
                return false;
            }
        });
    });
  </script>
</body>
</html>
