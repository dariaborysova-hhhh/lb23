function LoadText() {
    const form = document.getElementById('nurseForm');
    const formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'query_results.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const output = document.getElementById('output');
            output.innerHTML = "<h3>Результати TEXT (XMLHttpRequest):</h3><pre>" + xhr.responseText + "</pre>";
        } else {
            document.getElementById('output').textContent = 'Сталася помилка при запиті';
        }
    };

    xhr.onerror = function () {
        document.getElementById('output').textContent = 'Помилка зʼєднання';
    };

    xhr.send(formData);
}
