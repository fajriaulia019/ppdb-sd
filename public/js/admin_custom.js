function showRejectModal(pendaftarId) {
    
    $('#rejectForm').attr('action', "/admin/pendaftar/" + pendaftarId + "/tolak"); 
    $('#rejectModal').modal('show');
}
// Jalankan script ini ketika DOM sudah siap (menggunakan jQuery AdminLTE/Bootstrap 4)
$(document).ready(function() {
    $(".alert").fadeTo(5000, 500).slideUp(500, function() {
        $(this).alert('close');
    });    
});

