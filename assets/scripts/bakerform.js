const radio = document.getElementById('baker_bakerType')
const radioBtns = document.querySelectorAll('input[name="baker[bakerType]"]');
const commercialName = document.getElementById('commercialName');
const facebook = document.getElementById('facebook');
const instagram = document.getElementById('instagram');
const logoFile = document.getElementById('logoFile');
const siretFile = document.getElementById('siretFile');
const diplomaFile = document.getElementById('diplomaFile');

radio.addEventListener('change', function () {
    for (const radioBtn of radioBtns) {
        if (radioBtn.checked && radioBtn.value === "professionnel") {
            commercialName.classList.remove('hidden');
            facebook.classList.remove('hidden');
            instagram.classList.remove('hidden');
            logoFile.classList.remove('hidden');
            siretFile.classList.remove('hidden');
            diplomaFile.classList.remove('hidden');
        }
        if (radioBtn.checked && radioBtn.value === "amateur") {
            commercialName.classList.add('hidden');
            facebook.classList.add('hidden');
            instagram.classList.add('hidden');
            logoFile.classList.add('hidden');
            siretFile.classList.add('hidden');
            diplomaFile.classList.add('hidden');
        }
    }
})
