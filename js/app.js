function saveRecord() {
    var elName = document.getElementById('name');
    var elSurname = document.getElementById('surname');
    var elAge = document.getElementById('age');

    var name = elName.value;
    var surname = elSurname.value;
    var age = elAge.value;

    // чистим от предыдущей валидации
    elName.classList.remove('error-input');
    elSurname.classList.remove('error-input');
    elAge.classList.remove('error-input');

    if (!name.trim()) {
        alert('Имя обязательно для заполнения!');
        elName.classList.add('error-input');
        return;
    }
    if (!surname.trim()) {
        alert('Фамилия обязательна для заполнения!');
        elSurname.classList.add('error-input');
        return;
    }
    if (!age.trim()) {
        alert('Возраст обязателен для заполнения!');
        elAge.classList.add('error-input');
        return;
    }

    var formData = {
        name: name,
        surname: surname,
        age: age
    };

    var data = new FormData();
    data.append("data", JSON.stringify(formData));

    fetch("/saver.php",
        {
            method: "POST",
            body: data
        })
        .then(function (res) {
            return res.json();
        })
        .then(function (data) {
            console.log(JSON.stringify(data));
            if (data.status === 200) {
                document.peopleForm.reset();
                document.getElementById('form-success').classList.remove('hidden');
                document.getElementById('form-success').innerHTML = data.message;
            } else {
                document.getElementById('form-error').classList.remove('hidden');
                document.getElementById('form-error').innerHTML = data.message;
            }
            setTimeout(function () {
                document.getElementById('form-success').classList.add('hidden');
                document.getElementById('form-success').innerHTML = '';
                document.getElementById('form-error').classList.add('hidden');
                document.getElementById('form-error').innerHTML = '';
            }, 2000);
        })
}