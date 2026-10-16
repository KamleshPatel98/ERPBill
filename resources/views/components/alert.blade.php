@if(session()->has('success'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    })
</script>
@endif

@if(session()->has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: "{{ session('error') }}"
    })
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Validation Error!',
        text: "{{ $errors->first() }}"
    })
</script>
@endif