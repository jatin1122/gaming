const profileInput = document.getElementById('profile-upload')
if(profileInput) {
    const readURL = input => {
        if (input.files && input.files[0]) {
            let reader = new FileReader()

            reader.onload = function(e) {
                document.getElementById('profile-preview').setAttribute('src', e.target.result)
            }

            reader.readAsDataURL(input.files[0])
        }
    }

    profileInput.addEventListener('change', function() {
        readURL(this)
    })

    document.getElementById('profile-upload-button').addEventListener('click', function() {
        console.log('click');
        profileInput.click()
    })
}