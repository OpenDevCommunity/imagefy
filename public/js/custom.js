const SwalModal = (icon, title, text) => {
    swal({
        icon,
        title,
        text
    })
}

const SwalConfirm = (icon, title, text, confirmButtonText, method, params, callback) => {
    swal.fire({
        icon: 'warning',
        title,
        text,
        showCancelButton: true,
        buttons: ["Cancel", "Yes!"],
    }).then(result => {
        if (result.value) {
            return livewire.emit(method, params)
        }

        if (callback) {
            return livewire.emit(callback)
        }
    })
}

const SwalAlert = (icon, title, timeout = 7000) => {
    const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timeout,
        onOpen: toast => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon,
        title
    })
}

document.addEventListener('DOMContentLoaded', () => {
    this.livewire.on('swal:modal', data => {
        SwalModal(data.icon, data.title, data.text)
    })

    this.livewire.on('swal:confirm', data => {
        SwalConfirm(data.icon, data.title, data.text, data.confirmText, data.method, data.params, data.callback)
    })

    this.livewire.on('swal:alert', data => {
        SwalAlert(data.icon, data.text, data.timeout)
    })

    window.addEventListener('tempUrlModal', () => {
        $('#tempurlmodal').modal('hide')
    })
})
