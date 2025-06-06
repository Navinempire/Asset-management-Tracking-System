<?php
// DB connection
include "..\config\connection.php";
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'asset_tracker';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $conn = $_oconnect;

function getBotResponse($input, $conn) {
    $input = strtolower(trim($input));

    $responses = [
        'hello' => 'Hi there! How can I help you today?',
        'how are you' => 'I am a bot, but I\'m doing great! Thanks for asking.',
        'bye' => 'Goodbye! Have a nice day.',
        'your name'=>'I am Asset bot',
    ];

    if (strpos($input, 'list assets') !== false || strpos($input, 'show assets') !== false) {
        $sql = "
            SELECT asset.asset_name, category.category_name, asset_type.asset_type_name,
                asset.serial_number, asset.status, asset.conditions
            FROM asset
            INNER JOIN category ON asset.category_id = category.category_id
            INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
            LIMIT 10
        ";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $reply = "<strong> Asset List:</strong><br>";
            while ($row = $result->fetch_assoc()) {
                $reply .= "<div>🔹 <b>" . htmlspecialchars($row['asset_name']) . "</b><br>
                            Type: " . htmlspecialchars($row['asset_type_name']) . "<br>
                            Category: " . htmlspecialchars($row['category_name']) . "<br>
                            Serial: " . htmlspecialchars($row['serial_number']) . "<br>
                            Status: " . htmlspecialchars($row['status']) . "<br>
                            Condition: " . htmlspecialchars($row['conditions']) . "</div><hr>";
            }
            return $reply;
        } else {
            return " No assets found.";
        }
    }

    if (strpos($input, 'view') === 0) {
        $search = trim(str_replace('view', '', $input));
        if ($search === '') return " Please enter a search term.";

        $search = $conn->real_escape_string($search);
        $sql = "
            SELECT asset.asset_name, category.category_name, asset_type.asset_type_name,
            asset.serial_number, asset.status, asset.conditions
            FROM asset
            INNER JOIN category ON asset.category_id = category.category_id
            INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
            WHERE asset.asset_name LIKE '%$search%' OR
                asset_type.asset_type_name LIKE '%$search%' OR
                category.category_name LIKE '%$search%' OR
                asset.serial_number LIKE '%$search%' OR
                asset.status LIKE '%$search%' OR
                asset.conditions LIKE '%$search%'
            LIMIT 10
        ";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $reply = "<strong> Search results for \"$search\":</strong><br>";
            while ($row = $result->fetch_assoc()) {
                $reply .= "<div>🔹 <b>" . htmlspecialchars($row['asset_name']) . "</b><br>
                            Type: " . htmlspecialchars($row['asset_type_name']) . "<br>
                            Category: " . htmlspecialchars($row['category_name']) . "<br>
                            Serial: " . htmlspecialchars($row['serial_number']) . "<br>
                            Status: " . htmlspecialchars($row['status']) . "<br>
                            Condition: " . htmlspecialchars($row['conditions']) . "</div><hr>";
            }
            return $reply;
        } else {
            return " No matching assets for \"$search\".";
        }
    }

    foreach ($responses as $key => $response) {
        if (strpos($input, $key) !== false) return $response;
    }

    return "🤖 Sorry, I didn't understand that. Try 'list assets' or 'search laptop'.";
}

if (isset($_POST['user_input'])) {
    $user_input = $_POST['user_input'];
    $bot_response = getBotResponse($user_input, $conn);
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asset Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <style>
        .chat-container {
            max-width: 600px;
            margin: auto;
            margin-top: 100px;
            margin-right:0px;
            position: relative;

        }
        .chat-box {
            height: 400px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }
        .message.user {
            text-align: right;
        }
        .message.user p {
            background: #d1e7dd;
            display: inline-block;
            padding: 10px;
            border-radius: 15px;
        }
        .message.bot p {
            background: #f8d7da;
            display: inline-block;
            padding: 10px;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container chat-container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-brands fa-bots"></i> Asset Management Chatbot</h5>
        </div>
        <div class="card-body chat-box" id="chatBox">
            <?php if (isset($bot_response)): ?>
                <div class="message user mb-2">
                    <p><strong>You:</strong> <?= htmlspecialchars($user_input) ?></p>
                </div>
                <div class="message bot">
                    <p><strong>Bot:</strong><br> <?= $bot_response ?></p>
                </div>
            <?php else: ?>
                <div class="text-muted"><i class="fa-regular fa-message"></i> Start chatting by typing something below...</div>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <form method="post" class="d-flex">
                <input type="text" name="user_input" class="form-control me-2" placeholder="Type a message..." required autofocus>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Scroll to bottom on load
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>
