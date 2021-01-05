<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>База уклонистов от военной службы ver. 0.1</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<div class="wrapper">
    <hearer class="header">
        <div class="container">
            <h1>База уклонистов от военной службы ver. 0.1</h1>
        </div>
    </hearer>
    <div class="content">
        <div class="container">
            <form action="" method="post">
                <p class="content__form-group">
                <label for="name">Имя*</label>
                <input type="text">
                </p>
                <p class="content__form-group">
                <label for="name">Фамилия*</label>
                <input type="text">
                </p>
                <p class="content__form-group">
                <label for="name">Возраст, лет*</label>
                <input type="number" min="1" step="1">
                </p>
                <p class="content__form-group">
                <button type="submit" class="button">Сохранить</button>
                    <a href="/get_recruits.php" class="button">Выгрузить</a>
                </p>
            </form>
        </div>
    </div>
    <foother class="foother">
        <div class="container">
            <p>Ни один не уйдет от своего долга! С нами военные технологии!</p>
        </div>
    </foother>
</div>
</body>
</html>
