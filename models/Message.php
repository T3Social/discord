<?PHP
//
//-- https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c
//
    function discordmsg($msg, $webhook) {
        if($webhook != "") {
            $ch = curl_init( $webhook );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 
            $response = curl_exec( $ch );
            // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
            echo $response;
            curl_close( $ch );
        }
    }
 
    // URL FROM DISCORD WEBHOOK SETUP
    $webhook = "hook_url"; 
    $timestamp = date("c", strtotime("now"));
    $msg = json_encode([
    // Message
    "content" => "Kek lol ;) <@75216985209700352>",
 
    // Username
    "username" => "krasin.space",
 
    // Avatar URL.
    // Uncomment to use custom avatar instead of bot's pic
    //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",
 
    // text-to-speech
    "tts" => false,
 
    // file_upload
    // "file" => "",
 
    // Embeds Array
    "embeds" => [
        [
            // Title
            "title" => "PHP - Send message to Discord (embeds) via Webhook",

            // Embed Type, do not change.
            "type" => "rich",

            // Description
            "description" => "Description will be here, someday <@75216985209700352>",

            // Timestamp, only ISO8601
            "timestamp" => $timestamp,

            // Author name & url
            "author" => [
                "name" => "krasin.space",
                "url" => "https://krasin.space/"
            ],

            // Custom fields
            "fields" => [
                // Field 1
                [
                    "name" => "Field #1",
                    "value" => "Value #1",
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Field #2",
                    "value" => "Value #2",
                    "inline" => true
                ]
                // etc
            ]
        ]
    ]
 
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
 
    discordmsg($msg, $webhook); // SENDS MESSAGE TO DISCORD
    echo "sent?";
?>