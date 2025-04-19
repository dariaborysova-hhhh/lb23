function LoadText() {
    const form = document.getElementById('nurseForm');
    const nurse_id = form.nurse_id.value;
    const ward_id = form.ward_id.value;
    const shift = form.shift.value;

    const url = `query_results.php?nurse_id=${nurse_id}&ward_id=${ward_id}&shift=${shift}`;
    const a= 2;

    const xhr = new XMLHttpRequest(); 
    xhr.open('GET', url, true);

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

    xhr.send();
}
