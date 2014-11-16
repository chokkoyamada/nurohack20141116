nurohack20141116
================

server side code of NURO hackathon 2014/11/16 Akasaka Garden Tower

## API Endpoint

http://54.64.72.139/hvc

## register data

http://54.64.72.139/hvc/post.php

#### METHOD

GET/POST

#### Params

* team_id(required) INTEGER between 1 and 2
* emotion_id(required) INTEGER between 1 and 5
* emotion_rate(required) INTEGER between 0 and 100
* random(optional) if "TRUE", random value will be inserted

## display data

http://54.64.72.139/hvc/post.php

#### METHOD

GET

it displays bar chart.

## Other resouces

Kibana for ElasticSearch
http://54.64.72.139/kibana/index.html#/dashboard/elasticsearch/nuro
