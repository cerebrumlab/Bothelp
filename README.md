**Задание:**

Есть веб-api, непрерывно принимающее события (ограничимся 10000 событий) для группы аккаунтов (1000 аккаунтов) и складывающее их в очередь. Каждое событие связано с определённым аккаунтом и важно, чтобы события аккаунта обрабатывались в том же порядке, в котором поступили в очередь. Обработка события занимает 1 секунду (эмулировать с помощью sleep). Сделать обработку очереди событий максимально быстрой на данной конкретной машине. Код писать на PHP. Можно использовать фреймворки и инструменты такие как RabbitMQ, Redis, MySQL и т.д.

**Решение:**
Для ускорения обработки создается 101 очередь в каждую очередь попадают клиенты по целочисленному делению на 10. 
Таким образом для каждого клиента все события поподают в одну очередь что гарантирует что они будут выполняться в правильном порядке


**Установка**

**клонируем репозиторий**
```git clone https://github.com/cerebrumlab/Bothelp.git```

**переходим в папку Bothelp/app <br>**
```cd Bothelp/app ```<br>
**устанавливаем пакеты <br>**
```composer install``` <br>
**выдаем права на исполнения воркера <br>**
```chmod -R a+x bin/ ```<br>

**собираем контейнер <br>**
```docker-compose build```<br>
**запускаем контейнер <br>**
```docker-compose up -d```<br>
**заходим в контейнер<br>**
```docker exec -it php sh```<br>

**Создаем и направляем в апи Эвенты<br>**
```bin/console app:send-events ```<br>
**Создание Эвентов в ручную <br>**
```http://localhost:8080/event/new/  POST {"account_id":38,"event_id":6}```<br>
**Запускаем Консьюмеры <br>**
```bin/QueueWorker```<br>
