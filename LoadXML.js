function LoadXML(){
    const form = document.getElementById('nurseForm');
    const formData = new FormData(form);

    fetch('query_results_xml.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // отримаємо XML як текст
    .then(xmlText => {
        const output = document.getElementById('output');
        output.innerHTML = "<h3>Результати XML:</h3><pre>" + escapeHtml(xmlText) + "</pre>";
    })
    .catch(error => {
        console.error('Помилка:', error);
        document.getElementById('output').textContent = 'Помилка запиту';
    });

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;<br>");
    }
}