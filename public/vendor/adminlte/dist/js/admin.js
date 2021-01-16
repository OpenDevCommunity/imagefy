$('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure?',
        text: $(this).attr("data-text"),
        showCancelButton: true,
        confirmButtonText: `I Understand`
    }).then((result) => {
        if (result.value) {
            window.location.href = url;
        }
    });
});
