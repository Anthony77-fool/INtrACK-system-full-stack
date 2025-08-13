$('#download_QR_Icon').on('click', function () {
    let imgSrc = $('.qr-code-container img').attr('src');
    let filename = $(this).data('filename') || 'student_qr_code.png';

    if (!imgSrc) {
        alert('QR code not available yet!');
        return;
    }

    let link = document.createElement('a');
    link.href = imgSrc;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});
