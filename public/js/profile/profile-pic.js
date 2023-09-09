document.getElementById('picture').addEventListener('change', function (event) {
    const fileName = event.target.files[0].name;
    document.getElementById('fileName').textContent = fileName;
});
