<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <title>Alert</title>
</head>

<body>
    <script>
        let timerInterval
        Swal.fire({
            title: "<?= $title ?>",
            icon: '<?= $type ?>',
            text: "<?= $message ?>",
            timer: 2000,
            onClose: () => {
                window.location.replace("<?= $url ?>");
            }
        });
    </script>
</body>

</html>