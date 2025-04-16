function LoadJSON(){
    const form = document.getElementById('nurseForm');
    const formData = new FormData(form);

    fetch('query_results_json.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const output = document.getElementById('output');
        output.innerHTML = "<h3>Результати JSON:</h3><pre>" + JSON.stringify(data, null, 2) + "</pre>";
    })
    .catch(error => {
        console.error('Помилка:', error);
        document.getElementById('output').textContent = 'Помилка запиту';
    });
}