function confirmAction({ formId, title, text, confirmButton = 'Lanjutkan', cancelButton = 'Batal', icon = 'warning' }) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButton,
        cancelButtonText: cancelButton
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}