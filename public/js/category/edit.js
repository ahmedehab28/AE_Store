document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (button) {
    button.addEventListener('click', function () {
        var categoryId = this.getAttribute('data-category-id');
        var categoryName = this.getAttribute('data-category-name');

        var modal = document.querySelector(this.getAttribute('data-bs-target'));
        modal.querySelector('form').setAttribute('action', '/category/update/' + categoryId);
        modal.querySelector('input[name="name"]').value = categoryName;
    });
});
