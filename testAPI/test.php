<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hehe</title>
</head>
<body>
<?php

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://google-translator9.p.rapidapi.com/v2/detect",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'q' => 'Xin chào Việt Nam'
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: google-translator9.p.rapidapi.com",
            "x-rapidapi-key: a06a6c81a5mshc689423e3e49e56p113309jsn70d4450f99eb"
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //echo $response;
        $array = json_decode($response);
        var_dump($array);
        echo "<br>Ket qua sau khi dich la: ";
        echo $array['data']['translations'][0]['translatedText'];
    }
?>
</body>
</html>