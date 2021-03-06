Docker'изированный проект.
============================
----
# Описание директорий
* В директории conf лежат конфиги php и nginx. Их можно править, но потребуется пересоздать стек.
* Директория docker используется для нужд докера. Без знаний и уверенности ничего не править.
* В директорию logs будут прилетать логи веб-сервера.
* - Файлы error.log и access.log должны быть созданы, иначе веб-сервер не запустится.

----
# Скрипты
* `init.sh` - начальный скрипт требуемый для первоначальной инициализации.
* `docker_start.sh` - пересобирает образы и создает стек.
* `docker_stop.sh` - удаляет стек.
* `docker_reload.sh` -  пересоздает стек.
* `composer_install.sh` -  обновляет composer.

----
# Начало работы
В самом начале работы выполнить единожды от root'а `init.sh`, более выполнять его не имеет смысла, так как там вещи только для инициализации. Если у вас что-то пошло не так или очень хочется, то можно дергать и его, но после первого раза смысла в этом нет.
Далее в работе понадобятся только `docker_start.sh`, `docker_stop.sh`, `docker_reload.sh` и `composer_install.sh`.

Убедиться что запустились все нужные контейнеры можно выполнив команду:
`docker service ls`

Если какой-то контейнер не поднялся мы можем просмотреть логи выполнив:
`docker service logs <имя или id сервиса>`

Просмотреть список запущенных контейнеров:
`docker ps`

Подключиться к контейнеру:
`docker exec -ti <id или название контейнера> /bin/bash`

----
# Статусы контейнеров
После запуска стека статус контейнеров можно отслеживать по адресу `localhost:8080`

----
# Возможные ошибки
* Q: Во время деплоя процесс завис на моменте с точками.
* - A: Открыть новый терминал, выполнить `docker_stop.sh` и попробовать снова. Процесс который был запущен не надо прерывать вручную! В случае очередного фиаско обратиться к создателю.
