document.getElementById('photoInput')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file || !file.type.startsWith('image/')) return;

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('photoPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);
});
