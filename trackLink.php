<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Shortened Url</title>
</head>
<body>
    <h2>TrackLink</h2>
    <p>Aplikasi untuk melihat url tujuan dari sebuah link yang diperpendek (Shortened URL)</p>

    <p>Masukan url tanpa https:// <strong>(Contoh: bit.ly/contoh)</strong></p>
    <form action="" method="post">
        Url anda: <input type="text" name="url" id="" value="<?php if(isset($_POST['submit'])){echo $_POST['url'];}?>">
        <input type="submit" value="Track!" name="submit">
    </form>

    <?php
    if(isset($_POST['submit']))
    {
        function getRedirectTarget($shortenedUrl) {
            $ch = curl_init($shortenedUrl);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = curl_exec($ch);

            if (curl_errno($ch)) {
                return false; // Gagal mengambil header
            }

            curl_close($ch);

            $headersArray = explode("\n", $headers);

            foreach ($headersArray as $header) {
                if (strpos($header, 'Location: ') !== false) {
                    $redirectUrl = str_replace('Location: ', '', $header);
                    return trim($redirectUrl);
                }
            }

            return false; // Tidak ada header redirect
        }

        $shortenedUrl = $_POST['url']; // Gantilah dengan URL yang ingin Anda cek
        $redirectTarget = getRedirectTarget($shortenedUrl);

        if ($redirectTarget) {
            echo "URL tujuan redirect dari $shortenedUrl adalah: <br> <strong> $redirectTarget</strong>";
        } else {
            echo "Tidak dapat menentukan URL tujuan redirect dari $shortenedUrl";
        }
    }
    else
    {
        echo "";
    }
    ?>

</body>
</html>