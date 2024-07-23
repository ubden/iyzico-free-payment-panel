document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const amountInput = document.getElementById('amount');
    const phoneInput = document.getElementById('phone');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Form verilerini kontrol edin
        let isValid = true;
        let message = '';

        // Ödeme miktarını kontrol et
        let amountValue = parseFloat(amountInput.getAttribute('data-raw-value'));
        if (isNaN(amountValue) || amountValue <= 0) {
            isValid = false;
            message += 'Ödeme miktarı sıfırdan büyük olmalıdır.<br>';
        }

        // Telefon numarasını kontrol et
        if (!/^05\d{9}$/.test(phoneInput.value)) {
            isValid = false;
            message += 'Telefon numarası geçersiz.<br>';
        }

        if (!isValid) {
            messageDiv.innerHTML = message;
            messageDiv.classList.remove('hidden');
        } else {
            messageDiv.classList.add('hidden');
            form.submit();
        }
    });

    phoneInput.addEventListener('input', function() {
        // Otomatik olarak telefon numarasını biçimlendirme
        let phoneValue = phoneInput.value.replace(/\D/g, '');
        if (phoneValue.length > 11) {
            phoneValue = phoneValue.substring(0, 11);
        }
        phoneInput.value = phoneValue;
    });

    amountInput.addEventListener('input', function() {
        // Miktar girişini işlerken geçici olarak veriyi sakla
        let amountValue = amountInput.value.replace(/[^\d.-]/g, '');
        amountInput.setAttribute('data-raw-value', amountValue);
    });

    amountInput.addEventListener('blur', function() {
        // Input'tan çıkıldığında son biçimlendirmeyi yap
        let amountValue = parseFloat(amountInput.getAttribute('data-raw-value'));
        if (!isNaN(amountValue) && amountValue > 0) {
            amountInput.value = amountValue.toLocaleString('tr-TR', { style: 'currency', currency: 'TRY' });
        } else {
            amountInput.value = '';
        }
    });

    amountInput.addEventListener('focus', function() {
        // Input'a geri
