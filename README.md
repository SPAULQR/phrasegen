# Phrasegen
This is small algorithm for phrase generator on php  
технологический стек: OpenServer, MySql, php 7  

- Основной алгоритм Программы находится в методе **decision($string)** и рекурсивно вызывает себя,  
пока не будет получен избыточный массив фраз, сгенерированых согласно заданному условию.  
В Программе избыточный массив помещается в переменную **$tempArr**

- В качестве аргумента метод **decision** должен принимать массив строк, поэтому в классе присутствуют  
инструкции для преобразования входной строки в единичный массив **$input**.  

- Далее, избыточный массив переносится в итоговый **$answer** с отсечением дублированных вариантов,  
после чего итоговый массив последовательно выгружается в базу данных MySql.  

- База данных должна иметь схему **phrasegen**, таблицу **phrase** c двумя колонками **id** и **phrase**.  
**phrase** необходимо пометить индексом UNIQUE, таким образом обеспечивая  
отсутствие дубликатов сгенерированных программой значений в базе данных.  
