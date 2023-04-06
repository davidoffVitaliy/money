http://f0767718.xsph.ru

utf-8
Модель - делает запрос в базу данных
Контроллер - логика, алгоритмы , сборка html блоков и отправка во view
Views - показывает в браузере

Транзакция по внесению записей в таблици: payment, asset, liabilitie вносятся в модели Payment

Models
    "Сущность" - имя файла модели
        "действиеОбъектСущность" - "достатьВсёизТаблицы"
        "действиеСущность" - "создатьСущность"

        User
            createUser
            findOneUser
            findAllUser
            updateUser
            deleteOneUser
            deleteSelectUser
     
    
Controllers
    "СущностьController" - имя файла контролллера
        "действиеСущностьController" - имя метода

        UserController
            createUserController
            findOneUserController
            findAllUserController
            updateUserController
            deleteUserController
            deleteSelectUserController


Файл Crud:
/* 
    function creat(){}- Создать одну сущность
    function findAll(){} - Найти всё из одной таблицы
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function update(){} - Редактировать одну сущность
    function deleteOne(){} - Удалить одну сущность      
    function deleteSelect(){} - Удалить одну и более сущностей 
*/

