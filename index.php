<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>AJAX Запити</title>
</head>
<body>
    <h2>Запити до бази даних</h2>

    <form id="nurseForm">
        <label for="nurse_id">Виберіть медсестру:</label>
        <select name="nurse_id" id="nurse_id">
            <option value="1">ivanova</option>
            <option value="2">petrova</option>
        </select><br><br>

        <label for="ward_id">Виберіть палату:</label>
        <select name="ward_id" id="ward_id">
            <option value="1">WardFirst</option>
            <option value="2">WardSecond</option>
            <option value="3">WardThird</option>
        </select><br><br>

        <label for="shift">Виберіть зміну:</label>
        <select name="shift" id="shift">
            <option value="First">Перша</option>
            <option value="Second">Друга</option>
            <option value="Third">Третя</option>
        </select><br><br>

        <button type="button" onclick="LoadJSON()">Отримати JSON</button>
        <button type="button" onclick="LoadXML()">Отримати XML</button>
        <button type="button" onclick="LoadText()">Отримати TXT </button>
        
    </form>

    <div id="output" style="margin-top: 20px;"></div>

    <script src="LoadJSON.js"></script>
    <script src="LoadXML.js"></script>
    <script src="LoadText.js"></script>
    <script src="LoadPlainText.js"></script>
</body>
</html>
