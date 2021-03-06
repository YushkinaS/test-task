# test-task
Ссылка на сайт: http://php-yushkinas.rhcloud.com/

Ссылка на код плагина: https://github.com/YushkinaS/test-task/blob/master/film-post-type.php

Скриншоты: 
![single-films](https://github.com/YushkinaS/test-task/blob/master/%D1%81%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA3.png)
![Content-films часть 1](https://github.com/YushkinaS/test-task/blob/master/%D1%81%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA1.png)
![Content-films часть 2](https://github.com/YushkinaS/test-task/blob/master/%D1%81%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA2.png)

## Вопросы

### Уточнить задание:

1. Должны ли поля “стоимость” и “дата выхода”  быть обязательными к заполнению?

2. Последние фильмы - по дате добавления на сайт или по дате выхода самого фильма? 

### По особенностям выполнения:

3. По пункту “На странице отдельного фильма данные выводим через создание и правку шаблона”
Какой шаблон нужно было создавать? Ограничиться шаблоном single-films и вставить данные до или после контента? Или можно также создать Content-films? Мне кажется, лучше работать с шаблоном контента - больше вариантов размещения блоков.

4. Допустимо ли использовать ob_start() + ob_get_clean() (как у меня в плагине) для добавления данных к фильмам в списке? Или можно только строки склеивать?

### И по возникшим сложностям

5. Хотелось уменьшить картинку фильма (использовалась тема WPBSS). Но в лоб не получилось, т.к. там в стилях - для картинки min-width 100%. Поэтому картинки, на мой взгляд, очень большие для каталога фильмов. Как следует поступать в такой ситуации? Менять стили дочерней темы? А если хочется весь функционал, связанный с фильмами, положить в плагин - подключать в файле свой css, который перекроет стили темы? 

6. К слову о полном переносе работы с фильмами в плагин из темы - допустимо добавить в плагин свой файл шаблона Content-films?
