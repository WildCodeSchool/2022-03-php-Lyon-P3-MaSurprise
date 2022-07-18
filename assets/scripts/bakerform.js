// display the fields for professionnal bakers, after the checkbox is selected
const radio = document.getElementById('baker_bakerType')
const radioBtns = document.querySelectorAll('input[name="baker[bakerType]"]');
const commercialName = document.getElementById('commercialName');
const logoFile = document.getElementById('logoFile');
const siretFile = document.getElementById('siretFile');
const diplomaFile = document.getElementById('diplomaFile');

radio.addEventListener('change', function () {
    for (const radioBtn of radioBtns) {
        if (radioBtn.checked && radioBtn.value === "professionnel") {
            commercialName.classList.remove('hidden');
            logoFile.classList.remove('hidden');
            siretFile.classList.remove('hidden');
            diplomaFile.classList.remove('hidden');
        }
        if (radioBtn.checked && radioBtn.value === "amateur") {
            commercialName.classList.add('hidden');
            logoFile.classList.add('hidden');
            siretFile.classList.add('hidden');
            diplomaFile.classList.add('hidden');
        }
    }
})

// copy the delivery address if similar to billing adress

const copyAddress = document.getElementById('copyAddress');
const copy = document.querySelector("input[name=copy]");
const streetNumber = document.getElementById('baker_user_billingAddress_0_streetNumber');
const deliveryStreetNumber = document.getElementById('baker_deliveryAddress_streetNumber');
const bis = document.getElementById('baker_user_billingAddress_0_bisTerInfo');
const deliveryBis = document.getElementById('baker_deliveryAddress_bisTerInfo');
const streetName = document.getElementById('baker_user_billingAddress_0_streetName');
const deliveryStreetName = document.getElementById('baker_deliveryAddress_streetName');
const department = document.getElementById('baker_user_billingAddress_0_department');
const deliveryDepartment = document.getElementById('baker_deliveryAddress_department');
const postCode = document.getElementById('baker_user_billingAddress_0_postcode');
const deliveryPostCode = document.getElementById('baker_deliveryAddress_postcode');
const city = document.getElementById('baker_user_billingAddress_0_city');
const deliveryCity = document.getElementById('baker_deliveryAddress_city');
const extraInfo = document.getElementById('baker_user_billingAddress_0_extraInfo');
const deliveryExtraInfo = document.getElementById('baker_deliveryAddress_extraInfo');

copyAddress.addEventListener('change', function () {
    if (copy.checked) {
        deliveryStreetNumber.value = streetNumber.value;
        deliveryBis.value = bis.value;
        deliveryStreetName.value = streetName.value;
        deliveryDepartment.value = department.value;
        deliveryPostCode.value = postCode.value;
        deliveryCity.value = city.value;
        deliveryExtraInfo.value = extraInfo.value;
    }
})

