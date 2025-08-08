
document.getElementById('visa_photo_select').addEventListener('change', function() {
    // Create the image preview
    var container = document.getElementById('visa_photo_container');
    var image = document.createElement('img');
    image.className = 'img-fluid "col-md-6';
    image.style='width:132px;margin-top:5px';
    image.setAttribute('id', 'visa_photo_preview');

    var file = document.getElementById('visa_photo_select').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        image.src = reader.result;
        container.appendChild(image);
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }

    // Check if a image is selected
    if (document.getElementById('visa_photo_select').files.length === 1) {
        document.getElementById('remove_visa_photo_button').classList.remove('display-none');
        document.getElementById('remove_visa_photo_button').classList.add('display-block');
        document.getElementById('visa_photo_select').classList.remove('display-block');
        document.getElementById('visa_photo_select').classList.add('display-none');

        // Remove the 'removed' input if a image is selected
        if (document.getElementById('removed')) {
            var elem = document.getElementById('removed');
            elem.parentNode.removeChild(elem);
        }
    }

});

document.getElementById('remove_visa_photo_button').addEventListener('click', function() {
    document.getElementById('visa_photo_preview').outerHTML = '';

    document.getElementById('remove_visa_photo_button').classList.remove('display-block');
    document.getElementById('remove_visa_photo_button').classList.add('display-none');

    document.getElementById('visa_photo_select').classList.remove('display-none');
    document.getElementById('visa_photo_select').classList.add('display-block');

    document.getElementById('visa_photo_select').value = '';

    // Create a hidden input if the image is removed
    var input = document.createElement("input");
    input.setAttribute('type', 'hidden');
    input.setAttribute('id', 'removed');
    input.setAttribute('name', 'removed');
    document.getElementById('visa_photo_container').appendChild(input);
});

