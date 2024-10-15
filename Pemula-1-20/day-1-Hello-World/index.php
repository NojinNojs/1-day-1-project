<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World with PHP and JavaScript</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@1.14.0/dist/full.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6; /* Tailwind gray-100 */
        }
        @media (max-width: 640px) {
            h1 {
                font-size: 2rem; /* Responsive font size for small screens */
            }
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-blue-600"><?php echo "Hello World from PHP!"; ?></h1>
        <button class="mt-4 btn btn-primary" onclick="displayMessage()">Klik Saya</button>
    </div>

    <script>
        function displayMessage() {
            alert("Hello World from JavaScript!");
        }
    </script>
</body>
</html>
